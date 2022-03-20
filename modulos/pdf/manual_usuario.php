<?php

	require_once "../../config/Index_PDF.php";

	$pdf = new Index_PDF();
	
	//PAGINA 1
	$pdf->AddPage();
	$pdf->Bookmark('Portada',false);
	$pdf->SetFont('Arial','B',11);
	$pdf->Image("../../img/Escudo_Izquierdo_Unefa.gif", 15, 22, 35, 40,"GIF");
	$pdf->Image("../../img/logo_unefa.jpg", 175.9, 26, 25, 30);
	$pdf->Cell(0,5,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,1,"C");
	$pdf->Cell(0,5,'MINISTERIO DEL PODER POPULAR PARA LA DEFENSA',0,1,"C");
	$pdf->Cell(0,5,'UNIVERSIDAD NACIONAL EXPERIMENTAL POLITECNICA',0,1,"C");
	$pdf->Cell(0,5,'DE LA FUERZA ARMADA NACIONAL BOLIVARIANA',0,1,"C");


	$pdf->Ln(75);
	$pdf->SetFont('Abril Fatface','',44);
	$pdf->Cell(0, 15, utf8_decode("MANUAL DE USUARIO"),0,1,"C");
	$pdf->Ln(5);
	$pdf->SetFont('RobotoCondensed','',20);
	$pdf->Multicell(0, 10, utf8_decode("Sistema de Administración de Pagos de Impuestos Mensuales de las Personas Juridicas (Empresas u Organizaciones) del Municipio Sucre."),0,"C");


	$pdf->SetXY(150,200);
	$pdf->SetFont('RobotoCondensed','B',13);
	$pdf->Cell(20, 8,utf8_decode("Bachiller"),0,1,"C");
	$pdf->SetX(130);
	$pdf->SetFont('RobotoCondensed','B',12);
	$pdf->Cell(22, 8,chr(149)." ".utf8_decode("Nombres:"),0,0,"L");
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Cell(50, 8, utf8_decode("Wilson Daniel"),0,1,"L");
	$pdf->SetX(130);
	$pdf->SetFont('RobotoCondensed','B',12);
	$pdf->Cell(22, 8,chr(149)." ".utf8_decode("Apellidos:"),0,0,"L");
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Cell(50, 8, utf8_decode("Escalona Fernández"),0,1,"L");
	$pdf->SetX(130);
	$pdf->SetFont('RobotoCondensed','B',12);
	$pdf->Cell(22, 8,chr(149)." ".utf8_decode("Cedula:"),0,0,"L");
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Cell(50, 8, utf8_decode("V-26.784.724"),0,1,"L");
	$pdf->SetX(130);
	$pdf->SetFont('RobotoCondensed','B',12);
	$pdf->Cell(22, 8,chr(149)." ".utf8_decode("Carrera:"),0,0,"L");
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Cell(50, 8, utf8_decode("Ingeniería de Sistemas"),0,1,"L");
	$pdf->SetX(130);
	$pdf->SetFont('RobotoCondensed','B',12);
	$pdf->Cell(22, 8,chr(149)." ".utf8_decode("Semestre:"),0,0,"L");
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Cell(50, 8, utf8_decode("IX. (Practicas Profesionales)"),0,1,"L");
	//FIN DE LA PAGINA 1


	//INDICE.
	$pdf->AddPage();
	$pdf->Bookmark(utf8_decode('Índice'),false);
	$pdf->SetFont('RobotoCondensed','B',14);
    $pdf->Cell(0,5,utf8_decode('Índice'),0,1,'C');
    $pdf->SetFont('RobotoCondensed','B',12);
    $pdf->Ln(6);

    $pdf->Cell(160,5,'Portada .....................................................................................................................',0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 1",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(160,5,'Indice .......................................................................................................................',0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 2",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(160,5,utf8_decode('1. Descripción del Sistema ...........................................................................................'),0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 3",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(160,5,'2. Primeros Pasos ......................................................................................................',0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 4",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(10);
    $pdf->Cell(150,5,'2.1 Ingreso al Sistema .........................................................................................',0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 4",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(10);
    $pdf->Cell(150,5,'2.2 Subiendo Respaldo ........................................................................................',0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 4",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(160,5,'3. Antes de registrar a una empresa (obligatorio) .............................................................',0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 5",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(10);
    $pdf->Cell(150,5,'3.1 Registro de los impuestos anuales ...................................................................',0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 5",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(10);
    $pdf->Cell(150,5,'3.2 Registro de Actividades Comerciales ................................................................',0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 6",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(160,5,'4. Registro de una Empresa ..........................................................................................',0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 7",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(160,5,'5. Modulo de Inicio .....................................................................................................',0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 9",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(160,5,'6. Modulo de Deudores ................................................................................................',0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 11",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(160,5,'7. Modulo de Solventes ...............................................................................................',0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 12",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(160,5,'8. Modulo de Facturaciones .........................................................................................',0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 13",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(160,5,utf8_decode('9. Modulo de Realización de Pagos de Meses por Empresa ...............................................'),0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 14",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(160,5,utf8_decode('10. Opciones de Usuario Administrador .........................................................................'),0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 15",0,1,'R');

    $pdf->Ln(4);
    $pdf->Cell(160,5,utf8_decode('11. Mensaje de finalización .........................................................................................'),0,0,'L');
    $pdf->SetX(180);
    $pdf->Cell(15,5,"pag. 17",0,1,'R');

   	/***************************  DESCRIPCIÓN DEL SISTEMA *********************/ 
	$pdf->AddPage();
	$pdf->Bookmark(utf8_decode('1. Descripción del Sistema'),false);
	$pdf->SetFont('RobotoCondensed','B',14);
	$pdf->Cell(10);
	$pdf->Cell(0, 10,"1. " . utf8_decode("Descripción del Sistema"),0,1,"L");
	$pdf->Ln(5);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tEl Sistema presentado es un proceso administrativo amplio que lleva a cabo distintas tareas para un propósito en general, el cual trata acerca del registro y control de los pagos que son generados por el impuesto mensual de cada Empresa en el sector geopolítico municipal (Municipio Sucre). Como todo sistema, está compuesto de módulos que son de gran relevancia para la gestión de las actividades. En específico los módulos son: registro de una empresa con su dueño, modificación de los datos de la empresa, verificación de cada empresa, pago o registro de facturaciones o recibos realizados, verificación del listado de deudores, verificación del listado de solventes, verificación de las facturas registradas, Impresión de facturas o recibos, registro de impuestos, registro de actividad comercial."),0,"J");
	$pdf->Ln(5);
    $pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tDicho proceso administrativo está plasmado de forma que cubre todas las necesidades del área de Hacienda de la respectiva Organización, cumpliendo así con los requisitos del sistema en su totalidad y con esto obteniendo una mayor eficiencia y eficacia al momento de realizar las operaciones respectivas especificadas anteriormente, es totalmente fácil de comprenderlo y controlarlo solo tiene que seguir leyendo este manual para llegar a controlarlo sin ninguna duda."),0,"J");

    /******************** PRIMEROS PASOS ****************************/
    $pdf->AddPage();
    $pdf->Bookmark(utf8_decode('2. Primeros Pasos'),false);
    $pdf->SetFont('RobotoCondensed','B',14);
	$pdf->Cell(10);
	$pdf->Cell(0, 10,"2. " . utf8_decode("Primeros Pasos"),0,1,"L");
	$pdf->Ln(1);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tPara comenzar a utilizar el sistema, antes el desarrollador del mismo tuvo que haber instalado y configurado todo el sistema para que el usuario administrador pueda comenzar a utilizarlo."),0,"J");
	$pdf->Ln(1);
	$pdf->Bookmark(utf8_decode('2.1 Ingreso al Sistema'),false,1,-1);
	$pdf->Cell(15);
	$pdf->SetFont('RobotoCondensed','B',12);
	$pdf->Cell(0, 10,"2.1 " . utf8_decode("Ingreso al Sistema"),0,1,"L");
	$pdf->Cell(8);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tEl ingreso del sistema se realiza de la siguiente manera:"),0,"J");
	$pdf->Ln(1);
	$column_width = $pdf->w-30;
	$text = array(
		"Abrir el navegador predeterminado (Mozilla Firefox o Google Chrome, preferiblemente), esperar a que el navegador cargue completamente.",
		"Escribir el siguiente Link en la barra de direcciones en el lado superior de la ventana del navegador: \"localhost/AlcaldiaSucre/\".",
		"Esperar a que cargue bien el sistema (No desesperes)."
	);
	$identado = array();
	$identado['bullet'] = '>';
	$identado['margin'] = ' ';
	$identado['indent'] = 10;
	$identado['spacer'] = 5;
	$identado['text'] = array();
	for ($i=0; $i<count($text); $i++)
	{
	    $identado['text'][$i] = utf8_decode($text[$i]);
	}
	$pdf->SetX(30);
	$pdf->MultiCellBltArray($column_width-$pdf->x,6,$identado);
	$pdf->Ln(3);
	$pdf->SetX(25);
	$pdf->Multicell(0, 6, utf8_decode("\t\t\t\t\t\t\tNota: El o los navegadores a utilizar tienen que estar siempre actualizados a la última versión, y la computadora tiene que ser mantenida cada 4 meses como mínimo."),0,"J");
	$pdf->Ln(3);
	$pdf->Bookmark(utf8_decode('2.2 Subiendo Respaldo'),false,1,-1);
	$pdf->Cell(15);
	$pdf->SetFont('RobotoCondensed','B',12);
	$pdf->Cell(0, 10,"2.2 " . utf8_decode("Subiendo Respaldo"),0,1,"L");
	$pdf->Cell(8);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tDirigirse al botón de la barra de navegación en donde aparece un icono de configuración e ingresar al módulo de \"Restaurar Sistema\" y buscar el archivo de respaldo del sistema (es un archivo comprimido que contiene información de la Base de Datos) con el navegador de archivos del sistema operativo, Cliquearlo y dar Restaurar, esperar un momento hasta que se cargue al sistema el respaldo, la página te enviara un aviso y se reiniciara automáticamente, ya tienes el sistema para utilizarlo."),0,"J");

	/********************* ANTES DE REGISTRAR A UNA EMPRESA  *******************/
	$pdf->AddPage();
    $pdf->Bookmark(utf8_decode('3. Antes de registrar a una empresa (obligatorio)'),false);
    $pdf->SetFont('RobotoCondensed','B',14);
	$pdf->Cell(10);
	$pdf->Cell(0, 10,"3. " . utf8_decode("Antes de registrar a una empresa (obligatorio)"),0,1,"L");
	$pdf->Ln(1);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tPara realizar el registro de una empresa, antes tienen que existir registros en el impuesto anual y en las actividades comerciales, ya que de no haber registros en ambas el sistema no va a saber; 1ero ¿desde donde comienza a deber la empresa?, y 2do ¿cuál es su actividad comercial? Por ende, debe seguir los siguientes pasos."),0,"J");
	
	$pdf->Ln(3);
	$pdf->Bookmark(utf8_decode('3.1 Registro de los impuestos anuales'),false,1,-1);
	$pdf->Cell(15);
	$pdf->SetFont('RobotoCondensed','B',12);
	$pdf->Cell(0, 10,"3.1 " . utf8_decode("Registro de los impuestos anuales"),0,1,"L");
	$pdf->Cell(8);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tPara ingresar al registro de los impuestos anuales Ud. debe de dirigirse al botón situado en la barra de navegación el cual tiene un icono con configuración de usuario, seleccione la opción de impuestos anuales."),0,"J");
	$pdf->Cell(8);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tAl seleccionar dicha opción saldrá una pantalla que tendrá un listado (si existen registros) de los impuestos anuales, y a su derecha un formulario de registro que contiene 2 campos, el primero es el año en el cual aplicará el impuesto y el segundo será el porcentaje del impuesto para ese año."),0,"J");
	$pdf->Cell(8);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tEste formulario valida el año para que no se ingresen años mayores al actual, pero si se pueden ingresar año menores al mismo, teniendo en cuenta que solo se registraran una sola ves los años menores al actual, y si se registra el año actual entonces este en primera instancia funciona igual que los anteriores, pero se puede registrar varias veces, pero en diferentes meses, se hace esta validación teniendo en cuenta que en cualquier mes del año actual el impuesto puede cambiar de porcentaje. Ya sabiendo lo anterior se puede especificar que, el registro del año actual en los impuestos se tomará desde el mes actual en adelante si es de segunda vez en adelante, sino tomara todos los meses del año."),0,"J");
	$pdf->Cell(8);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tEn la validación del campo del porcentaje del impuesto, éste no debe ser mayor al 16.5% ya que así lo dicta la Ley del Impuesto del Valor Agregado (IVA) y la Ley del Impuesto Sobre la Renta (ISR). Para insertar el número decimal debe de colocar el Punto (.) como separador decimal, sino el sistema no dejará registrar y debe contener con obligatoriedad 2 decimales, en el caso de que no tenga 2 decimales el número a ingresar coloque \".00\" después del número entero."),0,"J");

	$pdf->Ln(5);
	$pdf->Bookmark(utf8_decode('3.2 Registro de Actividades Comerciales.'),false,1,-1);
	$pdf->Cell(15);
	$pdf->SetFont('RobotoCondensed','B',12);
	$pdf->Cell(0, 10,"3.2 " . utf8_decode("Registro de Actividades Comerciales."),0,1,"L");
	$pdf->Cell(8);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tCliquear el botón de la barra de navegación que tiene el icono de configuración de usuario."),0,"J");
	$pdf->Cell(8);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tElegir el enlace de Actividad Comercial, saldrá de inmediato la pantalla respectiva al módulo."),0,"J");
	$pdf->Cell(8);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tEn ésta se encuentra un listado de las actividades comerciales (siempre y cuando existan registros) las cuales tienen la opción de modificado y eliminado. Y a la derecha aparece un formulario de llenado para el registro de una actividad nueva."),0,"J");

	$column_width = $pdf->w-30;
	$text = array(
		"Campo Buscar: Sirve para buscar a la actividad por código exacto o descripción (no exacta), puede escribir el código y dar Enter o puede cliquear el botón de búsqueda.",
		"Botón de modificación: al dar click en el mismo de una empresa en específico, el formulario de llenado automáticamente se llenará con los datos respectivos de dicha actividad, solo se podrá modificar la descripción de la actividad. “Si se equivoca en el llenado del código y registra la actividad, es mejor que la elimine y la vuelva a registrar”.",
		"Botón eliminar: al cliquear el mismo, entonces aparecerá un aviso advirtiendo del eliminado, si da cancelar no elimina nada, sino entonces elimina dicha actividad.",
		"Llenado de la actividad comercial: es sencillo solo colocar el código que no debe de ser repetido, y debe tener como mínimo 5 dígitos y como máximo 12 dígitos, y el llenado de la descripción que debe tener como mínimo 10 caracteres y como máximo 140."
	);
	$identado = array();
	$identado['bullet'] = '>';
	$identado['margin'] = ' ';
	$identado['indent'] = 10;
	$identado['spacer'] = 5;
	$identado['text'] = array();
	for ($i=0; $i<count($text); $i++)
	{
	    $identado['text'][$i] = utf8_decode($text[$i]);
	}
	$pdf->SetX(30);
	$pdf->MultiCellBltArray($column_width-$pdf->x,6,$identado);
	$pdf->Ln(3);
	$pdf->SetX(25);
	$pdf->Multicell(0, 6, utf8_decode("\t\t\t\t\t\t\tAl dar guardar saldrá un aviso y automáticamente se vacían los campos del formulario y aparece la actividad comercial en el listado."),0,"J");

	/*********************  REGISTRO DE UNA EMPRESA *******************/
	$pdf->AddPage();
	$pdf->Bookmark(utf8_decode('4. Registro de una Empresa'),false);
	$pdf->Cell(10);
	$pdf->SetFont('RobotoCondensed','B',14);
	$pdf->Cell(0, 10,"4. " . utf8_decode("Registro de una Empresa"),0,1,"L");
	$pdf->Cell(8);
	$pdf->Ln(1);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tPara este proceso solo elegir la opción de Nueva Empresa ubicada en la barra de navegación."),0,"J");
	$pdf->Cell(8);
	$pdf->Ln(1);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tAparece una Pantalla con todos los datos requeridos para el llenado de los datos necesarios de una Empresa. Tener en cuenta que todos y absolutamente todos los datos que aparecen en la pantalla son requeridos (obligatorio)."),0,"J");
	$pdf->Cell(8);
	$pdf->Ln(1);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tEl formulario de llenado se divide en 2 partes:"),0,"J");
	$pdf->Cell(10);
	$pdf->Ln(5);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\t1era. Es para los datos de la empresa en específico: esta parte tiene los campos respectivos para los datos esenciales de la empresa en sí. Como lo son:"),0,"J");
	$pdf->Cell(15);
	$column_width = $pdf->w-30;
	$text = array(
		"Nombre de la empresa (Se válida para que sea único).",
		"Rif de la empresa (tiene que ser único).",
		"Código de comercio.",
		"Número telefónico.",
		"Fecha de registro legal (es la fecha que tienen los papeles del registro de la empresa, no debe ser mayor a la fecha actual).",
		"Dirección que está comprendida en municipio, parroquia y descripción (solo saldrá el municipio sucre, por razones de que la empresa tiene que estar ubicada en este).",
		"Actividad Comercial (saldrán las actividades que ya están previamente guardadas, elija una de ellas para la actividad de la empresa).",
		"Último mes en Deuda (aquí salen 2 selectores, uno del año en el cual salen los años registrados con anterioridad de los impuestos anuales, registrar los año sucesivamente ya que aquí se válida la sucesión de los años del impuesto; y también está el selector del mes, el cual debe elegir porque es obligatorio), en general este campo permitirá saber al sistema desde cuándo va a comenzar a deber dicha empresa a registrar, ósea si Ud. registra una empresa tiene que saber desde que mes le va a cobrar los impuestos, exactamente eso es los que hace dicho campo."
	);
	$identado = array();
	$identado['bullet'] = '>';
	$identado['margin'] = ' ';
	$identado['indent'] = 10;
	$identado['spacer'] = 5;
	$identado['text'] = array();
	for ($i=0; $i<count($text); $i++)
	{
	    $identado['text'][$i] = utf8_decode($text[$i]);
	}
	$pdf->SetX(30);
	$pdf->MultiCellBltArray($column_width-$pdf->x,6,$identado);
	$pdf->Ln(3);
	$pdf->SetX(25);
	$pdf->Cell(10);
	$pdf->Ln(5);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\t2da. En esta parte se llenan los datos del propietario de la empresa, todos los campos son obligatorios y debe ser un propietario por empresa, quiere decir que no deben haber registro de un mismo propietario varias veces. Los campos que acompañan a este son:"),0,"J");
	$pdf->Cell(15);
	$column_width = $pdf->w-30;
	$text = array(
		"Nombres (Obligatorio).",
		"Apellido (Obligatorio).",
		"Cedula de Identidad (Obligatorio, Coloque la Letra V para venezolano, E para extranjero, no es necesario que coloque el guion (-), se coloca solo, a continuación, coloque el número de la cedula).",
		"Rif (Obligatorio, Este trabaja de la misma forma que el campo cedula, pero tiene que tener nueve (9) dígitos en el Rif aparte de la Letra de prefijo).",
		"Fecha de nacimiento (Obligatorio, se válida para que no sea mayor a la fecha actual).",
		"Dirección de Habitación (obligatorio en todos sus campos, es igual que la dirección de la empresa, pero aquí debe colocar la dirección de vivienda del dueño de la empresa en el Municipio Sucre).",
		"Números telefónicos (Obligatorio(s), existe un solo campo de número telefónico para el dueño, pero si quiere registrar 2 numero telefónicos entonces das en el botón “otro” para sacar el otro campo para un nuevo número telefónico, si se arrepiente de querer registrarlo dar en el botón “Deshacer”)."
	);
	$identado = array();
	$identado['bullet'] = '>';
	$identado['margin'] = ' ';
	$identado['indent'] = 10;
	$identado['spacer'] = 5;
	$identado['text'] = array();
	for ($i=0; $i<count($text); $i++)
	{
	    $identado['text'][$i] = utf8_decode($text[$i]);
	}
	$pdf->SetX(30);
	$pdf->MultiCellBltArray($column_width-$pdf->x,6,$identado);
	$pdf->Ln(3);
	$pdf->SetX(20);
	$pdf->Multicell(0, 6, utf8_decode("\t\t\t\t\t\t\tEl Botón de Guardar: si Ud. presiona este botón faltando algún campo saldrá la advertencia en dicho campo, también sirve de guía para el llenado del formulario completo, de da una guía de cuál será el campo siguiente en el llenado, si todo está bien guardará los datos y saldrá un aviso del guardado y se reinicia el formulario para el llenado de la siguiente empresa."),0,"J");


	/*******************   MODULO DE INICIO  *****************************/
	$pdf->AddPage();
	$pdf->Bookmark(utf8_decode('5. Modulo de Inicio'),false);
	$pdf->Cell(10);
	$pdf->SetFont('RobotoCondensed','B',14);
	$pdf->Cell(0, 10,"5. " . utf8_decode("Modulo de Inicio"),0,1,"L");
	$pdf->Cell(8);
	$pdf->Ln(1);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tEste módulo saldrá en la carga de la página principal, es el Home del Sistema, aquí existe una lista de empresas, la cual cada una contiene tres (3) botones, uno para ver la planilla de la empresa, otro para modificar los datos de la empresa y el ultimo para eliminar a dicha empresa. En el pie del listado de empresa existe un botón que consigue el reporte de las empresas en búsqueda en formato PDF. En la parte superior de la tabla existe un selector de parroquia para realizar la búsqueda directa de empresas por parroquia sin tener que buscarlo en el buscador (valga la redundancia). Al lado derecho de la pantalla se encuentra un listado de las facturaciones diarias (si es que existen facturaciones), y al mismo tiempo existe un botón para obtener el reporte de la facturación diaria como para realizar el cierre del registro diario de recibos."),0,"J");
	$pdf->Ln(5);
	$column_width = $pdf->w-30;
	$text = array(
		"Buscador: El buscador ubicado en la parte derecha de la barra de navegación, en esta sección solo sirve para buscar a empresas por, nombre o Rif, automáticamente saldrán la(s) empresa(s) buscadas en el listado de empresas. Acciona dando en Enter o Haciendo click en el botón de buscar.",
		"Búsqueda por Parroquia:  En la parte superior izquierda del listado de empresas, existe un selector de parroquias la cual actúa como buscador, si selecciona una parroquia entonces, aparecen las empresas que están en esa ubicación, si se quiere el listado completo vuelva a seleccionar la opción por defecto que es “Parroquia”.",
		"Paginación del Listado de Empresa: La función es sencilla para el control de usuario, salen los botones típicos de una paginación los cuales son primera página, pagina anterior, los numero de páginas que existen, la página siguiente y la última página, respectivamente.",
		"Botón de Ver Planilla: Este está en cada empresa de la lista, y al cliquearlo aparece un reporte en Formato PDF que contiene todos los datos de la empresa actual, tiene como título Patente de Industria y Comercio. Puede descargarse o ser impresa en la misma pantalla actual de la Planilla.",
		"Botón de Modificar: Al elegir esta opción se extraen todos los datos de la empresa y se colocan en el formulario de datos que Aparece en Nueva Empresa, Pero hay algunos datos que no se podrán modificar, como lo son: por empresa (nombre, Rif, código de comercio, fecha del registro legal, actividad comercial, y último mes en deuda), por propietario (cedula, y Rif), el resto de los datos si podrán ser modificados y también se puede eliminar un teléfono si tiene 2 y/o se pueden cambiar los dos en su mismos campo, como también agregar un número telefónico nuevo si solo tiene uno.",
		"Botón Eliminar: Si se elige este entonces saldrá una advertencia explicado en pocas palabras que si elimina a la empresa Ud. perderá absolutamente todos los datos relacionados a esta.",
		"Botón de Reporte Empresa: Manda un reporte en formato PDF de la búsqueda Actual o listado actual de las empresas. Si se realiza una búsqueda de cualquier empresa, entonces sacará a dicha empresa en ese reporte, si se realiza una búsqueda por parroquia, imprimirá al grupo de empresas en esa parroquia, si se quiere imprimir todo el listado de empresas, entonces se tiene que tener vacío el campo de búsqueda y elegido la opción “Parroquia” en el selector respectivo.",
		"Paginación en el listado de facturas diarias: Es sencillísimo solo tiene 2 botones el pagina anterior, y pagina siguiente, así se podrá navegar entre las páginas del listado de facturas diarias. Importante, que este actúa independientemente del listado de Empresas y no repercute en nada a dicho listado, así sea que se encuentren en la misma pantalla.",
		"Botón de Imprimir facturas diarias: Imprime el listado de facturas diarias, y el total de dinero ingresado por ese día, todo en formato PDF. Todo con el propósito de ser imprimible en hoja de papel (tipo Carta 8 y ½  x 11 pulg)."
	);
	$identado = array();
	$identado['bullet'] = '>';
	$identado['margin'] = ' ';
	$identado['indent'] = 10;
	$identado['spacer'] = 5;
	$identado['text'] = array();
	for ($i=0; $i<count($text); $i++)
	{
	    $identado['text'][$i] = utf8_decode($text[$i]);
	}
	$pdf->SetX(30);
	$pdf->MultiCellBltArray($column_width-$pdf->x,6,$identado);

	/*********************  MODULO DEUDORES  *********************************/
	$pdf->AddPage();
	$pdf->Bookmark(utf8_decode('6. Modulo de Deudores'),false);
	$pdf->Cell(10);
	$pdf->SetFont('RobotoCondensed','B',14);
	$pdf->Cell(0, 10,"6. " . utf8_decode("Modulo de Deudores"),0,1,"L");
	$pdf->Cell(8);
	$pdf->Ln(1);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tEn esta sección saldrá un listado de las empresas que están en deuda hasta el mes actual, el listado tiene los datos más relevantes para tener a simple vista, existe la oportunidad de realizar búsqueda por rango de fechas, por nombre o Rif (en el buscador), obtener un reporte del listado actual y dirigirse al pago de la empresa en particular."),0,"J");
	$pdf->Ln(5);
	$column_width = $pdf->w-30;
	$text = array(
		"Buscador: Se realizan búsqueda por nombre de empresa o por Rif de empresa.",
		"Búsqueda por rango de fechas: Este trabaja de la forma que, existen 2 Checkbox, uno que es desde el cual en primera instancia aparece habilitado, y el otro que es hasta que aparece deshabilitado. Se tiene que elegir el Check desde para poder buscar por fecha desde el año y el mes que también son validados, si solo selecciona este Check entonces buscara desde la fecha ingresada hasta la fecha actual, si se selecciona la otra opción (Hasta) que aparecerá desactivada solo si esta seleccionada la opción desde y están llenos los campos de año y mes de Desde, entonces buscara desde el mes – hasta el otro mes. Todo está validado al presionar el botón “Ir” saldrán las advertencias pertinentes al llenado de campos para la búsqueda por fecha.",
		"Botón Obtener Reporte: Obtiene el reporte del listado actual buscado o no, en el listado de deudores, en formato PDF.",
		"Botón pagar de cada empresa: Este coge los datos de la empresa deudora elegida y los traslada hacia la sección de realización pago, en el cual aparecerán los meses que debe cancelar el deudor."
	);
	$identado = array();
	$identado['bullet'] = '>';
	$identado['margin'] = ' ';
	$identado['indent'] = 10;
	$identado['spacer'] = 5;
	$identado['text'] = array();
	for ($i=0; $i<count($text); $i++)
	{
	    $identado['text'][$i] = utf8_decode($text[$i]);
	}
	$pdf->SetX(30);
	$pdf->MultiCellBltArray($column_width-$pdf->x,6,$identado);

	/*********************  MODULO SOLVENTES  *********************************/
	$pdf->AddPage();
	$pdf->Bookmark(utf8_decode('7. Modulo de Solventes'),false);
	$pdf->Cell(10);
	$pdf->SetFont('RobotoCondensed','B',14);
	$pdf->Cell(0, 10,"7. " . utf8_decode("Modulo de Solventes"),0,1,"L");
	$pdf->Cell(8);
	$pdf->Ln(1);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tSección en donde aparecen solo las empresas solventes. Tener en cuenta que las empresas son solventes siempre y cuando paguen hasta el mes actual, ya que hasta ahí es donde es permitido pagar por cualquier empresa."),0,"J");
	$pdf->Ln(5);
	$column_width = $pdf->w-30;
	$text = array(
		"Buscador: Se realizar búsquedas por nombre o Rif de Empresa, el resultado se obtendrá en la parte del listado de empresa.",
		"Botón Obtener Reporte: Se Obtiene el Reporte de la Búsqueda actual de las empresas solventes o todo el listado de empresas respectivas.",
		"Botón Certificado: Aquí se obtendrá un reporte del certificado de la solvencia de la empresa escogida hasta el mes actual, tiene como título Certificado de Solvencia y se obtiene en formato PDF para que se pueda Imprimir y así el dueño de la empresa tenga un documento que avale su solvencia hasta dicho mes."
	);
	$identado = array();
	$identado['bullet'] = '>';
	$identado['margin'] = ' ';
	$identado['indent'] = 10;
	$identado['spacer'] = 5;
	$identado['text'] = array();
	for ($i=0; $i<count($text); $i++)
	{
	    $identado['text'][$i] = utf8_decode($text[$i]);
	}
	$pdf->SetX(30);
	$pdf->MultiCellBltArray($column_width-$pdf->x,6,$identado);

	/*********************  MODULO FACTURACIONES *********************************/
	$pdf->AddPage();
	$pdf->Bookmark(utf8_decode('8. Modulo de Facturaciones'),false);
	$pdf->Cell(10);
	$pdf->SetFont('RobotoCondensed','B',14);
	$pdf->Cell(0, 10,"8. " . utf8_decode("Modulo de Facturaciones"),0,1,"L");
	$pdf->Cell(8);
	$pdf->Ln(1);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tEn esta sección saldrá cada factura que se ha creado desde la más actual hasta la más antigua, se pueden hacer búsqueda de facturas por, código, referencia, tipo de pago, nombre de empresa. Búsqueda por rango de fechas, imprimir reporte actual, imprimir dicha factura, e ir directamente hacia el módulo de realización de pagos."),0,"J");
	$pdf->Ln(5);
	$column_width = $pdf->w-30;
	$text = array(
		"Buscador: Realizar búsquedas por Código de Factura (exacto), Numero de Referencia del tipo de pago de la factura (exacto), El Tipo de Pago (exacto), nombre de la empresa (exacto), la búsqueda será reflejada por el listado en pantalla.",
		"Búsqueda por Rango de Fechas: Se realiza de forma sencilla. El campo Desde de la fecha saldrá activado, el campo Hasta saldrá desactivado y el botón “Ir” saldrá desactivado. Para realizar una búsqueda por fecha se tendrá que colocar una fecha valida en el campo de Desde, y buscara desde esa fecha hasta la actual y si se quiere hasta una fecha limite rellenar el campo de Hasta con una fecha valida mayor que la de Desde y menor o igual a la actual, y con este criterio ya se pueden realizar las búsquedas por rango de fechas. Para buscar en un día en concreto se tienen que colocar en los dos campos la misma fecha exacta.",
		"Botón Obtener Reporte de Facturas: Obtendrá el reporte de las facturas en la búsqueda actual, o todo el listado de facturas, en formato PDF.",
		"Botón Imprimir de cada Factura en lista: Al elegir se tomarán los datos de la factura y se imprimirá la factura en formato PDF para luego (si se quiere) mandarlo a la impresora, para dar dicha factura al respectivo dueño de empresa.",
		"Botón Hacer Facturación: Redirige hacia el módulo de realización de pagos de meses por empresa, pero en este modo todos los campos aparecerán vacíos, por el motivo de que el usuario pueda buscar a la empresa que desee. Se explicará más adelante con más minuciosidad."
	);
	$identado = array();
	$identado['bullet'] = '>';
	$identado['margin'] = ' ';
	$identado['indent'] = 10;
	$identado['spacer'] = 5;
	$identado['text'] = array();
	for ($i=0; $i<count($text); $i++)
	{
	    $identado['text'][$i] = utf8_decode($text[$i]);
	}
	$pdf->SetX(30);
	$pdf->MultiCellBltArray($column_width-$pdf->x,6,$identado);



	/**************  MODULO REALIZACION DE PAGOS DE MESES POR EMPRESA ********/

	$pdf->AddPage();
	$pdf->Bookmark(utf8_decode('9. Modulo de Realización de Pagos de Meses por Empresa'),false);
	$pdf->Cell(10);
	$pdf->SetFont('RobotoCondensed','B',14);
	$pdf->Cell(0, 10,"9. " . utf8_decode("Modulo de Realización de Pagos de Meses por Empresa"),0,1,"L");
	$pdf->Cell(8);
	$pdf->Ln(1);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tExisten 2 casos para este módulo, y estos son:"),0,"J");
	$pdf->Ln(5);
	$column_width = $pdf->w-30;
	$text = array(
		"Cuando se ingresa por el botón de Hacer Facturación: El Buscador aparece activado para realizar la búsqueda de la empresa por Id o por Rif de la misma. Si dicha empresa no existe saldrá un mensaje advirtiendo y si existe saldrán sus datos en los campos respectivos y los meses que debe de cancelar la empresa.",
		"Cuando se ingresa por el botón de Pagar en la Lista de Deudores: El Buscador saldrá desactivado ya que aparecerán los datos específicos de la empresa escogida y los meses que dicha empresa tiene que cancelar, no es necesario de una búsqueda de por empresa, ya que este módulo es individual para esa empresa."
	);
	$identado = array();
	$identado['bullet'] = 1;
	$identado['margin'] = '. ';
	$identado['indent'] = 10;
	$identado['spacer'] = 5;
	$identado['text'] = array();
	for ($i=0; $i<count($text); $i++)
	{
	    $identado['text'][$i] = utf8_decode($text[$i]);
	}
	$pdf->SetX(30);
	$pdf->MultiCellBltArray($column_width-$pdf->x,6,$identado);
	$pdf->Ln(3);
	$pdf->SetX(20);
	$pdf->Multicell(0, 6, utf8_decode("\t\t\t\t\t\t\tPasos para la cancelación de los meses: para la empresa a la cual se va a cancelar los meses, estos aparecerán en un listado en la sección central, el check del primer mes aparecerá activado, tiene que elegir dicho check para poder rellenar los campos siguientes. El campo de Concepto siempre estará desactivado, elija el tipo de pago, si tipo de pago es efectivo se desactivará el campo de referencia, si elige el otro tipo de pago entonces se activa el campo de referencia para que coloque la misma, coloque el ingreso bruto mensual de la empresa, y cliquee el botón Calcular si todos los campos están bien saldrá el total a cancelar de dicho mes, se activara el checkbox del mes siguiente (si es que existe el mes), y se ira sumando al total general a cancelar en la parte inferior al lado de Observación. "),0,"J");
	$pdf->Cell(8);
	$pdf->Ln(3);
	$pdf->Multicell(0, 6, utf8_decode("\t\t\t\t\t\t\tLa Observación General de la Factura es muy importante rellenarla de texto coherente al pago de los meses, si esta no se llena entonces saldrá la advertencia respectiva para dicho campo."),0,"J");
	$pdf->Cell(8);
	$pdf->Ln(3);
	$pdf->Multicell(0, 6, utf8_decode("\t\t\t\t\t\t\tSi por alguna razón piensa que todo está bien y presiona alguno de los botones de guardar, y falta algún campo saldrá la advertencia en dicho campo, hasta que no llene todos los campos debidamente correctos no podrá guardar la información del pago o recibo."),0,"J");
	$pdf->Cell(8);
	$pdf->Ln(3);
	$pdf->Multicell(0, 6, utf8_decode("\t\t\t\t\t\t\tBotón Guardar (a secas): Este botón valida los campos anteriores y si todo está bien guarda la información y reinicia o vuelve atrás dependiendo de donde vino la petición de pago, no muestra ninguna factura, pero estas aparecerán en el listado de facturación."),0,"J");
	$pdf->Cell(8);
	$pdf->Ln(3);
	$pdf->Multicell(0, 6, utf8_decode("\t\t\t\t\t\t\tBotón Guardar y Generar PDF: Este botón realiza el mismo trabajo que el anterior en primera instancia, pero al guardar automáticamente genera un archivo PDF el cual contendrá todas las facturas de los meses cancelados en ese momento, esto con el propósito de imprimir directamente las facturas que se le realizaron a la empresa."),0,"J");


	/* OPCIONES DE USUARIO ADMINISTRADOR (DIRECTOR DE HACIENDA O ADMINISTRADOR DEL AREA RESPECTIVA). */

	$pdf->AddPage();
	$pdf->Bookmark(utf8_decode('10. Opciones de Usuario Administrador (Director de Hacienda o administrador del área respectiva)'),false);
	$pdf->Cell(10);
	$pdf->SetFont('RobotoCondensed','B',14);
	$pdf->Multicell(0, 8, utf8_decode("10. Opciones de Usuario Administrador (Director de Hacienda o administrador del área respectiva)"),0,"L");
	$pdf->Cell(8);
	$pdf->Ln(1);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tAlgunas de estas opciones ya fueron mencionadas anteriormente y se encuentra en el botón que contiene solo un icono de \"Configuración de Usuario\" en la barra de navegación principal del sistema, es el último botón antes del campo de Búsqueda. Son 4 opciones importantes para el funcionamiento del sistema en general, a continuación, se describen."),0,"J");
	$pdf->Ln(3);
	$column_width = $pdf->w-30;
	$text = array(
		"Impuesto Anual: de esta opción ya se habló en un punto anterior, en específico en el punto 3.1, el cual describe correctamente el funcionamiento de la misma, cuando se debe ingresar a este módulo y también ¿Cuál es el propósito del mismo? \"Ir al punto 3.1\".",
		"Actividad Comercial: este módulo también ya se describió anteriormente, en el punto 3.2, el cual explica de manera detallada dicho funcionamiento del mismo. \"Ir al punto 3.2\".",
		"Hacer Respaldo: este es uno de los botones más importantes del sistema y uno de los que más se tendría que tener en cuenta, ya que este es el que realiza el Backup o Respaldo del Sistema en su momento actual, por ende, se debería realizar un respaldo del sistema cada 2 días como mínimo, por si en algún momento ocurre una avería en la computadora donde se está utilizando el sistema se puedan recuperar dichos datos de forma fácil y rápida. Es sencillo, con solo cliquear en el enlace se generará la descarga del mismo en el computador. Después de descargar el archivo es recomendable que lo busque inmediatamente en donde se descargó y lo suba a un repositorio en la nube o lo suba a un correo electrónico concurrido, para que estos se salven correctamente y no se perjudiquen los datos. Al momento de utilizarlo se Descarga el archivo y se coloca en “Escritorio” o en un directorio que sea fácil de acceder.",
		"Restaurar Sistema: esta sección se explicó de manera general en el punto 2.2 en la sección de \"Primeros Pasos\". Continuando con lo anterior, esta sección solo se utilizará para la Restauración de los datos del Sistema (solo para ese propósito), y puede ser útil al momento de comenzar con el sistema (explicado anteriormente) y también para cuando el sistema o el computador tenga un fallo y se quiera volver a trabajar con el sistema y los datos actuales del mismo, esto evita volver a comenzar de nuevo con el sistema desde cero. Es sencillo de utilizar, solo cliquear en el enlace respectivo, saldrá una ventana sobresaliente que contendrá un solo campo (es el campo de la subida del archivo), dar click en el icono de la carpeta para proceder a buscar el archivo (anteriormente descargado y colocado en un directorio con fácil acceso), ya que lo encontró darle click y esperar a que en el campo se escriba el nombre del archivo, ya que lo tiene dar click en el botón de \"Restaurar\", comenzara la restauración del sistema, espere unos segundo de carga, luego saldrá un aviso de restauración y se reiniciara el sistema automáticamente para comenzar a utilizarlo desde el punto de Respaldo Guardado."
	);
	$identado = array();
	$identado['bullet'] = 1;
	$identado['margin'] = '. ';
	$identado['indent'] = 1;
	$identado['spacer'] = 5;
	$identado['text'] = array();
	for ($i=0; $i<count($text); $i++)
	{
	    $identado['text'][$i] = utf8_decode($text[$i]);
	}
	$pdf->SetX(30);
	$pdf->MultiCellBltArray($column_width-$pdf->x,6,$identado);


	/**************  Mensaje de finalización. ********/
	$pdf->AddPage();
	$pdf->Bookmark(utf8_decode('11. Mensaje de finalización'),false);
	$pdf->Cell(10);
	$pdf->SetFont('RobotoCondensed','B',14);
	$pdf->Cell(0, 10,"11. " . utf8_decode("Mensaje de finalización"),0,1,"L");
	$pdf->Cell(8);
	$pdf->Ln(1);
	$pdf->SetFont('RobotoCondensed','',12);
	$pdf->Multicell(0, 8, utf8_decode("\t\t\t\t\t\t\tCon este manual se orienta a cualquier usuario a manipular y controlar de manera eficiente y correcta el sistema expuesto, puede ser consultado sin ningún obstáculo, para poder salir de la duda de cualquier función de dicho sistema. Se recomienda analizarlo detalladamente para su mejor comprensión y adquisición de conocimientos."),0,"J");
	
	/*$pdf->Bookmark('Subsection 1',false,1,-1);
	$pdf->Cell(0,6,'Subsection 1');
	$pdf->Ln(50);
	$pdf->Bookmark('Subsection 2',false,1,-1);
	$pdf->Cell(0,6,'Subsection 2');*/

	//Page 2
	/*$pdf->AddPage();
	$pdf->Bookmark('Section 2',false);
	$pdf->Cell(0,6,'Section 2',0,1);
	$pdf->Bookmark('Subsection 1',false,1,-1);
	$pdf->Cell(0,6,'Subsection 1');*/

	//Content
	/*$pdf->AddPage();
	$pdf->Bookmark('Contenido',false);
	$pdf->SetFont('Ubuntu','',12);

	$column_width = $pdf->w-30;
	$sample_text = 'This is bulleted text. The text is indented and the bullet appears at the first line only. This list is built with a single call to MultiCellBltArray().';

	//Test1
	$test1 = array();
	$test1['bullet'] = chr(149);
	$test1['margin'] = ' ';
	$test1['indent'] = 0;
	$test1['spacer'] = 0;
	$test1['text'][0] = $sample_text;
	$pdf->SetX(10);
	$pdf->MultiCellBltArray($column_width-$pdf->x,6,$test1);

	//Test 2
	$test2 = array();
	$test2['bullet'] = '>';
	$test2['margin'] = ' ';
	$test2['indent'] = 5;
	$test2['spacer'] = 5;
	$test2['text'][0] = $sample_text;
	$pdf->SetX(20);
	$pdf->MultiCellBltArray($column_width-$pdf->x,6,$test2);

	//Test 3
	$test3 = array();
	$test3['bullet'] = 1;
	$test3['margin'] = ') ';
	$test3['indent'] = 10;
	$test3['spacer'] = 10;
	$test3['text'] = array();
	for ($i=0; $i<4; $i++)
	{
	    $test3['text'][$i] = $sample_text;
	}
	$pdf->SetX(30);
	$pdf->MultiCellBltArray($column_width-$pdf->x,6,$test3);*/

	$pdf->Output();
?>