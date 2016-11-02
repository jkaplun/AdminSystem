var pathAgencias="public/agencias/";
var pathPolizaController="public/polizas/"; 
var pathProductoController="public/productos/"; 
var idAgenciaActual;
var productos_todos={};
var actualizarVistas = {"vistaDatos":false, "vistaServicio":false};



$(document).ready(function() { 

    $('#dataTable-polizas-vigentes').DataTable({
        responsive: true,
        "language":{
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ning&uacute;n dato disponible en esta tabla",
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
			    "sLast":     "&Uacute;timo",
			    "sNext":     "Siguiente",
			    "sPrevious": "Anterior"
			},
			"oAria": {
			    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		}
    });


	// cuando se eliga una agencia de la lista se llama a la función cunslutar agencia
	$("#select_agencias").change(function(){
		idAgenciaActual =$("#select_agencias").val();
		consultarAgencia(idAgenciaActual);

		actualizarVistas.vistaUsuarioAgencia=false;
		var tablePolizas = $('#dataTable-polizas-vigentes').DataTable();
		tablePolizas.clear().draw();
		mostrarProductos();
		mostrarPolizas();
	 	//mostrarProductosEnTabla();
        actualizarVistas.vistaUsuarioAgencia =true;
	});

}); // end  $(document).ready(function() { 

function consultarAgencia(id_agencia){
	$.ajax({
		url: pathAgencias + "consultar",
		method: "post",
		data: "id_agencia="+id_agencia,
		dataType: "html"
	})
	.done(function(res) { 
		console.log(res);	
		mostarDatosAgencia(res);
  	})// end ajax done 
		.fail(function() {
    	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
  	});
}

// Se muestran los datos de la gencia
function mostarDatosAgencia(datosAgencia){
	var datosAgencia = jQuery.parseJSON( datosAgencia );

	$("#nombre_agencia-info").html(datosAgencia.nombre);
	$("#direccion-info").html(datosAgencia.direccion);
	$("#telefono1-info").html(datosAgencia.tel1);
	$("#telefono2-info").html(datosAgencia.tel2);
	
 	$("#observaciones_agencia-info").html(datosAgencia.observaciones);

 	if(datosAgencia.tel1 != null && datosAgencia.tel1.length != 0){
 		$("#telefono1-info").html(datosAgencia.tel1);
 		$('#te1').show();
 	}else{
 		$('#te1').hide();
 	}
 	if(datosAgencia.tel2 != null && datosAgencia.tel2.length != 0){
 		$("#telefono2-info").html(datosAgencia.tel2);
 		$('#te2').show();
 	}else{
 		$('#te2').hide();
 	}
 	
 	if(datosAgencia.email != null && datosAgencia.email.length != 0){
 		$("#correo1-info").html(datosAgencia.email);
 		$('#co1').show();
 	}else{
 		$('#co1').hide();
 	}
 	if(datosAgencia.email_alt != null && datosAgencia.email_alt.length != 0){
 		$("#correo2-info").html(datosAgencia.email_alt);
 		$('#co2').show();
 	}else{
 		$('#co2').hide();
 	}

	$("#datos-agencia").show();
};

function mostrarPolizas(){
	polizas={};
  	ajaxActionPoliza="consultar"
 	var addIdAgencia="id_agencia="+idAgenciaActual;
 	$.ajax({ 
		url: pathPolizaController+"consultar", 
		method: "post", 
		data: addIdAgencia,
		dataType: "json" 
    }) 
    .done(function(res) {  
    	var i=0;
		//pruebaMostrarUsuarios(res, i);
		for (i;i<res.length;i++){
			polizas[res[i].id_poliza]=res[i];
			agregarPolizaEnTabla(res[i]);
		}
   		//$(".frontEndIdColumn").hide();
  		//console.log("polizas despues de consulta");
  		//console.log(polizas);
  	})// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  	}); 
}

function mostrarProductos(){

  productos_todos={};
  ajaxActionProducto="consultarproductos"
  //var addIdAgencia="id_agencia="+idAgenciaActual;
 $.ajax({ 
      url: pathProductoController+ajaxActionProducto, 
      method: "post", 
      //data: addIdAgencia,
      dataType: "json" 
    }) 
    .done(function(res) {  
      var i=0;
      for (i;i<res.length;i++){
        if(res[i].vigente_prod=="S"){
        	productos_todos[res[i].id_producto]=res[i];
        }
      }
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  }); 
}


function agregarPolizaEnTabla(res){ 
	// console.log("entrando a agregarUsuarioAgenciaEnTabla"); 
	// var frontEndId = Object.keys(polizas).length + 1; 
	var polizaTable = $('#dataTable-polizas-vigentes').DataTable();   
	var estatusUsuario; 
	var info = polizaTable.page.info(); 

	if(res.estatus == "ACT"){ 
		estadoPoliza="Activa"; 
	} else if (res.estatus == "ADE"){ 
		estadoPoliza="Adeudo"; 
	} else if (res.estatus == "BLQ"){ 
		estadoPoliza="Bloqueado"; 
	} else{
		estadoPoliza="Cancelado";
	}
	//  ACT - Activo
	// ADE - Adeudo
	// BLQ - Bloqueado
	// CAN - Cancelado

	res.descripcion=""; 

	var nombre_producto_poliza="";
	var clave_producto_poliza="";
	if ($(productos_todos[res.id_producto]).length){
		nombre_producto_poliza=productos_todos[res.id_producto].nombre_prod
	}else{
		nombre_producto_poliza="no vigente"
	}

	var id_poliza_row = "idPolizaRow"+res.id_poliza;
	// borrar despues 

	//console.log("productos_todos[res.id_producto].nombre_prod: "+productos_todos[res.id_producto].nombre_prod);
	polizaTable.row.add( [  
		res.id_poliza, res.clave, nombre_producto_poliza, res.horas_poliza, '0', res.costo_poliza, res.fecha_ini, res.fecha_fin, estadoPoliza
	]).draw(); 

	polizaTable.page( 'last' ).draw( 'page' );  


	$('#dataTable-polizas-vigentes tr:last-child td:first-child').attr('class', 'frontEndIdPoliza'); 
	$('#dataTable-polizas-vigentes tr:last-child td:first-child').css('background-color', 'red');  
	$('#dataTable-polizas-vigentes tr:last-child td:last-child').attr('id', "editarPolizaBtn"+res.id_poliza); 
	//$('#dataTable-polizas-vigentes tr:last-child td:last-child').attr('class', "frontEndIdPoliza"); 
	$("#editarPolizaBtn"+res.id_poliza).closest('tr').attr('id', id_poliza_row); 

	

	// ocultar front-end-id
	$(".frontEndIdPoliza").hide();  

} // end function agregarUsuarioAgenciaEnTabla(res){ 