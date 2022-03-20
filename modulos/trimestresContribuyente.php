<?php

	require_once "../config/EntidadBase.php";

	$rif = $_POST['rif'];
	$anyo = $_POST['anyo'];
	$entidad = new EntidadBase("contribuyente");

	$conexion = $entidad->db();
	$id = $entidad->id_contribuyente_rif($rif);
	
  	$sql = "SELECT trimestre.id_trimestre FROM detalle_factura 
	  INNER JOIN trimestre ON detalle_factura.trimestre = trimestre.id_trimestre 
	  INNER JOIN factura ON detalle_factura.factura = factura.cod_factura 
	  INNER JOIN contribuyente ON factura.contribuyente = contribuyente.id
	  WHERE contribuyente.id = $id AND trimestre.anyo = $anyo 
	  GROUP BY trimestre.id_trimestre 
	  ORDER BY trimestre.id_trimestre ASC";

  	$resultado = $conexion->query($sql);
 
  	if($resultado->num_rows == 0){
		$datos = array();
  		$sql = "SELECT id_trimestre, periodo AS nombre FROM trimestre WHERE anyo = $anyo";
  		$r = $conexion->query($sql);
		$datos = array();
	  	while($datos[] = $r->fetch_assoc());
		array_pop($datos);
		$trimestres = json_encode($datos, JSON_UNESCAPED_UNICODE);
	  	echo $trimestres;
  	}else if($resultado->num_rows == 4){
  		echo 4;
  	}else{
  		$datos = array();

	  	while($datos[] = $resultado->fetch_row());
		array_pop($datos);

		$no_trimestres = "";

		for($i = 0; $i < count($datos); $i++){
			if($i == count($datos) - 1){
				$no_trimestres .= $datos[$i][0];
			}else{
				$no_trimestres .= $datos[$i][0] . ",";
			}
		}

		$sql = "SELECT id_trimestre, periodo AS nombre FROM trimestre WHERE anyo = $anyo AND id_trimestre NOT IN ($no_trimestres) ORDER BY id_trimestre ASC";
		$r = $conexion->query($sql);
		$datos = array();
	  	while($datos[] = $r->fetch_assoc());
		array_pop($datos);

		$trimestres = json_encode($datos, JSON_UNESCAPED_UNICODE);
	  	echo $trimestres;
  	}
?>