$(document).ready(function(){
	$("#pagination a").click(function(){
		var page = $(this).attr('data-page');
		//alert('pushado'+page+'-'+n_rows);
		$("#filtroformusers").append('<input type="hidden" name="page" value="'+page+'" id="page">').trigger("submit");
	});
});


function datosform_edita_usuario(id_user,username,realname,activo,id_rol){
	$('#myModalLabel').html(username+' - '+realname);
	
	$('#edita_nombre_real').val(realname);
	$('#edita_rol').val(id_rol);
	$('#edita_id_user').val(id_user);
	$('#edita_activo').val(activo);
	
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

