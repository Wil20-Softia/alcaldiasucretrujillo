<?phP
	
	include "../../config/Plantilla.php";
	require "../../config/EntidadBase.php";

	setlocale(LC_ALL,'es_VE.UTF-8');
	date_default_timezone_set ("America/Caracas"); 

	$fecha_actual_escrita = date("Y") . "-" . date("n") . "-" . date("d"). "-" . date("w");
    $fecha_actual_escrita = reg_date($fecha_actual_escrita);

	$cabecera = array('Rif','Nombre', 'Telefono','Parroquia');
	$datos = array();
	$datos_pagina = array();

	$entidad = new EntidadBase("contribuyente");

	$conexion = $entidad->db();

	if(!isset($_GET["parroquia"]) || $_GET["parroquia"] == 0){
		$sql_paginacion = "SELECT id, tipo FROM contribuyente WHERE id NOT IN (1) ORDER BY tipo ASC";
		$resul = $conexion->query($sql_paginacion);

	  	while($row = $resul->fetch_object()){
	  		if($row->tipo == "per"){
	  			$sql = "SELECT rif, CONCAT(nombres,' ',apellidos) AS nombre, telefono, parroquia.nombre_parroquia FROM persona INNER JOIN parroquia ON persona.id_parroquia = parroquia.id_parroquia WHERE contribuyente = ".$row->id;
	  		}else{
	  			$sql = "SELECT rif, nombre, telefono, parroquia.nombre_parroquia FROM empresa INNER JOIN parroquia ON empresa.id_parroquia = parroquia.id_parroquia WHERE contribuyente = ".$row->id;
	  		}

	  		$r = $conexion->query($sql);
	  		if($r->num_rows == 1){
			  	while($datos = $r->fetch_assoc()){
			  		$d[] = array(
			  			0 => $datos["rif"],
			  			1 => $datos["nombre"],
			  			2 => $datos["telefono"],
			  			3 => $datos["nombre_parroquia"]
			  		);
			  	}
	  		}
	  	}
	}else{
		$sql_paginacion = "SELECT id, tipo FROM contribuyente WHERE id NOT IN (1) ORDER BY tipo ASC";
		$resul = $conexion->query($sql_paginacion);

	  	while($row = $resul->fetch_object()){
	  		if($row->tipo == "per"){
	  			$sql = "SELECT rif, CONCAT(nombres,' ',apellidos) AS nombre, telefono, parroquia.nombre_parroquia FROM persona INNER JOIN parroquia ON persona.id_parroquia = parroquia.id_parroquia WHERE contribuyente = ".$row->id." AND persona.id_parroquia = " . $_GET["parroquia"];
	  		}else{
	  			$sql = "SELECT rif, nombre, telefono, parroquia.nombre_parroquia FROM empresa INNER JOIN parroquia ON empresa.id_parroquia = parroquia.id_parroquia WHERE contribuyente = ".$row->id." AND empresa.id_parroquia = " .$_GET["parroquia"];
	  		}

	  		$r = $conexion->query($sql);
	  		if($r->num_rows == 1){
			  	while($datos = $r->fetch_assoc()){
			  		$d[] = array(
			  			0 => $datos["rif"],
			  			1 => $datos["nombre"],
			  			2 => $datos["telefono"],
			  			3 => $datos["nombre_parroquia"]
			  		);
			  	}
	  		}
	  	}
	}
	
	$pdf = new PDF();
	
	$pdf->AddPage();
	$pdf->Cell(105);
	$pdf->SetFont('Times','I',9);
	$pdf->Cell(0,10,utf8_decode($fecha_actual_escrita . strftime(" a las %I:%M:%S %p")),0,1,'R');
	$pdf->Ln(5);
	$pdf->Cell(10);
	$pdf->SetTextColor(0);
	$pdf->SetDrawColor(122,122,122);
	$pdf->SetLineWidth(0.7);
	$pdf->SetFont('Arial','BIU',14);
	$pdf->Cell(60,10,utf8_decode("Registros de Contribuyentes"),0,1,'C');
	$pdf->Ln(5);
	if(!isset($d)){
		$pdf->SetFont('Arial','',14);
		$pdf->Cell(0,10,utf8_decode("NO SE ENCONTRO NINGUN REGISTRO DE EMPRESAS."),1,1,'C');
	}else{
		$pdf->SetFont('Arial','',9);
		$pdf->TablaColoreadaEmpresas($cabecera, $d);
	}
	$pdf->Output('','listado_contribuyentes.pdf');
?>