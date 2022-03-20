let mayor_scroll = 5;
let menor_scroll = 1;
let modificar = 0;
let modificar_ac = 0;
let modificar_per = 0;
let cantidad_tributos = 0;
let superTotal = 0;
let activo = 0;
let deudor = 0;
let searching = 0;
let datos;
let pdf;

let desplegable =0;

var f = new Date();
let yearActual = f.getFullYear();
let mesActual = f.getMonth() + 1;

var meses = ["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];

function onEvents(){
  $.ajax({
    url: "modulos/eventosAutomaticos.php"
  });
}

function inicio(){
  $("#seccion_impresion").html("");
  $("#seccion_impresion").addClass("pd-ssm");
  $("#seccion_impresion").removeClass("pd-centrado45l");
  $("#seccion_impresion").removeClass('fondo-vinotinto-oscuro');
  $("#seccion_impresion").html(template_index);

  $('#btn-busqueda').removeClass('btn-busqueda-facturas');
  $("#busqueda").removeClass('busqueda-facturas');

  $('#btn-busqueda').removeClass('btn-busqueda-deudores');
  $("#busqueda").removeClass('busqueda-deudores');

  $("#busqueda").removeClass('busqueda-empresa-factura');
  $("#btn-busqueda").removeClass('btn-busqueda-empresa-factura');
  
  $('#btn-busqueda').removeClass('btn-busqueda-solventes');
  $("#busqueda").removeClass('busqueda-solventes');

  $('#btn-busqueda').removeClass('btn-busqueda-acti-com');
  $("#busqueda").removeClass('busqueda-acti-com');

  $("#busqueda").removeClass("desactivar");
  $("#btn-busqueda").removeClass('desactivar');

  $('#btn-busqueda').addClass('btn-busqueda-empresas');
  $("#busqueda").addClass('busqueda-empresas');

  $("#busqueda").attr("placeholder","Rif");
  
  $("#busqueda").val('');
  $("#busqueda").focus();
  
  paginacion_empresa();
  parroquias();
}

function parroquias(){
  $.ajax({
    url: "modulos/parroquias.php",
    type: "GET",
    success: function(response){
      let parroquias = JSON.parse(response);
      let opcion = "<option value='0'>Parroquia</option>";
      parroquias.forEach(parroquia => {
        opcion += "<option value="+parroquia.id+">"+parroquia.nombre+"</option>";
      });
      $(".parroquias").html(opcion);
    }
  });
}

function setValueSelect(SelectId, Value) {
  var SelectObject;
  SelectObject = document.getElementById(SelectId);
  for(index = 0;  index < SelectObject.length;  index++) {
    if(SelectObject[index].value == Value) SelectObject.selectedIndex = index;
  }
}

function obtenerTextoSelect(SelectId, Value) {
  var SelectObject;
  SelectObject = document.getElementById(SelectId);
  for(index = 0;  index < SelectObject.length;  index++) {
    if(SelectObject[index].value == Value) return SelectObject[index].text;
  }
}

function colocarOption(objSelector, valor, texto){
    objSelector.html("<option value='"+valor+"' selected>"+texto+"</option>");
}

//FUNCION QUE SACA EL CUADRO DE DIALOGO DE LA ADVERTENCIA DE VALIDACION.
function advertencia(padre, valor){
  $(padre).addClass('posicion_relativa');
  $("<div>", {
        'class': 'advertencia-formulario',
        'text':  valor
  }).css("display","block").appendTo(padre);
}

function advertencia_animada(padre, valor){
  $(padre).addClass('posicion_relativa');
  $("<div>", {
        'class': 'advertencia-formulario animacion_aparecer',
        'text':  valor
  }).css("display","block").appendTo(padre);
}

function quitar_advertencia(contenedor){
  $(contenedor).removeClass('posicion_relativa');
  $(".advertencia-formulario").css("display","none");
}

function paginacion_empresa(pagina = 1){

  //VACIAR EL AREA DE LLENADO DE LA PAGINACION DE LAS EMPRESAS.
  $("#primeros").html("");
  $("#numeros-paginas").html("");
  $("#ultimos").html("");

  $.ajax({
    url: "modulos/paginacion-empresa.php",
    type: "GET",
    success: function(response){
      let total_paginas = parseInt(response);
      let botones_anteriores = "", botones_siguientes = "", numeros_paginas = "";

      listado_empresaPaginacion(pagina);

      if(total_paginas < mayor_scroll){
        mayor_scroll = total_paginas;
      }

      if(pagina >= (mayor_scroll - 1) && mayor_scroll <= (total_paginas - 1)){
        if(mayor_scroll < total_paginas){
          mayor_scroll++;
          menor_scroll++;
        }
      }else if(pagina <= (menor_scroll + 1) && menor_scroll >= 2){
        if(menor_scroll > 1){
          mayor_scroll--;
          menor_scroll--;
        }
      }

      if(pagina > 1){
        botones_anteriores += `
            <a href="#" id="primero-empresa" class="num_pag" title="1">
              <i class="fa fa-angle-double-left" aria-hidden="true"></i>
            </a>
            <a href="#" id="atras-empresa" class="num_pag" title="`+ (pagina-1) +`">
              <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>
        `
      }else{
        botones_anteriores += `
            <a href="#" id="primero-empresa" class="num_pag desactivar" title="1">
              <i class="fa fa-angle-double-left" aria-hidden="true"></i>
            </a>
            <a href="#" id="atras-empresa" class="num_pag desactivar" title="`+ (pagina-1) +`">
              <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>
        `
      }

      for(var i = menor_scroll; i <= mayor_scroll; i++){
        if(pagina === i){
          numeros_paginas += `<a href="#" class="num_pag num_pag-active" title="`+ i +`">`+ i +`</a>`
        }else{
          numeros_paginas += `<a href="#" class="num_pag" title="`+ i +`">`+ i +`</a>`
        }
      }

      if(pagina < total_paginas){
        botones_siguientes += `
            <a href="#" id="siguiente-empresa" class="num_pag" title="`+ (pagina+1) +`">
              <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
            <a href="#" id="ultimo-empresa" class="num_pag" title="`+ total_paginas +`">
              <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            </a>
        `
      }else{
        botones_siguientes += `
            <a href="#" id="siguiente-empresa" class="num_pag desactivar" title="`+ (pagina+1) +`">
              <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
            <a href="#" id="ultimo-empresa" class="num_pag desactivar" title="`+ total_paginas +`">
              <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            </a>
        `
      }

      $("#primeros").html(botones_anteriores);
      $("#numeros-paginas").html(numeros_paginas);
      $("#ultimos").html(botones_siguientes);
    }
  });
}

function listado_empresaPaginacion(pagina = 1){

  $("#seccion-bi").html("");

  $.ajax({
    url: "modulos/lista-empresa.php",
    type: "POST",
    data: {pagina: pagina},
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
        template += `<div class="avisar_nada">¡No se ha encontrado ningún resultado, intente buscar de nuevo!</div>`;
      }

      $(".listado-impresion").html(template);
    }
  });
}

