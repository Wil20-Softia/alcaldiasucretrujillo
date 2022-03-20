$(document).ready(function(){
  //Para verificar si el Objeto JQuery funciona bien.
  console.log("Archivo core.js Funcionando");
  onEvents();
  /*SECCION QUE SE EJECUTARÁ DE PRIMERO AL CARGARSE LA PAGINA.*/
  $("#seccion_impresion").addClass("pd-ssm");
  $("#seccion_impresion").html(template_index);
  searching = 1;
  parroquias();
  paginacion_empresa();
  $("#busqueda").attr("placeholder","Rif");
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
  $("#busqueda").val('');
  $("#busqueda").focus();

  //AL HACER CLICK SOBRE EL ENLACE INICIO SE 
  //REINICIA LA PAGINA Y SE IMPRIME EL TEMPLATE PRINCIPAL.
  $(document).on("click","#inicio", function(){
    modificar = 0;
    searching = 1;
    onEvents();
    inicio();
  });

  $(document).on("click","#nueva_empresa", function(){
    modificar = 0;
    formNuevaEmpresa();
  });

  $(document).on("click","#nueva_persona",function(){
    modificar_per = 0;
    formNuevaPersona();
  });

  $(document).on("click","#deudores",function(){
    searching = 2;
    onEvents();
    seccionDeudores();
  });

  $(document).on("click","#solventes",function(){
    searching = 3;
    onEvents();
    seccionSolventes();
  });

  $(document).on("click","#facturaciones",seccion_facturaciones);

  $(document).on("click","#facturacion",function(){
    formularioFacturaciones();
  });

  $(document).on("click","#manual",function(){
    window.open("modulos/pdf/manual_usuario.php","Manual_de_Usuario.pdf","width=1250px, height=700px, left=80px, top=0px");
  });

  $(document).on("click","#actividad_comercial",seccion_ActividadComercial);

  $(document).on("click","#respaldo",function(){
    location.href="config/backups.php";
  });
}); // AQUI FINALIZA EL OBJETO JQUERY.