<?php

	require_once "../config/EntidadBase.php";
	
	$entidad = new EntidadBase("contribuyente");
	
	$entidad->establecerYearActual();
	$entidad->establecerMesActual();
	$entidad->TrimestresAnual();
	$entidad->DeudorTrimestreActual();
?>