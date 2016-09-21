/**
 * javascript for UsuariosController
 */

function datosform_edita_usuario(json_values){
	
	console.log(json_values);
	var obj = jQuery.parseJSON( json_values );
	$('#myModalLabel').html(obj.nombre+' '+obj.apellido_paterno +' - '+ obj.clave);
	 
	populate('formedituser',obj);

	
}

function populate(frm, data) {   
    $.each(data, function(key, value){  
    	$("#"+key).val(value);
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