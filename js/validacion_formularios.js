// JavaScript Document
//FUNCION QUE SACA EL CUADRO DE DIALOGO DE LA ADVERTENCIA DE VALIDACION.

let fecha_actual = new Date();
let patron_telefono = /^([0]){1}([2|4]){1}([\d]){1}([\d]){1}([-]){1}([\d]){7}$/;
let patron_rif = /^([V|E|P|G|J|C]){1}([-]){1}([0-9]){9}$/;
let patron_cedula = /^([V|E]){1}([-]){1}([0-9]){7,8}$/;
var patron_decimales = /^([0-9]){1,9}([.]){1}([0-9]){2}$/;

//SI TIPO ES:
/*
	1 -> Vacio.
	2 -> Patron o Vacio.
	3 -> Fecha o Vacio.
	4 -> Longitud o Vacio.
*/
function Validaciones(tipo,campo,contenedor,texto_advertencia,patron="",long_min=6,long_max=200,maximo=0){
	$(document).on("input change",campo,function(){
		switch(tipo){
			case 1:
				if(!CampoVacio(campo)){
					advertenciaEnfocada(contenedor,campo,texto_advertencia);
				}else{
					quitar_advertencia(contenedor);
				}
			break;

			case 2:
				if(!CampoPatron(campo,patron) || !CampoVacio(campo)){
					advertenciaEnfocada(contenedor,campo,texto_advertencia);
				}else{
					quitar_advertencia(contenedor);
				}
			break;

			case 3:
				if(!CampoFechaActual(campo) || !CampoVacio(campo)){
					advertenciaEnfocada(contenedor,campo,texto_advertencia);
				}else{
					quitar_advertencia(contenedor);
				}
			break;

			case 4:
				if(!LongitudCampo(campo,long_min,long_max) || !CampoVacio(campo)){
					advertenciaEnfocada(contenedor,campo,texto_advertencia);
				}else{
					quitar_advertencia(contenedor);
				}
			break;

			case 5:
				if(!LongitudCampo(campo,long_min,long_max) || !validacionMayorQue(campo,maximo) || !CampoVacio(campo)){
					advertenciaEnfocada(contenedor,campo,texto_advertencia);
				}else{
					quitar_advertencia(contenedor);
				}
			break;

			case 6:
				if(!LongitudCampo(campo,long_min,long_max) || !validacionMayorQue(campo,maximo) || !CampoVacio(campo) || !CampoPatron(campo,patron) ){
					advertenciaEnfocada(contenedor,campo,texto_advertencia);
				}else{
					quitar_advertencia(contenedor);
				}
			break;
		}
	});
}

function ValidacionesCheck(campo,contenedor,texto_advertencia){
	$(document).on("click",campo,function(){
		if(!checkRadioBox(campo)){
			advertenciaEnfocada(contenedor,campo,texto_advertencia);
		}else{
			quitar_advertencia(contenedor);
		}
	});
}

/*
	Buscador: 
	en -> empresa nombre
	er -> empresa rif
	pc -> propietario cedula
	pr -> propietario rif
	act_com -> actividad_comercial
*/
function ValidacionEncontrar(campo,buscador,contenedor,texto_advertencia){
	$(document).on("keyup",campo,function(){
		let valor = $(this).val();
		let datos = {valor,buscador};
		$.ajax({
            url: "modulos/buscador.php",
            type: "POST",
            data: datos,
            success: function(response){
            	if(response == 1){
            		advertenciaEnfocada(contenedor,campo,texto_advertencia,1);
            	}
            }
        });
	});
}

function validacionMayorQue(campo,maximo){
	var val = parseFloat($(campo).val());
	if(val > maximo){
		return false;
	}else{
		return true;
	}
}

function PosicionCaracterCampo(campo,caracter,posicion_anterior){
	$(document).on("keyup",campo,function(e){
		let tecla = (e.keyCode ? e.keyCode : e.which);
		let valor = $(campo).val();
	    if(valor.length === posicion_anterior && tecla !== 8){
	       $(campo).val(valor+caracter);
	    }
	});
}

function ActivarBoton(boton){
	$(boton).removeClass("desactivar");
}

function DesactivarBoton(boton){
	$(boton).addClass('desactivar');
}

function CampoVacio(campo){
	let valor = $(campo).val();
	if(valor === "" || valor === 0 || valor === "0"){
		return false;
	}else{
		return true;
	}
}

function CampoPatron(campo,patron){
	let valor = $(campo).val();
	if(!patron.test(valor)){
		return false;
	}else{
		return true;
	}
}

function CampoFechaActual(campo){
	let valor = $(campo).val();
    let valor_format = new Date(valor);

    if(valor_format > fecha_actual){
        return false;
    }else{
    	return true;
    }
}

function LongitudCampo(campo, longitud_minima=6,longitud_maxima=200){
	let valor = $(campo).val();
	let tam = valor.length;
	if(tam >= longitud_minima && tam <= longitud_maxima){
		return true;
	}else{
		return false;
	}
}

