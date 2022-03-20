<?php

	require "fpdf/fpdf.php";
	require "CifrasEnLetras.php";
	require "functions.php";

	/****************************************************************************/
	/*************************  EJEMPLO DE USO:  ********************************/
	/****************************************************************************/
	/****************************************************************************
	
	$data = array(
		array(
			"Impuestos",
			"Ha Cancelado todos los tributos",
			25000.50,
			8.89,
			28650.36
		),
		array(
			"Impuestos por no querer pagar todos los tributos del municipio",
			"Ha Cancelado todos los tributos por que el hombre tiene mucho dinero",
			400000000.50,
			20.89,
			500000000.36
		)
	);

	$fact = new Factura();
	$fact->establecerCodigo(3);
	$fact->establecerFechaCompleta("2019-07-05","18:36:30");
	$fact->establecerNombreEmpresa("Wilsoftia C.A");
	$fact->establecerRifEmpresa("J-123456789");
	$fact->establecerMontoTotal(153550.89);
	$fact->establecerTipoPago("Transferencia");
	$fact->establecerReferencia("123456789011");
	$fact->establecerRangoPago("Enero - Marzo","Octubre - Diciembre",2018, 2019);
	$fact->establecerRifRepresentante("V-267847246");
	$fact->establecerNombreRepresentante("Wilson Daniel","Escalona Fernández");
	$fact->insertarTributos($data);

	$fact->dibujarFactura();
	$fact->dibujarFactura();
	$fact->dibujarFactura();
	$fact->Output("","Facturas.pdf");

	POR CADA $fact->dibujarFactura(); SE CREA UNA FACTURA NUEVA EN UNA HOJA
	DIFERENTE.
	******************************************************************************/

	class Factura extends FPDF{
		private $codigo;
		private $tributos = array();
		private $fecha_completa;
		private $nombre_empresa;
		private $rif_empresa;
		private $monto_total;
		private $monto_escrito;
		private $tipo_pago;
		private $referencia;
		private $nombre_completo_representante;
		private $rif_representante;
		private $year_desde;
		private $year_hasta;
		private $mes_desde;
		private $mes_hasta;
		protected $xc;
		protected $yc;
		protected $altura_actual;
		public $rec;

		public function __construct(){
			parent::__construct('P','mm',array(215.9,279.4));
			$this->SetMargins(10,10,10);
			$this->SetAutoPageBreak(false, 10);
			$this->rec = 0;
		}

		public function establecerCodigo($codigo){
			$this->codigo = $codigo;
		}

		public function establecerFechaCompleta($fecha,$hora){
			$this->fecha_completa = reg_date($fecha) . "; Hora: " . $hora;
		}

		public function establecerNombreContribuyente($empresa){
			$this->nombre_empresa = $empresa;
		}

		public function establecerRifContribuyente($rif){
			$this->rif_empresa = $rif;
		}

		public function establecerMontoTotal($monto){
			$m = str_replace(",","",$monto);
			$m = number_format($m,2,',','.'); 
			$this->monto_total = $m;

			$this->monto_escrito = $monto;
		}

		public function formatearNumerico($numero){
			$numero = (float)$numero;
			$n = str_replace(",","",$numero);
			$n = number_format($n,2,',','.'); 
			return $n;
		}

		public function MontoEnLetras($monto){
			$m = str_replace(",","",$monto);
			$m = number_format($m,2,',',''); 
			$mont = CifrasEnLetras::convertirNumeroEnLetras("$m");
			return ucwords($mont);
		}

		public function establecerTipoPago($tipo_pago){
			$this->tipo_pago = $tipo_pago;
		}

		public function establecerReferencia($referencia){
			$this->referencia = $referencia;
		}

		public function establecerNombreRepresentante($nombre,$apellido){
			$nombre_array = explode (" ", $nombre);
			$apellido_array = explode (" ", $apellido);
			$this->nombre_completo_representante = $nombre_array[0] . " " . $apellido_array[0];
		}

		public function establecerRangoPago($desde,$hasta,$yd, $yh){
			$desde_array = explode (" ", $desde);
			$hasta_array = explode (" ", $hasta);
			$this->year_desde = $yd;
			$this->year_hasta = $yh;
			$this->mes_desde = $desde_array[0];
			$this->mes_hasta = $hasta_array[2];
		}

		public function establecerRifRepresentante($rif){
			$this->rif_representante = $rif;
		}

		public function insertarTributos($t = array(array())){
			$this->tributos = $t;
		}

		public function dibujarRectangulo(){
			$this->rec++;
			$this->SetDrawColor(0);
			$this->SetLineWidth(.3);
			if(($this->rec % 2) != 0){
				$this->AddPage();
				$this->Rect(10,10,195.9,124.7,"D");
				$this->altura_actual = 10.3;
			}else{
				$this->Rect(10,144.7,195.9,124.7,"D");
				$this->altura_actual = 145;
			}
		}

		public function dibujarFilas($xCurrent, $yCurrent, $h){
			$this->SetXY($xCurrent,$yCurrent);
			$tamTrib = count($this->tributos);
			$i = 0;
			while($tamTrib > 0 && $tamTrib <= 12 && $i < 12){
				$this->SetFont("Arial","",9);
				if(isset($this->tributos[$i]) && !empty($this->tributos[$i][0])){
					encogimientoTexto($this, 9, 59, $h, $this->tributos[$i][0], 1);
					encogimientoTexto($this, 9, 59, $h, $this->tributos[$i][1], 1);
					$this->Cell(30.6, $h, $this->formatearNumerico($this->tributos[$i][2]),1,0,"C");
					$this->Cell(16.6, $h, $this->formatearNumerico($this->tributos[$i][3]),1,0,"C");
					$this->Cell(30.6, $h, $this->formatearNumerico($this->tributos[$i][4]),1,1,"C");
				}else{
					$this->Cell(59, $h, utf8_decode(""),1,0,"L");
					$this->Cell(59, $h, utf8_decode(""),1,0,"L");
					$this->Cell(30.6, $h, utf8_decode(""),1,0,"L");
					$this->Cell(16.6, $h, utf8_decode(""),1,0,"L");
					$this->Cell(30.6, $h, utf8_decode(""),1,1,"L");
				}
				$i++;
			}
			
			$this->yc = $this->GetY();
			$this->xc = $this->GetX();
		}

		public function dibujarFactura(){			
			$hLine = 3.75;

			$this->dibujarRectangulo();
			$this->SetLineWidth(.1);
			//IMAGENES DE LA CABECERA.
			$this->SetFont("Arial","BI",11);
			$this->Image("../../img/escudo_trujillo.jpg", 10.3, $this->altura_actual, 30, 15);
			$this->Image("../../img/cabecera.png", 40, $this->altura_actual, 135, 15);
			$this->Image("../../img/escudo_municipio.jpg", 175, $this->altura_actual, 30, 15);

			//ENUNCIADO DE LA ALCALDIA.
			$this->SetFont("Arial","BI",8);
			$this->SetXY(40, $this->altura_actual+15);
			$this->Cell(50, $hLine, utf8_decode("Alcaldia del Municipio Sucre"),0,1,"C");
			$this->SetX(40);
			$this->Cell(50, $hLine, utf8_decode("Estado Trujillo"),0,1,"C");
			$this->SetX(40);
			$this->Cell(50, $hLine, utf8_decode("Dirección de Hacienda"),0,1,"C");
			$this->SetX(40);
			$this->Cell(50, $hLine, utf8_decode("Coordinación de Trujillo"),0,1,"C");

			//RIF Y NRO DE RECIBO.
			$this->SetXY(140, $this->altura_actual+15);
			$this->Cell(50, $hLine*2, utf8_decode("Rif: G-20001865-8"),0,1,"L");
			$this->SetX(140);
			$this->SetFont("Arial","B",9);
			$this->Cell(50, $hLine*2, utf8_decode("Nro de Recibo: #".$this->codigo),1,1,"L");

			$this->SetXY(20,$this->altura_actual+32);
			$this->SetFont("Arial","IU",9);
			$this->Cell(185.9, $hLine+1.25, utf8_decode("Sabana de Mendoza; ".$this->fecha_completa),0,1,"L");

			$this->SetXY(12,$this->altura_actual+39);
			$this->SetFont("Arial","B",11);
			$this->Cell(29, $hLine+1.25, utf8_decode("Contribuyente:"),0,0,"L");
			$this->SetFont("Arial","I",11);
			$this->Cell(88, $hLine+1.25, utf8_decode($this->nombre_empresa),"B",0,"L");
			$this->SetFont("Arial","B",11);
			$this->Cell(8, $hLine+1.25, utf8_decode("Rif:"),0,0,"L");
			$this->SetFont("Arial","I",11);
			$this->Cell(0, $hLine+1.25, utf8_decode($this->rif_empresa),"B",1,"L");
			
			$this->SetXY(12,$this->altura_actual+46);
			$this->SetFont("Arial","B",11);
			$this->Cell(35, $hLine+1.25, utf8_decode("Cantidad de BsS."),0,0,"L");
			$this->SetFont("Arial","I",9);
			$this->Cell(0, $hLine+1.25, utf8_decode($this->MontoEnLetras($this->monto_escrito)),"B",1,"L");

			$this->SetXY(12,$this->altura_actual+53);
			$this->SetFont("Arial","B",9);
			$this->Cell(22, $hLine, utf8_decode("Tipo de Pago:"),0,0,"L");
			$this->SetFont("Arial","I",9);
			$this->Cell(22, $hLine, utf8_decode($this->tipo_pago),"B",0,"C");
			$this->SetFont("Arial","B",9);
			$this->Cell(19, $hLine, utf8_decode("Referencia:"),0,0,"L");
			$this->SetFont("Arial","I",9);
			$this->Cell(22, $hLine, utf8_decode($this->referencia),"B",0,"C");
			$this->Cell(10);
			$this->SetFont("Arial","B",9);
			$this->Cell(21, $hLine, utf8_decode("Pagó, Desde:"),0,0,"L");
			$this->SetFont("Arial","I",9);
			$this->Cell(32, $hLine, utf8_decode($this->mes_desde . " del " . $this->year_desde),"B",0,"L");
			$this->SetFont("Arial","B",9);
			$this->Cell(14, $hLine, utf8_decode("- Hasta:"),0,0,"L");
			$this->SetFont("Arial","I",9);
			$this->Cell(32, $hLine, utf8_decode($this->mes_hasta . " del " . $this->year_hasta),"B",1,"L");

			$this->SetXY(10,$this->altura_actual+59);
			$this->SetFont("Arial","IB",11);
			$this->Cell(0, $hLine+0.25, utf8_decode("TRIBUTOS CANCELADOS"),0,1,"C");
			$this->Ln(.5);
			$this->SetFont("Arial","B",11);
			$this->Cell(59, $hLine, utf8_decode("Tributo"),1,0,"C");
			$this->Cell(59, $hLine, utf8_decode("Observación"),1,0,"C");
			$this->Cell(30.6, $hLine, utf8_decode("Monto (Bs)"),1,0,"C");
			$this->SetFont("Arial","B",10);
			$this->Cell(16.6, $hLine, utf8_decode("Mora %"),1,0,"C");
			$this->SetFont("Arial","B",11);
			$this->Cell(30.6, $hLine, utf8_decode("Total (Bs)"),1,1,"C");

			$this->dibujarFilas(10, $this->altura_actual+67.25, $hLine);
			
			if(!empty($this->rif_representante)){
				$this->SetXY($this->xc, $this->yc+0.5);
				$this->SetFont("Arial","B",9);
				$this->Cell(33, ($hLine-0.75), utf8_decode("Representante Legal:"),0,0,"L");
				$this->SetFont("Arial","",8);
				$this->Cell(45, ($hLine-0.75), utf8_decode($this->nombre_completo_representante),"B",0,"L");
				$this->SetFont("Arial","B",9);
				$this->Cell(7, ($hLine-0.75), utf8_decode("Rif:"),0,0,"L");
				$this->SetFont("Arial","",8);
				$this->Cell(23, ($hLine-0.75), utf8_decode($this->rif_representante),"B",0,"L");
			}

			$this->SetXY($this->xc+148.6,$this->yc);
			$this->SetFont("Arial","B",9);
			$this->Cell(16.6, ($hLine), utf8_decode("Total (Bs)"),1,0,"L");
			$this->SetFont("Arial","",8);
			$this->Cell(0, ($hLine), $this->monto_total,1,0,"C");

			$this->SetXY($this->xc+10,$this->yc+5);
			$this->SetFont("Arial","B",8);
			$this->Cell(55.3, ($hLine-0.75), utf8_decode("______________________________"),0,0,"C");
			$this->Cell(66.3, ($hLine-0.75), utf8_decode("______________________________"),0,0,"C");
			$this->Cell(55.3, ($hLine-0.75), utf8_decode("______________________________"),0,1,"C");
			$this->SetX($this->xc+10);
			$this->SetFont("Arial","B",9);
			$this->Cell(55.3, ($hLine-0.75), utf8_decode("Director(a) de Renta"),0,0,"C");
			$this->Cell(66.3, ($hLine-0.75), utf8_decode("Director(a) de Hacienda"),0,0,"C");
			$this->Cell(55.3, ($hLine-0.75), utf8_decode("Director(a) de Tesoreria"),0,1,"C");
		}
	}
?>