/*
  animacion:
    0 -> sin animacion
    1 -> animada
*/
function advertenciaEnfocada(contenedor,campo,texto_advertencia,animacion=0){
  quitar_advertencia(contenedor);
  if(animacion === 0){
    advertencia(contenedor,texto_advertencia);
  }else{
    advertencia_animada(contenedor, texto_advertencia);
  }
  setTimeout(function(){
      $(campo).focus();
  }, 1);
}

function parroquias_dependientes(municipio=0,select_parroquia){
  $.ajax({
    async: false,
    url: "modulos/parroquias.php",
    type: "POST",
    data: {id_municipio : municipio},
    success: function(response){
      let parroquias = JSON.parse(response);
      let opcion = "<option value=0>Parroquia</option>";
      parroquias.forEach(parroquia => {
        opcion += "<option value="+parroquia.id+">"+parroquia.nombre+"</option>";
      });
      $(select_parroquia).html(opcion);
    }
  });
}

function municipios_dependientes(est = 0, select_municipio){
  $.ajax({
    async: false,
    url: "modulos/municipios.php",
    type: "GET",
    data: {estado: est},
    success: function(response){
      let municipios = JSON.parse(response);
      let opcion = "<option value=0>Municipio</option>";
      municipios.forEach(municipio => {
        opcion += "<option value="+municipio.id+">"+municipio.nombre+"</option>";
      });
      $(select_municipio).html(opcion);
    }
  });
}