function checkRadioBox(nameRadioBox) {
	return $(nameRadioBox).is(":checked") ? true : false;
}

function checkSelect(idSelect) {
	return (($(idSelect).val() !== "") || ($(idSelect).val() !== 0)) ? true : false;
}

function soloLetras(campo){
	var patron =/[A-Za-z\s]/;
	$(document).on("keypress",campo,function(e){
		var tecla = e.key;
		if (tecla=="Backspace"){
			return true;
		}
		if(!patron.test(tecla)){
			e.preventDefault();
		}
	});
}

function soloNumeros(campo){
	var patron =/^[0-9]$/;
	$(document).on("keypress",campo,function(e){
		var tecla = e.key;
		if (tecla=="Backspace"){
			return true;
		}
		if(!patron.test(tecla)){
			e.preventDefault();
		}
	});
}

function mayusculasCampo(campo){
	$(document).on("keyup",campo,function(){
    	$(campo).val($(campo).val().toUpperCase());
	});
}

function minusculasCampo(campo){
	$(document).on("keyup",campo,function(){
		$(campo).val($(campo).val().toLowerCase());
	});
}

function validacion_formulario_empresa(){         
    //EMPRESA:
    //validacion para nombre.
    Validaciones(4,"#nombre_empresa-form","#caja_nomemp","Introduzca el Nombre de la Empresa. Maximo 25 caracteres, Minimo 6. ¡ES OBLIGATORIO!","",6,25);
    ValidacionEncontrar("#nombre_empresa-form",'en',"#caja_nomemp","¡El nombre de esta empresa ya esta registrado en el sistema!");
                
    //validacion para rif.
    mayusculasCampo("#rif_empresa-form");
    PosicionCaracterCampo("#rif_empresa-form","-",1);
    Validaciones(2,"#rif_empresa-form","#caja_rifemp","No debe dejarlo vacio. Formato: [V | E | P | G | J | C]-123456789. ¡ES OBLIGATORIO!",patron_rif);
    ValidacionEncontrar("#rif_empresa-form",'er',"#caja_rifemp","El Rif de esta empresa ya esta registrado. ¡No debe de existir otro igual!");

    //validacion para codigo de comercio.
    Validaciones(4,"#cod_comercio-form","#caja_codcomemp","Ingrese el Codigo del Registro o Comercio de la Empresa. ¡ES OBLIGATORIO!","",8,20);

    //validacion para telefono de la empresa.
    Validaciones(2,"#telefono_empresa-form","#caja_telemp","Formato Incorrecto, Ingrese Valores. Ej: 0271-6638765. ¡ES OBLIGATORIO!",patron_telefono);
    soloNumeros("#telefono_empresa-form");
    PosicionCaracterCampo("#telefono_empresa-form","-",4);

    //validacion del campo fecha del registro.
    Validaciones(3,"#registro_empresa-form","#caja_fecregemp","La fecha no debe exceder a la actual, Ingrese una fecha valida!. ¡ES OBLIGATORIO!");

    //validacion de la parroquia de la dirección.
    Validaciones(1,"#parroquia-empresa-form","#caja_paremp","Debe elegir la parroquia, para proseguir. ¡ES OBLIGATORIO!");

    //validacion del detalle de la dirección.
    Validaciones(4,"#deta_dir_empresa-form","#caja_detdiremp","Coloque detalladamente, El Sector - Calle - Numero o Nombre de Casa, Referencia. ¡ES OBLIGATORIO!","",25,200);

    //validacion de la actividad comercial.
    Validaciones(1,"#actividad_comercial-form","#caja_actcomemp","Elija la Actividad Comercial pertinente de la Empresa. ¡ES OBLIGATORIO!");

    //PROPIETARIO:
    //validacion del nombre.
    Validaciones(4,"#nombre_propietario-form","#caja_nomprop","Ingrese el o los nombres del Propietario. ¡ES OBLIGATORIO!","",3,30);

    //validacion del apellido.
    Validaciones(4,"#apellido_propietario-form","#caja_apeprop","Ingrese el o los apellidos del Propietario. ¡ES OBLIGATORIO!","",4,30);
                
    //validacion de la cedula.
    mayusculasCampo("#cedula_propietario-form");
    PosicionCaracterCampo("#cedula_propietario-form","-",1);
    Validaciones(2,"#cedula_propietario-form","#caja_cedprop","No debe dejarlo vacio. Formato: [V | E]-12345678. ¡ES OBLIGATORIO!",patron_cedula);
    ValidacionEncontrar("#cedula_propietario-form",'pc',"#caja_cedprop","¡Este propietario ya existe en el sistema!");
                
    //validacion del rif.
    mayusculasCampo("#rif_propietario-form");
    PosicionCaracterCampo("#rif_propietario-form","-",1);
    Validaciones(2,"#rif_propietario-form","#caja_rifprop","No debe dejarlo vacio. Formato: [V | E | P | G | J | C]-123456789. ¡ES OBLIGATORIO!",patron_rif);
    ValidacionEncontrar("#rif_propietario-form",'pr',"#caja_rifprop","¡Este propietario ya existe en el sistema!");

    //validacion del estado de la dirección.
    Validaciones(1,"#estado_propietario-form","#caja_estprop","Debe elegir el estado, para proseguir. ¡ES OBLIGATORIO!");

    //validacion del municipio.
    Validaciones(1,"#municipio_propietario-form","#caja_munprop","Debe elegir el municipio, para proseguir. ¡ES OBLIGATORIO!");

    //validacion de la parroquia.
    Validaciones(1,"#parroquia-propietario-form","#caja_parprop","Debe elegir la parroquia, para proseguir. ¡ES OBLIGATORIO!");

    //validacion del detalle de la dirección.
    Validaciones(4,"#deta_dir_persona-form","#caja_detdirper","Coloque detalladamente, El Sector - Calle - Numero o Nombre de Casa, Referencia. ¡ES OBLIGATORIO!","",25,200);

    //validacion para telefono.
    Validaciones(2,"#telefono_propietarioForm","#caja_telefono","Formato Incorrecto, Ingrese Valores. Ej: 0414-7638765. ¡ES OBLIGATORIO!",patron_telefono);
    soloNumeros("#telefono_propietarioForm");
    PosicionCaracterCampo("#telefono_propietarioForm","-",4);
}

