var path="public/agencias/";
var idAgenciaActual;
var actualizarVistas = {"vistaAgencia":false, "vistaUsuarioAgencia":false, "vistaPoliza":false};

$(document).ready(function() {


	$("#emailUsuarioAgencia").keyup(function () {
        var value = $(this).val();
        $("#claveUsuarioAgencia").val(value);
    });
	

    $('#dataTable-usuarios-agencias,#dataTable-productos').DataTable({
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
		},
        "bSort": false
    
    });

	// cuando se eliga una agencia de la lista se llama a la función cunslutar agencia
	$("#select_agencias").change(function(){
		selectAgenciaChange();
	});

	$( "#tipo" ).change(function() {
		openPolizaModal();
		updateFechaFin();
	});
	
	$( "#fecha_ini" ).change(function() {
		updateFechaFin();
	});
	
	$( "#fecha_fin" ).change(function() {
		//$("#fecha_fin_servicio").val($("#fecha_fin").val());
		if( ajaxActionPoliza == 'agregar' ){
			$("#fecha_fin_servicio").datepicker("update", $("#fecha_fin").val());	
		}
		
	});
	
}); // end  $(document).ready(function() {

function selectAgenciaChange(){
	blockUI();
	
	idAgenciaActual =$("#select_agencias").val();
	consultarAgencia(idAgenciaActual);

	actualizarVistas.vistaUsuarioAgencia=false;
	var tableUsuariosAgencias = $('#dataTable-usuarios-agencias').DataTable();
	var tablePolizas = $('#dataTable-polizas-vigentes').DataTable();
	var productoTable = $('#dataTable-productos-adquiridos').DataTable();

	tableUsuariosAgencias.clear().draw();
	tablePolizas.clear().draw();
	productoTable.clear().draw();

	// limpiar select producto de polizas
	$('#producto').empty();

	// mostrar información correspondiente a esa agencia
 	mostrarUsuariosAgencia();   //usuarioagencia/index.js
 	mostrarPolizas(); 			//polizas/index.js
 	mostrarProductosEnTabla();  //productos/index.js
 	mostrarFolios();
 	productosSelectAgencia();
    actualizarVistas.vistaUsuarioAgencia =true;
}

function updateFechaFin(){
	var fecha = $("#fecha_ini").val();
	var res = fecha.split("-");
	var anio = res[0];

	if (fecha != '') {
		if($("#tipo").val() == "G"){
			var d = new Date( parseInt(anio) , (res[1]-1), (parseInt(res[2]) + 60));
		} else if($("#tipo").val() == "X"){
			var d = new Date( parseInt(anio) , (res[1]-1), (parseInt(res[2]) + 15));
		} else {
			var aniomasuno = parseInt(anio) +1 ;
			var d = new Date( aniomasuno , (res[1]-1), res[2]);
		}
		$("#fecha_fin").datepicker("update",d);
	}
}

function openPolizaModal(){
	var horas = $("#tipo_poliza_"+$("#tipo").val()).val();
	$("#horas_poliza").val( horas );	
	var tipo = $( "#tipo" ).val();
	//console.log(tipo);
	if( tipo == "G" || tipo == "X"  ){
		$("#div-costo-poliza").hide();
		$("#costo_poliza").val("");
	} else {
		$("#div-costo-poliza").show();
	}
	$("#div-id-poliza-estatus").hide();
}

function abrirModalAgregarAgencia(){
	$('#myModalLabel').html("Crear Nueva Agencia");
	document.getElementById("form_agregar_agencia").reset();
	$("#action-form-agencia").attr('onclick','submitFormAddAgencia()');

}

function abrirModalEditarAgencia(){
	$('#myModalLabel').html("Editar Datos de la Agencia");
	$("#action-form-agencia").attr('onclick','submitFormUpdateAgencia()');
	idAgenciaActual =$("#select_agencias").val();
	consultarAgencia(idAgenciaActual);
}

