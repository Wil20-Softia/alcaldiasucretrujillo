<!DOCTYPE html>
<html lang="es" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, minimum-scale=1.0">
    <title>Contribuyente Alcaldia Sucre</title>

    <!--  CODIGO PARA EL ICONO DEL SISTEMA. -->
    <link rel="apple-touch-icon" sizes="57x57" href="img/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="img/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/icon/favicon-16x16.png">
    <link rel="manifest" href="img/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="img/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
    <!--  FIN DEL CODIGO DEL ICONO DEL SISTEMA -->

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>

    <!--
        IMAGEN QUE VA EN EL FONDO DEL SISTEMA. SI DESEA CAMBIAR LA IMAGEN DE FONDO
        COLOQUE LA DIRECCION DE LA IMAGEN AQUI Y LISTO.
    -->
	<img src="img/fondo_oficina3.jpg">
    
    <!--
        Contendor que esta invisible y solo se activa cuando se esta restaurando el sistema. Es una Imagen de Carga.
    -->
    <div class="cargando">
        <img src="img/cargando3.gif">
    </div>
    
    <!--  
        IMAGENES QUE ESTAN EN LA CABECERA DEL SISTEMA.  
        REPRESENTANDO EL LOGOTIPO DE LA ALCALDIA.
    -->
    <header>
    	<img id="img_header1" src="img/escudo_trujillo.jpg">
    	<img id="img_header2" src="img/cabecera.png">
    	<img id="img_header3" src="img/escudo_municipio.jpg">
    </header>

	<div id="seccion_principal">

        <!-- Menú Principal del Sistema -->
    	<nav>
	    	<ul id="ul1">
	    		<li>
                    <a href="#" id="inicio" title="Ir a inicio"><i class="fas fa-home"></i> Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="registrar" title="Registrar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-archive"></i> Registrar
                    </a>
                    <!-- SUB-MENU DE NAVEGACION -->
                    <div class="dropdown-menu bg-info" aria-labelledby="registrar">
                        <a href="#" class="dropdown-item text-white" id="nueva_empresa" title="Registrar una Empresa">
                           <i class="far fa-building"></i> Empresa
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-white" id="nueva_persona" title="Registrar un Contribuyente Natural">
                            <i class="fas fa-user-tag"></i> Persona
                        </a>
                    </div>
                </li>
	    		<li>
                    <a href="#" id="deudores" title="Ver Listado de Morosos"><i class="fas fa-hand-holding-usd"></i> Morosos</a>
                </li>
	    		<li>
                    <a href="#" id="solventes" title="Ver Listado de Amortizados"><i class="fas fa-balance-scale"></i> Amortizados</a>
                </li>
	    		<li>
                    <a href="#" id="facturaciones" title="Ver Listado de Recibos"><i class="fas fa-money-check-alt"></i> Recibos</a>
                </li>
	    		<li>
                    <a href="#" id="facturacion" title="Formulario para realizar el Pago de un Contribuyente">
                        <i class="fas fa-handshake"></i>
                        Cancelar
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="admin" title="Opciones Especiales de Administrador" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-cog"></i>
                    </a>
                    <!-- SUB-MENU DE NAVEGACION -->
                    <div class="dropdown-menu bg-info" aria-labelledby="admin">
                        <a href="#" class="dropdown-item text-white" id="actividad_comercial">
                           <i class="far fa-file-alt"></i> Actividad Comercial
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-white" id="respaldo">
                            <i class="fas fa-file-archive"></i> Hacer Respaldo
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-white" id="restaurar" data-toggle="modal" data-target="#exampleModal">
                            <i class="fas fa-cloud-upload-alt"></i> Restaurar Sistema
                        </a>
                    </div>
                </li>
	    	</ul>
	    	
	    	<ul id="ul2">
	    		<li id="item-busqueda">
	    			<input type="text" id="busqueda" class="field" placeholder="">
	    		</li>
	    		<a href="#" id="btn-busqueda"><i class="fas fa-search"></i></a>
	    	</ul>	    		
    	</nav>
        <!-- FIN....... Menú Principal del Sistema -->

        <!-- Formulario de la Restauracion del sistema -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Restauración de Sistema</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="formulario_restaurar" method="POST" enctype="multipart/form-data" autocomplete="off">
                  <div class="modal-body">
                        <div class="uploader">
                            <div id="inputval" class="input-value"></div>
                            <label for="file_restaurar"></label>
                            <input id="file_restaurar" class="upload" type="file" name="file_restaurar" accept=".gz">
                        </div>
                  </div>
                  <div class="modal-footer">
                    <a type="button" id="btn-cerrar" class="btn btn-secondary" data-dismiss="modal">Cerrar</a>
                    <button type="submit" id="btn-subir-restauracion" class="btn btn-primary">Restaurar</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
        <!-- FIN.... Formulario de la Restauracion del sistema -->


		<div id="seccion_impresion" class="pd-ssm">
            <!--AQUI ES DONDE SE IMPRIMEN LOS CONTENIDOS DINAMICAMENTE.-->
            
            

            <!--TERMINA LA SECCION DE IMPRESION DINAMICA.-->
       	</div>
    </div>
    
    <!-- LIBRERIAS DE JAVASCRIPT PARA FACILITAR LA PROGRAMACION. -->
    <script type="text/javascript" src="js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="js/popper.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    
    <script type="text/javascript" src="js/all.js"></script>
    <!--<script type="text/javascript" src="js/fontawesome.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>-->

    <!-- SECCION DE ARCHIVOS CONFECCIONADOS POR EL DESARROLLADOR.-->
    <script type="text/javascript" src="js/templates.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>
    <script type="text/javascript" src="js/validacion_formularios.js"></script>
    <script type="text/javascript" src="js/events.js"></script>
    <script type="text/javascript" src="js/core.js"></script>
    

    <script type="text/javascript">    </script>

  </body>

</html>