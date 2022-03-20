<?php

	require_once "../config/EntidadBase.php";

	$datos = array();

	$sql = "SELECT * FROM tipo_pago ORDER BY tipo_pago.cod_tipopago ASC";

	$entidad = new EntidadBase("tipo_pago");
	
	$conexion = $entidad->db();
	
	$resultado = $conexion->query($sql);

	while($datos[] = $resultado->fetch_assoc());
	
	array_pop($datos);

	$tiposPago = json_encode($datos, JSON_UNESCAPED_UNICODE);

  	echo $tiposPago;

?>