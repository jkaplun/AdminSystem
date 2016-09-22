/**
 * javascript for UsuariosController
 */

function datosform_edita_usuario(json_values){
	
	console.log(json_values);
	var obj = jQuery.parseJSON( json_values );
	$('#myModalLabel').html(obj.nombre+' '+obj.apellido_paterno +' - '+ obj.clave);
	
	$('#edita_nombre_real').val(realname);
	$('#edita_rol').val(id_rol);
	$('#edita_id_user').val(id_user);
	$('#edita_activo').val(activo);
	
}

function populate(frm, data) {   
    $.each(data, function(key, value){  
    var $ctrl = $('[name='+key+']', frm);  
    switch($ctrl.attr("type"))  
    {  
        case "text" :   
        case "hidden":  
        $ctrl.val(value);   
        break;   
        case "radio" : case "checkbox":   
        $ctrl.each(function(){
           if($(this).attr('value') == value) {  $(this).attr("checked",value); } });   
        break;  
        default:
        $ctrl.val(value); 
    }  
    });  
}

function submitForm(){
	
	var newpass = $.trim($('#edita_password').val());
	var confirmpass = $.trim($('#edita_passwordConfirm').val());
	
	if (newpass != '' ){
		if ( newpass.length >= 6 ){
			if ( newpass == confirmpass){
				$("#formedituser").submit();
			} else {
				alert('Los passwords no coinciden.');
			}
		} else {
			alert ("El password debe de contener minimo 6 caracteres.");
		}
		
	} else {
		$("#formedituser").submit();
	}
}


function submitFormNewUser(){
	
	var newpass = $.trim($('#password').val());
	var confirmpass = $.trim($('#passwordConfirm').val());
	
	if ( newpass.length >= 6 ){
		if ( newpass == confirmpass){
			$("#formnewuser").submit();
		} else {
			alert('Los passwords no coinciden.');
		}
	} else {
		alert ("El password debe de contener minimo 6 caracteres.");
	}

}

function abrirModalAgregarUsuario(){
	$('#myModalLabel').html("Agregar Usuario");
}

$(document).ready(function() {
    $('#dataTable-usuarios').DataTable({
        responsive: true,
        "language":{
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "NingÃºn dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			    "sFirst":    "Primero",
			    "sLast":     "Ãšltimo",
			    "sNext":     "Siguiente",
			    "sPrevious": "Anterior"
			},
			"oAria": {
			    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		}

    });
});