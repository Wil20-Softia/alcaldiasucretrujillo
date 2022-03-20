<?php

	include "../../config/Plantilla.php";
	require "../../config/EntidadBase.php";

	setlocale(LC_ALL,'es_VE.UTF-8');
	date_default_timezone_set ("America/Caracas");

	$sql = "";
	$datos = array();

    $fecha_actual_escrita = reg_date(date("Y") . "-" . date("n") . "-" . date("d"). "-" . date("w"));
    $fecha_actual = date("Y") . "-" . date("m") . "-" . date("d");
    $anyo_actual = (int)date("Y");
	$entidad = new EntidadBase("contribuyente");

	$conexion = $entidad->db();

	/*****************   PARTE DEL PDF  *************************/

	$pdf = new PDF();
	
	$h = 7;
	$l = 3;

	//  NUEVA PAGINA
	$pdf->AddPage();

	/*****************   FIN DE LA PARTE DE PDF  ****************/


	/****************    PARTE MYSQL-PHP    ********************/
	if(isset($_GET["cr"]) && !empty($_GET["cr"])){
		$rif = $_GET["cr"];
		$tipo = $entidad->tipo_contribuyente_rif($rif);
		$firma = "";
		if($tipo == "emp"){
			$persona = "Juridica";
			$firma = "Representante Legal";
			$sql = "SELECT empresa.rif, empresa.nombre, empresa.contribuyente FROM empresa WHERE empresa.rif = '$rif'";
		}else{
			$persona = "Natural";
			$firma = "Persona Natural";
			$sql = "SELECT persona.rif, CONCAT(persona.nombres,' ',persona.apellidos) AS nombre, persona.contribuyente FROM persona WHERE persona.rif = '$rif'";
		}

		$resultado = $conexion->query($sql);
		if($resultado){
			
			//ARRAY QUE TIENE LOS DATOS DEL CONTRIBUYENTE.
			$datosContribuyente = $resultado->fetch_assoc();

			$consulta = "SELECT MAX(cod_factura) ultimo_pago FROM factura GROUP BY contribuyente HAVING contribuyente = " . $datosContribuyente["contribuyente"];
			$resultado = $conexion->query($consulta);

			$cf = $resultado->fetch_assoc();

			//VARIABLE QUE GUARDA EL CODIGO DE LA FACTURA DEL ULTIMO PAGO.
			$codigo_factura = $cf["ultimo_pago"];

			$sql = "SELECT detalle_factura.trimestre, trimestre.periodo, trimestre.anyo FROM factura INNER JOIN detalle_factura ON factura.cod_factura = detalle_factura.factura INNER JOIN trimestre ON detalle_factura.trimestre = trimestre.id_trimestre WHERE factura.cod_factura = $codigo_factura GROUP BY trimestre.id_trimestre ORDER BY detalle_factura.trimestre DESC LIMIT 0,1";
			$resultado = $conexion->query($sql);

			//ARRAY QUE GUARDA LOS DATOS DEL ULTIMO TRIMESTRE CANCELADO
			$ultimo_trimestre = $resultado->fetch_assoc();

			$sql = "SELECT detalle_factura.total FROM detalle_factura INNER JOIN trimestre ON detalle_factura.trimestre = trimestre.id_trimestre INNER JOIN factura ON detalle_factura.factura = factura.cod_factura WHERE trimestre.anyo = $anyo_actual AND factura.contribuyente = ".$datosContribuyente["contribuyente"] ." GROUP BY detalle_factura.total";
			$resultado = $conexion->query($sql);
			
			//ARRAY QUE GUARDA LOS TOTALES 
			while($totales[] = $resultado->fetch_assoc());
			array_pop($totales);
			$total = 0;
			for($i=0;$i<count($totales);$i++){
				//VARIABLE QUE SUMA TODOS LOS TOTALES OBTENIDOS EN LA CONSULTA.
				$total += $totales[$i]["total"];
			}

			$sql = "SELECT montoTotal FROM factura WHERE cod_factura = $codigo_factura";
			$resultado = $conexion->query($sql);
			$mt = $resultado->fetch_assoc();

			//VARIABLE QUE GUARADA EL MONTO TOTAL DE LA ULTIMA
			//FACTURA PAGADA POR EL CONTRIBUYENTE.
			$monto_total = $mt["montoTotal"];

			$sql = "SELECT tributo.denominacion FROM detalle_factura INNER JOIN tributo ON detalle_factura.tributo = tributo.codigo WHERE detalle_factura.factura = $codigo_factura GROUP BY detalle_factura.tributo ";
			$tributos_ultimos = "";
			$resultado = $conexion->query($sql);
			while($tributos[] = $resultado->fetch_assoc());
			array_pop($tributos);

			for($i = 0; $i < count($tributos); $i++){
				if($i == count($tributos)-1){
					$tributos_ultimos .= $tributos[$i]["denominacion"];
				}else{
					$tributos_ultimos .= $tributos[$i]["denominacion"] . ", ";
				}
			}
		}else{
			echo $conexion->error;
		}
	}else{
		echo "Debe elegir una busqueda para la empresa y tiene que ser su RIF.";
	}
	/*     FIN DE LA PARTE MYSQL-PHP     */


	/*   PARTE DEL PDF  */

	//IMPRESION O VISTA DE FECHA Y HORA.
	$pdf->Ln($l+1);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(0,($h+3),utf8_decode("Certificado de Solvencia"),0,1,'C');
	$pdf->Ln($l);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(28,($h+3),utf8_decode("De parte de:"),0,0,'L');
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,($h+3),utf8_decode("Alcaldia del Municipio Sucre, Estado Tujillo"),0,1,'L');
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(33,($h+3),utf8_decode("Contribuyente:"),0,0,'L');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(90,($h+3),utf8_decode($datosContribuyente["nombre"]),0,0,'L');
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(10,($h+3),utf8_decode("Rif:"),0,0,'R');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,($h+3),utf8_decode($datosContribuyente["rif"]),0,1,'L');

	$pdf->SetFont('Arial','',12);
	$pdf->Ln($l+3);
	$pdf->MultiCell(0,7,utf8_decode("\t          Con ésta, hacemos Constar la Solvencia o Liquidación de la Persona $persona, la cual ha cancelado hasta el trimestre que se mencionará en breve, del Contribuyente al que va dirigida la misma."),0,"J");


	$pdf->Ln($l+2);
	$pdf->MultiCell(0,7,utf8_decode("\t       Se otorga el siguiente certificado, ya que ha cumplido con el pago de los Tributos Municipales respectivos mencionados en la Constitución de la República Bolivariana de Venezuela y en las demas leyes inherentes al funcionamiento y control del pago tributario acogidos en los Municipios de la Nación, con el fin de contribuir al desarrollo social, ambiental, politico, educativo, etc; de los servicios Públicos de la localización geopolitica."),0,"J");
	
	$pdf->Ln($l+2);
	$pdf->MultiCell(0,7,utf8_decode("\t" . '       Teniendo el Contribuyente una solvencia hasta el Trimestre "' . $ultimo_trimestre["periodo"] . '" del Año ' . $ultimo_trimestre["anyo"] . ", con un Monto Total acumulado en el Año Actual de Bs. " . number_format((float)$total,2,",",".") . " y Saldando el último recibo con un monto de BsS. " . number_format((float)$monto_total,2,",",".") . ' e incluyendo a los Tributos: "'.$tributos_ultimos.'".'),0,"J");

	$pdf->Ln($l+2);
	$pdf->MultiCell(0,7,utf8_decode("\t            Carta que se da por realizada, firmada y cellada por las autoridades competentes de la Institución \"Alcaldia del Municipio Sucre\", por el Departamento de Hacienda, en la fecha de " . $fecha_actual_escrita . "."),0,"J");

	$pdf->SetY(210);
	$pdf->Cell(88,($h+3),"__________________________",0,0,'C');
	$pdf->Cell(88,($h+3),"__________________________",0,1,'C');
	$pdf->Cell(88,($h+3),utf8_decode($firma),0,0,'C');
	$pdf->Cell(88,($h+3),"Director(a) de Hacienda",0,1,'C');
	
	/*****************   FIN DE LA PARTE DE PDF  ****************/
	$pdf->Output('','Cert-Solv_'.$datosContribuyente["rif"]."_$fecha_actual.pdf",true);
?>