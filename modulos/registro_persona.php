<?php
	date_default_timezone_set ("America/Caracas"); 
	$fecha_actual = date("Y") . "-" . date("m") . "-" . date("d");
	$aa = (int)date("Y");
	$ma = (int)date("m");
	$mensaje = "";
	$advertencia = 0;
	require_once "../config/EntidadBase.php";

    //DATOS DEL PROPIETARIO DE LA EMPRESA.
    $nombre_prop = $_POST["nombre_prop"];
    $apellido_prop = $_POST["apellido_prop"];
    $cedula_prop = $_POST["cedula_prop"];
    $rif_prop = $_POST["rif_prop"];
    $parroquia_prop = $_POST["parroquia_prop"];
    $deta_dir_prop = $_POST["deta_dir_prop"];
    $telefono1_prop = $_POST["telefono_prop"];

	$entidad = new EntidadBase("persona");

	$conexion = $entidad->db();

	$sql_prop = "SELECT * 
				FROM persona 
				WHERE (cedula LIKE '$cedula_prop') OR (rif LIKE '$rif_prop')";
	$resultado_prop = $conexion->query($sql_prop);

	if($resultado_prop->num_rows == 0){

		$sql = "INSERT INTO contribuyente (fecha_registrado, tipo, deudor) VALUES (NOW(),'per',1);";
		$resultado = $conexion->query($sql);
		if($resultado){
			$id_contribuyente_per = $conexion->insert_id;
			$registro = "INSERT INTO persona (rif, cedula, contribuyente, nombres, apellidos, id_parroquia, direccion, telefono) VALUES ('$rif_prop','$cedula_prop',$id_contribuyente_per,'$nombre_prop','$apellido_prop',$parroquia_prop,'$deta_dir_prop','$telefono1_prop')";
			$resultado = $conexion->query($registro);
			if($resultado){
				$mensaje = "¡REGISTRO DE CONTRIBUYENTE EXITOSO!";
				$advertencia = 1;
			}else{
				$mensaje = "Fallo en la inserción de persona. Descripción del Error: ". $conexion->error;
				$advertencia = 3;
			}
		}else{
			$mensaje = "Fallo en la inserción de contribuyente. Descripción del Error: ". $conexion->error;
			$advertencia = 3;
		}	
	}else{
		$mensaje = "¡Este Persona Natural ya esta registrada en el Sistema. Cedula o Rif ya Reistrados.";
		$advertencia = 2;
	}

	$datos = array('mensaje' => $mensaje, 'advertencia' => $advertencia);
	$datos_json = json_encode($datos, JSON_UNESCAPED_UNICODE);
	echo $datos_json;
?>