function submitFormAddAgencia(){
	//console.log("parametros a mandar: ");
	//console.log($("#form_agregar_agencia").serialize());
	$.ajax({
		  url: path + "agregar",
		  method: "post",
		  data: $("#form_agregar_agencia").serialize() ,
		  dataType: "json"
		})
		.done(function(res) { 

			if(res.estado =="ok"){
				swal({title: res.descripcion,   
					 text: "Redireccionando . .", 
					 type: "success",   
					 timer: 2800,   
					 showConfirmButton: false
					});

				setTimeout(function(){location.reload();}, 3000);
				
			}else{
				swal(res.estado, res.descripcion,"error");
			}
			
  })// end ajax done 
		.fail(function() {
    	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
  });
} // submitForm(){

function submitFormUpdateAgencia(){
	//console.log("parametros a mandar: ");
	//console.log($("#form_agregar_agencia").serialize());
	$.ajax({
		  url: path + "actualizar",
		  method: "post",
		  data: $("#form_agregar_agencia").serialize() ,
		  dataType: "json"
		})
		.done(function(res) { 

			if(res.estado =="ok"){
				swal({title: res.descripcion,   
					 text: "Redireccionando . .", 
					 type: "success",   
					 timer: 2800,   
					 showConfirmButton: false
					});

				setTimeout(function(){location.reload();}, 3000);
				
			}else{
				swal(res.estado, res.descripcion,"error");
			}
			
  })// end ajax done 
		.fail(function() {
    	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
  });
} // submitForm

function submitFormUpdateObservaciones(){
	//console.log("parametros a mandar: ");
	//console.log("observaciones=" + $("#observaciones_agencia").text());
	$.ajax({
		  url: path + "observaciones",
		  method: "post",
		  data:{
			  id_agencia: idAgenciaActual,
			  observaciones : $("#observaciones_agencia").val() ,
			  observaciones_internas : $("#observaciones_internas").val() ,
				},
		  dataType: "json"
		})
		.done(function(res) { 
			if(res.estado =="ok"){
				swal({title: res.descripcion,   
					 type: "success",   
					 timer: 2800,   
					 showConfirmButton: false
					});
			}else{
				swal(res.estado, res.descripcion,"error");
			}
  })// end ajax done 
		.fail(function() {
    	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
  });
} // submitForm

function consultarAgencia(id_agencia){
	$.ajax({
		  url: path + "consultar",
		  method: "post",
		  data: "id_agencia="+id_agencia,
		  dataType: "json"
		})
		.done(function(res) {		
			mostarDatosAgencia(res);
			mostrarDatosDeConexiones(res.conexiones)
			editarAgenciaForm(res);
			mostrarActualizaciones(res.actualizaciones)
  })// end ajax done 
		.fail(function() {
    	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
  });
	
}

// Se muestran los datos de la gencia
function mostarDatosAgencia(datosAgencia){
	//var datosAgencia = jQuery.parseJSON( datosAgencia );

	//jQuery.parseJSON( datosAgencia );
	//console.log("actulizando datos agencia");
	$("#nombre_agencia-info").html(datosAgencia.nombre);
	$("#direccion-info").html(datosAgencia.direccion);
	$("#telefono1-info").html(datosAgencia.tel1);
	$("#telefono2-info").html(datosAgencia.tel2);
	$("#cve_usopor_tit-info").html(datosAgencia.cve_usopor_tit);
	$("#cve_usopor_aux-info").html(datosAgencia.cve_usopor_aux);
	$("#rfc-info").html(datosAgencia.rfc);
	$("#prov_timbrado-info").html(datosAgencia.prov_timbrado);
	$("#facturacion_boleto-info").html(datosAgencia.facturacion_boleto);
	$("#boton-editar-agencia").val(datosAgencia);
	$("#datos-agencia").show();
 	$("#observaciones_agencia").val(datosAgencia.observaciones );
 	$("#observaciones_internas").val(datosAgencia.observaciones_internas );
 	$("#cfdi").val(datosAgencia.cfdi);
 	$("#prov_timbrado").val(datosAgencia.prov_timbrado);
 	$("#id_agencia_folios").val(datosAgencia.id_agencia);
 	

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

 	var q=encodeURIComponent(datosAgencia.direccion);
    $('#map').attr('src',
            'https://www.google.com/maps/embed/v1/place?key=AIzaSyCkxg35_4QHr8ev1erQ9hU5uGnRGL-y49U&q='+q);
	
};

