<?php

	const REGISTROS = 5;
	
	require_once "../config/EntidadBase.php";

	$pagina = $_POST["pagina"];

	$entidad = new EntidadBase("contribuyente");

	$conexion = $entidad->db();

	$datos = array();

	$empezar_desde = ($pagina - 1) * REGISTROS;

	$sql_paginacion = "SELECT id, tipo FROM contribuyente WHERE id NOT IN (1) ORDER BY tipo LIMIT ".$empezar_desde.",". REGISTROS;

	$resul = $conexion->query($sql_paginacion);
  if($resul->num_rows > 0){
  	while($row = $resul->fetch_object()){
  		if($row->tipo == "per"){
  			$sql = "SELECT contribuyente, rif, CONCAT(nombres,' ',apellidos) AS nombre, telefono, direccion FROM persona WHERE contribuyente = ".$row->id;
  		}else{
  			$sql = "SELECT contribuyente, rif, nombre, telefono, direccion FROM empresa WHERE contribuyente = ".$row->id;
  		}
  		$r = $conexion->query($sql);
  		if($r->num_rows == 1){
		  	while($datos[] = $r->fetch_assoc());
			  array_pop($datos);
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
?>