function seleccionar_radio(etiqueta,valor){
  var radios = $(etiqueta);
  for(var g = 0; g < radios.length; g++){
    if($(radios[g]).val() == valor){
      $(radios[g]).prop('checked',true);
    }
  }
}

function obtener_valor_radio(etiqueta){
  var radios = $(etiqueta);
  var valor;
  for(var g = 0; g < radios.length; g++){
    if($(radios[g]).prop('checked')){
      valor = $(radios[g]).val();
    }
  }
  return valor;
}

function validarRadio(etiqueta){
  var radios = $(etiqueta);
  var tam = radios.length;
  var cont = tam;
  var valor;
  for(var g = 0; g < tam; g++){
    if(!$(radios[g]).prop('checked')){
      cont--;
    }
  }
  if(cont == 0){
    return false;
  }else{
    return true;
  }
}

function estados_dependientes(){
  $.ajax({
    async: false,
    url: "modulos/estados.php",
    type: "GET",
    success: function(response){
      let estados = JSON.parse(response);
      let opcion = "<option value=0>Estado</option>";
      estados.forEach(estado => {
        opcion += "<option value="+estado.id+">"+estado.nombre+"</option>";
      });
      $(".estado-dependiente").html(opcion);
    }
  });
}

function actividades_cormeciales(){
  $.ajax({
    async: false,
    url: "modulos/actividades_comerciales.php",
    type: "GET",
    data: {criterio : "Listado"},
    success: function(response){
      let acti_comer = JSON.parse(response);
      let opcion = "<option value='0'></option>";
      acti_comer.forEach(ac_com => {
        opcion += "<option value='"+ac_com.id+"'>"+ac_com.nombre+"</option>";
      });
      $("#actividad_comercial-form").html(opcion);
    }
  });
}

function formNuevaEmpresa(datos={}){
  var munEmp, munProp;
  $("#busqueda").addClass('desactivar');
  $("#btn-busqueda").addClass('desactivar');

  $("#seccion_impresion").html("");
  $("#seccion_impresion").addClass("pd-ssm");
  $("#seccion_impresion").removeClass("pd-centrado45l");
  $("#seccion_impresion").html(template_nuevaEmpresa);
  if(modificar === 0){
    $("#deta_dir_empresa-form").addClass('desactivar');  
    $("#municipio_propietario-form").addClass('desactivar');
    $("#parroquia-propietario-form").addClass('desactivar');
    $("#deta_dir_persona-form").addClass('desactivar');
  }else if(modificar === 1){
    $("#nombre_empresa-form").addClass('desactivar');
    $("#rif_empresa-form").addClass('desactivar');
    $("#cod_comercio-form").addClass('desactivar');
    $("#registro_empresa-form").addClass('desactivar');
    $("#actividad_comercial-form").addClass('desactivar');
    $("#cedula_propietario-form").addClass('desactivar');
    $("#rif_propietario-form").addClass('desactivar');
    $(".contribuyente_rep").addClass('desactivar');
  }

  validacion_formulario_empresa();
  parroquias_dependientes(282,"#parroquia-empresa-form");
  estados_dependientes();
  actividades_cormeciales();

  if(!($.isEmptyObject(datos))){
    for(var clave in datos){
      if(clave == "estado_propietario-form" || clave == "actividad_comercial-form" || clave == "parroquia-empresa-form"){
        if(clave == "estado_propietario-form"){
          estProp = parseInt(datos[clave]);
        }
        setValueSelect(clave, datos[clave]);
      }else if(clave == "municipio_propietario-form"){
        munProp = parseInt(datos[clave]);
        municipios_dependientes(estProp,"#"+clave);
        setValueSelect(clave, datos[clave]);
      }else if(clave == "parroquia-propietario-form"){
        parroquias_dependientes(munProp,"#"+clave);
        setValueSelect(clave, datos[clave]);
      }else if(clave == "contribuyente_rep"){
        seleccionar_radio("."+clave, datos[clave]);
      }else{
        $("#"+clave).val(datos[clave]);
      }
    }
  }
}

function obtenerEmpresa(llave, formulario){
  $.ajax({
    url: "modulos/obtenerEmpresa.php",
    type: "POST",
    data: {llave},
    asyn: true,
    success: function(response){
      let respuesta = JSON.parse(response);
      if(respuesta == 0){
        $("<div>",{
          'class' : "wh-completo bd-1p-bln msj-oculto",
          'id' : "mensaje_busqueda",
          'text' : "EL CONTRIBUYENTE NO EXITE"
        }).appendTo('#mensaje_busqueda_factura');
        setTimeout(function(){
            $("#mensaje_busqueda").remove();
        },5500);
      }else{
        formulario(respuesta);
      }
    }
  });
}

