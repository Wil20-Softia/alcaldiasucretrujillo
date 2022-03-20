<?php
	require_once "../config/EntidadBase.php";

	$search = $_POST['busqueda'];

	$datos = array();

	$entidad = new EntidadBase("contribuyente");

	$conexion = $entidad->db();

	$tipo = $entidad->tipo_contribuyente_rif($search);

	if(!$tipo){
		echo 0;
	}else{
		if($tipo == "per"){
	  		$sql = "SELECT contribuyente, rif, CONCAT(nombres,' ',apellidos) AS nombre, telefono, direccion FROM persona WHERE rif = '".$search."'";
	  	}else{
	  		$sql = "SELECT contribuyente, rif, nombre, telefono, direccion FROM empresa WHERE rif = '".$search."'";
	  	}

	  	$r = $conexion->query($sql);
	  	while($datos[] = $r->fetch_assoc());
		array_pop($datos);

		$datos_pagina_js = json_encode($datos, JSON_UNESCAPED_UNICODE);
  		echo $datos_pagina_js;
	}
?>