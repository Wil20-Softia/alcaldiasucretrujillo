<?php
 
	require_once "../config/EntidadBase.php";
	require_once "../config/functions.php";

	$datos_solvente = array();
	$d = array();
	$entidad = new EntidadBase("contribuyente");
	$mes_actual = (int)date("m");
	$anyo_actual = (int)date("Y");
	$conexion = $entidad->db();
	$disponible = 0;

	if(isset($_POST["mesDesde"]) && isset($_POST["mesHasta"])){

		$trimestre_desde = $_POST["mesDesde"];
		$trimestre_hasta = $_POST["mesHasta"];

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
					  			"rif" => $rw["rif"],
					  			"nombre" => $rw["nombre"],
					  			"tipo" => $tipo_con,
					  			"ultimo_pago" => $ult_pag,
					  			"parroquia" => $rw["parroquia"]
					  		);
					  	}
		  			}
		  		}
		  		if(count($datos) > 0){
		 			$datos_pagina_js = json_encode($datos, JSON_UNESCAPED_UNICODE);
		  			echo $datos_pagina_js;
		  		}else{
		  			echo 0;
		  		}
		  	}else{
		    	echo 0;
		  	}
		}else{
			echo $disponible;
		}
	}else if(isset($_POST["busqueda"])){
		$search = $_POST["busqueda"];
	  	$tipo = $entidad->tipo_contribuyente_rif($search,"0");

		if(!$tipo){
			echo 0;
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
		  			"rif" => $rw["rif"],
		  			"nombre" => $rw["nombre"],
		  			"tipo" => $tipo_con,
		  			"ultimo_pago" => $ult_pag,
		  			"parroquia" => $rw["parroquia"]
		  		);
		  	}

			$datos_pagina_js = json_encode($datos, JSON_UNESCAPED_UNICODE);
	  		echo $datos_pagina_js;
		}
	}
?>