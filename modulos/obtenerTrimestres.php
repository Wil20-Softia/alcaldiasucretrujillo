<?php

	require_once "../config/EntidadBase.php";

	$anyo = $_POST['anyo'];

	$entidad = new EntidadBase("trimeste");

	$conexion = $entidad->db();

	$sql = "SELECT id_trimestre, periodo AS nombre FROM trimestre WHERE anyo = $anyo";

	$resul = $conexion->query($sql);
	
	while($datos[] = $resul->fetch_assoc());
	array_pop($datos);
	$trimestres = json_encode($datos, JSON_UNESCAPED_UNICODE);
	echo $trimestres;
?>