function editarAgenciaForm(json_values){
	$('#myModalLabel').html("Editar Datos de la Agencia");
	var obj = json_values ;
	populate(obj);
	$("#action-form-agencia").attr('onclick','submitFormUpdateAgencia()');
}

function populate(data) {   
    $.each(data, function(key, value){  
    	$("#"+key).val(value);
    });
}


function abrirModalAgregarFolios(){
	//console.log('Agregar Folio');
	$("#folios_comprados").val(""); 
	$("#fecha_compra_folios").val("");
	$("#observaciones_folios").val("");
	$("#modalLabelFolios").html("Agregar Folios");
	$("#submitAgregarFolios").show();
	$("#submitEditarFolios").hide();

}

function abrirModalEditarFolios(id_folios_agencia,fecha_compra,folios_comprados,observaciones){
	//console.log('Agregar Folio');
	$("#id_folios_agencia_form").val(id_folios_agencia); 
	$("#folios_comprados").val(folios_comprados);
	$("#fecha_compra_folios").datepicker("update", fecha_compra);
	$("#observaciones_folios").val(observaciones);
	$("#modalLabelFolios").html("Editar Folios");
	$("#submitEditarFolios").show();
	$("#submitAgregarFolios").hide();
}



function submitAgregarFolios(){

	var valoresForm =  $("#form-agregar-folios-agencia").serialize();
	$.ajax({
		  url: path + "agregarfolios",
		  method: "post",
		  data: valoresForm,
		  dataType: "json"
		})
		.done(function(res) { 
			if (res.error=='1'){
				var msg = res.folios_comprados + ' ' + res.fecha_compra_folios;
				
				swal("Error :(", msg , "error" );
				
			} else {
				
				$('#AgregarFolios').modal('hide');
			    swal("Los folios se agregaron exitosamente", " ", "success");  
			    mostrarFolios();
			}
})// end ajax done 
		.fail(function() {
  	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
});
}



function mostrarFolios(){

	 var addIdAgencia="id_agencia="+idAgenciaActual;
	 $.ajax({ 
	      url: path+"obtienefoliosagencia", 
	      method: "post", 
	      data: addIdAgencia,
	      dataType: "json" 
	    }) 
	    .done(function(res) {  
	    	$( "#body-tabla-folios" ).html("");
	    	$.each( res, function( key, value ) {
	    		  var obs = value.observaciones;
	    		  $( "#body-tabla-folios" ).append( '<tr id="idUsuarioAgenciaRow1" class="odd" role="row">' +
	    		  		
	    		  		"<td>"+ value.id_folios_agencia +"</td>" +
	    		  		"<td>"+ value.fecha_compra +"</td>" +
	    		  		"<td>"+ value.folios_comprados +"</td>" +
	    		  		"<td>"+ value.observaciones +"</td>" +
	    		  		"<td>"+ value.descripcion +"</td>" +
	    		  		"<td><button class='btn btn-primary btn-sm btn-circle' type='button' data-toggle='modal' data-target='#AgregarFolios' value='1' " +
	    		  		'onclick=\'abrirModalEditarFolios("'+value.id_folios_agencia+'","'+ value.fecha_compra +'","'+ value.folios_comprados +'","'+ obs +'")\'' +
	    		  				"><i class='fa fa-info-circle'></i></button></td></tr>");
	    		});

	  })// end ajax done  
	    .fail(function() { 
	      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
	  }); 
	}


function submitEditarFolios(){

	var valoresForm =  $("#form-agregar-folios-agencia").serialize();
	//console.log(valoresForm);
	$.ajax({
		  url: path + "editarfolios",
		  method: "post",
		  data: valoresForm,
		  dataType: "json"
		})
		.done(function(res) { 
			if (res.error=='1'){
				var msg = res.folios_comprados + ' ' + res.fecha_compra_folios;
				
				swal("Error :(", msg , "error" );
				
			} else {
				
				$('#AgregarFolios').modal('hide');
			    swal("Los folios se editaron exitosamente", " ", "success");  
			    mostrarFolios();
			}
	})// end ajax done 
			.fail(function() {
	  	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
	});
}

