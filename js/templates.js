const template_index = `
	<div class="wh-completo pd-ssm">
        <div class="fila-auto texto-centrado texto-cabecera-tabla fondo-azul-blanco">
            <div class="column-2-12 pd-btigual-mitad">Rif</div>
            <div class="column-2-12 pd-btigual-mitad">Nombre</div>
            <div class="column-2-12 pd-btigual-mitad">Telefono</div>
            <div class="column-3-12 pd-btigual-mitad">Dirección</div>
            <div class="column-3-12 pd-ssm">
                <select class="wh-completo parroquias" id="parroquias" name="parroquias">
                    <option value="0" selected="selected">Parroquias</option>
                </select>
            </div>
        </div>

        <div class="bd-1p-bln fondo-blanco-transparente fila-h80 listado-impresion fila-int-azul-gris fila-hover-blan scrolleable">
            <!--CONTENEDOR DONDE SE MOSTRARÁ LA LISTA DE LOS DEUDORES-->
        </div>

        <footer class="fila-h1 fondo-azul-blanco">
            <article id="contenedor-paginacion" class="column-9-12">
                <div id="primeros"> </div>
                        
                <div id="numeros-paginas"> </div>

                <div id="ultimos"> </div>
            </article>

            <article class="column-3-12">
                <a href="#" class="btn-naranja hover-naranja-blanco" id="reporte-empresas"><i class="fas fa-file-download"></i> Reporte Contribuyentes</a>
            </article>
        </footer>
    </div>
`;


