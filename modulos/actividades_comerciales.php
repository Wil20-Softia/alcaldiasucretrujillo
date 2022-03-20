<?php
	require_once "../config/EntidadBase.php";
	
	$entidad = new EntidadBase("actividad_comercial");
	$conexion = $entidad->db();

	if(isset($_GET["criterio"])){
		if($_GET["criterio"] == "Listado"){
			$sql = "SELECT descripcion as nombre, cod_actCom as id FROM actividad_comercial WHERE 1";

			$datos = array();

			$resultado = $conexion->query($sql);

			while($datos[] = $resultado->fetch_assoc());

			array_pop($datos);

			$actividades_comerciales = json_encode($datos, JSON_UNESCAPED_UNICODE);

		  	echo $actividades_comerciales;
		}else if($_GET["criterio"] == "ListadoCompleto"){
			if(!isset($_GET["busqueda"])){
				$sql = "SELECT descripcion as nombre, cod_actCom as id FROM actividad_comercial WHERE 1 ORDER BY descripcion ASC";
			}else{
				$busqueda = $_GET["busqueda"];
				$sql = "SELECT descripcion as nombre, cod_actCom as id FROM actividad_comercial WHERE cod_actCom = '$busqueda' OR descripcion LIKE '%$busqueda%' ORDER BY descripcion ASC";
			}

			$resultado = $conexion->query($sql);

			if($resultado->num_rows > 0){
			  	while($row = $resultado->fetch_assoc()){
					$actividades_comerciales[] = array(
				        'codigo' 	=>	$row["id"],
				        'nombre'	=>	$row["nombre"]
				    );
			  	}

			  	$datos_js = json_encode($actividades_comerciales, JSON_UNESCAPED_UNICODE);

			  	echo $datos_js;
			}else{
				echo 0;
			}
		}else if($_GET["criterio"] == "Guardar"){
			$codigo = $_GET["codigo"];
			$descripcion = $_GET["descripcion"];
			$sql = "SELECT * FROM actividad_comercial WHERE cod_actCom = '$codigo'";
			$resultado = $conexion->query($sql);
			if($resultado->num_rows > 0){
				$mensaje = "No Pueden Existir 2 o mas Actividades Comerciales con el mismo Codigo.";
				$advertencia = 2;
			}else{
				$sql = "INSERT INTO actividad_comercial (cod_actCom, descripcion) VALUES ('$codigo','$descripcion')";

				$resultado = $conexion->query($sql);

				if($resultado){
					$mensaje = "¡Enhorabuena! Se ha Guardado exitosamente la Actividad Comercial.";
					$advertencia = 1;
				}else{
					$mensaje = "¡ERROR FATAL AL REGISTRAR LA ACTIVIDAD COMERCIAL!";
					$advertencia = 3;
				}
			}

			$datos = array('mensaje' => $mensaje, 'advertencia' => $advertencia);
			$datos_json = json_encode($datos, JSON_UNESCAPED_UNICODE);
			echo $datos_json;
		}else if($_GET["criterio"] == "Modificar"){
			$codigo = $_GET["codigo"];
			$descripcion = $_GET["descripcion"];
			$sql = "UPDATE actividad_comercial SET descripcion = '$descripcion' WHERE cod_actCom = '$codigo'";

			$resultado = $conexion->query($sql);

			if($resultado){
				$mensaje = "¡Enhorabuena! Se ha Modificado exitosamente la Actividad Comercial.";
				$advertencia = 1;
			}else{
				$mensaje = "¡ERROR FATAL AL MODIFICAR LA ACTIVIDAD COMERCIAL!";
				$advertencia = 3;
			}

			$datos = array('mensaje' => $mensaje, 'advertencia' => $advertencia);
			$datos_json = json_encode($datos, JSON_UNESCAPED_UNICODE);
			echo $datos_json;
		}else if($_GET["criterio"] == "Eliminar"){
			$codigo = $_GET["codigo"];
			$sql = "DELETE FROM actividad_comercial WHERE cod_actCom = '$codigo'";

			$resultado = $conexion->query($sql);

			if($resultado){
				$mensaje = "¡Actividad Comecial Eliminada!";
				$advertencia = 2;
			}else{
				$mensaje = "¡ERROR FATAL AL ELIMINAR LA ACTIVIDAD COMERCIAL!";
				$advertencia = 3;
			}

			$datos = array('mensaje' => $mensaje, 'advertencia' => $advertencia);
			$datos_json = json_encode($datos, JSON_UNESCAPED_UNICODE);
			echo $datos_json;
		}
	 }

?>