function saveFEConfig(){
	console.log(idAgenciaActual);
	$.ajax({
		  url: path + "configfolios?id_agencia="+idAgenciaActual,
		  method: "post",
		  data: $("#config-CFDI-Pack").serialize(),
		  dataType: "json"
		})
		.done(function(res) { 
			if (res.success == true) {
				 swal("Guardado", " ", "success"); 
			} else {
				 swal("Hubo un error", " ", "error"); 
			}
	})// end ajax done 
			.fail(function() {
				swal("Error en la conexión.", " ", "error"); 
	});
	
}

function agregarConexion() {
	
	if ( $("#nombre_bd").val()=='' ) {
		alert('Se requiere el nombre de la Base de Datos.');
		return;
	}
	
	var id_agencia = idAgenciaActual;
	$.ajax({
			url: path + "agregar-datos-conexion",
		  	method: "post",
		  	dataType: "json",
		  	data: {
			  "nombre_bd" : $("#nombre_bd").val(),
			  "host" : $("#host").val(),
			  "puerto" : $("#puerto").val(),
			  "data_source_name" : $("#data_source_name").val(),
			  "observaciones_conexion" : $("#observaciones_conexion").val(),
			  "id_producto" : $("#id_producto_d_c").val(),
			  "id_agencia" : id_agencia }
			  
		})
		.done(function(res) { 
			if (res.success == true) {
				 swal("Guardado", " ", "success"); 
				  $("#nombre_bd").val("");
				  $("#host").val("");
				  $("#puerto").val("");
				  $("#data_source_name").val("");
				  $("#observaciones_conexion").val("");
				  $("#id_producto_d_c").val(3);
			} else {
				 swal("Hubo un error", " ", "error"); 
			}
			consultaDatosConexion(id_agencia);
	})// end ajax done 
			.fail(function() {
				swal("Error en la conexión.", " ", "error"); 
	});
	
}

function consultaDatosConexion(id_agencia){
	
	$.ajax({
		url: path + "consultar-datos-conexion",
	  	method: "post",
	  	dataType: "json",
	  	data: {
		  "id_agencia" : id_agencia }
		  
	})
	.done(function(res) { 
		//console.log(res.conexiones);
		mostrarDatosDeConexiones(res.conexiones)
	})// end ajax done 
			.fail(function() {
				swal("Error en la conexión.", " ", "error"); 
	});

}

/**
 * Recive un json con las conexiones
 */
function mostrarDatosDeConexiones(conexiones){

	$("#datos-de-conexiones").empty();
    $.each(conexiones, function(key, value){
    	$("#datos-de-conexiones").append(
    			"<tr><td>"+value.id_agencia_conexion_datos+"</td>" +
    			"<td>"+value.nombre_prod+"</td>" +
    			"<td>"+value.nombre_bd+"</td>" +
    			"<td>"+value.host+"</td>" +
    			"<td>"+value.puerto+"</td>" +
    			"<td>"+value.data_source_name+"</td>" +
    			"<td>"+value.observaciones_conexion+"</td>" +
    			'<td>' +
    			"<button type='button' class='btn btn-default btn-xs' onclick='editarDatosDeConexion(\""+value.id_agencia_conexion_datos + 
    			'","'+value.nombre_bd+
    			'","'+value.id_producto+
    			'","'+value.host+
    			'","'+value.puerto+
    			'","'+value.data_source_name+
    			'","'+value.observaciones_conexion+
    			'")\'>Editar</button>' +
    			'<button type="button" class="btn btn-default btn-xs" onclick="eliminarDatosDeConexion('+value.id_agencia_conexion_datos+')">Eliminar</button></td></tr>');
    });
    
    if ( conexiones.length < 10) {
    	$("#form-agregar-conexion").show();
    } else {
    	$("#form-agregar-conexion").hide();
    }

	$("#div-edita-conexion").hide();
	$("#div-agrega-conexion").show();
}