function formNuevaPersona(datos={}){
  $("#busqueda").addClass('desactivar');
  $("#btn-busqueda").addClass('desactivar');

  $("#seccion_impresion").html("");
  $("#seccion_impresion").addClass("pd-ssm");
  $("#seccion_impresion").removeClass("pd-centrado45l");
    $("#seccion_impresion").html(template_nuevaPersona);
  if(modificar === 0){
    $("#deta_dir_persona-form").addClass('desactivar');
  }else if(modificar === 1){
    $("#cedula_persona-form").addClass('desactivar');
    $("#rif_persona-form").addClass('desactivar');
    $("#deta_dir_persona-form").addClass('desactivar');
  }

  validacion_formulario_persona();
  parroquias_dependientes(282,"#parroquia-persona-form");

  if(!($.isEmptyObject(datos))){
    for(var clave in datos){
      if(clave == "parroquia-persona-form"){
        setValueSelect(clave, datos[clave]);
      }else{
        $("#"+clave).val(datos[clave]);
      }
    }
  }
}

function obtenerPersona(llave, formulario){
  $.ajax({
    url: "modulos/obtenerPersona.php",
    type: "POST",
    data: {llave},
    asyn: true,
    success: function(response){
      let respuesta = JSON.parse(response);
      if(respuesta == 0){
        $("<div>",{
          'class' : "wh-completo bd-1p-bln msj-oculto",
          'id' : "mensaje_busqueda",
          'text' : "EL CONTRIBUYENTE NO EXITE"
        }).appendTo('#mensaje_busqueda_factura');
        setTimeout(function(){
            $("#mensaje_busqueda").remove();
        },5500);
      }else{
        formulario(respuesta);
      }
    }
  });
}

function seccionDeudores(){
  $("#seccion_impresion").removeClass("pd-centrado45l");
  $("#busqueda").removeClass("desactivar");
  $("#btn-busqueda").removeClass('desactivar');
  $("#seccion_impresion").removeClass('fondo-vinotinto-oscuro');

  $('#btn-busqueda').removeClass('btn-busqueda-facturas');
  $("#busqueda").removeClass('busqueda-facturas');

  $("#busqueda").removeClass('busqueda-empresa-factura');
  $("#btn-busqueda").removeClass('btn-busqueda-empresa-factura');

  $('#btn-busqueda').removeClass('btn-busqueda-empresas');
  $("#busqueda").removeClass('busqueda-empresas');

  $('#btn-busqueda').removeClass('btn-busqueda-solventes');
  $("#busqueda").removeClass('busqueda-solventes');

  $('#btn-busqueda').removeClass('btn-busqueda-acti-com');
  $("#busqueda").removeClass('busqueda-acti-com');

  $('#btn-busqueda').addClass('btn-busqueda-deudores');
  $("#busqueda").addClass('busqueda-deudores');

  $("#busqueda").val('');
  $("#busqueda").focus();
  $("#busqueda").attr("placeholder","Nombre o Rif");
  $("#seccion_impresion").html(template_deudores);

  listadoDeudores();  
}

function seccionSolventes(){
    $("#seccion_impresion").removeClass("pd-centrado45l");
    $("#busqueda").removeClass("desactivar");
    $("#btn-busqueda").removeClass('desactivar');
    $("#seccion_impresion").removeClass('fondo-vinotinto-oscuro');

    $('#btn-busqueda').removeClass('btn-busqueda-facturas');
    $("#busqueda").removeClass('busqueda-facturas');

    $("#busqueda").removeClass('busqueda-empresa-factura');
    $("#btn-busqueda").removeClass('btn-busqueda-empresa-factura');

    $('#btn-busqueda').removeClass('btn-busqueda-empresas');
    $("#busqueda").removeClass('busqueda-empresas');
            
    $('#btn-busqueda').removeClass('btn-busqueda-deudores');
    $("#busqueda").removeClass('busqueda-deudores');

    $('#btn-busqueda').removeClass('btn-busqueda-acti-com');
    $("#busqueda").removeClass('busqueda-acti-com');
            
    $('#btn-busqueda').addClass('btn-busqueda-solventes');
    $("#busqueda").addClass('busqueda-solventes');
            
    $("#busqueda").val('');
    $("#busqueda").focus();
    $("#busqueda").attr("placeholder","Nombre o Rif");
            
    $("#seccion_impresion").html(template_solventes);
    
    $('.check-desde').prop('checked',false);
    $('.check-hasta').prop('checked',false);

    obtenerYearSolventes("#year_desde");
    validacionFechas();    
    listadoSolventes();
}

