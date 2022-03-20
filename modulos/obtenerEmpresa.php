<?php

	require_once "../config/EntidadBase.php";
	$entidad = new EntidadBase("empresa");
	$conexion = $entidad->db();
	$retornoCompleto = array();
	$rif = $_POST['llave'];

	$sql_empresa = "SELECT 
				empresa.rif as rif_empresa, 
				empresa.codigo_comercio,
				empresa.nombre as nombre_empresa, 
				empresa.telefono as telefono_empresa, 
				empresa.id_parroquia as parroquia_empresa, 
				empresa.direccion as direccion_empresa, 
				empresa.cod_actCom as actividad_comercial, 
				fecha_creacion,  
				persona.rif as rif_persona, 
				persona.cedula as cedula_persona, 
				persona.nombres as nombre_persona, 
				persona.apellidos as apellido_persona, 
				persona.id_parroquia as parroquia_persona, 
				persona.direccion as direccion_persona, 
				persona.telefono as telefono_persona,
				estado.id_estado as estado_persona,
				municipio.id_municipio as municipio_persona
				FROM empresa
				INNER JOIN persona ON empresa.persona_rif = persona.rif
				INNER JOIN parroquia ON persona.id_parroquia = parroquia.id_parroquia 
				INNER JOIN municipio ON parroquia.id_municipio = municipio.id_municipio
				INNER JOIN estado ON municipio.id_estado = estado.id_estado 
				WHERE empresa.rif = '$rif'";

	$resultado = $conexion->query($sql_empresa);

	if($resultado->num_rows == 1){
		while($datos_empresa[] = $resultado->fetch_assoc());
		array_pop($datos_empresa);
		$dataEmp = $datos_empresa[0];

		$q = "SELECT contribuyente FROM persona WHERE rif = '".$dataEmp["rif_persona"]."'";
		$r = $conexion->query($q);
		if($r){
			while($d[] = $r->fetch_assoc());
			$per_contri = $d[0]["contribuyente"];
			if($per_contri >= 2){
				$contrib = 1;
			}else if($per_contri == 1){
				$contrib = 0;
			}

			$retornoCompleto = array(
				'rif_empresa-form' => $dataEmp["rif_empresa"],
				'cod_comercio-form' => $dataEmp["codigo_comercio"],
				'nombre_empresa-form' => $dataEmp["nombre_empresa"],
				'telefono_empresa-form' => $dataEmp["telefono_empresa"],	
				'registro_empresa-form' => $dataEmp["fecha_creacion"],
				'parroquia-empresa-form' => $dataEmp["parroquia_empresa"],
				'deta_dir_empresa-form' => $dataEmp["direccion_empresa"],
				'actividad_comercial-form' => $dataEmp["actividad_comercial"],
				'rif_propietario-form' => $dataEmp["rif_persona"],
				'cedula_propietario-form' => $dataEmp["cedula_persona"],
				'nombre_propietario-form' => $dataEmp["nombre_persona"],
				'apellido_propietario-form' => $dataEmp["apellido_persona"],
				'estado_propietario-form' => $dataEmp['estado_persona'],
				'municipio_propietario-form' => $dataEmp['municipio_persona'],
				'parroquia-propietario-form' => $dataEmp["parroquia_persona"],
				'deta_dir_persona-form' => $dataEmp["direccion_persona"],
				'telefono_propietarioForm' => $dataEmp['telefono_persona'],
				'contribuyente_rep' => $contrib
			);

			$datosCompletos = json_encode($retornoCompleto, JSON_UNESCAPED_UNICODE);
			echo $datosCompletos;
		}		
	}else{
		echo 0;
	}
?>