function eliminarDatosDeConexion(id_agencia_conexion_datos){
	$.ajax({
		url: path + "eliminar-datos-conexion",
	  	method: "post",
	  	dataType: "json",
	  	data: {
		  "id_agencia_conexion_datos" : id_agencia_conexion_datos ,
		  "id_agencia" : idAgenciaActual }
	})
	.done(function(res) { 
		//console.log(res.conexiones);
		mostrarDatosDeConexiones(res.conexiones)
	})// end ajax done 
			.fail(function() {
				swal("Error en la conexión.", " ", "error"); 
	});
}


function editarDatosDeConexion( id_agencia_conexion_datos , nombre_bd , id_producto , host , puerto , data_source_name , observaciones_conexion){
	
//	console.log( id_agencia_conexion_datos +"-"+ nombre_bd +"-"+ id_producto +"-"+ host +"-"+ puerto +"-"+ data_source_name +"-"+ observaciones_conexion);
	
	$("#nombre_bd").val(nombre_bd);
	$("#host").val(host);
	$("#puerto").val(puerto);
	$("#data_source_name").val(data_source_name);
	$("#observaciones_conexion").val(observaciones_conexion);
	$("#id_producto_d_c").val(id_producto);
	$("#id_agencia_conexion_datos").val(id_agencia_conexion_datos);
	
	$("#div-edita-conexion").show();
	$("#div-agrega-conexion").hide();
	$("#form-agregar-conexion").show();
} 

function cancelarActualizarConexion(){
	$("#nombre_bd").val("");
	$("#host").val("");
	$("#puerto").val("");
	$("#data_source_name").val("");
	$("#observaciones_conexion").val("");
	$("#id_producto_d_c").val(3);
	$("#div-edita-conexion").hide();
	$("#div-agrega-conexion").show();
	consultaDatosConexion(idAgenciaActual);
}

function actualizarConexion() {
	
	if ( $("#nombre_bd").val()=='' ) {
		alert('Se requiere el nombre de la Base de Datos.');
		return;
	}
	
	var id_agencia = idAgenciaActual;
	$.ajax({
			url: path + "actualizar-datos-conexion",
		  	method: "post",
		  	dataType: "json",
		  	data: {
			  "nombre_bd" : $("#nombre_bd").val(),
			  "host" : $("#host").val(),
			  "puerto" : $("#puerto").val(),
			  "data_source_name" : $("#data_source_name").val(),
			  "observaciones_conexion" : $("#observaciones_conexion").val(),
			  "id_producto" : $("#id_producto_d_c").val(),
			  "id_agencia_conexion_datos" : $("#id_agencia_conexion_datos").val(),
			  "id_agencia" : id_agencia }
			  
		})
		.done(function(res) { 
			if (res.success == true) {
				 swal("Guardado", " ", "success"); 
				  $("#nombre_bd").val("");
				  $("#host").val("");
				  $("#puerto").val("");
				  $("#data_source_name").val("");
				  $("#observaciones_conexion").val("");
				  $("#id_producto_d_c").val(3);
			} else {
				 swal("Hubo un error", " ", "error"); 
			}
			consultaDatosConexion(id_agencia);
	})// end ajax done 
			.fail(function() {
				swal("Error en la conexión.", " ", "error"); 
	});

}

/*
 * 
 * 
 */
function mostrarActualizaciones(actualizaciones){
	$("#tabla-actualizaciones").empty();
    $.each(actualizaciones, function(key, value){
    	$("#tabla-actualizaciones").append(
    			"<tr><td>"+value.id_update+"</td>" +
    			"<td>"+value.nombre+"</td>" +
    			"<td>"+value.nombre_prod+"</td>" +
    			"<td>"+value.nombre_usuario_solicita+"</td>" +
    			"<td>"+value.fecha_solicitud+"</td>" +
    			"<td>"+value.fecha_cierre+"</td>" +
    			"<td>"+value.nombre_usuario_cierra+"</td>" +
    			"<td>"+value.version_update+"</td>" +
    			"<td>"+value.archivo_update+"</td>" +
    			"<td>"+value.descripcion+"</td>" +
    			'</tr>');
    });
}