function seccion_facturaciones(){
  searching = 5;
  $("#busqueda").removeClass("desactivar");
  $("#btn-busqueda").removeClass('desactivar');
  $("#seccion_impresion").removeClass("pd-centrado45l");

  $("#busqueda").removeClass('busqueda-empresa-factura');
  $("#btn-busqueda").removeClass('btn-busqueda-empresa-factura');

  $('#btn-busqueda').removeClass('btn-busqueda-empresas');
  $("#busqueda").removeClass('busqueda-empresas');

  $('#btn-busqueda').removeClass('btn-busqueda-solventes');
  $("#busqueda").removeClass('busqueda-solventes');

  $('#btn-busqueda').removeClass('btn-busqueda-deudores');
  $("#busqueda").removeClass('busqueda-deudores');

  $('#btn-busqueda').removeClass('btn-busqueda-acti-com');
  $("#busqueda").removeClass('busqueda-acti-com');

  $('#btn-busqueda').addClass('btn-busqueda-facturas');
  $("#busqueda").addClass('busqueda-facturas');

  $("#busqueda").val('');
  $("#busqueda").focus();
  $("#busqueda").attr("placeholder","Cod | Ref | Tipo | Emp");

  $("#seccion_impresion").html(template_facturaciones);

  $("#f_hasta").addClass("desactivar");
  $("#b_rFechasFacturas").addClass("desactivar");

  listadoFacturas();
}

function listadoFacturas(filtro = '', fechaD = "", fechaH = ""){
        let datos;
        if(filtro == ''){
          datos = {
            fechaD, 
            fechaH 
          };
        }else if(filtro != ''){
          datos = {
              busqueda: filtro
          };
        }
          $.ajax({
            url: 'modulos/listado_facturas.php',
            type: 'POST',
            data: datos
          })
          .done(function(response){
            //console.log(response);
            let facturas = JSON.parse(response);
            let template = "";
            if(facturas !== 0){
              facturas.forEach(factura => {
                template += `
                    <div class="fila-h2 borde-abajo-2p-blanco">
                        <div class="cod_factura column-1m-12 txt-uf20">${factura.codigo}</div>
                        <div class="column-1m-12 txt-uf20">${factura.fecha}</div>
                        <div class="column-2-12 txt-uf20">${factura.contribuyente}</div>
                        <div class="column-1m-12 txt-uf20">${factura.tipopago}</div>
                        <div class="column-2-12 txt-uf20">${factura.referencia}</div>
                        <div class="column-2-12 txt-uf20">${factura.monto}</div>
                        <div class="column-1m-12">
                            <a href="#" class="imprimir_factura btn-naranja-fp margen-btn-col9" title="Factura en Formato PDF para Imprimirla."><i class="fas fa-print"></i> Imprimir</a>
                        </div>
                    </div>
                   `
              });
            }else{
              template += `<div class="avisar_nada">¡No se ha encontrado ningún resultado!</div>`
            }

            $(".cuerpo-tabla").html(template);
          })
          .fail(function() {
            console.log("error");
          });   
    }