const template_nuevaEmpresa = `
<form class="wh-completo" id="formulario_empresa">
    <div class="columna-5 mar-izq mar-der">
        <div class="fila-h90 sombra-negra-caja fondo-degradado-grisblanco">
            <div class="titulo-formulario fila-h1 pd-ssm mar-aba">
                Datos de la Empresa
            </div>
            <div class="fila-h1 mar-aba-2p">
                <div class="columna-5 pd-ssm" id="caja_nomemp">
                    <input class="wh-completo sombra-negra-caja" id="nombre_empresa-form" name="nombre_empresa-form" type="text" placeholder="* Nombre de la empresa" maxlength="25">
                </div>
                <div class="columna-5 pd-ssm" id="caja_rifemp">
                    <input class="wh-completo sombra-negra-caja" id="rif_empresa-form" name="rif_empresa-form" type="text" placeholder="* Rif Empresa: J-123456789" maxlength="11">
                </div>
            </div>
            <div class="fila-h1 mar-aba">
                <div class="columna-5 pd-ssm" id="caja_codcomemp">
                    <input class="wh-completo sombra-negra-caja" id="cod_comercio-form" name="cod_comercio-form" type="text" placeholder="* Codigo de Comercio" maxlength="20">
                </div>
                <div class="columna-5 pd-ssm" id="caja_telemp">
                    <input class="wh-completo sombra-negra-caja" id="telefono_empresa-form" name="telefono_empresa-form" type="text" placeholder="* Número telefónico: 0281-4437788" maxlength="12">
                </div>
            </div>
            <div class="fila-h1 mar-aba-2p pd-centrado45l">
                <div class="subtitulo-formulario-pq texto-derecho columna-45 mar-der pd-sm">
                    * Fecha del Registro Legal:
                </div>
                <div class="pd-ssm columna-45" id="caja_fecregemp">
                    <input class="wh-completo sombra-negra-caja" id="registro_empresa-form" name="registro_empresa-form" type="date" maxlength="8" size="8">
                </div>
            </div>
            <div class="fila-h1">
                <div class="subtitulo-formulario-pqm texto-centrado column-4-12 pd-ssm">
                    *Dirección:
                </div>
                <div class="column-5-12 pd-ssm" id="caja_paremp">
                    <select class="wh-completo sombra-negra-caja" name="parroquia-empresa-form" id="parroquia-empresa-form">
                    	<option value=0>Parroquia</option>
                    </select>
                </div>
            </div>
            <div class="fila-h2 mar-aba pd-ssm" id="caja_detdiremp">
                <textarea class="wh-completo sombra-negra-caja" id="deta_dir_empresa-form" name="deta_dir_empresa-form" placeholder="* Detalles de la dirección: Sector; calle o, carrera o, vereda o, bloque; numero de casa o, apartamento." maxlength="200"></textarea> 
            </div>
            <div class="fila-h1 mar-aba pd-centrado45l">
                <div class="texto-izquierdo txt-bold-pq columna-4 pd-sm">
                    *Activida Comercial:
                </div>  
                <div class="pd-ssm columna-65" id="caja_actcomemp">
                    <select class="wh-completo sombra-negra-caja" name="actividad_comercial-form" id="actividad_comercial-form">
                    </select>
                </div>
            </div>
        </div>
        <div class="fila-final">
        	<button class="bd-1p-bln btn-primary boton-importante" id="boton-guardar-empresa" name="boton-guardar-empresa"><i class="far fa-save"></i> Guardar</button>
        </div>
    </div>
                
    <div class="columna-45 fila-h90 sombra-negra-caja fondo-degradado-grisblanco bd-1p-bln">
        <div class="titulo-formulario mar-aba pd-ssm fila-h1">
            Representante Legal
        </div>
        <div class="fila-h1">
            <div class="columna-5 pd-ssm" id="caja_nomprop">
                <input class="wh-completo sombra-negra-caja" id="nombre_propietario-form" name="nombre_propietario-form" type="text" placeholder="* Nombres" maxlength="20">
            </div>
            <div class="columna-5 pd-ssm" id="caja_apeprop">
                <input class="wh-completo sombra-negra-caja" id="apellido_propietario-form" name="apellido_propietario-form" type="text" placeholder="* Apellidos" maxlength="25">
            </div>
        </div>
        <div class="fila-h1 mar-arr-2p">
            <div class="columna-5 pd-ssm" id="caja_cedprop">
                <input class="wh-completo sombra-negra-caja" id="cedula_propietario-form" name="cedula_propietario-form" type="text" placeholder="* C.I: V-12345678" maxlength="10">
            </div>
            <div class="columna-5 pd-ssm" id="caja_rifprop">
                <input class="wh-completo sombra-negra-caja" id="rif_propietario-form" name="rif_propietario-form" type="text" placeholder="* Rif: J-123456789" maxlength="11">
            </div>
        </div>
        <div class="fila-h1 subtitulo-formulario-pqm texto-centrado pd-sm">
                        * Dirección de Habitación.
        </div>
        <div class="fila-h1">
            <div class="column-4-12 pd-ssm" id="caja_estprop">
                <select class="wh-completo sombra-negra-caja estado-dependiente" name="estado_propietario-form" id="estado_propietario-form">
                    <option value=0>Estado</option>
                </select>
            </div>
            <div class="column-4-12 pd-ssm" id="caja_munprop">
                <select class="wh-completo sombra-negra-caja" name="municipio_propietario-form" id="municipio_propietario-form">
                    <option value=0>Municipio</option>
                </select>
            </div>
            <div class="column-4-12 pd-ssm" id="caja_parprop">
                <select class="wh-completo sombra-negra-caja" name="parroquia-propietario-form" id="parroquia-propietario-form">
                	<option value=0>Parroquia</option>
                </select>
            </div>
        </div>
        <div class="fila-h2 mar-aba pd-ssm" id="caja_detdirper">
            <textarea class="wh-completo sombra-negra-caja" id="deta_dir_persona-form" name="deta_dir_persona-form" placeholder="* Detalles de la dirección: Sector; calle o, carrera o, vereda o, bloque; numero de casa o, apartamento." maxlength="200"></textarea> 
        </div>
            <div class="fila-h1 pd-ssm">
                 <div class="column-5-12 subtitulo-formulario-pq texto-izquierdo pd-ssm">
                            * Número Telefónico.
                </div>
                <div class="column-4-12 pd-ssm" id="caja_telefono">
                    <input class="wh-completo sombra-negra-caja telefono_propietario-form" name="telefono_propietarioForm" id="telefono_propietarioForm" type="text" placeholder="0426-7778888" maxlength="12">
                </div>
            </div>
            <div class="fila-h1 pd-ssm">
                 <div class="column-8-12 subtitulo-formulario-pq texto-izquierdo">
                        * ¿Es él, Contribuyente del Municipio?
                </div>
                <div id="caja-pregcontrib" class="column-4-12">
                    <div class="column-6-12">
                        <label class="column-6-12 subtitulo-formulario-pq texto-derecho" for="contribuyente_rep">Si</label> 
                        <div class="column-6-12">
                            <input class="option-input-completo radio contribuyente_rep" name="contribuyente_rep" type="radio" value="1">
                        </div>
                    </div>
                    <div class="column-6-12">
                        <label class="column-6-12 subtitulo-formulario-pq texto-derecho" for="contribuyente_rep">No</label> 
                        <div class="column-6-12">
                            <input class="option-input-completo radio contribuyente_rep" name="contribuyente_rep" type="radio" value="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
`;


