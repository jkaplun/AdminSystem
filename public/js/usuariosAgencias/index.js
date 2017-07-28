//ruta para el controlador de usuarioAgencia 
var pathUsuarioAgenciaController="public/usuarios-agencia/"; 
var usuariosAgencias={};
var seAgregoNuevoUsuario=false;
var idUsuarioAgenciaToEdit;

// accion que se realiza en el ajax, esta se define en 
// datosform_edita_usuario_agencia() -> 'actualiza' 
// datosform_edita_usuario_agencia() -> 'actualiza' 
var ajaxActionUsuarioAgencia="consultar"; 

//Variable donde se almacena el id que asigna la base de datos al usuario 
var id_usuario_agencia=""; 
var claveUsuarioAgencia="";
 
 
$(document).ready(function() { 
 
  $("#agregarUsuarioAgenciaBtn").click(function(){
	  $("#edita_usr_age_id_agencia").val(idAgenciaActual);
	  abrirModalAgregarUsuario(); 
  }) 
 
 }); // end  $(document).ready(function() { 
 
 
 
function submitFormUsuarioAgencia(){ 
  $.ajax({
      url: pathUsuarioAgenciaController + ajaxActionUsuarioAgencia, 
      method: "post", 
      data: $("#formUsuarioAgencia").serialize(),
      dataType: "json" 
    })
    .done(function(res) {
    	if (res.estado == 'error'){
    		 swal("Error :(", res.descripcion, "error" ); 
    	} else {
    		$('#nuevoUsuarioModal').modal('hide')
    		mostrarUsuariosAgencia();
    	}
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" ); 
  }); 
} // submitForm(){ 
  
 
function agregarUsuarioAgenciaEnTabla(res){ 
	$("#dataTable-usuarios-agencias").empty();
	$.each( res , function( index, value ) {
        
		 usuariosAgencias[value.id_usuario_agencia]=value;
		
		var boton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#nuevoUsuarioModal" value='+ value.id_usuario_agencia +   
        ' onclick="datosform_edita_usuario_agencia(this.value)" >' +  // 
        '<i class="fa fa-pencil-square-o"></i>'+  
        '</button>';   
        
		$("#dataTable-usuarios-agencias").append(
		"<tr><td>"+ value.cve_user + "</td>"+
		"<td>" + value.pwd + "</td>" +
		"<td>" + value.nombre + " " + value.apellidos + "</td>" +
		"<td>" + value.email + "</td>" +
		"<td>" + value.telefono + "</td>" +
		"<td>" + value.puesto + "</td>" +
		"<td>" + boton + "</td>" +

		"</tr>"
		
		);
	});
	
	
	
} // end function agregarUsuarioAgenciaEnTabla(res){ 
 
 
function agregarUsuarioAgenciaAjaxDone(res){ 
  if(res.estado == "ok"){ // si la respuesta es correcta: 
        //console.log(res);  
        seAgregoNuevoUsuario=true;
 
      agregarUsuarioAgenciaEnTabla(res, 0); 
       usuariosAgencias[Object.keys(usuariosAgencias).length + 1] = res;
      swal("el usuario de la agencia ha sido guardado exitosamente", " ", "success");  
 
   } else{ 
     swal(res.descripcion, " ", "error");  
     } 
} // end agregarAjaxDone() 
 
 
 
function actualizarUsuarioAgenciaAjaxDone(res){ 
  //var userTable = $('#dataTable-usuarios').DataTable();

 
  if(res.estado == "ok"){ 

    agregarUsuarioAgenciaEnTabla(res, 0); 
   

    swal("el usuario de la agencia ha sido actualizado exitosamente", " ", "success"); 
 
  }else{ 
    swal(res.descripcion, " ", "error"); 
  } 
   
  //dataTable.row('.selected').remove().draw( false ); 
   
 
} 
 
 
 function datosform_edita_usuario_agencia(frontEndId){ 
   //alert("no es necesario llenar los campos, se simulan los datos desde un JSON en el public/js/usuariosagencia/index.js ")
	 
	 
	 //$( "#claveUsuarioAgencia" ).prop( "disabled", true );
   ajaxActionUsuarioAgencia="actualizar"; 
   //console.log("ajaxActionUsuarioAgencia "+ajaxActionUsuarioAgencia); 

   idUsuarioAgenciaToEdit=frontEndId;
   //console.log("usuariosAgencias[frontEndId]: "+usuariosAgencias[frontEndId]);
   id_usuario_agencia = usuariosAgencias[frontEndId].id_usuario_agencia;

   	$("#edita_id_user").val(frontEndId);
   
    populateUsuarioAgenciaForm(usuariosAgencias[frontEndId ]);
      
 } 
 
 function abrirModalAgregarUsuario(){ 
  //$('#myModalLabel').html("Agregar Usuario"); 
  document.getElementById("formUsuarioAgencia").reset(); 

  ajaxActionUsuarioAgencia="agregar";
   
} 

function mostrarUsuariosAgencia(){
	usuariosAgencias={};

	$.ajax({
		url: pathUsuarioAgenciaController+"consultar", 
      	method: "post", 
      	data: {
    	  'id_agencia' : idAgenciaActual
      	},
      	dataType: "json" 
    }) 
    	.done(function(res) {  
    		agregarUsuarioAgenciaEnTabla(res);
    })// end ajax done  
    	.fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
    }); 
}

function populateUsuarioAgenciaForm(data) {  
    //console.log("populating form"); 

    $.each(data, function(key, value){
    		
    	if(key == "cve_user"){
    		$("#cve_user_agencia").val(value);
    	}
      if(key == "nombre"){
          $("#nombreUsuarioAgencia").val(value);
      } else if(key == "email"){
        $("#emailUsuarioAgencia").val(value);
      }else if(key == "clave"){
        //console.log("populating clave:"+value);
         claveUsuarioAgencia="&claveUsuarioAgencia="+value;
        $("#claveUsuarioAgencia").val(value);
      }else{
      //console.log("key: "+key + " value: " +value);
      $("#"+key).val(value);
      }
    });
}



