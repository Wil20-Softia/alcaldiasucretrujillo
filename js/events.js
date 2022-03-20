$(document).ready(function(){

  console.log("Archivo: events.js funciona correctamente");

  // Escuchamos el evento 'change' del input donde cargamos el archivo
  // Al la etiqueta label le colocamos el nombre del archivo a subir.
  $(document).on("change","#file_restaurar",function(){
    $('#inputval').text(this.files[0].name);
  });

  //Evento que al hacer click suber el archivo al servidor.
  $(document).on("click","#btn-subir-restauracion",function(e){
    e.preventDefault();
    var formulario = document.getElementById("formulario_restaurar");
    var formData = new FormData(formulario);
    $.ajax({
      url: "config/restablecer.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function(){
        $("#formulario_restaurar").trigger("reset");
        $("#btn-cerrar").trigger('click');
        $(".cargando").css('display', 'block');
      }
    }).done(function(response){
      let respuesta = JSON.parse(response);
        alertar(respuesta.advertencia, respuesta.mensaje);
        setTimeout(function(){
            ocultarAlerta(0.001);
            location.reload();
        },5999);
    }).always(function(){
      $(".cargando").css('display', 'none');
    });
  });

  $(document).on("keyup","#busqueda",function(event) {
        let tecla = (event.keyCode ? event.keyCode : event.which);
        let campoBuscar;
        if(tecla === 13 || tecla == "Enter"){
            $("#busqueda").focus();
            campoBuscar = $("#busqueda").val();
            switch(searching){
                case 1:
                  busqueda(campoBuscar, listadoEmpresas);
                break;
                case 2:
                  busqueda(campoBuscar, listadoDeudores);
                break;
                case 3:
                  busqueda(campoBuscar, listadoSolventes);
                case 4:
                  busqueda(campoBuscar, obtenerContribuyente);
                break;
                case 5:
                    busqueda(campoBuscar, listadoFacturas);
                break;
                case 6:
                    busqueda(campoBuscar, listadoActividadesComerciales);
                break;
            }
        }
  });

  //CLICK A CADA BOTON DE LA BARRA DE NAVEGACION.
  $(document).on("click","#ul1 > li > a",function(){
    let tamLinks = $("#ul1 > li > a").length;
    for(var i = 0; i < tamLinks; i++){
      let elemento = $("#ul1 > li > a")[i];
      $(elemento).css({
        background: '',
        color: '',
        textShadow: ''
      });
    }
    $($(this)[0]).css({
      background: '#FFF',
      color: '#151514',
      textShadow: '4px 4px 5px #835905'
    });
  });

  //ENVENTO QUE CONTIENE CADA BOTON DE LA PAGINACION NUMERICA.
  $(document).on("click",".num_pag",function(){
    let pag_select = parseInt($($(this)[0]).attr("title"));
    paginacion_empresa(pag_select);
  });

   //EVENTO QUE OBTIENE LA PLANILLA DE LOS REGISTROS DE LA EMPRESA.
   $(document).on("click","#reporte-empresas",function(){
    var elemento = parseInt($("#parroquias").val());
    window.open("modulos/pdf/lista_empresas.php?parroquia="+elemento,"reporte_empresas.pdf","width=1100px, height=700px");
   });

  //EVENTO QUE OBTIENE LA PLANILLA DE LA EMPRESA EN LA QUE SE CLICKEO.
  $(document).on("click",".btn-ver-planilla",function(){
    let rif = $($(this)[0]).parent().parent().children('.rif_empresa').text();
    window.open("modulos/pdf/planilla_empresa.php?rif="+rif,"planilla_empresa.pdf","width=1100px, height=700px");
  });

  //EVENTO LLEVA AL FORMULARIO CON LOS DATOS DE LA EMPRESA PARA SER MODIFICADO.
  $(document).on("click",".btn-modificar-empresa",function(){
    let rif = $($(this)[0]).parent().parent().children('.rif_empresa').text();
    console.log(rif);   
    $.ajax({
      url: 'modulos/tipo_contribuyente.php',
      type: 'GET',
      data: {rif}
    })
    .done(function(response){
      console.log(response);
      if(response == "emp"){
        modificar = 1;
        obtenerEmpresa(rif,formNuevaEmpresa);
      }else if(response == "per"){
        modificar_per = 1;
        obtenerPersona(rif,formNuevaPersona);
      }
    })
    .fail(function() {
      console.log("error");
    }); 
  });

  //EVENTO LLEVA AL FORMULARIO CON LOS DATOS DE LA EMPRESA PARA SER MODIFICADO.
  $(document).on("click",".btn-eliminar-empresa",function(){
    if(confirm('¿Esta Seguro de querer Eliminar la Empresa? ¡Si elimina a la empresa se eliminarán con ella todos los registros que la contengan, como las facturaciones y otros!')){
      let id = parseInt($($(this)[0]).parent().parent().children(".rif_empresa").attr("contribuyente"));
      $.ajax({
        url: 'modulos/eliminar_empresa.php',
        type: 'POST',
        data: {id}
      })
      .done(function(response){
        console.log(response);
        let r = JSON.parse(response);
        alertar(r.advertencia, r.mensaje);
        ocultarAlerta(3);
        paginacion_empresa();
      })
      .fail(function() {
        console.log("error");
      });
    }
  });

  //CUANDO SE DESENFOCA ALGUN CAMPO DE TEXTO QUE CONTENGA LA CLASE FIELD
  $(".field").on("focusout",function(){
    $(".advertencia-formulario").css("display","none");
    $(".field").css('border', '');
  });

  //FUNCIONALIDAD DEL BOTON DE BUSQUEDA DE EMPRESA EN PANTALLA PRINCIPAL
  $(document).on("click",".btn-busqueda-empresas", function(){
    let campoBuscar = $("#busqueda").val();
    busqueda(campoBuscar, listadoEmpresas);
  });

  $(document).on("change",".parroquias",function(){

    var elemento = parseInt($(".parroquias").val());
   
    $("#seccion-bi").html("");
    if(elemento === 0){
      listado_empresaPaginacion();
    }else{
      $.ajax({
        url: "modulos/lista-empresa-parroquias.php",
        type: "POST",
        data: {parr: elemento},
        success: function(response){
          let empresas = JSON.parse(response);

          let template = "";
          if(empresas !== 0){
            empresas.forEach(empresa => {
              template += `
                <div class="fila-h2">
                  <article contribuyente="${empresa.contribuyente}" class="rif_empresa column-2-12 txt-oscuro texto-centrado pd-btigual-mitad">${empresa.rif}</article>
                  <article class="column-2-12 txt-oscuro pd-btigual-mitad scrolleable">${empresa.nombre}</article>
                  <article class="column-2-12 txt-oscuro texto-centrado pd-btigual-mitad">${empresa.telefono}</article>
                  <article class="column-3-12 txt-oscuro pd-btigual-mitad scrolleable">${empresa.direccion}</article>
                  <div class="column-1-12 pd-btigual texto-centrado txt-bold-xl">
                      <a href="#" class="btn-ver-planilla" title="Ver Planilla"><i class="fas fa-file-alt"></i></a>
                    </div>
                    <div class="column-1-12 pd-btigual texto-centrado txt-bold-xl texto-verde">
                      <a href="#" class="btn-modificar-empresa" title="Modificar Datos"><i class="fas fa-edit"></i></a>
                    </div>
                    <div class="column-1-12 pd-btigual texto-centrado txt-bold-xl texto-rojo">
                      <a href="#" class="btn-eliminar-empresa" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
              `
            });
          }else{
            template += `<div class="avisar_nada">¡No se ha encontrado ningún resultado, intente buscar de nuevo!</div>`
          }
         $(".listado-impresion").html(template);
        }
      });
    }
  });

  $(document).on("change","#estado_propietario-form",function(){
      let id_est = parseInt($($(this)).val());

      if(id_est !== 0){
          $("#municipio_propietario-form").removeClass('desactivar');
          municipios_dependientes(id_est,"#municipio_propietario-form");
          $("#deta_dir_persona-form").val("");
          $("#deta_dir_persona-form").addClass('desactivar');
          $("#parroquia-propietario-form").empty();
          $("#parroquia-propietario-form").html("<option value=0 selected>Parroquia</option>");
          $("#parroquia-propietario-form").addClass('desactivar');
      }else{
          $("#deta_dir_persona-form").val("");
          $("#deta_dir_persona-form").addClass('desactivar');
          $("#parroquia-propietario-form").empty();
          $("#parroquia-propietario-form").html("<option value=0 selected>Parroquia</option>");
          $("#parroquia-propietario-form").addClass('desactivar');
          $("#municipio_propietario-form").empty();
          $("#municipio_propietario-form").html("<option value=0 selected>Municipio</option>");
          $("#municipio_propietario-form").addClass('desactivar');
      }
  });

  $(document).on("change","#municipio_propietario-form",function(){
      let id_mun = parseInt($($(this)).val());

      if(id_mun !== 0){
          $("#parroquia-propietario-form").removeClass('desactivar');
          parroquias_dependientes(id_mun,"#parroquia-propietario-form");
          $("#deta_dir_persona-form").val("");
          $("#deta_dir_persona-form").addClass('desactivar');
      }else{
          $("#deta_dir_persona-form").val("");
          $("#deta_dir_persona-form").addClass('desactivar');
          $("#parroquia-propietario-form").empty();
          $("#parroquia-propietario-form").html("<option value=0 selected>Parroquia</option>");
          $("#parroquia-propietario-form").addClass('desactivar');
      }
  });

  $(document).on("change","#parroquia-propietario-form",function(){
      let id_parr = parseInt($($(this)).val());

      if(id_parr !== 0){
          $("#deta_dir_persona-form").removeClass('desactivar');
          $("#deta_dir_persona-form").val("");
      }else{
          $("#deta_dir_persona-form").val("");
          $("#deta_dir_persona-form").addClass('desactivar');
      }
  });

  $(document).on("change","#parroquia-empresa-form",function(){
      let id_parr = parseInt($($(this)).val());

      if(id_parr !== 0){
          $("#deta_dir_empresa-form").removeClass('desactivar');
      }else{
          $("#deta_dir_empresa-form").val("");
          $("#deta_dir_empresa-form").addClass('desactivar');
      }
  });

  $(document).on("change","#parroquia-persona-form",function(){
      let id_parr = parseInt($($(this)).val());

      if(id_parr !== 0){
          $("#deta_dir_persona-form").removeClass('desactivar');
      }else{
          $("#deta_dir_persona-form").val("");
          $("#deta_dir_persona-form").addClass('desactivar');
      }
  });

  $(document).on("click","#boton-guardar-empresa",function(e){
    e.preventDefault();
    if(!LongitudCampo("#nombre_empresa-form",6,25) || !CampoVacio("#nombre_empresa-form")){
        advertenciaEnfocada("#caja_nomemp","#nombre_empresa-form","Introduzca el Nombre de la Empresa. Maximo 25 caracteres, Minimo 6. ¡ES OBLIGATORIO!",1);
    }else if(!CampoPatron("#rif_empresa-form",patron_rif) || !CampoVacio("#rif_empresa-form")){

        advertenciaEnfocada("#caja_rifemp","#rif_empresa-form","No debe dejarlo vacio. Formato: [V | E | P | G | J | C]-123456789. ¡ES OBLIGATORIO!",1);

    }else if(!LongitudCampo("#cod_comercio-form",8,20) || !CampoVacio("#cod_comercio-form")){

        advertenciaEnfocada("#caja_codcomemp","#cod_comercio-form","Ingrese el Codigo del Registro o Comercio de la Empresa. ¡ES OBLIGATORIO!",1);

    }else if(!CampoPatron("#telefono_empresa-form",patron_telefono) || !CampoVacio("#telefono_empresa-form")){

        advertenciaEnfocada("#caja_telemp","#telefono_empresa-form","Formato Incorrecto, Ingrese Valores. Ej: 0271-6638765. ¡ES OBLIGATORIO!",1);

    }else if(!CampoFechaActual("#registro_empresa-form") || !CampoVacio("#registro_empresa-form")){

        advertenciaEnfocada("#caja_fecregemp","#registro_empresa-form","La fecha no debe exceder a la actual, Ingrese una fecha valida!. ¡ES OBLIGATORIO!",1);
                    
    }else if(!CampoVacio("#parroquia-empresa-form")){
                    
        advertenciaEnfocada("#caja_paremp","#parroquia-empresa-form","Debe elegir la parroquia, para proseguir. ¡ES OBLIGATORIO!",1);
                    
    }else if(!LongitudCampo("#deta_dir_empresa-form",25,200) || !CampoVacio("#deta_dir_empresa-form")){
                    
        advertenciaEnfocada("#caja_detdiremp","#deta_dir_empresa-form","Coloque detalladamente, El Sector - Calle - Numero o Nombre de Casa, Referencia. ¡ES OBLIGATORIO!",1);
                    
    }else if(!CampoVacio("#actividad_comercial-form")){
                    
        advertenciaEnfocada("#caja_actcomemp","#actividad_comercial-form","Elija la Actividad Comercial pertinente de la Empresa. ¡ES OBLIGATORIO!",1);
                    
    }else if(!LongitudCampo("#nombre_propietario-form",3,30) || !CampoVacio("#nombre_propietario-form")){
                    
        advertenciaEnfocada("#caja_nomprop","#nombre_propietario-form","Ingrese el o los nombres del Propietario. ¡ES OBLIGATORIO!",1);
                    
    }else if(!LongitudCampo("#apellido_propietario-form",4,30) || !CampoVacio("#apellido_propietario-form")){

        advertenciaEnfocada("#caja_apeprop","#apellido_propietario-form","Ingrese el o los apellidos del Propietario. ¡ES OBLIGATORIO!",1);
                    
    }else if(!CampoPatron("#cedula_propietario-form",patron_cedula) || !CampoVacio("#cedula_propietario-form")){

        advertenciaEnfocada("#caja_cedprop","#cedula_propietario-form","No debe dejarlo vacio. Formato: [V | E]-12345678. ¡ES OBLIGATORIO!",1);

    }else if(!CampoPatron("#rif_propietario-form",patron_rif) || !CampoVacio("#rif_propietario-form")){

        advertenciaEnfocada("#caja_rifprop","#rif_propietario-form","No debe dejarlo vacio. Formato: [V | E | P | G | J | C]-123456789. ¡ES OBLIGATORIO!",1);

    }else if(!CampoVacio("#estado_propietario-form")){

        advertenciaEnfocada("#caja_estprop","#estado_propietario-form","Debe elegir el estado, para proseguir. ¡ES OBLIGATORIO!",1);

    }else if(!CampoVacio("#municipio_propietario-form")){

        advertenciaEnfocada("#caja_munprop","#municipio_propietario-form","Debe elegir el municipio, para proseguir. ¡ES OBLIGATORIO!",1);

    }else if(!CampoVacio("#parroquia-propietario-form")){

        advertenciaEnfocada("#caja_parprop","#parroquia-propietario-form","Debe elegir la parroquia, para proseguir. ¡ES OBLIGATORIO!",1);

    }else if(!LongitudCampo("#deta_dir_persona-form",25,200) || !CampoVacio("#deta_dir_persona-form")){
                    
        advertenciaEnfocada("#caja_detdirper","#deta_dir_persona-form","Coloque detalladamente, El Sector - Calle - Numero o Nombre de Casa, Referencia. ¡ES OBLIGATORIO!",1);
                   
    }else if(!CampoPatron("#telefono_propietarioForm",patron_telefono) || !CampoVacio("#telefono_propietarioForm")){
                    
        advertenciaEnfocada("#caja_telefono","#telefono_propietarioForm","Formato Incorrecto, Ingrese Valores. Ej: 0414-7638765. ¡ES OBLIGATORIO!",1);
                    
    }else if(!validarRadio(".contribuyente_rep")){
      advertenciaEnfocada("#caja-pregcontrib",".contribuyente_rep","Elija si es Contibuyente del Municipio o No lo es. ¡ES OBLIGATORIO!",1);
    }else{
        var contribuyente_resp = obtener_valor_radio(".contribuyente_rep");
        var url;
        datos = {
            nombre_empresa  :    $("#nombre_empresa-form").val(),
            rif_empresa     :    $("#rif_empresa-form").val(),
            cod_com_emp     :    $("#cod_comercio-form").val(),
            telefono_emp    :    $("#telefono_empresa-form").val(),
            fech_reg_emp    :    $("#registro_empresa-form").val(),
            parroquia_emp   :    $("#parroquia-empresa-form").val(),
            deta_dir_emp    :    $("#deta_dir_empresa-form").val(),
            act_com_emp     :    $("#actividad_comercial-form").val(),
            nombre_prop     :    $("#nombre_propietario-form").val(),
            apellido_prop   :    $("#apellido_propietario-form").val(),
            cedula_prop     :    $("#cedula_propietario-form").val(),
            rif_prop        :    $("#rif_propietario-form").val(),
            parroquia_prop  :    $("#parroquia-propietario-form").val(),
            deta_dir_prop   :    $("#deta_dir_persona-form").val(),
            telefono_prop   :    $("#telefono_propietarioForm").val(),
            contribuyente_resp
        };
        if(modificar === 1){
          url = "modulos/modificacion_empresa.php";
        }else{
          url = "modulos/registro_empresa.php";
        }
        $.ajax({
            url: url,
            type: "POST",
            data: datos,
            success: function(response){
              console.log(response);
                let respuesta = JSON.parse(response);
                alertar(respuesta.advertencia, respuesta.mensaje);
                setTimeout(function(){
                  if(modificar === 1){
                    modificar = 0;
                    searching = 1;
                    inicio();
                  }else{
                    formNuevaEmpresa();
                  }
                  ocultarAlerta(0.001);
                },4999);
            }
        });
    }
  });// AQUI TERMINA EL EVENTO DEL BOTON DE GUARDADO DE FORMULARIO DE EMPRESA.


  $(document).on("click","#boton-guardar-persona",function(e){
    e.preventDefault();
    if(!LongitudCampo("#nombre_persona-form",3,30) || !CampoVacio("#nombre_persona-form")){
                    
        advertenciaEnfocada("#caja_nompers","#nombre_persona-form","Ingrese el o los nombres de la Persona. ¡ES OBLIGATORIO!",1);
                    
    }else if(!LongitudCampo("#apellido_persona-form",4,30) || !CampoVacio("#apellido_persona-form")){

        advertenciaEnfocada("#caja_apepers","#apellido_persona-form","Ingrese el o los apellidos de la Persona. ¡ES OBLIGATORIO!",1);
                    
    }else if(!CampoPatron("#cedula_persona-form",patron_cedula) || !CampoVacio("#cedula_persona-form")){

        advertenciaEnfocada("#caja_cedpers","#cedula_persona-form","No debe dejarlo vacio. Formato: [V | E]-12345678. ¡ES OBLIGATORIO!",1);

    }else if(!CampoPatron("#rif_persona-form",patron_rif) || !CampoVacio("#rif_persona-form")){

        advertenciaEnfocada("#caja_rifpers","#rif_persona-form","No debe dejarlo vacio. Formato: [V | E | P | G | J | C]-123456789. ¡ES OBLIGATORIO!",1);

    }else if(!CampoVacio("#parroquia-persona-form")){

        advertenciaEnfocada("#caja_parpers","#parroquia-persona-form","Debe elegir la parroquia, para proseguir. ¡ES OBLIGATORIO!",1);

    }else if(!LongitudCampo("#deta_dir_persona-form",25,200) || !CampoVacio("#deta_dir_persona-form")){
                    
        advertenciaEnfocada("#caja_detdirpers","#deta_dir_persona-form","Coloque detalladamente, El Sector - Calle - Numero o Nombre de Casa, Referencia. ¡ES OBLIGATORIO!",1);
                   
    }else if(!CampoPatron("#telefono_personaForm",patron_telefono) || !CampoVacio("#telefono_personaForm")){
                    
        advertenciaEnfocada("#caja_telpers","#telefono_personaForm","Formato Incorrecto, Ingrese Valores. Ej: 0414-7638765. ¡ES OBLIGATORIO!",1);
                    
    }else{
        var url;
        datos = {
            nombre_prop     :    $("#nombre_persona-form").val(),
            apellido_prop   :    $("#apellido_persona-form").val(),
            cedula_prop     :    $("#cedula_persona-form").val(),
            rif_prop        :    $("#rif_persona-form").val(),
            parroquia_prop  :    $("#parroquia-persona-form").val(),
            deta_dir_prop   :    $("#deta_dir_persona-form").val(),
            telefono_prop   :    $("#telefono_personaForm").val()
        };
        if(modificar_per === 1){
          url = "modulos/modificacion_persona.php";
        }else{
          url = "modulos/registro_persona.php";
        }
        $.ajax({
            url: url,
            type: "POST",
            data: datos,
            success: function(response){
                let respuesta = JSON.parse(response);
                alertar(respuesta.advertencia, respuesta.mensaje);
                setTimeout(function(){
                  if(modificar_per === 1){
                    modificar_per = 0;
                    searching = 1;
                    inicio();
                  }else{
                    formNuevaPersona();
                  }
                  ocultarAlerta(0.001);
                },4999);
            }
        });
    }
  });//AQUI TERMINA EL BOTON DE GUARDAR PERSONA.
  

/**************   SECCION DE LOS EVENTOS DE CANCELACION   ********************/
  $(document).on("click","#otro_tributo",function(e){
    e.preventDefault();
    if(cantidad_tributos >= 12){

      /******* MENSAJE DE ADVERTENCIA ****************/
      $("<div>",{
        'class' : "wh-completo mar-izq bd-1p-bln msj-oculto",
        'id' : "mensaje_busqueda",
        'text' : "SOLO SON 12 TRIBUTOS POR FACTURA, PARA MAS ORDEN."
      }).appendTo('#mensaje_busqueda_factura');
      setTimeout(function(){
        $("#mensaje_busqueda").remove();
      },5500);

    }else if($("#rif_contribuyente").text() == "" || $("#nombre_contribuyente").text() == ""){

      advertenciaEnfocada("#contenido_principal_pago","#busqueda","DEBE BUSCAR A UN CONTRIBUYENTE PARA SEGUIR",1);
      setTimeout(function(){
        quitar_advertencia("#contenido_principal_pago");
      }, 3999);

    }else if(!CampoVacio("#yd_tributo") || !CampoVacio("#trid_tributo")){

      advertenciaEnfocada("#caja_desdeTributo","#yd_tributo","Seleccione el Año y el Trimestre para seguir.",1);
      setTimeout(function(){
        quitar_advertencia("#caja_desdeTributo");
      }, 3999);
    }else if(!CampoVacio("#yh_tributo") || !CampoVacio("#trih_tributo")){

      advertenciaEnfocada("#caja_hastaTributo","#yh_tributo","Seleccione el Año y el Trimestre para seguir.",1);
      setTimeout(function(){
        quitar_advertencia("#caja_hastaTributo");
      }, 3999);
    }else if(!CampoVacio("#tipo_pago")){

      advertenciaEnfocada("#caja_tipopago","#tipo_pago","Seleccione el Tipo de Pago para seguir.",1);
      setTimeout(function(){
        quitar_advertencia("#caja_tipopago");
      }, 3999);
    }else if(parseInt($("#tipo_pago").val()) > 1 && !CampoVacio("#referencia")){

      advertenciaEnfocada("#caja_referencia","#referencia","Seleccione el Tipo de Pago para seguir.",1);
      setTimeout(function(){
        quitar_advertencia("#caja_referencia");
      }, 3999);
    }else if(!CampoVacio("#tributo")){

      advertenciaEnfocada("#caja_tributo","#tributo","Seleccione el Tributo para seguir.",1);
      setTimeout(function(){
        quitar_advertencia("#caja_tributo");
      }, 3999);
    }else if(!LongitudCampo("#observacion_tributo",15,200) || !CampoVacio("#observacion_tributo")){

      advertenciaEnfocada("#caja_observacion","#observacion_tributo","Minimo 15 caracteres y maximo 200. Obligatorio",1);
      setTimeout(function(){
        quitar_advertencia("#caja_observacion");
      }, 3999);
    }else if(!CampoVacio("#monto_tributo") || !CampoPatron("#monto_tributo",patron_decimales)){

      advertenciaEnfocada("#caja_monto","#monto_tributo","Digite el Monto para seguir",1);
      setTimeout(function(){
        quitar_advertencia("#caja_monto");
      }, 3999);
    }else if($("#check-impuesto_mora").prop("checked") && (!CampoVacio("#impuesto_mora") || !CampoPatron("#impuesto_mora",patron_decimales))){

      advertenciaEnfocada("#caja_check_imp","#impuesto_mora","Debe ingresar una Cantidad para el Porcentaje, Sino desmarque para no colocar Impuesto.",1);
      setTimeout(function(){
        quitar_advertencia("#caja_check_imp");
      }, 3999);
    }else if(!CampoVacio("#total_tributo")){

      advertenciaEnfocada("#caja_total","#total_tributo","Este campo debe de tener valores, es Obligatorio.",1);
      setTimeout(function(){
        quitar_advertencia("#caja_total");
      }, 3999);
    }else{
        /***********   PARTE EN DONDE SE ENVIA EL TRIBUTO AL LISTADO DE LISTOS ******/
        cantidad_tributos++;
        superTotal = superTotal + parseFloat($("#total_tributo").val());

        $("#yd_tributo").addClass("desactivar");
        $("#trid_tributo").addClass("desactivar");
        $("#yh_tributo").addClass("desactivar");
        $("#trih_tributo").addClass("desactivar");
        $("#tipo_pago").addClass("desactivar");
        $("#referencia").addClass("desactivar");
  
        let nodo_actual = `
          <div class="fila-h5 mar-aba">
                <div class="contenedor-datos column-11-12 borde-verde-oscuro fondo-degradado-verdeblanco borde-caja-moderado sombra-negra-caja">
                    <div class="fila-h5 borde-abajo-2p-gris">
                        <div class="column-5-12 pd-ssm borde-dercho-2p-gris">
                            <select class="tributo wh-completo texto-centrado desactivar">
                            </select>
                        </div>
                        <div class="column-7-12 pd-ssm">
                            <textarea class="wh-completo pd-null observacion_tributo desactivar" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="fila-h5 contenedor-datos-abajo">
                        <div class="column-4-12 borde-dercho-2p-gris">
                            <div class="column-5-12 pd-btigual">
                                <div class="fila-auto pd-izqtop-pq txt-bold-men">Monto BsS.</div>
                            </div>
                            <div class="column-7-12 pd-ssm">
                                <input type="text" class="monto_tributo wh-completo texto-centrado desactivar">
                            </div>
                        </div>
                        <div class="column-4-12 borde-dercho-2p-gris">
                            <div class="column-7-12 pd-btigual">
                                <div class="fila-auto pd-izqtop-pq txt-bold-men">Impuesto Mora:</div>
                            </div>
                            <div class="column-5-12 pd-btigual">
                                <input type="text" class="impuesto_mora wh-completo pd-btigual desactivar">
                            </div>
                        </div>
                        <div class="seccion-total-tributo column-4-12">
                            <div class="column-5-12 pd-btigual">
                                <div class="fila-auto pd-izqsolo txt-bold-men">Total BsS.</div>
                            </div>
                            <div class="caja-total_tributo column-7-12 pd-ssm">
                                <input type="text" class="total_tributo wh-completo desactivar">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column-1-12">
                    <button class="deshacer_tributo btn-rojo-ico mar-centrado pd-all-small" title="Eliminar Tributo antes de ser Registrado"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
        `;

        $("#listado_tributos").append(nodo_actual);

        let indice = parseInt($(".tributo").length) - 1;

        colocarOption($($(".tributo")[indice]), $("#tributo").val(), obtenerTextoSelect("tributo", $("#tributo").val()));

        $($(".observacion_tributo")[indice]).val($("#observacion_tributo").val());

        $($(".monto_tributo")[indice]).val($("#monto_tributo").val());

        $($(".impuesto_mora")[indice]).val($("#impuesto_mora").val());

        $($(".total_tributo")[indice]).val($("#total_tributo").val());

        $("#super_total").val(superTotal);

        setValueSelect("tributo", '0');
        $("#observacion_tributo").val("");
        $("#monto_tributo").val("");
        $("#check-impuesto_mora").prop("checked",false);
        $("#check-impuesto_mora").addClass("desactivar");
        $("#impuesto_mora").val("");
        $("#impuesto_mora").addClass("desactivar");
        $("#total_tributo").val("");
    }
  });//AQUI TERMINA EL EVENTO DEL BOTON AGREGAR OTRO TRIBUTO

  $(document).on("click",".deshacer_tributo", function(e){
      e.preventDefault();
      $($(this)[0]).parent().parent().remove();
      cantidad_tributos--;
      let total_actual = parseFloat($($(this)[0]).parent().parent().children('.contenedor-datos').children('.contenedor-datos-abajo').children('.seccion-total-tributo').children('.caja-total_tributo').children('.total_tributo').val());
      superTotal -= total_actual;
      $("#super_total").val(superTotal);
      if(cantidad_tributos == 0){
        $("#yd_tributo").removeClass("desactivar");
        $("#trid_tributo").removeClass("desactivar");
        $("#yh_tributo").removeClass("desactivar");
        $("#trih_tributo").removeClass("desactivar");
        $("#tipo_pago").removeClass("desactivar");
        if($("#tipo_pago").val() != 1){
          $("#referencia").removeClass("desactivar");
        }
      }
  });//AQUI TERMINA EL EVENTO DE DESHACER EL TRIBUTO SELECCIONADO

  $(document).on("click","#guardar_recibo",function(e){
    e.preventDefault();
    if(cantidad_tributos > 0){
      $("#guardar_recibo").addClass("desactivar");
      /******* ZONA EN DONDE SE REALIZA LA PETICION AJAX PARA GUARDAR ***/
      let supremo = [];
      let tributosPagos = [];
      let datosTributos = {};
      let datos = {
        "nombre" : $("#nombre_contribuyente").text(),
        "rif" : $("#rif_contribuyente").text(),
        "total_completo" : $("#super_total").val(),
        "trimestre_desde" : $("#trid_tributo").val(),
        "trimestre_hasta" : $("#trih_tributo").val(),
        "year_desde" : $("#yd_tributo").val(),
        "year_hasta" : $("#yh_tributo").val(),
        "tipo_pago" : $("#tipo_pago").val(),
        "referencia" : $("#referencia").val()
      };
      supremo.push(datos);
      let cant_tri = $(".tributo").length;
      for(var k = 0; k < cant_tri; k++){
        datosTributos = {
            "tributo": $($(".tributo")[k]).val(),
            "observacion" : $($(".observacion_tributo")[k]).val(),
            "monto" : $($(".monto_tributo")[k]).val(),
            "impuesto" : $($(".impuesto_mora")[k]).val(),
            "total_tribut" : $($(".total_tributo")[k]).val()
        };
        tributosPagos.push(datosTributos);
      }
      supremo.push(tributosPagos);
      /* PETICION AJAX PARA ENVIAR LOS DATOS AL SERVIDOR Y GUARDARLOS */
      $.ajax({
          url: "modulos/registro_facturas.php",
          type: 'POST',
          data: {superdata : JSON.stringify(supremo)}
      })
      .done(function(response){
          let respuesta = JSON.parse(response);
          alertar(respuesta.advertencia, respuesta.mensaje);
          setTimeout(function(){
            ocultarAlerta(0.001);
            window.open("modulos/pdf/facturas.php?cf="+respuesta.codigo_factura,"facturas.pdf","width=1100px, height=700px");
            formularioFacturaciones();
          },4999);
      })
      .fail(function() {
          console.log("error");
      });
      /* AQUI TERMINA LA PETICION AJAX */
    }else{
      /******* MENSAJE DE ADVERTENCIA ****************/
      $("<div>",{
        'class' : "wh-completo mar-izq bd-1p-bln msj-oculto",
        'id' : "mensaje_busqueda",
        'text' : "DEBE LISTAR UN TRIBUTO PARA PODER GENERAR FACTURA."
      }).appendTo('#mensaje_busqueda_factura');
      setTimeout(function(){
        $("#mensaje_busqueda").remove();
      },5500);
    }
  });//AQUI TERMINA EL EVENTO DE GUARDAR LOS TRIBUTOS EN LISTA.

  $(document).on("change","#yd_tributo",function(){
    let val = parseInt($(this).val());
    let rif = $("#rif_contribuyente").text();
    if(val == 0){
      $("#trid_tributo").addClass("desactivar");
      $("#trid_tributo").empty();
      $("#yh_tributo").addClass("desactivar");
      setValueSelect("yh_tributo", "0");
      $("#trih_tributo").addClass("desactivar");
      setValueSelect("trih_tributo", "0");
    }else{
      if(rif == ""){
        advertenciaEnfocada("#contenido_principal_pago","#busqueda","DEBE BUSCAR A UN CONTRIBUYENTE PARA SEGUIR.",1);
        setValueSelect("yd_tributo", "0");
      }else{
        quitar_advertencia("#contenido_principal_pago");
        $("#trid_tributo").removeClass("desactivar");
        $("#trid_tributo").empty();
        $("#yh_tributo").removeClass("desactivar");
        setValueSelect("yh_tributo", "0");
        $("#trih_tributo").addClass("desactivar");
        setValueSelect("trih_tributo", "0");
        $.ajax({
          async: false,
          url: 'modulos/trimestresContribuyente.php',
          type: 'POST',
          data: {
            anyo: val,
            rif
          }
        })
        .done(function(response){
          let trimestres = JSON.parse(response);
          if(trimestres !== 4){
            let opcion = "<option value='0'>Trimestre</option>";
            trimestres.forEach(trimestre => {
              opcion += "<option value='"+trimestre.id_trimestre+"'>"+trimestre.nombre+"</option>";
            });
            $("#trid_tributo").html(opcion);
          }else{
            $("#trid_tributo").addClass("desactivar");
            $("#trid_tributo").empty();
            advertencia_animada("#caja_anyodesde", "YA ESTE AÑO ESTA CANCELADO COMPLETAMENTE, ELIJA OTRO AÑO.");
            setTimeout(function(){
              quitar_advertencia("#caja_anyodesde");
            }, 1000);
          }
        })
        .fail(function(){
          console.log("error");
        });
      }
    }
  });

  $(document).on("change","#trid_tributo",function(){
    let valor = $(this).val();
    if(valor != 0){
        $("#yh_tributo").removeClass("desactivar");
    }else{
      $("#yh_tributo").addClass("desactivar");
      setValueSelect("yh_tributo", "0");
      $("#trih_tributo").addClass("desactivar");
      setValueSelect("trih_tributo", "0");
    }
  });

  $(document).on("change","#yh_tributo",function(){
    let anyo_desde = $("#yd_tributo").val();
    let valor = $(this).val();
    if(valor == 0 || valor < anyo_desde){
      $("#trih_tributo").addClass("desactivar");
      $("#trih_tributo").empty();
      advertencia_animada("#caja_anyohasta", "EL AÑO DEBE SER MAYOR O IGUAL QUE EL DE DESDE Y DEBE SER DIFERENTE A CERO");
      setTimeout(function(){
        quitar_advertencia("#caja_anyohasta");
      }, 3999);
    }else if(valor >= anyo_desde && valor != 0){
      $("#trih_tributo").removeClass("desactivar");
      $("#trih_tributo").empty();
      obtenerTrimestresYear("#trih_tributo",parseInt(valor));
    }
  });

  $(document).on("change","#trih_tributo",function(){
    let anyo_desde = $("#yd_tributo").val();
    let anyo_hasta = $("#yh_tributo").val();
    let trimestre_desde = $("#trid_tributo").val();
    let valor = $(this).val();
    if(anyo_desde == anyo_hasta){
      if(valor < trimestre_desde){
        $("#trih_tributo").addClass("desactivar");
        $("#trih_tributo").empty();
        setValueSelect("yh_tributo", "0");
        advertencia_animada("#caja_anyohasta", "Debe Elegir un trimestre que sea mayor o igual al escogido en Desde.");
        setTimeout(function(){
          quitar_advertencia("#caja_anyohasta");
        }, 3999);
      }
    }
  });

  $(document).on("change","#tipo_pago",function(){
      if(parseInt($(this).val()) <= 1){
          $("#referencia").addClass("desactivar");
      }else{
          $("#referencia").removeClass("desactivar");
      }
      $("#referencia").val("");
  });

  $(document).on("click","#check-impuesto_mora",function(){
      if($(this).prop("checked")){
        $("#impuesto_mora").removeClass("desactivar");
      }else{
        if($("#impuesto_mora").val() != ""){
          var tt = parseFloat($("#total_tributo").val());
          var monto = parseFloat($("#monto_tributo").val());
          var val = (parseFloat($("#impuesto_mora").val()) / 100); 
         
          $("#total_tributo").val((monto*val)-tt);
          $("#impuesto_mora").val("");
          $("#impuesto_mora").addClass("desactivar");
        }
      }
  });

  $(document).on("keyup","#monto_tributo",function(){
      let valor = $(this).val(); 
      $("#total_tributo").val(valor);
      $("#impuesto_mora").val("");
      $("#check-impuesto_mora").prop("checked",false);
      if(valor == ""){
        $("#check-impuesto_mora").addClass("desactivar");
        $("#impuesto_mora").addClass("desactivar");
      }else{
        $("#check-impuesto_mora").removeClass("desactivar");
      }
  });

  $(document).on("blur","#impuesto_mora",function(){
      let valor = parseFloat($(this).val());
      let monto = parseFloat($("#monto_tributo").val());
      let total = ((valor/100)*monto)+monto; 
      $("#total_tributo").val(total);
  });

  $(document).on("click",".btn-busqueda-empresa-factura", function(){
    let campoBuscar = $("#busqueda").val();
    busqueda(campoBuscar, obtenerContribuyente);
  });

/**************** TERMINA LA SECCION DE LOS EVENTOS DE CANCELACION  *************/


/*  EVENTOS PARA LA SECCION DE SOLVENTES  */
  $(document).on("click",".btn-certificado-solvente",function(){
    let rif = $($(this)[0]).parent().parent().children('.rif-contribuyente').text();
    window.open("modulos/pdf/certificado_solvente.php?cr="+rif,"certificadoSolvente.pdf","width=1100px, height=700px");
  });

          $(document).on("click",".check-desde",function(){
            if($('.check-desde').prop('checked')){
                quitar_advertencia(".contenedor-chd");

                setValueSelect("year_desde",0);
                $(".select-year-desde").removeClass('desactivar');

                $(".check-hasta").removeClass('desactivar');

                $("#reporte_solventes").addClass('desactivar');
            }else{
                quitar_advertencia(".contenedor-ad");
                quitar_advertencia(".contenedor-md");
                quitar_advertencia(".contenedor-ah");
                quitar_advertencia(".contenedor-mh");
                $("#reporte_solventes").removeClass('desactivar');

                setValueSelect("year_desde",0);
                $(".select-year-desde").addClass('desactivar');

                $(".select-mes-desde").html("<option value=0>Trimestre</option>");
                $(".select-mes-desde").addClass('desactivar');

                $('.check-hasta').prop('checked',false);
                $(".check-hasta").addClass('desactivar');

                $(".select-year-hasta").html("<option value=0>Año</option>");
                $(".select-year-hasta").addClass('desactivar');

                $(".select-mes-hasta").html("<option value=0>Trimestre</option>");
                $(".select-mes-hasta").addClass('desactivar');
            }
        });

        $(document).on("change","#year_desde",function(){
          let val = parseInt($(this).val());
          if(val == 0){
            $("#reporte_solventes").addClass('desactivar');
            $("#mes_desde").addClass("desactivar");
            $("#mes_desde").html("<option value=0>Trimestre</option>");
            $("#year_hasta").addClass("desactivar");
            setValueSelect("year_hasta", "0");
            $("#mes_hasta").addClass("desactivar");
            setValueSelect("mes_hasta", "0");
            $('.check-hasta').prop('checked',false);
          }else{
            $("#mes_desde").removeClass("desactivar");
            $("#mes_desde").empty();
            obtenerTrimestresYear("#mes_desde",parseInt(val));
              
            if($('.check-hasta').prop('checked')){
              $("#year_hasta").removeClass("desactivar");
              setValueSelect("year_hasta", "0");
            }else{
              $("#year_hasta").addClass("desactivar");
              setValueSelect("year_hasta", "0");
            }
            $("#mes_hasta").addClass("desactivar");
            setValueSelect("mes_hasta", "0");
          }
        });

        $(document).on("change","#mes_desde",function(){
          let val = parseInt($(this).val());
          let aH = parseInt($(".select-year-hasta").val());
          let aD = parseInt($(".select-year-desde").val());
          if(val != 0 && $('.check-hasta').prop('checked')){
              $("#reporte_solventes").addClass('desactivar');
              $(".select-year-hasta").removeClass('desactivar');
              obtenerYearSolventes("#year_hasta");
          }else if(val != 0 && !($('.check-hasta').prop('checked'))){
              $("#reporte_solventes").removeClass('desactivar');
          }else{
              $(".select-year-hasta").addClass('desactivar');
              setValueSelect("year_hasta",0);
              $(".select-mes-hasta").addClass('desactivar');
              $(".select-mes-hasta").html("<option value=0>Trimestre</option>");
          }
        });

        $(document).on("click",".check-hasta",function(){
            let mD = parseInt($(".select-mes-desde").val());
            if($('.check-hasta').prop('checked')){
                if(mD != 0){
                    $(".select-year-hasta").removeClass('desactivar');
                    obtenerYearSolventes("#year_hasta");
                }
                $("#reporte_solventes").addClass('desactivar');
            }else{
                $("#reporte_solventes").removeClass('desactivar');

                setValueSelect("year_hasta",0);
                $(".select-year-hasta").addClass('desactivar');

                $(".select-mes-hasta").html("<option value=0>Trimestre</option>");
                $(".select-mes-hasta").addClass('desactivar');
            }
        });

        $(document).on("change","#year_hasta",function(){
            let val = parseInt($(this).val());
            let aD = parseInt($("#year_desde").val());
            if(val == 0 || val < aD){
                advertencia_animada(".contenedor-ah", "EL AÑO DEBE SER MAYOR O IGUAL QUE EL DE DESDE, Y DEBE SER DIFERENTE A CERO");
                setTimeout(function(){
                  quitar_advertencia(".contenedor-ah");
                }, 3999);
                $("#reporte_solventes").addClass('desactivar');
                setValueSelect("year_hasta",0);
                $(".select-mes-hasta").addClass('desactivar');
                $(".select-mes-hasta").html("<option value=0>Trimestre</option>");
            }else if(val >= aD && val != 0){
              $("#mes_hasta").removeClass("desactivar");
              $("#mes_hasta").empty();
              obtenerTrimestresYear("#mes_hasta",parseInt(val));
            }
        });

        $(document).on("change","#mes_hasta",function(){
          let anyo_desde = $("#year_desde").val();
          let anyo_hasta = $("#year_hasta").val();
          let trimestre_desde = $("#mes_desde").val();
          let valor = $(this).val();
          if(anyo_desde == anyo_hasta){
            if(valor < trimestre_desde){
              $("#reporte_solventes").addClass('desactivar');
              $("#mes_hasta").addClass("desactivar");
              $("#mes_hasta").html("<option value=0>Trimestre</option>");
              setValueSelect("year_hasta", "0");
              advertencia_animada(".contenedor-ah", "Debe Elegir un trimestre que sea mayor o igual al escogido en Desde.");
              setTimeout(function(){
                quitar_advertencia(".contenedor-ah");
              }, 3999);
            }else{
              $("#reporte_solventes").removeClass('desactivar');
            }
          }else{
            $("#reporte_solventes").removeClass('desactivar');
          }
        });

        $(document).on("click","#boton_solvente_fecha",function(){
            let aD = parseInt($(".select-year-desde").val());
            let mD = parseInt($(".select-mes-desde").val());
            let aH = parseInt($(".select-year-hasta").val());
            let mH = parseInt($(".select-mes-hasta").val());
            let mesDesde, mesHasta;
            let bandera = 0;
            if($('.check-desde').prop('checked')){
                if(aD === 0){
                    $("#reporte_solventes").addClass('desactivar');
                    advertenciaEnfocada(".contenedor-ad",".select-year-desde","Si ha seleccionado el Check Desde Elija el Año. ¡Es Obligatorio!",1);
                }else{
                    if(mD === 0){
                        $("#reporte_solventes").addClass('desactivar');
                        advertenciaEnfocada(".contenedor-md",".select-mes-desde","Si ha seleccionado el Check Desde Elija el Mes respectivo. ¡Es Obligatorio!",1);
                    }else if(mD !== 0 && $('.check-hasta').prop('checked')){
                        if(aH === 0){
                            $("#reporte_solventes").addClass('desactivar');
                            advertenciaEnfocada(".contenedor-ah",".select-year-hasta","Si ha seleccionado el Check Hasta Elija el Año. ¡Es Obligatorio!",1);
                        }else{
                            if(mH === 0){
                                $("#reporte_solventes").addClass('desactivar');
                                advertenciaEnfocada(".contenedor-mh",".select-mes-hasta","Si ha seleccionado el Check Hasta Elija el Mes respectivo. ¡Es Obligatorio!",1);
                            }else{
                                bandera = 1;
                                mesDesde = mD;
                                mesHasta = mH;
                                $("#reporte_solventes").removeClass('desactivar');
                            }
                        }
                    }else if(mD !== 0 && !($('.check-hasta').prop('checked'))){
                        bandera = 1;
                        mesDesde = mD;
                        mesHasta = 0;
                        $("#reporte_solventes").removeClass('desactivar');
                    }
                }
            }else{
                advertenciaEnfocada(".contenedor-chd","#desde_solvente","¡No se pueden realizar busquedas por fechas si no has seleccionado el Check Desde y Colocas la(s) Fecha(s)!",1);
            }

            if(bandera === 1){
                listadoSolventes("",mesDesde,mesHasta);
            }
        });

        $(document).on("click",".btn-busqueda-solventes", function(){
            let campoBuscar = $("#busqueda").val();
            busqueda(campoBuscar, listadoSolventes);
        });

        $(document).on("click","#reporte_solventes",function(){
            let busqueda = $("#busqueda").val();
            let mD = parseInt($(".select-mes-desde").val());
            let mH = parseInt($(".select-mes-hasta").val());
            if(busqueda === ""){
                window.open("modulos/pdf/reporte_solventes.php?dm="+mD+"&hm="+mH,"reporte_solventes.pdf","width=1100px, height=700px");
            }else{
                window.open("modulos/pdf/reporte_solventes.php?b="+busqueda,"reporte_solventes.pdf","width=1100px, height=700px");
            }
        });
/*   AQUI TERMINAN LOS EVENTOS DE LA SECCION DE SOLVENTES   */


/*   EVENTOS DE LA SECCION DE DEUDORES   */
  $(document).on("click",".btn-busqueda-deudores", function(){
      let campoBuscar = $("#busqueda").val();
      busqueda(campoBuscar, listadoDeudores);
  });

  $(document).on("click","#reporte_deudores",function(){
      let busqueda = $("#busqueda").val();
      window.open("modulos/pdf/reporte_deudores.php?b="+busqueda,"reporte_deudoras.pdf","width=1100px, height=700px");
  });
/*   AQUI TERMINAN LOS EVENTOS DE LA SECCION DE LOS DEUDORES   */


/*  EVENTOS PARA LA SECCION DE LA LISTA DE FACTURAS O FACTURACIONES  */
        $(document).on("click",".btn-busqueda-facturas", function(){
            let campoBuscar = $("#busqueda").val();
            busqueda(campoBuscar, listadoFacturas);
        });

        $(document).on("input","#f_desde",function(){
            let val = $(this).val();
            $("#f_hasta").val("");
            let valor_format = new Date(val);

            if(val != "" && valor_format <= fecha_actual){
                $("#f_hasta").removeClass('desactivar');
                $("#reporte_facturas").removeClass("desactivar");
                $("#b_rFechasFacturas").removeClass("desactivar");
            }else if(!CampoFechaActual("#f_desde") || val == ""){
                $("#f_hasta").addClass('desactivar');
                if(val != ""){
                  $("#reporte_facturas").addClass("desactivar");
                }
                $("#b_rFechasFacturas").addClass("desactivar");
            }
        });

        $(document).on("input","#f_hasta",function(){
            let val = $(this).val();
            let fechaD = $("#f_desde").val();

            let valor_hasta = new Date(val);
            let valor_desde = new Date(fechaD);
            
            if(val != ""){
                if((valor_hasta < valor_desde) || (valor_hasta > fecha_actual)){
                    $("#reporte_facturas").addClass("desactivar");
                    $("#b_rFechasFacturas").addClass("desactivar");
                }else{
                    $("#reporte_facturas").removeClass("desactivar");
                    $("#b_rFechasFacturas").removeClass("desactivar");
                }
            }else{
                $("#reporte_facturas").removeClass("desactivar");
                $("#b_rFechasFacturas").removeClass("desactivar");
            }
        });

        $(document).on("click","#b_rFechasFacturas",function(){
            let fechaD = $("#f_desde").val();
            let fechaH = $("#f_hasta").val();
            listadoFacturas("", fechaD, fechaH);
        });

        $(document).on("click","#reporte_facturas", function(){
            let busqueda = $("#busqueda").val();
            let fechaD = $("#f_desde").val();
            let fechaH = $("#f_hasta").val();
            if(busqueda === ""){
                window.open("modulos/pdf/reporte_facturaciones.php?fechaD="+fechaD+"&fechaH="+fechaH,"reporte_facturaciones.pdf","width=1100px, height=700px");
            }else{
                window.open("modulos/pdf/reporte_facturaciones.php?busqueda="+busqueda,"reporte_facturaciones.pdf","width=1100px, height=700px");
            }
        });

        $(document).on("click",".imprimir_factura",function(){
          let codigo_factura = $($(this)[0]).parent().parent().children('.cod_factura').text();
          window.open("modulos/pdf/facturas.php?cf="+codigo_factura,"facturas.pdf","width=1100px, height=700px");
        });

        $(document).on("click","#facturacion",function(){
            deudor = 0; 
            formularioFacturaciones();
        });

/*      AQUI TERMINAN LOS EVENTOS DEL LISTADO DE FACTURAS.      */




/*    EVENTOS PARA LAS ACTIVIDADES COMERCIALES       */
    $(document).on("click",".btn-busqueda-acti-com",function(){
        let val = $(".busqueda-acti-com").val();
        busqueda(val,listadoActividadesComerciales);
    });

    $(document).on("click",".modificar-acticom",function(){
        modificar_ac = 1;
        let codigo = $($(this)[0]).parent().parent().children('.cod_ac').text();
        let descripcion = $($(this)[0]).parent().parent().children('.des_ac').text();

        $("#cod_acti_com").val(codigo).addClass('desactivar');
        $("#desc_act_com").val(descripcion);
    });

    $(document).on("click",".eliminar-acticom",function(){
        if(confirm('¿Está Segúro de querer Eliminar la Actividad Comercial?')){
            let codigo = $($(this)[0]).parent().parent().children('.cod_ac').text();
            let datos = {
                criterio: "Eliminar",
                codigo : codigo
            }
            $.ajax({
                url: "modulos/actividades_comerciales.php",
                type: "GET",
                data: datos,
                success: function(response){
                    let respuesta = JSON.parse(response);
                    alertar(respuesta.advertencia, respuesta.mensaje);
                    setTimeout(function(){
                        $("#cod_acti_com").val("");
                        $("#desc_act_com").val("");
                        listadoActividadesComerciales();
                        ocultarAlerta(0.001);
                    },2999);
                }
            });
        }
    });

    $(document).on("click","#btn-guardar-actcom",function(){
        if(!LongitudCampo("#cod_acti_com",5,12) || !CampoVacio("#cod_acti_com")){
            advertenciaEnfocada("#contenedor_cod-act-com","#cod_acti_com","No debe estar vació o Debe tener al menos 5 Digítos.",1);
        }else if(!LongitudCampo("#desc_act_com",10,140) || !CampoVacio("#desc_act_com")){
            advertenciaEnfocada("#contenedor_desc-act-com","#desc_act_com","No debe estar vació y tiene que tener de 10 a 140 Caracteres.",1);  
        }else{
            if(modificar_ac === 1){
                datos = {
                    codigo      :    $("#cod_acti_com").val(),
                    descripcion  :    $("#desc_act_com").val(),
                    criterio    :    "Modificar"
                };
            }else{
                datos = {
                    codigo      :    $("#cod_acti_com").val(),
                    descripcion  :    $("#desc_act_com").val(),
                    criterio    :    "Guardar", 
                };
            }
            $.ajax({
                url: "modulos/actividades_comerciales.php",
                type: "GET",
                data: datos,
                success: function(response){
                    let respuesta = JSON.parse(response);
                    alertar(respuesta.advertencia, respuesta.mensaje);
                    setTimeout(function(){
                        modificar_ac = 0;
                        $("#cod_acti_com").val("").removeClass("desactivar");
                        $("#desc_act_com").val("");
                        listadoActividadesComerciales();
                        ocultarAlerta(0.001);
                    },2999);
                }
            });
        }
    });

    /*     FIN DE LOS EVENTOS PARA LAS ACTIVIDADES COMERCIALES     */
}); // AQUI FINALIZA EL OBJETO JQUERY.