const template_nuevaPersona = `
    <form class="wh-completo" id="formulario_persona">
                <div class="column-3-12"></div>
    <div class="column-6-12">
        <div class="fila-h90 sombra-negra-caja fondo-degradado-grisblanco">
            <div class="titulo-formulario fila-h1 pd-ssm mar-aba">
                Contribuyente Persona Natural
            </div>
            <div class="fila-h1 mar-aba-2p">
                <div class="columna-5 pd-ssm" id="caja_nompers">
                    <input class="wh-completo sombra-negra-caja" id="nombre_persona-form" name="nombre_persona-form" type="text" placeholder="* Nombres" maxlength="20">
                </div>
                <div class="columna-5 pd-ssm" id="caja_apepers">
                    <input class="wh-completo sombra-negra-caja" id="apellido_persona-form" name="apellido_persona-form" type="text" placeholder="* Apellidos" maxlength="25">
                </div>
            </div>
            <div class="fila-h1 mar-aba">
                <div class="columna-5 pd-ssm" id="caja_cedpers">
                    <input class="wh-completo sombra-negra-caja" id="cedula_persona-form" name="cedula_persona-form" type="text" placeholder="* C.I: V-12345678" maxlength="10">
                </div>
                <div class="columna-5 pd-ssm" id="caja_rifpers">
                    <input class="wh-completo sombra-negra-caja" id="rif_persona-form" name="rif_persona-form" type="text" placeholder="* Rif: V-123456789" maxlength="11">
                </div>
            </div>
            <div class="fila-h1">
                <div class="subtitulo-formulario-pqm texto-centrado column-4-12 pd-ssm">
                    * Dirección:
                </div>
                <div class="column-5-12 pd-ssm" id="caja_parpers">
                    <select class="wh-completo sombra-negra-caja" name="parroquia-persona-form" id="parroquia-persona-form">
                        <option value=0>Parroquia</option>
                    </select>
                </div>
            </div>
            <div class="fila-h2 mar-aba pd-ssm" id="caja_detdirpers">
                <textarea class="wh-completo sombra-negra-caja" id="deta_dir_persona-form" name="deta_dir_persona-form" placeholder="* Detalles de la dirección: Sector; calle o, carrera o, vereda o, bloque; numero de casa o, apartamento." maxlength="200"></textarea> 
            </div>
            <div class="fila-h2 mar-arr-2p pd-ssm">
                <div class="column-5-12 subtitulo-formulario-pq texto-izquierdo pd-ssm">
                   * Número Telefónico.
                </div>
                <div class="column-4-12 caja-telefonos">
                    <div class="fila-h5 pd-sm" id="caja_telpers">
                        <input class="wh-completo sombra-negra-caja telefono_persona-form" name="telefono_personaForm" id="telefono_personaForm" type="text" placeholder="0426-7778888" maxlength="12">
                    </div>
                </div>
            </div>
        </div>
        <div class="fila-final">
            <button class="bd-1p-bln btn-primary boton-importante" id="boton-guardar-persona" name="boton-guardar-persona"><i class="far fa-save"></i> Guardar</button>
        </div>
    </div>
                
    </form>
`;

