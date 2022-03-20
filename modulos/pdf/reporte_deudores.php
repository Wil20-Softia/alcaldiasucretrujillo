<?php
	
	include "../../config/Plantilla.php";
	require "../../config/EntidadBase.php";

	setlocale(LC_ALL,'es_VE.UTF-8');
	date_default_timezone_set ("America/Caracas"); 
	$fecha_actual = date("Y") . "-" . date("m") . "-01";
	$fecha_actual_escrita = date("Y") . "-" . date("n") . "-" . date("d"). "-" . date("w");
    $fecha_actual_escrita = reg_date($fecha_actual_escrita);

	$cabecera = array('Rif','Nombre','Tipo','Telefono', 'Parroquia','Dirección');
	$datos = array();

	$entidad = new EntidadBase("contribuyente");

	$conexion = $entidad->db();
	$disponible = 0;
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
	$pdf->Cell(60,10,utf8_decode("Contribuyentes Morosos"),0,1,'C');
	$pdf->Ln(5);
	/*FIN DE LA SECCIÓN.*/

	if(isset($_GET["b"]) && !empty($_GET["b"])){
	  	$search = $_GET["b"];
	  	$tipo = $entidad->tipo_contribuyente_rif($search,"1");

		if(!$tipo){
			$disponible = 0;
		}else{
			$disponible = 1;
			if($tipo == "per"){
		  		$sql = "SELECT rif, CONCAT(nombres,' ',apellidos) AS nombre, contribuyente.tipo, telefono, parroquia.nombre_parroquia, direccion FROM persona INNER JOIN contribuyente ON persona.contribuyente = contribuyente.id INNER JOIN parroquia ON persona.id_parroquia = parroquia.id_parroquia WHERE persona.rif = '".$search."'";
		  	}else{
		  		$sql = "SELECT rif, nombre, contribuyente.tipo, telefono, parroquia.nombre_parroquia, direccion FROM empresa INNER JOIN contribuyente ON empresa.contribuyente = contribuyente.id INNER JOIN parroquia ON empresa.id_parroquia = parroquia.id_parroquia WHERE empresa.rif = '".$search."'";
		  	}

		  	$r = $conexion->query($sql);
		  	while($rw = $r->fetch_assoc()){
		  		if($rw["tipo"] == "emp"){
		  			$tipo_con="Juridico";
		  		}else{
		  			$tipo_con="Natural";
		  		}
		  		$datos[] = array(
		  			$rw["rif"],
		  			$rw["nombre"],
		  			$tipo_con,
		  			$rw["telefono"],
		  			$rw["nombre_parroquia"],
		  			$rw["direccion"]
		  		);
		  	}
		}
	}else{
		$consulta = "SELECT id, tipo FROM contribuyente WHERE id NOT IN (1) AND deudor = 1 ORDER BY tipo";

		$resul = $conexion->query($consulta);
	  	if($resul->num_rows > 0){
	  		while($row = $resul->fetch_object()){
	  			if($row->tipo == "per"){
	  				$sql = "SELECT rif, CONCAT(nombres,' ',apellidos) AS nombre, contribuyente.tipo, telefono, parroquia.nombre_parroquia, direccion FROM persona INNER JOIN contribuyente ON persona.contribuyente = contribuyente.id INNER JOIN parroquia ON persona.id_parroquia = parroquia.id_parroquia WHERE contribuyente = ".$row->id;
	  			}else{
	  				$sql = "SELECT rif, nombre, contribuyente.tipo, telefono, parroquia.nombre_parroquia, direccion FROM empresa INNER JOIN contribuyente ON empresa.contribuyente = contribuyente.id INNER JOIN parroquia ON empresa.id_parroquia = parroquia.id_parroquia WHERE contribuyente = ".$row->id;
	  			}
	  			$r = $conexion->query($sql);
	  			if($r->num_rows == 1){
			  		while($rw = $r->fetch_assoc()){
				  		if($rw["tipo"] == "emp"){
				  			$tipo_con="Juridico";
				  		}else{
				  			$tipo_con="Natural";
				  		}
				  		$datos[] = array(
				  			$rw["rif"],
				  			$rw["nombre"],
				  			$tipo_con,
				  			$rw["telefono"],
				  			$rw["nombre_parroquia"],
				  			$rw["direccion"]
				  		);
				  	}
	  			}
	  		}
	  		if(count($datos) > 0){
	  			$disponible = 1;
	  		}else{
	  			$disponible = 0;
	  		}
	  	}else{
	    	$disponible = 0;
	  	}		
	}

	if($disponible == 1){
		/******************************    PARTE PDF    *************************/
		$pdf->SetFillColor(243,96,78);
		$pdf->SetTextColor(255);
		$pdf->SetDrawColor(82,75,75);
		$pdf->SetLineWidth(.3);
		$pdf->SetFont('Arial','B',11);
		$pdf->SetX(10);
		// Cabecera
		$anchurasColumnas = array(20, 33, 23, 30, 30, 60);
		for($i=0;$i<count($cabecera);$i++){
		    $pdf->Cell($anchurasColumnas[$i],12,utf8_decode($cabecera[$i]),'B',0,'C',true);
		}
		$pdf->Ln();
		//var_dump($datos);
	  	for($l = 0; $l < count($datos); $l++){
			$alineaciones = array("C","C","C","C","C","C","J");
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
		//echo 0;
	}

	$pdf->Output('','reporte_deudores.pdf');

?>