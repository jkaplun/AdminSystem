var path="public/agencias/";

$(document).ready(function() {
    $('#dataTable-usuarios-agencias').DataTable({
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
		consultarAgencia($("#select_agencias").val());
	});

	soloNumeros('cp');
	soloNumeros('lic_icaavwin');
	soloNumeros('lic_iriswin');
	soloNumeros('lic_gvc');
	soloNumeros('lic_centauro');

	soloLetrasNumeros('nombre')
	soloLetrasNumeros('nombre_comercial')
	soloLetrasNumeros('direccion')

	soloLetras('colonia');
	soloLetras('nombre');

	soloLetrasDot('nombre_comercial');



}); // end  $(document).ready(function() {

function abrirModalAgregarAgencia(){
	$('#myModalLabel').html("Crear Nueva Agencia");
	
	$("#action-form-agencia").attr('onclick','submitFormAddAgencia()');

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
} // submitForm(){


function consultarAgencia(id_agencia){
	$.ajax({
		  url: path + "consultar",
		  method: "post",
		  data: "id_agencia="+id_agencia,
		  dataType: "html"
		})
		.done(function(res) { 
			console.log(res);	
			//$("#boton-editar-agencia").val(res);
			mostarDatosAgencia(res);
  })// end ajax done 
		.fail(function() {
    	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
  });
	
	$.ajax({
		  url: path + "consultar",
		  method: "post",
		  data: "id_agencia="+id_agencia,
		  dataType: "html"
		})
		.done(function(res) { 
			console.log(res);	
			$("#boton-editar-agencia").val(res);
			//mostarDatosAgencia(res);
	})// end ajax done 
			.fail(function() {
	  	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
	});
}

// Se muestran los datos de la gencia
function mostarDatosAgencia(datosAgencia){
	var datosAgencia = jQuery.parseJSON( datosAgencia );

	//jQuery.parseJSON( datosAgencia );
	//console.log("actulizando datos agencia");
	$("#nombre_agencia-info").html(datosAgencia.nombre);
	$("#direccion-info").html(datosAgencia.direccion);
	$("#telefono1-info").html(datosAgencia.tel1);
	$("#telefono2-info").html(datosAgencia.tel2);
	$("#cve_usopor_tit-info").html(datosAgencia.cve_usopor_tit);
	$("#cve_usopor_aux-info").html(datosAgencia.cve_usopor_aux);
	$("#rfc-info").html(datosAgencia.rfc);
	$("#id_estatus_icaav-info").html(datosAgencia.id_estatus_icaav);
	$("#id_estatus_iris-info").html(datosAgencia.id_estatus_iris);
	$("#factura_electronica-info").html(datosAgencia.factura_electronica);
	$("#agencias_consolidadas-info").html(datosAgencia.agencias_consolidadas);
	$("#markup-info").html(datosAgencia.markup);
	$("#contabilidad_elect-info").html(datosAgencia.contabilidad_elect);
	$("#ine-info").html(datosAgencia.ine);
	$("#lic_icaavwin-info").val(datosAgencia.lic_icaavwin);
	$("#lic_iriswin-info").val(datosAgencia.lic_iriswin);
	$("#lic_centauro-info").val(datosAgencia.lic_centauro);
	$("#lic_gvc-info").val(datosAgencia.lic_gvc);
	$("#cfdi-info").html(datosAgencia.cfdi);
	$("#prov_timbrado-info").html(datosAgencia.prov_timbrado);
	$("#bolet_e-info").html(datosAgencia.boleto_e);
	$("#facturacion_boleto-info").html(datosAgencia.facturacion_boleto);
	$("#boton-editar-agencia").val(datosAgencia);
	$("#datos-agencia").show();

	
};

function editarAgenciaForm(json_values){
	$('#myModalLabel').html("Editar Datos de la Agencia");
	var obj = jQuery.parseJSON( json_values );
	populate(obj);
	$("#action-form-agencia").attr('onclick','submitFormUpdateAgencia()');
}

function populate(data) {   
    $.each(data, function(key, value){  
    	$("#"+key).val(value);
    });
}
