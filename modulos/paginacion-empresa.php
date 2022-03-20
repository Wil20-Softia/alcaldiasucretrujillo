<?php

	const REGISTROS = 10;

	require_once "../config/EntidadBase.php";

	$entidad = new EntidadBase("contribuyente");

	$conexion = $entidad->db();

	$sql_total_paginas = "SELECT * FROM contribuyente WHERE id NOT IN (1)"; 

	$resultado = $conexion->query($sql_total_paginas);

	$num_filas = $resultado->num_rows;

	$total_paginas = ceil($num_filas / REGISTROS);

  	echo $total_paginas;

?>