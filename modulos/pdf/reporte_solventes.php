<?php

	include "../../config/Plantilla.php";
	require "../../config/EntidadBase.php";

	setlocale(LC_ALL,'es_VE.UTF-8');
	date_default_timezone_set ("America/Caracas"); 
	$fecha_actual_escrita = date("Y") . "-" . date("n") . "-" . date("d"). "-" . date("w");
    $fecha_actual_escrita = reg_date($fecha_actual_escrita);
    $mes_actual = (int)date("m");
	$anyo_actual = (int)date("Y");
	$cabecera = array('Rif','Nombre','Tipo','Ultimo Pago','Parroquia');
	
	$entidad = new EntidadBase("empresa");

	$conexion = $entidad->db();

	/*SECCION PARA EL PDF DEL REPORTE: */

	$pdf = new PDF(); //CREANDO LA INSTANCIA DE LA CLASE PDF

	$pdf->AddPage();
	$pdf->Cell(105);
	$pdf->SetFont('Times','I',9);
	$pdf->Cell(0,10,utf8_decode($fecha_actual_escrita . strftime(" a las %I:%M:%S %p")),0,1,'R');
	$pdf->Ln(5);
	$pdf->SetTextColor(0);
	$pdf->SetDrawColor(122,122,122);
	$pdf->SetFont('Arial','BIU',14);
	$pdf->Cell(0,10,utf8_decode("Contribuyentes Solventes"),0,1,'L');
	$pdf->Ln(5);
	$disponible = 0;
	$dis_glob = 0;
 
	if(isset($_GET["dm"]) && isset($_GET["hm"])){

		$trimestre_desde = $_GET["dm"];
		$trimestre_hasta = $_GET["hm"];

		if($trimestre_desde == 0 && $trimestre_hasta == 0){
			//LISTADO COMPLETO DE LOS SOLVENTES.
			$consulta = "SELECT id, tipo FROM contribuyente WHERE id NOT IN (1) AND deudor = 0 ORDER BY tipo";
			$resul = $conexion->query($consulta);
			if($resul){
				$disponible = 1;
			}else{
				$disponible = 0;
			}
		}else if($trimestre_desde > 0 && $trimestre_hasta == 0){
			//BUSQUEDA DESDE EL TRIMESTRE DESDE HASTA EL TRIMESTRE ACTUAL.
			$numero_trimestre = encontrarTrimestre($mes_actual);
			$sql = "SELECT numero FROM trimestre WHERE id_trimestre = $trimestre_desde";
			$resultado = $conexion->query($sql);
			$tr = $resultado->fetch_assoc();
			if($tr["numero"] > $numero_trimestre){
				$disponible = 3;
			}else{
				//REALIZAR LA CONSULTA
				$sql = "SELECT id_trimestre FROM trimestre WHERE numero = $numero_trimestre AND anyo = $anyo_actual";
				$resultado = $conexion->query($sql);
				$th = $resultado->fetch_assoc();

				$consulta = "SELECT contribuyente.id, contribuyente.tipo 
						FROM contribuyente 
						INNER JOIN factura ON factura.contribuyente = contribuyente.id
						INNER JOIN detalle_factura ON detalle_factura.factura = factura.cod_factura 
						WHERE contribuyente.id NOT IN (1) AND contribuyente.deudor = 0 AND detalle_factura.trimestre >= $trimestre_desde AND detalle_factura.trimestre <= ".$th["id_trimestre"]." GROUP BY contribuyente.id ORDER BY contribuyente.tipo ASC";
				$resul = $conexion->query($consulta);

				if($resul){
					$disponible = 1;
				}else{
					$disponible = 0;
				}
			}
		}else if($trimestre_desde > 0 && $trimestre_hasta > 0){
			$consulta = "SELECT contribuyente.id, contribuyente.tipo 
						FROM contribuyente 
						INNER JOIN factura ON factura.contribuyente = contribuyente.id
						INNER JOIN detalle_factura ON detalle_factura.factura = factura.cod_factura 
						WHERE contribuyente.id NOT IN (1) AND contribuyente.deudor = 0 AND detalle_factura.trimestre >= $trimestre_desde AND detalle_factura.trimestre <= $trimestre_hasta GROUP BY contribuyente.id ORDER BY contribuyente.tipo ASC";
			$resul = $conexion->query($consulta);
				
			if($resul){
				$disponible = 1;
			}else{
				$disponible = 0;
			}
		}

		if($disponible == 1){
			if($resul->num_rows > 0){
		  		while($row = $resul->fetch_object()){
		  			if($row->tipo == "per"){
		  				$sql = "SELECT persona.contribuyente, persona.rif, CONCAT(persona.nombres,' ',persona.apellidos) AS nombre, contribuyente.tipo, parroquia.nombre_parroquia AS parroquia 
		  				FROM persona 
		  				INNER JOIN contribuyente ON persona.contribuyente = contribuyente.id 
		  				INNER JOIN parroquia ON persona.id_parroquia = parroquia.id_parroquia 
		  				WHERE contribuyente = ".$row->id;
		  			}else{
		  				$sql = "SELECT empresa.contribuyente, empresa.rif, empresa.nombre, contribuyente.tipo, parroquia.nombre_parroquia AS parroquia 
		  				FROM empresa 
		  				INNER JOIN contribuyente ON empresa.contribuyente = contribuyente.id 
		  				INNER JOIN parroquia ON empresa.id_parroquia = parroquia.id_parroquia 
		  				WHERE contribuyente = ".$row->id;
		  			}
		  			$r = $conexion->query($sql);
		  			if($r->num_rows == 1){
				  		while($rw = $r->fetch_assoc()){
					  		if($rw["tipo"] == "emp"){
					  			$tipo_con="Juridico";
					  		}else{
					  			$tipo_con="Natural";
					  		}

					  		$sql = "SELECT MAX(cod_factura) ultimo_pago, MAX(fecha_pago) fecha_ultimo_pago FROM factura GROUP BY contribuyente HAVING contribuyente = " . $rw["contribuyente"];
							$re = $conexion->query($sql);
							$d = array();
							if($re->num_rows > 0){
								while($d[] = $re->fetch_assoc());
								$ultimo_pago = $d[0];
								$ult_pag = "Cod: ".$ultimo_pago['ultimo_pago'];
								$ult_pag .= " - Fecha: ". $ultimo_pago['fecha_ultimo_pago'];
							}else{
								$ult_pag = "No posee ningúna solvencia";
							}

					  		$datos[] = array(
					  			$rw["rif"],
					  			$rw["nombre"],
					  			$tipo_con,
					  			$ult_pag,
					  			$rw["parroquia"]
					  		);
					  	}
		  			}
		  		}
		  		if(count($datos) > 0){
		 			$dis_glob = 1;
		  		}else{
		  			$dis_glob = 0;
		  		}
		  	}else{
		    	$dis_glob = 0;
		  	}
		}else{
			$dis_glob = 0;
		}
	}else if(isset($_GET["b"])){
		$search = $_GET["b"];
	  	$tipo = $entidad->tipo_contribuyente_rif($search,"0");

		if(!$tipo){
			$dis_glob = 0;
		}else{
			if($tipo == "per"){
		  		$sql = "SELECT persona.contribuyente, persona.rif, CONCAT(persona.nombres,' ',persona.apellidos) AS nombre, contribuyente.tipo, parroquia.nombre_parroquia AS parroquia 
		  		FROM persona 
		  		INNER JOIN contribuyente ON persona.contribuyente = contribuyente.id
		  		INNER JOIN parroquia ON persona.id_parroquia = parroquia.id_parroquia 
		  		WHERE persona.rif = '".$search."'";
		  	}else{
		  		$sql = "SELECT empresa.contribuyente, empresa.rif, empresa.nombre, contribuyente.tipo, parroquia.nombre_parroquia AS parroquia FROM empresa 
		  		INNER JOIN contribuyente ON empresa.contribuyente = contribuyente.id 
		  		INNER JOIN parroquia ON empresa.id_parroquia = parroquia.id_parroquia 
		  		WHERE empresa.rif = '".$search."'";
		  	}

		  	$r = $conexion->query($sql);
		  	while($rw = $r->fetch_assoc()){
		  		if($rw["tipo"] == "emp"){
		  			$tipo_con="Juridico";
		  		}else{
		  			$tipo_con="Natural";
		  		}

		  		$sql = "SELECT MAX(cod_factura) ultimo_pago, MAX(fecha_pago) fecha_ultimo_pago FROM factura GROUP BY contribuyente HAVING contribuyente = " . $rw["contribuyente"];
				$re = $conexion->query($sql);
				$d = array();
				if($re->num_rows > 0){
					while($d[] = $re->fetch_assoc());
					$ultimo_pago = $d[0];
					$ult_pag = "Cod: ".$ultimo_pago['ultimo_pago'];
					$ult_pag .= " - Fecha: ". $ultimo_pago['fecha_ultimo_pago'];
				}else{
					$ult_pag = "No posee ningúna solvencia";
				}

		  		$datos[] = array(
		  			$rw["rif"],
		  			$rw["nombre"],
		  			$tipo_con,
		  			$ult_pag,
		  			$rw["parroquia"]
		  		);
		  	}

			$dis_glob = 1;
		}
	}

	if($dis_glob == 1){
		/******************************    PARTE PDF    *************************/
		$pdf->SetFillColor(7,72,211);
		$pdf->SetTextColor(255);
		$pdf->SetDrawColor(82,75,75);
		$pdf->SetLineWidth(.3);
		$pdf->SetFont('Arial','B',11);
		$pdf->SetX(10);
		// Cabecera
		$anchurasColumnas = array(20, 50, 25, 40, 60);
		for($i=0;$i<count($cabecera);$i++){
		    $pdf->Cell($anchurasColumnas[$i],12,utf8_decode($cabecera[$i]),'B',0,'C',true);
		}
		$pdf->Ln();
		for($l = 0; $l < count($datos); $l++){
			$alineaciones = array("C","L","C","C","C");
		    $pdf->SetTextColor(0);
			
		    $pdf->SetFont("Arial","",8);

			$pdf->SetWidths($anchurasColumnas);

			$pdf->SetAligns($alineaciones);
			$posicionY = $pdf->GetY();
			if(($l+1) % 2 == 0){
				$pdf->Row($datos[$l],10,242,192,186,"DF");
			}else{
				$pdf->Row($datos[$l],10,255,255,255,"F");
			}		
	  	}	  	
	}else{
		$pdf->Ln(10);
		$pdf->SetFont('Arial','I',12);
		$pdf->Cell(0,10,utf8_decode("¡NO SE HAN ENCONTRADO RESULTADOS EN LA BUSQUEDA REALIZADA!"),1,1,'C');
	}
	
	$pdf->Output('','reporte_solventes.pdf');
?>