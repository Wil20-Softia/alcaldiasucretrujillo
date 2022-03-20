<?php

	header("Content-Type: text/html; charset=utf8 ");
	include "../../config/Plantilla.php";
	require "../../config/EntidadBase.php";

	setlocale(LC_ALL,'es_VE.UTF-8');

	date_default_timezone_set ("America/Caracas");

	$fecha_actual_escrita = date("Y") . "-" . date("n") . "-" . date("d"). "-" . date("w");
    $fecha_actual_escrita = reg_date($fecha_actual_escrita);

    $fecha_actual = date("Y") . "-" . date("m") . "-" . date("d");

    $datos = array();
    $dato_actCom = array();
    $datos_ubicacion = array();
    $datos_propietario = array();
    $datos_ubicacion_propietario = array();
    $datos_telefonos_propietario = array();
    $datos_ultimo_pago = array();

    $nombre_archivo = "";

    $meses = "";

	$entidad = new EntidadBase("empresa");

	$conexion = $entidad->db();

	$rif = isset($_GET["rif"]) ? $_GET["rif"] : 1;

	$tipo_contribuyente = $entidad->tipo_contribuyente_rif($rif);
	
	if($tipo_contribuyente == "emp"){
		$sql = "SELECT * FROM empresa WHERE rif = '$rif'";
	}else{
		$sql = "SELECT * FROM persona WHERE rif = '$rif'";
	}

	$datos = array();
	$r = $conexion->query($sql);
	while($datos[] = $r->fetch_assoc());
	array_pop($datos);
	$contrib = $datos[0];

	$qc = "SELECT * FROM contribuyente WHERE id = ".$contrib["contribuyente"];
	$dc = array();
	$rc = $conexion->query($qc);
	while($dc[] = $rc->fetch_assoc());
	array_pop($dc);
	$contribuyente = $dc[0];

	$pdf = new PDF();
	
	$h = 7;
	$l = 3;

	/*********************************   NUEVA PAGINA   ******************************/

	$pdf->AddPage();

	//HORA DE IMPRESION O VISTA
	$pdf->Cell(105);
	$pdf->SetFont('Times','I',7);
	$pdf->Cell(0,($h+3),utf8_decode($fecha_actual_escrita . strftime(" a las %I:%M:%S %p")),0,1,'R');
	$pdf->Ln($l+2);

	if($tipo_contribuyente == "emp"){
		$nombre_archivo .= $contrib['nombre'];
		//DATOS PRINCIPALES DE LA EMPRESA
		$pdf->SetFont('Arial','BIU',12);
		$pdf->Cell(10);
		$pdf->Cell(60,$h,utf8_decode("Datos del contribuyente (Empresa)."),0,0,'L');

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(0,$h,utf8_decode("Registrada en el sistema: ".reg_date($contribuyente["fecha_registrado"])),0,1,'R');
		$pdf->Ln($l);
		$pdf->Cell(60,$h,utf8_decode($contrib['nombre']),"T",0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(50,$h,utf8_decode("Rif: ".$contrib['rif']),"T",0,'C');
		$pdf->SetFont('Arial', '', 9);
		$pdf->Cell(0,$h,utf8_decode("Codigo de Comercio: ".$contrib['codigo_comercio']),"T",1,'L');
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(0,$h+2,utf8_decode("Número telefónico: ".$contrib['telefono']),"B",1,'L');
		$pdf->Ln($l+3);
		//BUSQUEDA DE LA ACTIVIDAD COMERCIAL DE LA EMPRESA
		$pdf->Cell(20);
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(0,$h,utf8_decode("Actividad Comercial"),0,1,'L');
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(0,$h+2,utf8_decode("Codigo: ".$contrib['cod_actCom']),"T",1,'L');
		$sql = "SELECT descripcion FROM actividad_comercial WHERE cod_actCom = ".$contrib['cod_actCom'];
		$resultado = $conexion->query($sql);
		while($dato_actCom[] = $resultado->fetch_assoc());
		$actividad_comercial = $dato_actCom[0];
		$pdf->SetFont('Arial', 'I', 12);
		encogimientoTexto($pdf, 12, 176, $h+2,$actividad_comercial['descripcion'], "B", 1, "L");
		$pdf->Ln($l+3);
		//UBICACIÓN DE LA EMPRESA.
		$sql = "SELECT estado.nombre_estado, municipio.nombre_municipio, parroquia.nombre_parroquia FROM empresa INNER JOIN parroquia ON empresa.id_parroquia = parroquia.id_parroquia INNER JOIN municipio ON parroquia.id_municipio = municipio.id_municipio INNER JOIN estado ON municipio.id_estado = estado.id_estado WHERE rif = '$rif'";
		$resultado = $conexion->query($sql);
		while($datos_ubicacion[] = $resultado->fetch_assoc());
		$ubicacion = $datos_ubicacion[0];
		$pdf->Cell(20);
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(0,$h,utf8_decode("Ubicación."),0,1,'L');
		$pdf->SetFont('Arial', '', 11);
		$pdf->Cell(50,$h+2,utf8_decode("Estado: " . $ubicacion['nombre_estado']),"T",0,'C');
		$pdf->Cell(50,$h+2,utf8_decode("Municipio: ". $ubicacion['nombre_municipio']),"T",0,'C');
		$pdf->Cell(0,$h+2,utf8_decode("Parroquia: ". $ubicacion['nombre_parroquia']),"T",1,'C');
		$pdf->SetFont('Times', 'I', 11);
		encogimientoTexto($pdf, 11, 176, $h,"Detalles: ".$contrib['direccion'], "B", 1, "L");
		$pdf->Ln($l+2);
		//FECHA DE CREACIÓN.
		$pdf->SetFont('Arial','BI',11);
		$pdf->Cell(0,$h,utf8_decode("Creada o Registrada legalmente el  ".reg_date($contrib['fecha_creacion'])),0,1,'L');
		$pdf->Ln($l);

		//DATOS DEL PROPIETARIO DE LA EMPRESA.
		$sql = "SELECT persona.nombres, persona.apellidos, persona.rif, persona.cedula, persona.direccion, persona.telefono FROM empresa INNER JOIN persona ON empresa.persona_rif = persona.rif WHERE empresa.rif = '$rif'";
		$resultado = $conexion->query($sql);
		while($datos_propietario[] = $resultado->fetch_assoc());
		$propietario = $datos_propietario[0];
		$pdf->Cell(20);
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(0,$h,utf8_decode("Representante Legal."),0,1,'L');
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(45,$h,utf8_decode($propietario['nombres']),"T",0,'L');
		$pdf->Cell(45,$h,utf8_decode($propietario['apellidos']),"T",0,'L');
		$pdf->Cell(0,$h,utf8_decode("Rif: ".$propietario['rif']),"T",1,'C');
		$pdf->Cell(90,$h+3,utf8_decode("Cedula de Identidad: ".$propietario['cedula']),"B",0,'C');
		$pdf->Cell(90,$h+3,utf8_decode("Número Telefonico: ".$propietario['telefono']),"B",1,'C');
		$pdf->Ln($l+3);

		//DIRECCIÓN DEL PROPIETARIO.
		$sql = "SELECT estado.nombre_estado, municipio.nombre_municipio, parroquia.nombre_parroquia FROM persona INNER JOIN parroquia ON persona.id_parroquia = parroquia.id_parroquia INNER JOIN municipio ON parroquia.id_municipio = municipio.id_municipio INNER JOIN estado ON municipio.id_estado = estado.id_estado WHERE rif LIKE '". $propietario['rif'] ."'";
		$resultado = $conexion->query($sql);
		while($datos_ubicacion_propietario[] = $resultado->fetch_assoc());
		$ubicacion_propietario = $datos_ubicacion_propietario[0];
		$pdf->Cell(40);
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(70,$h,utf8_decode("Dirección de habitación."),0,1,'L');
		$pdf->SetFont('Arial', '', 11);
		$pdf->Cell(50,$h,utf8_decode("Estado: " . $ubicacion_propietario['nombre_estado']),"T",0,'C');
		$pdf->Cell(50,$h,utf8_decode("Municipio: ". $ubicacion_propietario['nombre_municipio']),"T",0,'C');
		$pdf->Cell(0,$h,utf8_decode("Parroquia: ". $ubicacion_propietario['nombre_parroquia']),"T",1,'C');
		$pdf->SetFont('Times', 'I', 11);
		encogimientoTexto($pdf, 11, 176, $h,"Detalles: ".$propietario['direccion'], "B", 1, "L");

	}else{
		$pn = explode (" ", $contrib["nombres"]);
		$primer_nombre = $pn[0];
		$pa = explode (" ", $contrib["apellidos"]);
		$primer_apellido = $pa[0];
		$nombre_archivo .= $primer_nombre.$primer_apellido;	

		//DATOS PRINCIPALES DE LA EMPRESA
		$pdf->SetFont('Arial','BIU',12);
		$pdf->Cell(10);
		$pdf->Cell(60,$h,utf8_decode("Datos del contribuyente (Natural)."),0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(0,$h,utf8_decode("Registrado en el sistema: ".reg_date($contribuyente["fecha_registrado"])),0,1,'R');
		$pdf->Ln($l);
		$pdf->Cell(70,$h,utf8_decode($contrib['nombres'] . " " . $contrib['apellidos']),"T",0,'L');
		$pdf->Cell(0,$h,utf8_decode("Cedula de Identidad: ".$contrib['cedula']),"T",1,'L');
		$pdf->Cell(70,$h+2,utf8_decode("Número telefónico: ".$contrib['telefono']),"B",0,'L');
		$pdf->Cell(0,$h+2,utf8_decode("Rif: ".$contrib['rif']),"B",1,'L');
		$pdf->Ln($l+3);

		
		//UBICACIÓN DE LA EMPRESA.
		$sql = "SELECT estado.nombre_estado, municipio.nombre_municipio, parroquia.nombre_parroquia FROM persona INNER JOIN parroquia ON persona.id_parroquia = parroquia.id_parroquia INNER JOIN municipio ON parroquia.id_municipio = municipio.id_municipio INNER JOIN estado ON municipio.id_estado = estado.id_estado WHERE rif = '$rif'";
		$resultado = $conexion->query($sql);
		while($datos_ubicacion[] = $resultado->fetch_assoc());
		$ubicacion = $datos_ubicacion[0];
		$pdf->Cell(20);
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(0,$h,utf8_decode("Dirección de habitación."),0,1,'L');
		$pdf->SetFont('Arial', '', 11);
		$pdf->Cell(50,$h+2,utf8_decode("Estado: " . $ubicacion['nombre_estado']),"T",0,'C');
		$pdf->Cell(50,$h+2,utf8_decode("Municipio: ". $ubicacion['nombre_municipio']),"T",0,'C');
		$pdf->Cell(0,$h+2,utf8_decode("Parroquia: ". $ubicacion['nombre_parroquia']),"T",1,'C');
		$pdf->SetFont('Times', 'I', 11);
		encogimientoTexto($pdf, 11, 176, $h,"Detalles: ".$contrib['direccion'], "B", 1, "L");
		$pdf->Ln($l+2);
		
		$sql_emp_per = "SELECT nombre, rif FROM empresa WHERE persona_rif = '$rif'";
		$r = $conexion->query($sql_emp_per);
		if($r->num_rows == 1){
			while($datos_emp_per[] = $r->fetch_assoc());
			$repre_emp = $datos_emp_per[0];
			$texto = "Es representante de la Empresa ".$repre_emp["nombre"]."    Rif: ".$repre_emp["rif"];
		}else{
			$texto = "No representa a ningúna Empresa.";
		}
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(0,$h+2,utf8_decode($texto),1,1,'J');
	}

	$pdf->SetY(240);
	$pdf->Cell(0,$h,"___________________________",0,1,'C');
	$pdf->Cell(0,$h,"Director(a) de Hacienda.",0,0,'C');

	$pdf->Output('','Contribuyente-'.$nombre_archivo.'.pdf',true);
?>