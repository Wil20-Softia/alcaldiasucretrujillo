<?php

	include "../../config/Plantilla.php";
	require "../../config/EntidadBase.php";

	setlocale(LC_ALL,'es_VE.UTF-8');
	date_default_timezone_set ("America/Caracas"); 
	$fecha_actual = date("Y") . "-" . date("m") . "-" . date("d");
	$fecha_actual_escrita = date("Y") . "-" . date("n") . "-" . date("d"). "-" . date("w");
    $fecha_actual_escrita = reg_date($fecha_actual_escrita);

	$cabecera = array('Codigo','Fecha','Contribuyente Rif','Tipo de Pago','Referencia','Monto Total');
	$datos = array();

	$entidad = new EntidadBase("factura");

	$conexion = $entidad->db();

	/*SECCION PARA EL PDF DEL REPORTE: */

	$pdf = new PDF(); //CREANDO LA INSTANCIA DE LA CLASE PDF

	$pdf->AddPage();
	$pdf->Cell(105);
	$pdf->SetFont('Times','I',9);
	$pdf->Cell(0,10,utf8_decode($fecha_actual_escrita . strftime(" a las %I:%M:%S %p")),0,1,'R');
	$pdf->Ln(5);
	$pdf->SetTextColor(0);
	$pdf->SetDrawColor(122,122,122);
	$pdf->SetFont('Arial','BIU',14);
	$pdf->Cell(60,10,utf8_decode("Facturaciones"),0,1,'C');
	$pdf->Ln(5);

	/*FIN DE LA SECCIÓN.*/

	if(isset($_GET["fechaD"]) && isset($_GET["fechaH"])){

		$fechaD = $_GET["fechaD"];
		$fechaH = $_GET["fechaH"];

		if(empty($fechaD) && empty($fechaH)){
			$consulta = "SELECT factura.cod_factura as codigo, factura.fecha_pago as fecha, contribuyente.id as contribuyente, tipo_pago.nombre_tipopago as tipopago, factura.referencia as referencia, factura.montoTotal as monto FROM factura INNER JOIN contribuyente ON factura.contribuyente = contribuyente.id INNER JOIN tipo_pago ON factura.cod_tipopago = tipo_pago.cod_tipopago ORDER BY factura.cod_factura DESC";
		}else if(!empty($fechaD) && empty($fechaH)){
			$consulta = "SELECT factura.cod_factura as codigo, factura.fecha_pago as fecha, contribuyente.id as contribuyente, tipo_pago.nombre_tipopago as tipopago, factura.referencia as referencia, factura.montoTotal as monto FROM factura INNER JOIN contribuyente ON factura.contribuyente = contribuyente.id INNER JOIN tipo_pago ON factura.cod_tipopago = tipo_pago.cod_tipopago WHERE factura.fecha_pago BETWEEN '$fechaD' AND '$fecha_actual' ORDER BY factura.cod_factura DESC";
		}else if(!empty($fechaD) && !empty($fechaH)){
			$consulta = "SELECT factura.cod_factura as codigo, factura.fecha_pago as fecha, contribuyente.id as contribuyente, tipo_pago.nombre_tipopago as tipopago, factura.referencia as referencia, factura.montoTotal as monto FROM factura INNER JOIN contribuyente ON factura.contribuyente = contribuyente.id INNER JOIN tipo_pago ON factura.cod_tipopago = tipo_pago.cod_tipopago WHERE factura.fecha_pago BETWEEN '$fechaD' AND '$fechaH' ORDER BY factura.cod_factura DESC";
		}
	}else if(isset($_GET["busqueda"])){
		$search = $_GET['busqueda'];
		$consulta = "SELECT factura.cod_factura as codigo, factura.fecha_pago as fecha, contribuyente.id as contribuyente, tipo_pago.nombre_tipopago as tipopago, factura.referencia as referencia, factura.montoTotal as monto FROM factura INNER JOIN contribuyente ON factura.contribuyente = contribuyente.id INNER JOIN tipo_pago ON factura.cod_tipopago = tipo_pago.cod_tipopago WHERE factura.cod_factura = '$search' OR factura.referenciaPago = '$search' OR tipo_pago.nombre_tipopago = '$search' ORDER BY factura.cod_factura DESC";
	}

	$resultado = $conexion->query($consulta);

	if($resultado->num_rows > 0){
		/******************************    PARTE PDF    *************************/
		$pdf->SetFillColor(243,96,78);
		$pdf->SetTextColor(255);
		$pdf->SetDrawColor(82,75,75);
		$pdf->SetLineWidth(.3);
		$pdf->SetFont('Arial','B',11);
		$pdf->SetX(10);
		// Cabecera
		$anchurasColumnas = array(32, 30, 40, 30, 30, 35);
		for($i=0;$i<count($cabecera);$i++){
		    $pdf->Cell($anchurasColumnas[$i],12,utf8_decode($cabecera[$i]),'B',0,'C',true);
		}
		$pdf->Ln();

		$cont = 1;

		while($row = $resultado->fetch_assoc()){
			$tipo = $entidad->tipo_contribuyente($row["contribuyente"]);

	  		if($tipo == "emp"){
	  			$tabla = "empresa";
	  		}else{
	  			$tabla = "persona";
	  		}

	  		$sql = "SELECT rif FROM $tabla WHERE contribuyente = ".$row["contribuyente"];
	  		$r = $conexion->query($sql);
	  		$rc = $r->fetch_assoc();
	  		$rif_contribuyente = $rc["rif"];
	  		$monto_formateado = (string)number_format((float)$row["monto"],2,",",".");
			$datos_factura = array(
		        $row["codigo"],
		        $row["fecha"],
		        $rif_contribuyente,
		        $row["tipopago"],
		        $row["referencia"],
		        $monto_formateado
		    );
			
		    /*      PARTE PDF      */
			$alineaciones = array("C","C","C","C","C","C");
		    $pdf->SetTextColor(0);
			
		    $pdf->SetFont("Arial","",8);

			$pdf->SetWidths($anchurasColumnas);

			$pdf->SetAligns($alineaciones);
			$posicionY = $pdf->GetY();
			if($cont % 2 == 0){
				$pdf->Row($datos_factura,10,242,192,186,"DF");
			}else{
				$pdf->Row($datos_factura,10,255,255,255,"F");
			}			
			$cont++;
			//print_r($datos_factura[0]);
	  	}
	}else{
		$pdf->Ln(10);
		$pdf->SetFont('Arial','I',12);
		$pdf->Cell(0,10,utf8_decode("¡NO SE HAN ENCONTRADO RESULTADOS EN LA BUSQUEDA REALIZADA!"),1,1,'C');
	}

	$pdf->Output('','reporte_facturaciones.pdf');
?>