const template_deudores = `
	<!--PLANTILLA DE LA LISTA DE DEUDORES-->
            <div class="fila-h1"></div>
            <div class="fila-h80 pd-ssm">
                <div class="fila-auto fila-vinotinto-blanco texto-centrado texto-cabecera-tabla bordes-redondeados-arriba">
                    <div id="h-rif_empresa" class="column-1m-12 pd-btigual">Rif</div>
                    <div class="column-2-12 pd-btigual">Nombre</div>
                    <div class="column-1m-12 pd-btigual">Contribuyente</div>
                    <div class="column-2-12 pd-btigual">Telefono</div>
                    <div class="column-2-12 pd-btigual">Parroquia</div>
                    <div class="column-3-12 pd-btigual">Dirección</div>
                </div>

                <div class="bd-1p-bln fondo-gris cuerpo-tabla fila-int-rojo-gris fila-hover-blan scrolleable">
                    <!--CONTENEDOR DONDE SE MOSTRARÁ LA LISTA DE LOS DEUDORES-->
                </div>

            </div>
            <div class="fila-h1">
                <a href="#" id="reporte_deudores" class="btn-azul-izq" title="Descargar Reporte de los Deudores en .PDF"><i class="fas fa-file-download"></i> Obtener Reporte</a>
            </div>
            <!--AQUI FINALIZA LA PLANTILLA DE LOS DEUDORES-->
`;

const template_solventes = `
	<!--PLANTILLA DE LA LISTA DE SOLVENTES-->
    <div class="fondo-blanco-transparente borde-verde-oscuro fila-h1">
                <div class="column-5-12 mar-izq texto-izquierdo">
                    <div class="contenedor-chd column-3-12 texto-izquierdo texto-cabecera pd-btigual">
                        <input type="checkbox" id="desde_solvente" class="check-desde btn-desde option-input"/>
                        <label>Desde:</label>
                    </div>
                    <div class="column-3-12">
                        <div class="contenedor-ad columna-90 pd-btigual">
                            <select id="year_desde" class="select-year-desde txt-light-pq texto-centrado pd-inull wh-completo desactivar">
                                <option value="0">Año</option>
                            </select>
                        </div>
                        <div class="columna-10 txt-light-xl">/</div>
                    </div> 
                    <div class="contenedor-md column-6-12 pd-btigual">                     
                        <select id="mes_desde" class="select-mes-desde txt-ppq pd-inull wh-completo desactivar">
                            <option value="0">Trimestre</option>
                        </select>
                    </div>
                </div>
                <div class="column-5-12 mar-izq texto-izquierdo">
                    <div class="contenedor-chh column-3-12 texto-izquierdo texto-cabecera pd-btigual">
                        <input type="checkbox" id="hasta_solvente" class="check-hasta btn-hasta option-input desactivar"/>
                        <label>Hasta:</label>
                    </div>
                    <div class="column-3-12">
                        <div class="contenedor-ah pd-btigual columna-90">
                            <select id="year_hasta" class="select-year-hasta txt-light-pq texto-centrado pd-inull wh-completo desactivar">
                                <option value="0">Año</option>
                            </select>
                        </div>
                        <div class="columna-10 txt-light-xl">/</div>
                    </div> 
                    <div class="contenedor-mh pd-btigual column-6-12">                     
                        <select id="mes_hasta" class="select-mes-hasta txt-ppq pd-inull wh-completo desactivar">
                            <option value="0">Trimestre</option>
                        </select>
                    </div>
                </div>
                <div class="column-1-12 mar-izq">
                    <a href="#" id="boton_solvente_fecha" class="btn-verde" title="Encontrar Listado por Fecha Indicada"><i class="fas fa-search-plus"></i> Ir</a>
                </div>
            </div>
            <div class="fila-h80 pd-ssm">
                <div class="fila-auto fila-verde-blanco texto-centrado texto-cabecera-tabla bordes-redondeados-arriba">
                    <div id="h-rif_empresa" class="column-1-12 pd-btigual">Rif</div>
                    <div class="column-3-12 pd-btigual">Nombre</div>
                    <div class="column-1m-12 pd-btigual">Contribuyente</div>
                    <div class="column-2-12 pd-btigual">Último Pago</div>
                    <div class="column-3-12 pd-btigual">Parroquia</div>
                    <div class="column-1m-12"></div>
                </div>

                <div class="cuerpo-tabla bd-1p-bln fondo-gris fila-int-ver-blan fila-hover-blan scrolleable">
                    <!--CONTENEDOR DONDE SE MOSTRARÁ LA LISTA DE LOS SOLVENTES-->
                </div>

            </div>
            <div class="fila-h1">
                <a href="#" id="reporte_solventes" class="btn-azul-izq" title="Descargar Reporte de los Solventes en .PDF"><i class="fas fa-file-download"></i> Obtener Reporte</a>
            </div>
            <!--AQUI FINALIZA LA PLANTILLA DE LOS SOLVENTES-->
`;

