<?php
	
	$mensaje = ""; //MENSAJE PARA EL OBJETO JSON
	$advertencia = 0; //TIPO DE ADVERTENCIA 1: BIEN, 2: ADVERTENCIA, 3: PELIGRO
	$tr = 0;
	$codigo_factura = 0;

	require_once "../config/EntidadBase.php";
	require_once "../config/functions.php";

	$entidad = new EntidadBase("factura");
	$conexion = $entidad->db();

	//CONSULTA QUE OBTIENE LA FECHA Y HORA ACTUAL DEL SISTEMA.
	$sql = "SELECT now() as fecha_actual";
	$resultado = $conexion->query($sql);
	$resultado = $resultado->fetch_assoc();
	$dateCurrent = explode(' ',$resultado["fecha_actual"]);
	
	/* FECHA Y HORA ACTUAL DEL SISTEMA LOCAL. */
	$fecha_actual = $dateCurrent[0];
	$hora_actual = $dateCurrent[1];
	$mes_actual = (int)date("m");
	$anyo_actual = (int)date("Y");

	//GUARDA EL JSON GLOBAL QUE VIENE DE LA PETICION POST AJAX
	$superdata = $_POST["superdata"];
	
	//TRANSFORMA EL JSON EN UN ARRAY PARA QUE SEA UTIL EN PHP
	$array_superdata = json_decode($superdata, true, 512, JSON_BIGINT_AS_STRING);

	//GUARDA LOS DATOS RELEVANTES NO REPETIDOS
	$datosImportantes = $array_superdata[0];
	//GUARDA LOS TRIBUTOS CANCELADOS ES UN ARRAY DE ARRAYS.
	$datosTributos = $array_superdata[1];
	
	//OBTENER EL ID DEL CONTRIBUYENTE A TRAVES DE SU RIF.
	$id_contribuyente = $entidad->id_contribuyente_rif($datosImportantes["rif"]);
	
	//CONSULTA PARA OBTENER EL NUMERO DEL TRIMESTRE DE HASTA.
	$sql = "SELECT numero FROM trimestre WHERE id_trimestre = ". $datosImportantes["trimestre_hasta"] ;
	$resultado = $conexion->query($sql)->fetch_assoc();
	$hasta_trimestre = $resultado["numero"];

	if($datosImportantes["year_hasta"] == $anyo_actual && $hasta_trimestre >= encontrarTrimestre($mes_actual)){
		//QUEDA SOLVENTE SI VA A PAGAR LOS TRIBUTOS HASTA EL TRIMESTRE ACTUAL.
		$sql_act = "UPDATE contribuyente SET deudor = 0 WHERE id = $id_contribuyente";
	}else{
		//QUEDA DEUDOR SI TODAVIA NO LLEGA A PAGAR EL TRIMESTRE ACTUAL.
		$sql_act = "UPDATE contribuyente SET deudor = 1 WHERE id = $id_contribuyente";
	}

	$result = $conexion->query($sql_act);
	if($result){
		//REGISTRO DE LA FACTURA.
		$sql = "INSERT INTO factura (contribuyente, fecha_pago, hora_pago, cod_tipopago, referencia, montoTotal) VALUES ($id_contribuyente,'$fecha_actual','$hora_actual',".$datosImportantes["tipo_pago"].",'".$datosImportantes["referencia"]."',".$datosImportantes["total_completo"].")";
		$r = $conexion->query($sql);
		if($r){
			$codigo_factura = $conexion->insert_id; //CODIGO DE LA FACTURA.

			//VERIFICACION DEL TIPO DE PAGO SI ES UNO SE REGISTRA EL EFECTIVO.
			if($datosImportantes["tipo_pago"] == 1){
				$ie = "INSERT INTO efectivo (factura) VALUES ($codigo_factura)";
				$rie = $conexion->query($ie);
				if($rie){
					$mensaje .= "Se ha actualizado la referencia de efectivo. Y ";
				}else{
					$mensaje .= "Error el registro del Efecitvo." . $conexion->error . ". ";
					$advertencia = 3;
				}
			}

			//BUCLE (1) QUE COMIENZA EN 0 Y TERMINA EN EL (TAMAÑO - 1) DE LOS
			//TRIBUTOS A CANCELAR.
			for($i = 0; $i < count($datosTributos); $i++){
				$tributo = $datosTributos[$i];
				$id_tributo = $tributo["tributo"];
				$impuesto = !empty($tributo["impuesto"]) ? $tributo["impuesto"] : "NULL";
				//BUCLE (2) QUE COMIENZA EN TRIMESTRE DESDE Y TERMINA EN
				//TRIMESTRE HASTA
				for($j = $datosImportantes["trimestre_desde"]; $j <= $datosImportantes["trimestre_hasta"]; $j++){

					//GUARDA LA CANTIDAD DE REGISTROS ENCONTRADOS.
					$verificacion = $conexion->query("SELECT factura FROM detalle_factura WHERE trimestre = $j AND tributo = $id_tributo")->num_rows;
					
					//VERIFICACIÓN DEL TRIBUTO EN EL TRIMESTRE.
					//SINO ENCUENTRA TRIBUTOS.
					if($verificacion == 0){
						//REGISTRO DEL TRIBUTO EN EL TRIMESTRE ESPECIFICO.
						if($conexion->query("INSERT INTO detalle_factura (factura, trimestre, tributo, observacion, impuesto_mora, monto, total) VALUES ($codigo_factura,$j,$id_tributo,'".$tributo["observacion"]."',$impuesto,".$tributo["monto"].",".$tributo["total_tribut"].")")){
							$tr++;
						}
					}
				}
			}

			$vtr = $conexion->query("SELECT * FROM detalle_factura WHERE factura = $codigo_factura")->num_rows;

			if($vtr == $tr && $vtr != 0){
				$mensaje .= "REGISTRO EXITOSO DE LOS DATOS DE LA FACTURA. EN SEGUNDOS SALDRÁ EL REPORTE.";
				$advertencia = 1;
			}else{
				$mensaje .= "Error el registro de los detalles (tributos en trimestres) de la Factura." . $conexion->error;
				$advertencia = 3;
			}
		}else{
			$mensaje = "Error el registro de la Factura." . $conexion->error;
			$advertencia = 3;
		}
	}else{
		$mensaje = "Error en la verificacion de Deuda" . $conexion->error;
		$advertencia = 3;
	}

	$d = array('mensaje' => $mensaje, 'advertencia' => $advertencia, 'codigo_factura' => $codigo_factura);
	$d_json = json_encode($d, JSON_UNESCAPED_UNICODE);
	echo $d_json;
?>