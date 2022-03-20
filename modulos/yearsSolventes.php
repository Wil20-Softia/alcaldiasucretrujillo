<?php
	require_once "../config/EntidadBase.php";
	
	$entidad = new EntidadBase("detalle_factura");
	$conexion = $entidad->db();
	$sql = "SELECT trimestre.anyo FROM detalle_factura INNER JOIN trimestre ON detalle_factura.trimestre = trimestre.id_trimestre WHERE 1 GROUP BY trimestre.anyo";
	$resultado = $conexion->query($sql);
	if($resultado->num_rows > 0){
		while($r[] = $resultado->fetch_assoc());
		array_pop($r);
	}

	$datos_js = json_encode($r, JSON_UNESCAPED_UNICODE);
	echo $datos_js;
?>