function listadoEmpresas(filtro = ''){
        $.ajax({
        url: 'modulos/busqueda_empresa.php',
        type: 'POST',
        data: {busqueda: filtro},
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

function listadoDeudores(filtro = ''){
  $.ajax({
    url: 'modulos/listado_deudores.php',
    type: 'POST',
    data: {busqueda: filtro}
  })
  .done(function(response){
    let contribuyentes = JSON.parse(response);
    let template = "";
    if(contribuyentes !== 0){
      contribuyentes.forEach(contribuyente => {
        template += `
          <div class="fila-h2">
            <div class="rif_emp column-1m-12 txt-uf20">${contribuyente.rif}</div>
            <div class="column-2-12 txt-mf20 scrolleable">${contribuyente.nombre}</div>
            <div class="column-1m-12 txt-uf20">${contribuyente.tipo}</div>
            <div class="column-2-12 txt-uf20">${contribuyente.telefono}</div>
            <div class="column-2-12 txt-mf20 scrolleable">${contribuyente.parroquia}</div>
            <div class="column-3-12 txt-mmf20-arrb scrolleable">${contribuyente.direccion}</div>
          </div>
            `
      });
    }else{
      template += `<div class="avisar_nada">¡No se ha encontrado ningún resultado!</div>`
    }

    $(".cuerpo-tabla").html(template);
  })
  .fail(function() {
    console.log("error");
  });   
}

function listadoSolventes(filtro = '', mesDesde = 0, mesHasta = 0){
  let datos;
  if(filtro == ''){
      datos = { 
        mesDesde, 
        mesHasta 
      };
  }else if(filtro != ''){
      datos = {
          busqueda: filtro
      };
  }
  
  $.ajax({
    url: 'modulos/listado_solventes.php',
    type: 'POST',
    data: datos
  })
  .done(function(response){
        let contribuyentes = JSON.parse(response);
        let template = "";
        if(contribuyentes !== 0 && contribuyentes !== 3){
          contribuyentes.forEach(contribuyente => {
            template += `
                    <div class="fila-h2 borde-abajo-2p-gris">
                        <div class="rif-contribuyente column-1-12 txt-uf20">${contribuyente.rif}</div>
                        <div class="column-3-12 txt-uf20 scrolleable">${contribuyente.nombre}</div>
                        <div class="column-1m-12 txt-uf20">${contribuyente.tipo}</div>
                        <div class="column-2-12 txt-uf20 scrolleable">${contribuyente.ultimo_pago}</div>
                        <div class="column-3-12 txt-uf20 scrolleable">${contribuyente.parroquia}</div>
                        <div class="column-1m-12">
                          <a href="#" class="btn-certificado-solvente btn-naranja-fp margen-btn-col9" title="Obtener Certificado"><i class="fas fa-file-alt"></i> Certificado</a>
                        </div>
                    </div>
                   `
          });
        }else if(contribuyentes === 3){
          template += `<div class="avisar_nada">¡El campo de fecha "DESDE" excedio el Trimestre Actual. Intente Buscando con un Trimestre Menor o Igual al Actual!</div>`
        }else{
          template += `<div class="avisar_nada">¡No se ha encontrado ningún resultado!</div>`
        }

        $(".cuerpo-tabla").html(template);
  })
  .fail(function() {
    console.log("error");
  });   
}

function alertar(advertencia, mensaje){
  let alerta;
  if(advertencia === 1){
      alerta = "alerta-exitosa";
  }else if(advertencia === 2){
      alerta = "alerta-peligro";
  }else{
      alerta = "alerta-error";
  }
  $("<div>",{
      'class' : "fondo_aviso_sobresaliente"
  }).append($("<p>",{
      'class' : "aviso_sobresaliente " + alerta + " animacion_aumentando",
      'text': mensaje
  })).appendTo("body").fadeIn('1');
}

function ocultarAlerta(segundos){
  segundos *= 1000;
  setTimeout(function(){
    $(".fondo_aviso_sobresaliente").fadeOut('1');
  },segundos);
}

function busqueda(valor, listado){  
    if(valor === ''){
        $("#busqueda").focus();
        $("#busqueda").css('border', '3px solid #e84e29');
        advertencia_animada("#item-busqueda","Introduce una cadena con el Nombre o Rif de la empresa y podras continuar con la busqueda");
        $("#reporte_facturas").addClass("desactivar");
    }else{
        $("#reporte_facturas").removeClass("desactivar");
        $("#busqueda").css('border', '3px solid #49b0f7');
        $(".advertencia-formulario").css("display","none");

        listado(valor);
    }     
}

/*  SECCION DEL FORMULARIO DE FACTURACIONES. */
function formularioFacturaciones(llave = ""){
    superTotal = 0;
    cantidad_tributos = 0;
    searching = 4;
    onEvents();
    $("#seccion_impresion").removeClass("pd-centrado45l");
    $("#seccion_impresion").addClass('pd-ssm');
    $("#seccion_impresion").html(template_formularioFactura);
    $("#guardar_recibo").removeClass("desactivar");
    if(llave === ""){
        $(".dato-importante").val("");
        $("#busqueda").val("");
        $("#busqueda").focus();
        $("#busqueda").attr("placeholder","Rif Contribuyente");

        $("#busqueda").removeClass("desactivar");
        $("#btn-busqueda").removeClass('desactivar');

        $('#btn-busqueda').removeClass('btn-busqueda-empresas');
        $("#busqueda").removeClass('busqueda-empresas');

        $('#btn-busqueda').removeClass('btn-busqueda-solventes');
        $("#busqueda").removeClass('busqueda-solventes');

        $('#btn-busqueda').removeClass('btn-busqueda-deudores');
        $("#busqueda").removeClass('busqueda-deudores');

        $('#btn-busqueda').removeClass('btn-busqueda-acti-com');
        $("#busqueda").removeClass('busqueda-acti-com');                    

        $("#busqueda").addClass('busqueda-empresa-factura');
        $("#btn-busqueda").addClass('btn-busqueda-empresa-factura');

        $("#check-impuesto_mora").addClass("desactivar");

        $("#trid_tributo").addClass('desactivar');
        $("#yh_tributo").addClass('desactivar')
        $("#trih_tributo").addClass('desactivar');
    }else{
        $("#busqueda").addClass("desactivar");
        $("#btn-busqueda").addClass('desactivar');
    }

    obtenerTipoPagos();
    obtenerTributo();
    soloNumeros("#referencia");
    soloNumeros("#total_tributo");
    soloNumeros("#super_total");

    obtenerYears("#yd_tributo");
    obtenerYears("#yh_tributo");
}

function obtenerTributo(){
    $.ajax({
        async: false,
        url: 'modulos/obtenerTributo.php',
        type: 'GET'
    })
    .done(function(response){
        let tributos = JSON.parse(response);
        let opcion = "<option value='0'>TRIBUTO</option>";
        tributos.forEach(tributo => {
            opcion += "<option value='"+tributo.codigo+"'>"+tributo.denominacion+"</option>";
        });
        $("#tributo").html(opcion);
    })
    .fail(function() {
        console.log("error");
    });
}

function obtenerTipoPagos(){
    $.ajax({
        async: false,
        url: 'modulos/obtenerTipoPago.php',
        type: 'GET'
    })
    .done(function(response){
        let tiposPago = JSON.parse(response);
        let opcion = "<option value='0'>Tipo de Pago</option>";
        tiposPago.forEach(tipoPago => {
            opcion += "<option value='"+tipoPago.cod_tipopago+"'>"+tipoPago.nombre_tipopago+"</option>";
        });
        $(".s-tipo_pago-factura").html(opcion);
    })
    .fail(function() {
        console.log("error");
    });
}

function obtenerTrimestresYear(select,year){
    $.ajax({
        async: false,
        url: 'modulos/obtenerTrimestres.php',
        type: 'POST',
        data: {
          anyo: year
        }
    })
    .done(function(response){
        let trimestres = JSON.parse(response);
        let opcion = "<option value='0'>Trimestre</option>";
        trimestres.forEach(trimestre => {
            opcion += "<option value='"+trimestre.id_trimestre+"'>"+trimestre.nombre+"</option>";
        });
        $(select).html(opcion);
    })
    .fail(function() {
        console.log("error");
    });
}

function obtenerYearSolventes(select){
  $.ajax({
    async: false,
    url: 'modulos/yearsSolventes.php',
    type: 'GET'
  })
  .done(function(response){
    let years = JSON.parse(response);
      let opcion = "<option value='0'>Año</option>";
      years.forEach(year => {
          opcion += "<option value='"+year.anyo+"'>"+year.anyo+"</option>";
      });
      $(select).html(opcion);
  })
  .fail(function() {
    console.log("error");
  });
}

function obtenerYears(select){
  $.ajax({
    async: false,
    url: 'modulos/yearsTrimestres.php',
    type: 'GET'
  })
  .done(function(response){
    let years = JSON.parse(response);
      let opcion = "<option value='0'>Año</option>";
      years.forEach(year => {
          opcion += "<option value='"+year.anyo+"'>"+year.anyo+"</option>";
      });
      $(select).html(opcion);
  })
  .fail(function() {
    console.log("error");
  });
}

function obtenerContribuyente(rif){
    $.ajax({
      url: 'modulos/tipo_contribuyente.php',
      type: 'GET',
      data: {rif}
    })
    .done(function(response){
      if(response == "emp"){
        obtenerEmpresa(rif,renderizarDatos);
      }else{
        obtenerPersona(rif,renderizarDatos);
      }
    })
    .fail(function() {
      console.log("error");
    });
}

function renderizarDatos(datos={}){
  let nom_contr = "";
  if(!($.isEmptyObject(datos))){
    for(var clave in datos){
      if(clave == 'rif_persona-form' || clave == "rif_empresa-form"){
        $("#rif_contribuyente").text(datos[clave]);
      }else if(clave == 'nombre_empresa-form'){
        $("#nombre_contribuyente").text(datos[clave]);
      }else if(clave == 'nombre_persona-form'){
        nom_contr += datos[clave];
      }else if(clave == 'apellido_persona-form'){
        nom_contr += " " + datos[clave];
        $("#nombre_contribuyente").text(nom_contr);
      }
    }
  }
}
/*  FIN DE LA SECCION DEL AREA DE FACTURACIONES.  */



/*******  FUNCIONES PARA EL AREA DE ACTIVIDADES COMERCIALES *******************/


function seccion_ActividadComercial(){
    searching = 6;
    $("#seccion_impresion").removeClass("pd-centrado45l");
    $("#seccion_impresion").addClass("pd-ssm");
    $("#busqueda").attr('placeholder', 'Código o Descripción');

    $("#seccion_impresion").removeClass('fondo-vinotinto-oscuro');
    $("#seccion_impresion").html(template_actividad_comercial);

    $("#cod_acti_com").val("");
    $("#desc_act_com").val("");

    $('#btn-busqueda').removeClass('btn-busqueda-facturas');
    $("#busqueda").removeClass('busqueda-facturas');

    $('#btn-busqueda').removeClass('btn-busqueda-deudores');
    $("#busqueda").removeClass('busqueda-deudores');

    $("#busqueda").removeClass('busqueda-empresa-factura');
    $("#btn-busqueda").removeClass('btn-busqueda-empresa-factura');
          
    $('#btn-busqueda').removeClass('btn-busqueda-solventes');
    $("#busqueda").removeClass('busqueda-solventes');

    $("#busqueda").removeClass("desactivar");
    $("#btn-busqueda").removeClass('desactivar');

    $('#btn-busqueda').removeClass('btn-busqueda-empresas');
    $("#busqueda").removeClass('busqueda-empresas');

    $('#btn-busqueda').addClass('btn-busqueda-acti-com');
    $("#busqueda").addClass('busqueda-acti-com');

    $("#busqueda").val('');
    $("#busqueda").focus();

    validacionActividadesComerciales();
    listadoActividadesComerciales();
}

function listadoActividadesComerciales(busqueda = ""){
    if(busqueda === ""){
        datos = {criterio: "ListadoCompleto"};
    }else{
        datos = {
                    criterio: "ListadoCompleto",
                    busqueda: busqueda
                };
    }
    $.ajax({
      url: 'modulos/actividades_comerciales.php',
      type: 'GET',
      data: datos
    })
    .done(function(response){
      let activ_com = JSON.parse(response);
      let template = "";
      if(activ_com !== 0){
        activ_com.forEach(ac => {
          if(ac.codigo != 0){
            template += `
                <div class="fila-h2 borde-abajo-2p-blanco">
                        <div class="cod_ac column-3-12 txt-uf20">${ac.codigo}</div>
                        <div class="des_ac column-6-12 txt-mf20 scrolleable">${ac.nombre}</div>
                        <div class="column-1m-12 caja-btn-icono">
                            <a href="#" class="modificar-acticom btn-icon-verde" title="Modificar Datos">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                        <div class="column-1m-12 caja-btn-icono">
                            <a href="#" class="eliminar-acticom btn-icon-rojo" title="Eliminar">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                `
            }
        });
      }else{
        template += `<div class="avisar_nada">¡No se ha encontrado ningún resultado!</div>`
      }

      $(".cuerpo-tabla").html(template);
    })
    .fail(function() {
      console.log("error");
    });   
}
/****************   FIN DE LAS FUNCIONES DE LAS ACTIVIDADES COMERCIALES ************/