<?php

	$sql = "SELECT nombre_estado as nombre, id_estado as id FROM estado WHERE 1";

	require_once "../config/EntidadBase.php";

	$datos = array();

	$entidad = new EntidadBase("estado");

	$conexion = $entidad->db();

	$resultado = $conexion->query($sql);

	while($datos[] = $resultado->fetch_assoc());

	array_pop($datos);

	$estados = json_encode($datos, JSON_UNESCAPED_UNICODE);

  	echo $estados;
?>