<?php

	$sql = "SELECT nombre_municipio as nombre, id_municipio as id FROM municipio WHERE id_estado = " . $_GET["estado"];

	require_once "../config/EntidadBase.php";

	$datos = array();

	$entidad = new EntidadBase("municipio");

	$conexion = $entidad->db();

	$resultado = $conexion->query($sql);

	while($datos[] = $resultado->fetch_assoc());

	array_pop($datos);

	$municipios = json_encode($datos, JSON_UNESCAPED_UNICODE);

  	echo $municipios;

?>