<?php

	date_default_timezone_set ("America/Caracas"); 
	require_once "../config/EntidadBase.php";

	$datos = array();

	$entidad = new EntidadBase("empresa");

	$conexion = $entidad->db();

	if(isset($_POST["busqueda"]) && !empty($_POST["busqueda"])){
	  	$search = $_POST["busqueda"];
	  	$tipo = $entidad->tipo_contribuyente_rif($search,"1");

		if(!$tipo){
			echo 0;
		}else{
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
		  			"rif" => $rw["rif"],
		  			"nombre" => $rw["nombre"],
		  			"tipo" => $tipo_con,
		  			"telefono" => $rw["telefono"],
		  			"parroquia" => $rw["nombre_parroquia"],
		  			"direccion" => $rw["direccion"]
		  		);
		  	}

			$datos_pagina_js = json_encode($datos, JSON_UNESCAPED_UNICODE);
	  		echo $datos_pagina_js;
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
				  			"rif" => $rw["rif"],
				  			"nombre" => $rw["nombre"],
				  			"tipo" => $tipo_con,
				  			"telefono" => $rw["telefono"],
				  			"parroquia" => $rw["nombre_parroquia"],
				  			"direccion" => $rw["direccion"]
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
	}
?>