const template_formularioFactura = `
    <div class="fila-h30 fondo-degradado-naranjablanco borde-naranja-oscuro">
        <div id="contenido_principal_pago" class="fila-tercio borde-abajo-2p-gris">
            <div class="column-2-12 texto-centrado txt-bold-men pd-btigual">Contribuyente: </div>
            <div id="nombre_contribuyente" class="column-4-12 texto-izquierdo txt-bold-pq pd-btigual-mitad borde-dercho-2p-gris"></div>
            <div class="column-1-12 texto-centrado txt-bold-men pd-btigual">Rif: </div>
            <div id="rif_contribuyente" class="column-2-12 texto-izquierdo txt-bold-pq pd-btigual-mitad borde-dercho-2p-gris"></div>
            <div id="mensaje_busqueda_factura" class="column-3-12">
            </div>
        </div>

        <div id="contenido_principal_pago" class="fila-tercio borde-abajo-2p-gris borde-dercho-2p-gris">
            <div class="column-3-12 pd-btigual-mitad texto-cabecera-tabla texto-ngr-sombra-bln borde-dercho-2p-gris">LAPSO DE CANCELACIÓN:</div>

            <div id="caja_desdeTributo" class="column-4-12 borde-dercho-2p-gris">
                <div class="column-3-12 pd-btigual-mitad texto-cabecera-tabla">Desde:</div>
                <div id="caja_anyodesde" class="column-3-12 pd-ssm">
                    <select id="yd_tributo" name="yd_tributo" class="wh-completo">
                        <option value="0">Año</option>
                    </select>
                </div>
                <div class="column-6-12 pd-btigual">
                    <select id="trid_tributo" name="trid_tributo" class="wh-completo">
                        <option value="0">Trimestre</option>
                    </select>
                </div>
            </div>
            <div id="caja_hastaTributo" class="column-4-12">
                <div class="column-3-12 pd-btigual-mitad texto-cabecera-tabla">Hasta:</div>
                <div id="caja_anyohasta" class="column-3-12 pd-ssm">
                    <select id="yh_tributo" name="yh_tributo" class="wh-completo">
                        <option value="0">Año</option>
                    </select>
                </div>
                <div class="column-6-12 pd-btigual">
                    <select id="trih_tributo" name="trih_tributo" class="wh-completo">
                        <option value="0">Trimestre</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="contenido_principal_pago" class="fila-tercio">
            <div class="column-3-12"></div>
            <div id="caja_tipopago" class="column-3-12 borde-dercho-2p-gris pd-ssm">
                <select name="tipo_pago" id="tipo_pago" class="s-tipo_pago-factura wh-completo pd-null texto-centrado">
                    <option value="0">Tipo Pago</option>
                </select>
            </div>
            <div id="caja_referencia" class="column-3-12 pd-ssm">
                <input type="text" id="referencia" name="referencia" class="wh-completo pd-null desactivar" placeholder="Nro. Referencia"/>
            </div>
        </div>
    </div>

    <div class="fila-h2">
        <div class="column-11-12 borde-naranja-oscuro fondo-degradado-naranjablanco borde-caja-moderado sombra-negra-caja">
            <div class="fila-h5 borde-abajo-2p-gris">
                <div id="caja_tributo" class="column-5-12 pd-ssm borde-dercho-2p-gris">
                    <select id="tributo" name="tributo" class="wh-completo texto-centrado">
                        <option value="0">TRIBUTO</option>
                    </select>
                </div>
                <div id="caja_observacion" class="column-7-12 pd-ssm">
                    <textarea id="observacion_tributo" name="observacion_tributo" class="wh-completo" cols="30" rows="10" placeholder="Observación Tributo"></textarea>
                </div>
            </div>
            <div class="fila-h5">
                <div class="column-4-12 borde-dercho-2p-gris">
                    <div class="column-5-12 pd-btigual">
                        <div class="fila-auto pd-izqtop-pq txt-bold-men">Monto BsS.</div>
                    </div>
                    <div id="caja_monto" class="column-7-12 pd-ssm">
                        <input type="text" id="monto_tributo" class="wh-completo texto-centrado borde-abajo-texto" placeholder="Monto en BsS.">
                    </div>
                </div>
                <div id="caja_check_imp" class="column-4-12 borde-dercho-2p-gris">
                    <div class="column-7-12 pd-btigual">
                        <div class="fila-auto pd-izqtop-pq txt-bold-men">Impuesto Mora:</div>
                    </div>
                    <div class="column-2-12 pd-btigual">
                        <input type="checkbox" id="check-impuesto_mora" class="option-input-30">
                    </div>
                    <div class="column-3-12 pd-btigual">
                        <input type="text" id="impuesto_mora" class="wh-completo pd-btigual desactivar borde-abajo-texto">
                    </div>
                </div>
                <div class="column-4-12">
                    <div class="column-5-12 pd-btigual">
                        <div class="fila-auto pd-izqtop-men txt-bold-men">Total BsS.</div>
                    </div>
                    <div id="caja_total" class="column-7-12 pd-ssm">
                        <input type="text" id="total_tributo" class="wh-completo desactivar borde-abajo-texto">
                    </div>
                </div>
            </div>
        </div>
        <div class="column-1-12">
            <button id="otro_tributo" class="btn-verde-ico mar-centrado pd-all-small" title="Agregar el Tributo a la Lista de los Futuros Registrados"><i class="far fa-plus-square"></i></button>
        </div>
    </div>

    <div class="fila-h4 pd-ssm">
        <div id="listado_tributos" class="wh-completo scrolleable fondo-amarillo-formulario borde-naranja-oscuro pd-ssm">
            <!--   LUEGAR EN DONDE VAN LOS TRIBUTOS A PAGAR POR EL CONTRIBUYENTE  -->            
        </div>
    </div>

    <div class="fila-h1">
        <div class="column-5-12 fondo-degradado-naranjablanco borde-naranja-oscuro">
            <div class="column-7-12 texto-derecho txt-bold-men pd-btigual">Total a Cancelar BsS. </div>
            <div id="caja_supertotal" class="column-5-12 pd-ssm">
                <input id="super_total" class="wh-completo texto-izquierdo txt-bold-men pd-btigual borde-abajo-texto" type="text" disabled>
            </div>
        </div>
        <div class="column-2-12"></div>
        <div class="column-5-12">
            <button class="btn-azul-izq" id="guardar_recibo"><i class="far fa-save"></i> Finalizar</button>
        </div>
    </div>
`;

