<?php
	require_once "../config/EntidadBase.php";
	$entidad = new EntidadBase("empresa");
	$conexion = $entidad->db();
	$id = $_POST["id"];

	//SI EL CONTRIBUYENTE ES EMPRESA
	if($entidad->tipo_contribuyente($id) == "emp"){
		
		//SELECCIONAR EL RIF DEL REPRESENTANTE DE DICHA EMPRESA
		$sql = "SELECT persona_rif FROM empresa WHERE contribuyente = $id";
		$resultado = $conexion->query($sql);
		while($datos[] = $resultado->fetch_assoc());
		array_pop($datos);

		//RIF DEL REPRESENTANTE
		$prop = $datos[0]["persona_rif"];
		
		//OBTIENE LA CANTIDAD DE EMPRESAS QUE TIENE DICHO REPRESENTANTE
		$sql = "SELECT COUNT(rif) AS empresas FROM empresa WHERE persona_rif = '$prop'";
		$resultado = $conexion->query($sql);
		$num_empresas = $resultado->fetch_assoc();

		//CANTIDAD DE EMRPRESAS DEL REPRESENTANTE
		$num_empresas = $num_empresas["empresas"];

		//ELIMINA TANTO AL CONTRIBUYENTE COMO A LA EMPRESA A LA VEZ.
		$sql = "DELETE FROM contribuyente WHERE id = '$id'";
		$resultado = $conexion->query($sql);

		if($resultado){

			//VERIFICA SI EL REPRESENTANTE ES UN CONTRIBUYENTE.
			$sql = "SELECT contribuyente FROM persona WHERE rif = '".$prop."'";
			$r = $conexion->query($sql);
			$pc = $r->fetch_assoc();

			//ID DEL CINTRIBUYENTE: SI ES 1 NO LO ES, SINO SI ES.
			$per_cont = $pc["contribuyente"];
			
			//CONDICION QUE VERIFICA SI EL REPRESENTANTE SOLO TENIA A LA
			//EMPRESA ANTERIORMENTE ELIMINADA Y NO ES CONTRIBUYENTE.
			if($num_empresas == 1 && $per_cont == 1){

				//ELIMINAMOS AL REPRESENTANTE DE LA EMPRESA.
				$sqlDeleteProp = "DELETE FROM persona WHERE rif = '$prop'";
				$resultadoDeleteProp = $conexion->query($sqlDeleteProp);
				if($resultadoDeleteProp){
					$mensaje = "Empresa Eliminada Satisfactoriamente. Con su Representante Legal.";
					$advertencia = 1;
				}else{
					$mensaje = "Fallo en la Eliminación del Propietario.";
					$advertencia = 3;
				}
			
			//CONDICION QUE VERIFICA SI REPRESENTA MAS DE UNA EMPRESA
			//O SI ES UN CONTRIBUYENTE.
			}else if($num_empresas >= 1 || $per_cont >= 1){
				$mensaje = "Empresa Eliminada. Representante Legal es Contribuyente.";
				$advertencia = 1;
			}
		}else{
			$mensaje = "Fallo en la Eliminación de la Empresa.";
			$advertencia = 3;
		}
	
	//SI EL TIPO DE CONTRIBUYENTE ES UNA PERSONA NATURAL
	}else{

		//OBTIENE LA CANTIDAD DE EMPRESAS QUE REPRESENTA LA PERSONA NATURAL
		$sql = "SELECT COUNT(empresa.rif) AS empresas FROM persona INNER JOIN empresa ON persona.rif = empresa.persona_rif WHERE contribuyente = $id";
		$resultado = $conexion->query($sql);
		$num_empresas = $resultado->fetch_assoc();
		$num_empresas = $num_empresas["empresas"];

		//VERIFICA SI EL REPRESENTANTE TIENE UNA EMPRESA
		if($num_empresas >= 1){
			//MODIFICAR LA PERSONA A CONTRIBUYENTE IGUAL A 1
			$update = "UPDATE persona SET contribuyente = 1 WHERE contribuyente = $id";
			$resultado = $conexion->query($update);
			if($resultado){
				$mensaje = "La Persona ya no es Contribuyente. Sigue Siendo Representante.";
				$advertencia = 1;
			}

		//SI LA PERSONA NATURAL NO ES REPRESENTANTE DE NINGUNA EMPRESA
		}else{
			$del = "DELETE FROM contribuyente WHERE id = '$id'";
			$resultado = $conexion->query($del);
			if($resultado){
				$mensaje = "Contribuyente Natural, Eliminado Satisfactoriamente";
				$advertencia = 1;
			}
		}
	}

	$datos = array('mensaje' => $mensaje, 'advertencia' => $advertencia);
	$datos_json = json_encode($datos, JSON_UNESCAPED_UNICODE);
	echo $datos_json;
?>