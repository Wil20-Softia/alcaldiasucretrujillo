<?php
	date_default_timezone_set ("America/Caracas"); 
	$fecha_actual = date("Y") . "-" . date("m") . "-" . date("d");
	$mensaje = "";
	$advertencia = 0;
	require_once "../config/EntidadBase.php";
	
	//DATOS DE LA EMPRESA.
	$nombre_empresa = $_POST["nombre_empresa"]; 	//NO
    $rif_empresa = $_POST["rif_empresa"]; 			//NO
    $cod_com_emp = $_POST["cod_com_emp"]; 			//NO
    $telefono_emp = $_POST["telefono_emp"];
    $fech_reg_emp = $_POST["fech_reg_emp"]; 		//NO
    $parroquia_emp = $_POST["parroquia_emp"];
    $deta_dir_emp = $_POST["deta_dir_emp"];
    $act_com_emp = $_POST["act_com_emp"]; 			//NO

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

	$modificar = "UPDATE empresa SET telefono='$telefono_emp', id_parroquia=$parroquia_emp, direccion='$deta_dir_emp' WHERE rif = '$rif_empresa' AND nombre = '$nombre_empresa'";
	$resultado = $conexion->query($modificar);

	$mod_con = "UPDATE contribuyente INNER JOIN empresa ON empresa.contribuyente = contribuyente.id SET fecha_registrado='$fecha_actual' WHERE empresa.rif = '$rif_empresa'";
	$res = $conexion->query($mod_con);

	if($resultado && $res){
		$modificar = "UPDATE persona SET nombres='$nombre_prop', apellidos='$apellido_prop',id_parroquia=$parroquia_prop, direccion='$deta_dir_prop', telefono='$telefono_prop' WHERE cedula='$cedula_prop' AND rif='$rif_prop'";
		$resultado = $conexion->query($modificar);
		if($resultado){
			$mensaje = "¡MODIFICACIÓN EXITOSA!";
			$advertencia = 1;
		}else{
			$mensaje = "¡Fallo en la modificación de los datos del propietario!";
			$advertencia = 3;
		}
	}else{
		$mensaje = "¡Fallo en la modificación de los datos de la empresa!";
		$advertencia = 3;
	}

	$datos = array('mensaje' => $mensaje, 'advertencia' => $advertencia);
	$datos_json = json_encode($datos, JSON_UNESCAPED_UNICODE);
	echo $datos_json;
?>