const template_facturaciones = `
    <div class="fila-h1">
        <div class="column-1m-12 txt-mediano-der">
            Desde el: 
        </div>
        <div class="column-2-12 pd-ssm">
            <input type="date" id="f_desde" class="wh-completo"> 
        </div>
                    
        <div class="column-1m-12 txt-mediano-der">
            Hasta el: 
        </div>
        <div class="column-2-12 pd-ssm">
            <input type="date" id="f_hasta" class="wh-completo">
        </div>
                    
        <div class="column-2-12">
            <a href="#" id="b_rFechasFacturas" class="btn-verde"><i class="fas fa-search-plus"></i> Ir</a>
        </div>
    </div>
    <div class="fila-h80 pd-ssm">
        <div class="fila-auto texto-centrado texto-cabecera-tabla fila-gris-blanco">
            <div class="column-1m-12 pd-btigual">Codigo</div>
            <div class="column-1m-12 pd-btigual">Fecha</div>
            <div class="column-2-12 pd-btigual">Contribuyente Rif</div>
            <div class="column-1m-12 pd-btigual">Tipo de Pago</div>
            <div class="column-2-12 pd-btigual">Referencia</div>
            <div class="column-2-12 pd-btigual">Monto Total</div>
            <div class="column-1m-12"></div>
        </div>
        <div class="cuerpo-tabla fila-int-gris-blan bd-1p-bln fondo-gris scrolleable fila-hover-gris">
            <!--  LISTADO DE FACTURACIONES REALIZADAS  -->
        </div>
    </div>

    <div class="fila-h1">
        <a href="#" id="reporte_facturas" class="btn-azul-izq" title="Descargar Reporte de las Facturas en .PDF"><i class="fas fa-file-download"></i> Obtener Reporte de Facturas</a>
    </div>
`;


