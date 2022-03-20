<?php

	require_once "../config/EntidadBase.php";

	$datos = array();

	$sql = "SELECT codigo, denominacion FROM tributo WHERE 1 ORDER BY codigo ASC";

	$entidad = new EntidadBase("tributo");
	
	$conexion = $entidad->db();
	
	$resultado = $conexion->query($sql);

	while($datos[] = $resultado->fetch_assoc());
	
	array_pop($datos);

	$tributo = json_encode($datos, JSON_UNESCAPED_UNICODE);

  	echo $tributo;

?>