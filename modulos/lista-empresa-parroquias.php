<?php

	require_once "../config/EntidadBase.php";

	$parroquia = $_POST['parr'];

	$cant_parr = 0;

	$datos = array();

	$entidad = new EntidadBase("contribuyente");

	$conexion = $entidad->db();

	$sql_paginacion = "SELECT id, tipo FROM contribuyente WHERE id NOT IN (1) ORDER BY tipo ASC";
	$resul = $conexion->query($sql_paginacion);

	while($row = $resul->fetch_object()){
	  	if($row->tipo == "per"){
	  		$sql = "SELECT contribuyente, rif, CONCAT(nombres,' ',apellidos) AS nombre, telefono, parroquia.nombre_parroquia, direccion FROM persona INNER JOIN parroquia ON persona.id_parroquia = parroquia.id_parroquia WHERE contribuyente = ".$row->id." AND persona.id_parroquia = " . $parroquia;
	  	}else{
	  		$sql = "SELECT contribuyente, rif, nombre, telefono, direccion FROM empresa INNER JOIN parroquia ON empresa.id_parroquia = parroquia.id_parroquia WHERE contribuyente = ".$row->id." AND empresa.id_parroquia = " .$parroquia;
	  	}

	  	$r = $conexion->query($sql);
	  	if($r->num_rows == 1){
	  		$cant_parr++;
			while($datos[] = $r->fetch_assoc());
			array_pop($datos);
	  	}
	}

	if($cant_parr > 0){
		$datos_pagina_js = json_encode($datos, JSON_UNESCAPED_UNICODE);
  		echo $datos_pagina_js;
	}else{
		echo $cant_parr;
	}

?>