const template_actividad_comercial = `
    <div id="titulo_seccion" class="fila-h1 column-7-12 letra-azul sombra-letra-blanca pd-ssm mar-der titulo-formulario">Actividades Cormeciales.</div>
            
            <div class="fila-h90 column-7-12 mar-der pd-ssm">
                <div class="wh-completo sombra-negra-caja-completa">
                    <div class="fila-auto texto-centrado texto-cabecera-tabla texto-cabecera-tabla fila-gris-blanco">
                        <div class="column-3-12 pd-btigual">Código</div>
                        <div class="column-6-12 pd-btigual">Descripción</div>
                        <div class="column-3-12 pd-btigual"></div>
                    </div>
                    <div class="cuerpo-tabla fondo-gris fila-int-gris-blan bd-2p-bln scrolleable fila-hover-gris">
                        <!--  PARTE EN DONDE SE COLOCARAN LAS ACTIVIDADES COMERCIALES.  -->
                    </div>
                </div>    
            </div>

            <div class="fila-h90 pd-ssm column-4-12">
                <div class="wh-completo fondo-gris sombra-negra-caja-completa">
                    <div class="mar-arr mar-aba fila-h1 letra-azul pd-completo-pq subtitulo-formulario-pqm">Código</div>
                
                    <div id="contenedor_cod-act-com" class="mar-aba fila-h1 pd-izqsolo">
                        <input type="text" id="cod_acti_com" class="column-4-12 sombra-negra-caja-completa" placeholder="Código" maxlength="10" minlength="5">
                    </div>
                    
                    <div class="mar-aba fila-h1 letra-azul pd-completo-pq subtitulo-formulario-pqm">Decripción</div>
                    
                    <div id="contenedor_desc-act-com" class="mar-aba fila-h5 pd-ssm">
                        <textarea id="desc_act_com" class="wh-completo sombra-negra-caja-completa" cols="30" rows="10" placeholder="Coloque Exactamente el Nombre de la ACTIVIDAD COMERCIAL.">
                        </textarea>
                    </div>

                    <div class="fila-h1 pd-ssm">
                        <a href="#" class="btn-azul-drch" id="btn-guardar-actcom">Guardar</a>
                    </div>
                </div>
            </div>

`;