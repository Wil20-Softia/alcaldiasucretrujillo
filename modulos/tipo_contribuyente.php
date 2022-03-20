<?php

	require_once "../config/EntidadBase.php";

	$entidad = new EntidadBase("contribuyente");

	$conexion = $entidad->db();

	$tipo = $entidad->tipo_contribuyente_rif($_GET["rif"]);

	if(!$tipo){
		echo 0;
	}else{
		echo $tipo;
	} 
?>