function validacion_formulario_persona(){         
    
    Validaciones(4,"#nombre_persona-form","#caja_nompers","Introduzca el Nombre de la Persona. Maximo 20 caracteres, Minimo 6. ¡ES OBLIGATORIO!","",3,20);
       
    Validaciones(4,"#apellido_persona-form","#caja_apepers","Introduzca el Apellido de la Persona. Maximo 25 caracteres, Minimo 6. ¡ES OBLIGATORIO!","",4,25);
                
    //validacion de la cedula.
    mayusculasCampo("#cedula_persona-form");
    PosicionCaracterCampo("#cedula_persona-form","-",1);
    Validaciones(2,"#cedula_persona-form","#caja_cedpers","No debe dejarlo vacio. Formato: [V | E]-12345678. ¡ES OBLIGATORIO!",patron_cedula);
    ValidacionEncontrar("#cedula_persona-form",'pc',"#caja_cedpers","¡Este propietario ya existe en el sistema!");
                
    //validacion del rif.
    mayusculasCampo("#rif_persona-form");
    PosicionCaracterCampo("#rif_persona-form","-",1);
    Validaciones(2,"#rif_persona-form","#caja_rifpers","No debe dejarlo vacio. Formato: [V | E | P | G | J | C]-123456789. ¡ES OBLIGATORIO!",patron_rif);
    ValidacionEncontrar("#rif_persona-form",'pr',"#caja_rifpers","¡Esta persona ya existe en el sistema!");

    //validacion de la parroquia.
    Validaciones(1,"#parroquia-persona-form","#caja_parpers","Debe elegir la parroquia, para proseguir. ¡ES OBLIGATORIO!");

    //validacion del detalle de la dirección.
    Validaciones(4,"#deta_dir_persona-form","#caja_detdirpers","Coloque detalladamente, El Sector - Calle - Numero o Nombre de Casa, Referencia. ¡ES OBLIGATORIO!","",25,200);

    //validacion para telefono.
    Validaciones(2,"#telefono_personaForm","#caja_telpers","Formato Incorrecto, Ingrese Valores. Ej: 0414-7638765. ¡ES OBLIGATORIO!",patron_telefono);
    soloNumeros("#telefono_personaForm");
    PosicionCaracterCampo("#telefono_personaForm","-",4);
}

function validacionFechas(){
    //validacion del año del Desde.
    Validaciones(1,".select-year-desde",".contenedor-ad","Si ha seleccionado el Check Desde Elija el Año. ¡Es Obligatorio!");
    //validacion del mes del Desde.
    Validaciones(1,".select-mes-desde",".contenedor-md","Si ha seleccionado el Check Desde Elija el Mes respectivo. ¡Es Obligatorio!");
    //validacion del año del Hasta.
    Validaciones(1,".select-year-hasta",".contenedor-ah","Si ha seleccionado el Check Hasta Elija el Año. ¡Es Obligatorio!");
    //validacion del mes del Hasta.
    Validaciones(1,".select-mes-hasta",".contenedor-mh","Si ha seleccionado el Check Hasta Elija el Mes respectivo. ¡Es Obligatorio!");
}

function validacionActividadesComerciales(){
    Validaciones(4,"#cod_acti_com","#contenedor_cod-act-com","No debe estar Vacio o Debe tener al menos 5 Digítos.","",5,12);
    ValidacionEncontrar("#cod_acti_com","act_com","#contenedor_cod-act-com","El Código debe ser único, Este ya esta Registrado.");
    soloNumeros("#cod_acti_com");
            
    Validaciones(4,"#desc_act_com","#contenedor_desc-acti-com","No debe estar Vacio o sobre pasar los 140 Caracteres.","",10,140);
}