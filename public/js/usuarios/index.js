/**
 * javascript for UsuariosController
 */

// en esta variable (ajaxAction) se almacena la url a la que accederá la petición AJAX, 
// se le asigna un valor dentro de las siguientes fuciones:
// - datosform_edita_usuario(json_values) -> actualizar
// - abrirModalAgregarUsuario -> agregar
var ajaxAction;

var dataTable;

//Variable donde se almacena el id que asigna la base de datos al usuario
var idDataBaseUser="";


var path="public/usuarios/";
//var urlAgregr= "public/usuarios/agregar";
//var urlEditar= "public/usuarios/actualizar";




function datosform_edita_usuario(json_values){
	ajaxAction="actualizar";
	var obj = jQuery.parseJSON( json_values );
	//$("#"+obj.id_usuario).addClass('selected');
	idDataBaseUser =obj.id_usuario;
	$('#myModalLabel').html(obj.nombre+' '+obj.apellido_paterno +' - '+ obj.clave);
	 
	populate(obj);

	
}

function populate(data) {   
    $.each(data, function(key, value){  
    	$("#"+key).val(value);
    });
}

function submitForm(){
	//var form = $("#formnewuser").serialize() ;
	var addIdDataBaseParameter="";

	if(ajaxAction=="actualizar"){
		addIdDataBaseParameter="&id_usuario="+idDataBaseUser;

	}
	console.log("parametros a mandar: ");
	console.log($("#formedituser").serialize() + addIdDataBaseParameter );
	$.ajax({
		  url: path + ajaxAction,
		  method: "post",
		  data: $("#formedituser").serialize() + addIdDataBaseParameter ,
		  dataType: "json"
		})
		.done(function(res) { 

		if (ajaxAction == "agregar"){
			agregarAjaxDone(res);
		}else{
			actualizarAjaxDone(res);
		}



  })// end ajax done 
		.fail(function() {
    	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
  });

} //end submitForm()


function submitFormNewUser(){
	
	var newpass = $.trim($('#password').val());
	var confirmpass = $.trim($('#passwordConfirm').val());
	
	if ( newpass.length >= 6 ){
		if ( newpass == confirmpass){
			$("#formnewuser").submit();
		} else {
			swal('Los passwords no coinciden.', " ","error");
		}
	} else {
		swal ("El password debe de contener minimo 6 caracteres.", " ", "error");
	}

}

function abrirModalAgregarUsuario(){
	$('#myModalLabel').html("Agregar Usuario");
	document.getElementById("formedituser").reset();
	ajaxAction="agregar";

}


function agregarAjaxDone(res){
	if(res.estado == "ok"){ // si la respuesta es correcta:
	      console.log(res); 

			agregarUsuarioEnTabla(res);
			swal("el usuario ha sido guardado exitosamente", " ", "success"); 

 	} else{
 		swal(res.descripcion, " ", "error"); 
 		}
} // end agregarAjaxDone()



function actualizarAjaxDone(res){
	//var userTable = $('#dataTable-usuarios').DataTable();  

	if(res.estado == "ok"){
		agregarUsuarioEnTabla(res);
		swal("el usuario ha sido actualizado exitosamente", " ", "success");

	}else{
		swal(res.descripcion, " ", "error");
	}
	
	//dataTable.row('.selected').remove().draw( false );
	

}


function agregarUsuarioEnTabla(res){

	      idDataBaseUser=res.id_usuario;
	      var userTable = $('#dataTable-usuarios').DataTable();  
	      var estatusUsuario;
	      var info = userTable.page.info();


	      if(res.activo == "S"){
	      	estatusUsuario="Activo";
	      } else{
	      	estatusUsuario="Inactivo";
	      }


	      var nombreCompleto= res.nombre+" "+ res.apellido_paterno+ " " + res.apellido_materno; 
	      // se agrega la nueva columna a la tabla 
	      userTable.row.add( [ 
	        res.id_usuario, res.clave, nombreCompleto, estatusUsuario,  res.email, "x" 
	        ]).draw();

	      var boton = '<button type="button" class="btn btn-primary btn-sm btn-circle" data-toggle="modal" data-target="#myModal" value=' + JSON.stringify(res) +  
	      ' onclick="datosform_edita_usuario(this.value)">' +  
	      '<i class="fa fa-info-circle"></i>'+ 
	      '</button>'  
	 

	      if(ajaxAction=="agregar"){
	      userTable.page( 'last' ).draw( 'page' ); 

	      $('#dataTable-usuarios tr:last-child td:last-child').html(boton); 
	      $('#dataTable-usuarios tr:last-child td:last-child').attr('id', "editarBtn"+res.id_usuario);
	      $("#editarBtn"+res.id_usuario).closest('tr').attr('id', res.id_usuario);

	  	  }else{

	  	  	 userTable.page(info.page).draw( 'page' ); 

	  	  	$("#"+res.id_usuario).closest('tr').next('tr').attr('id', res.id_usuario);;
	  	  	//$("#"+res.id_usuario)
	  	  	dataTable.row('#'+res.id_usuario).remove().draw( false );
	  	  	$("#"+res.id_usuario + " td:last-child").html(boton);


	  	  	if (!$("#"+res.id_usuario).length){ // es el último elemento en la tabla
	  	  	   	//alert("ultimoElemento")
	  	  	   	$('#dataTable-usuarios tr:last-child td:last-child').html(boton); 
	  	  	}
	  	  	

	  	  }

	  		


	       
	       $('#myModal').modal('toggle'); 

}


$(document).ready(function() {
    dataTable = $('#dataTable-usuarios').DataTable({
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

    }); // end     $('#dataTable-usuarios').DataTable({





});// end $(document).ready(function() {