<?php

	require_once "../config/EntidadBase.php";

	$condicion = $_POST['buscador'];
	$busqueda = $_POST['valor'];

	if($condicion == 'en'){
		$tabla = "empresa";
		$campo = "nombre";
	}else if($condicion == 'er'){
		$tabla = "empresa";
		$campo = "rif";
	}else if($condicion == 'pc'){
		$tabla = "persona";
		$campo = "cedula";
	}else if($condicion == 'pr'){
		$tabla = "persona";
		$campo = "rif";
	}else if($condicion == 'act_com'){
		$tabla = "actividad_comercial";
		$campo = "cod_actCom";
	}
	
	$sql = "SELECT $campo FROM $tabla WHERE $campo LIKE '$busqueda'";
	$entidad = new EntidadBase($tabla);
	$conexion = $entidad->db();

	$resultado = $conexion->query($sql);

	if($resultado->num_rows > 0){
		echo 1;
	}else{
		echo 0;
	}
?>