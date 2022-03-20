<?php
	date_default_timezone_set ("America/Caracas"); 
	$fecha_actual = date("Y") . "-" . date("m") . "-" . date("d");
	$mensaje = "";
	$advertencia = 0;
	require_once "../config/EntidadBase.php";
	
    //DATOS DEL PROPIETARIO DE LA EMPRESA.
    $nombre_prop = $_POST["nombre_prop"];
    $apellido_prop = $_POST["apellido_prop"];
    $cedula_prop = $_POST["cedula_prop"]; 		//NO
    $rif_prop = $_POST["rif_prop"]; 			//NO
    $parroquia_prop = $_POST["parroquia_prop"];
    $deta_dir_prop = $_POST["deta_dir_prop"];
    $telefono_prop = $_POST["telefono_prop"];

	$entidad = new EntidadBase("empresa");

	$conexion = $entidad->db();

	$modificar = "UPDATE persona SET nombres='$nombre_prop', apellidos='$apellido_prop',id_parroquia=$parroquia_prop, direccion='$deta_dir_prop', telefono='$telefono_prop' WHERE cedula='$cedula_prop' AND rif='$rif_prop'";
	$resultado = $conexion->query($modificar);
	if($resultado){
		$mensaje = "¡MODIFICACIÓN EXITOSA!";
		$advertencia = 1;
	}else{
		$mensaje = "¡Fallo en la modificación de los datos de la persona!";
		$advertencia = 3;
	}

	$datos = array('mensaje' => $mensaje, 'advertencia' => $advertencia);
	$datos_json = json_encode($datos, JSON_UNESCAPED_UNICODE);
	echo $datos_json;
?>