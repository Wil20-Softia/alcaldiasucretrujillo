<?php
	
	$municipio = isset($_POST["id_municipio"]) ? $_POST["id_municipio"] : 282;
	
	$sql = "SELECT nombre_parroquia as nombre, id_parroquia as id FROM parroquia WHERE id_municipio = $municipio";

	require_once "../config/EntidadBase.php";

	$datos = array();

	$entidad = new EntidadBase("parroquia");

	$conexion = $entidad->db();

	$resultado = $conexion->query($sql);

	while($datos[] = $resultado->fetch_assoc());

	array_pop($datos);

	$parroquias = json_encode($datos, JSON_UNESCAPED_UNICODE);

  	echo $parroquias;
?>