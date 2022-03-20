<?php
	date_default_timezone_set ("America/Caracas"); 
	$fecha_actual = date("Y") . "-" . date("m") . "-" . date("d");
	$aa = (int)date("Y");
	$ma = (int)date("m");
	$mensaje = "";
	$advertencia = 0;
	require_once "../config/EntidadBase.php";
	
	//DATOS DE LA EMPRESA.
	$nombre_empresa = $_POST["nombre_empresa"]; 
    $rif_empresa = $_POST["rif_empresa"];
    $cod_com_emp = $_POST["cod_com_emp"];
    $telefono_emp = $_POST["telefono_emp"];
    $fech_reg_emp = $_POST["fech_reg_emp"];
    $parroquia_emp = $_POST["parroquia_emp"];
    $deta_dir_emp = $_POST["deta_dir_emp"];
    $act_com_emp = $_POST["act_com_emp"];

    //DATOS DEL PROPIETARIO DE LA EMPRESA.
    $nombre_prop = $_POST["nombre_prop"];
    $apellido_prop = $_POST["apellido_prop"];
    $cedula_prop = $_POST["cedula_prop"];
    $rif_prop = $_POST["rif_prop"];
    $parroquia_prop = $_POST["parroquia_prop"];
    $deta_dir_prop = $_POST["deta_dir_prop"];
    $telefono1_prop = $_POST["telefono_prop"];

    $contribuyente = $_POST["contribuyente_resp"];

	$entidad = new EntidadBase("persona");

	$conexion = $entidad->db();

	$sql_prop = "SELECT * 
				FROM persona 
				WHERE (cedula LIKE '$cedula_prop') OR (rif LIKE '$rif_prop')";

	$sql_emp = "SELECT * 
				FROM empresa 
				WHERE (rif LIKE '$rif_empresa') OR (nombre LIKE '$nombre_empresa')";

	$resultado_emp = $conexion->query($sql_emp);
	$resultado_prop = $conexion->query($sql_prop);

	if($resultado_prop->num_rows == 0 || $resultado_emp->num_rows == 0){

		if($contribuyente == 1){
			$sql = "INSERT INTO contribuyente (fecha_registrado, tipo, deudor) VALUES (NOW(),'per',1)";
			$resultado = $conexion->query($sql);
			if($resultado){
				$id_contribuyente_per = $conexion->insert_id;
			}else{
				$mensaje = "FALLO EN EL CONTRIBUYENTE NATURAL. Descripcion del Error: ". $conexion->error;
				$advertencia = 3;
			}
		}else{
			$id_contribuyente_per = 1;
		}

		$registro = "INSERT INTO persona (rif, cedula, contribuyente, nombres, apellidos, id_parroquia, direccion, telefono) VALUES ('$rif_prop','$cedula_prop',$id_contribuyente_per,'$nombre_prop','$apellido_prop',$parroquia_prop,'$deta_dir_prop','$telefono1_prop')";

		$resultado = $conexion->query($registro);
		if($resultado){
			$sql = "INSERT INTO contribuyente(fecha_registrado, tipo, deudor) VALUES (NOW(),'emp',1)";
			$resultado = $conexion->query($sql);
			if($resultado){
				$id_contribuyente_emp = $conexion->insert_id;
				$registro = "INSERT INTO empresa(rif, codigo_comercio, nombre, persona_rif, contribuyente, telefono, id_parroquia, direccion, cod_actCom, fecha_creacion) VALUES ('$rif_empresa','$cod_com_emp','$nombre_empresa','$rif_prop',$id_contribuyente_emp,'$telefono_emp',$parroquia_emp,'$deta_dir_emp','$act_com_emp','$fech_reg_emp')";
				$resultado = $conexion->query($registro);
				if($resultado){
					$mensaje = "¡REGISTRO DEL CONTRIBUYENTE EXITOSO!";
					$advertencia = 1;
				}else{
					$mensaje = "Descripcion del Error: ". $conexion->error . "\\nNumero de Linea del Error: " . $conexion->errno;
					$advertencia = 3;
				}
			}else{
				$mensaje = "Descripcion del Error: ". $conexion->error . "\\nNumero de Linea del Error: " . $conexion->errno;
				$advertencia = 3;
			}
		}else{
			$mensaje = "Fallo al registrar el representante.";
			$advertencia = 3;
		}
	}else{
		$mensaje = "¡Este Representante o Empresa ya esta registrada en el Sistema. Solo un Representante particular por Empresa.";
		$advertencia = 2;
	}

	$datos = array('mensaje' => $mensaje, 'advertencia' => $advertencia);
	$datos_json = json_encode($datos, JSON_UNESCAPED_UNICODE);
	echo $datos_json;
?>