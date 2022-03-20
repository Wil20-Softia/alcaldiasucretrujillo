<?php

	require "../../config/Factura.php";
	require "../../config/EntidadBase.php";

	$entidad = new EntidadBase("factura");
	$conexion = $entidad->db();

	/*$sql = "SELECT now() as fecha_actual";
	$resultado = $conexion->query($sql);
	$resultado = $resultado->fetch_assoc();
	$dateCurrent = explode(' ',$resultado["fecha_actual"]);
	
	 FECHA Y HORA ACTUAL DEL SISTEMA LOCAL.
	$fecha_actual = $dateCurrent[0];
	$hora_actual = $dateCurrent[1]; */

	$fact = new Factura();

	if(isset($_GET["cf"]) && !empty($_GET["cf"])){
		$cf = $_GET["cf"];

		//FACTURA POR CODIGO
		$consulta = "SELECT fecha_pago, hora_pago, contribuyente, montoTotal, tipo_pago.nombre_tipopago, referencia FROM factura INNER JOIN tipo_pago ON factura.cod_tipopago = tipo_pago.cod_tipopago WHERE cod_factura = $cf";
		$r = $conexion->query($consulta);
		if($r->num_rows > 0){

			//ARRAY QUE GUARDA LOS DATOS DE LA FACTURA.
			$datosFactura = $r->fetch_assoc();

			//TIPO DE CONTRIBUYENTE
			$tc = $entidad->tipo_contribuyente($datosFactura["contribuyente"]);
			
			//DEPENDIENDO DEL TIPO DE CONTRIBUYENTE SE PIDEN LOS DATOS.
			if($tc == "emp"){
				//CONTRIBUYENTE EMPRESA
				$consulta = "SELECT empresa.nombre AS nombre_empresa, empresa.rif AS rif_empresa, persona.nombres AS nombres_representante, persona.apellidos AS apellidos_representante, persona.rif AS rif_representante FROM empresa INNER JOIN persona ON empresa.persona_rif = persona.rif WHERE empresa.contribuyente = " . $datosFactura["contribuyente"];
			}else{
				//CONTRIBUYENTE PERSONA
				$consulta = "SELECT persona.nombres, persona.apellidos, persona.rif FROM persona WHERE contribuyente = " . $datosFactura["contribuyente"];
			}

			$r = $conexion->query($consulta);

			//ARRAY QUE GUARDA LOS DATOS DEL CONTRIBUYENTE.
			$datosContribuyente = $r->fetch_assoc();

			//CONSULTA QUE OBTIENE LOS ID DEL RANGO DE TRIMESTRE CANCELADOS.
			$consulta = "SELECT MAX(trimestre) AS desde, MIN(trimestre) AS hasta FROM detalle_factura WHERE factura = $cf";
			$r = $conexion->query($consulta);
			$idsTrimestres = $r->fetch_assoc();
			
			$desde = $idsTrimestres["desde"]; //ID DESDE
			$hasta = $idsTrimestres["hasta"]; //ID HASTA
			//CONSULTA PARA OBTENER LOS DATOS DE LOS TRIMESTRES CON LOS
			//ID'S ANTETIORMENTE OBTENIDOS.
			$consulta = "SELECT periodo, anyo FROM trimestre WHERE id_trimestre = $desde OR id_trimestre = $hasta";
			$r = $conexion->query($consulta);
			if($r){
				while($datosTrimestres[] = $r->fetch_assoc());
				array_pop($datosTrimestres);
			}else{
				echo $conexion->error;
			}
			if(count($datosTrimestres) == 1){
				//ARRAY QUE CONTIENE LOS DATOS DE DESDE
				$datosDesde = $datosTrimestres[0];
				//ARRAY QUE CONTIENE LOS DATOS DE HASTA
				$datosHasta = $datosTrimestres[0];
			}else{
				//ARRAY QUE CONTIENE LOS DATOS DE DESDE
				$datosDesde = $datosTrimestres[0];
				//ARRAY QUE CONTIENE LOS DATOS DE HASTA
				$datosHasta = $datosTrimestres[1];
			}

			//CONSULTA QUE OBTIENE LOS DATOS DE LOS TRIBUTOS CANCELADOS
			//EN LA FACTURA A MOSTRAR.
			$consulta = "SELECT tributo.denominacion, detalle_factura.observacion, detalle_factura.monto, detalle_factura.impuesto_mora, detalle_factura.total FROM detalle_factura INNER JOIN tributo ON detalle_factura.tributo = tributo.codigo WHERE factura = $cf GROUP BY tributo";
			$r = $conexion->query($consulta);
			while($data[] = $r->fetch_row());

			//ARRAY DATA NUMERICO CON LOS DATOS DE TODOS LOS TRIBUTOS
			//CANCELADOS EN LA FACTURA.
			array_pop($data);

			$fact->establecerCodigo($cf);
			$fact->establecerFechaCompleta($datosFactura["fecha_pago"], $datosFactura["hora_pago"]);
			if($tc == "emp"){
				//CONTRIBUYENTE EMPRESA
				$fact->establecerNombreContribuyente($datosContribuyente["nombre_empresa"]);
				$fact->establecerRifContribuyente($datosContribuyente["rif_empresa"]);
				$fact->establecerRifRepresentante($datosContribuyente["rif_representante"]);
				$fact->establecerNombreRepresentante($datosContribuyente["nombres_representante"],$datosContribuyente["apellidos_representante"]);
			}else{
				//CONTRIBUYENTE PERSONA
				$consulta = "SELECT persona.nombres, persona.apellidos, persona.rif FROM persona WHERE contribuyente = " . $datosFactura["contribuyente"];
				
				$fact->establecerNombreContribuyente($datosContribuyente["nombres"] . " " . $datosContribuyente["apellidos"]);
				$fact->establecerRifContribuyente($datosContribuyente["rif"]);
				$fact->establecerRifRepresentante("");
			}
			$fact->establecerMontoTotal($datosFactura["montoTotal"]);
			$fact->establecerTipoPago($datosFactura["nombre_tipopago"]);
			$fact->establecerReferencia($datosFactura["referencia"]);
			$fact->establecerRangoPago($datosDesde["periodo"],$datosHasta["periodo"],$datosDesde["anyo"], $datosHasta["anyo"]);
			$fact->insertarTributos($data);

			$fact->dibujarFactura();
			$fact->dibujarFactura();
			$fact->dibujarFactura();
		}else{
			$fact->SetFont("Arial","BI",13);
			$fact->Cell(0,10,"NO EXISTE NINGÚNA FACTURACION CON EL CRITERIO DE BUSQUEDA",1,0);
		}
	}

	$fact->Output("","Facturas.pdf");

?>