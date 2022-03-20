<?php

	require_once "../config/EntidadBase.php";
	$entidad = new EntidadBase("persona");
	$conexion = $entidad->db();
	$retornoCompleto = array();
	$rif = $_POST['llave'];

	$sql_empresa = "SELECT
				persona.rif as rif_persona, 
				persona.cedula as cedula_persona, 
				persona.nombres as nombre_persona, 
				persona.apellidos as apellido_persona, 
				persona.id_parroquia as parroquia_persona, 
				persona.direccion as direccion_persona, 
				persona.telefono as telefono_persona
				FROM contribuyente 
				INNER JOIN persona ON contribuyente.id = persona.contribuyente
				WHERE persona.rif = '$rif'";
	$resultado = $conexion->query($sql_empresa);

	if($resultado->num_rows == 1){
		while($datos_persona[] = $resultado->fetch_assoc());
		array_pop($datos_persona);
		$dataPers = $datos_persona[0];
		$retornoCompleto = array(
			'rif_persona-form' => $dataPers["rif_persona"],
			'cedula_persona-form' => $dataPers["cedula_persona"],
			'nombre_persona-form' => $dataPers["nombre_persona"],
			'apellido_persona-form' => $dataPers["apellido_persona"],
			'parroquia-persona-form' => $dataPers["parroquia_persona"],
			'deta_dir_persona-form' => $dataPers["direccion_persona"],
			'telefono_personaForm' => $dataPers['telefono_persona']
		);
		$datosCompletos = json_encode($retornoCompleto, JSON_UNESCAPED_UNICODE);
		echo $datosCompletos;		
	}else{
		echo 0;
	}
?>