<?php

	date_default_timezone_set ("America/Caracas"); 
	require_once "../config/EntidadBase.php";
	$fecha_actual = date("Y") . "-" . date("m") . "-" . date("d");

	$datos = array();

	$datos_factura = array();

	$entidad = new EntidadBase("factura");

	$conexion = $entidad->db();

	if(isset($_POST["fechaD"]) && isset($_POST["fechaH"])){

		$fechaD = $_POST["fechaD"];
		$fechaH = $_POST["fechaH"];

		if(empty($fechaD) && empty($fechaH)){
			$consulta = "SELECT factura.cod_factura as codigo, factura.fecha_pago as fecha, contribuyente.id as contribuyente, tipo_pago.nombre_tipopago as tipopago, factura.referencia as referencia, factura.montoTotal as monto FROM factura INNER JOIN contribuyente ON factura.contribuyente = contribuyente.id INNER JOIN tipo_pago ON factura.cod_tipopago = tipo_pago.cod_tipopago ORDER BY factura.cod_factura DESC";
		}else if(!empty($fechaD) && empty($fechaH)){
			$consulta = "SELECT factura.cod_factura as codigo, factura.fecha_pago as fecha, contribuyente.id as contribuyente, tipo_pago.nombre_tipopago as tipopago, factura.referencia as referencia, factura.montoTotal as monto FROM factura INNER JOIN contribuyente ON factura.contribuyente = contribuyente.id INNER JOIN tipo_pago ON factura.cod_tipopago = tipo_pago.cod_tipopago WHERE factura.fecha_pago BETWEEN '$fechaD' AND '$fecha_actual' ORDER BY factura.cod_factura DESC";
		}else if(!empty($fechaD) && !empty($fechaH)){
			$consulta = "SELECT factura.cod_factura as codigo, factura.fecha_pago as fecha, contribuyente.id as contribuyente, tipo_pago.nombre_tipopago as tipopago, factura.referencia as referencia, factura.montoTotal as monto FROM factura INNER JOIN contribuyente ON factura.contribuyente = contribuyente.id INNER JOIN tipo_pago ON factura.cod_tipopago = tipo_pago.cod_tipopago WHERE factura.fecha_pago BETWEEN '$fechaD' AND '$fechaH' ORDER BY factura.cod_factura DESC";
		}
	}else if(isset($_POST["busqueda"])){
		$search = $_POST['busqueda'];
		$consulta = "SELECT factura.cod_factura as codigo, factura.fecha_pago as fecha, contribuyente.id as contribuyente, tipo_pago.nombre_tipopago as tipopago, factura.referencia as referencia, factura.montoTotal as monto FROM factura INNER JOIN contribuyente ON factura.contribuyente = contribuyente.id INNER JOIN tipo_pago ON factura.cod_tipopago = tipo_pago.cod_tipopago WHERE factura.cod_factura = '$search' OR factura.referenciaPago = '$search' OR tipo_pago.nombre_tipopago = '$search' ORDER BY factura.cod_factura DESC";
	}

	$resultado = $conexion->query($consulta);

	if($resultado->num_rows > 0){
	  	while($row = $resultado->fetch_assoc()){

	  		$tipo = $entidad->tipo_contribuyente($row["contribuyente"]);

	  		if($tipo == "emp"){
	  			$tabla = "empresa";
	  		}else{
	  			$tabla = "persona";
	  		}

	  		$sql = "SELECT rif FROM $tabla WHERE contribuyente = ".$row["contribuyente"];
	  		$r = $conexion->query($sql);
	  		$rc = $r->fetch_assoc();
	  		$rif_contribuyente = $rc["rif"];

			$datos_factura[] = array(
		        'codigo' 	=>	$row["codigo"],
		        'fecha'		=>	$row["fecha"],
		        'contribuyente'	=> $rif_contribuyente,
		        'tipopago'	=>	$row["tipopago"],
		        'referencia'=>	$row["referencia"],
		        'monto'		=>	number_format((float)$row["monto"],2,",",".")
		    );
	  	}

	  	$datos_js = json_encode($datos_factura, JSON_UNESCAPED_UNICODE);

	  	echo $datos_js;
	}else{
		echo 0;
	}

?>