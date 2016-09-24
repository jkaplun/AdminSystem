var path="public/agencias/";

$(document).ready(function() {
    $('#dataTable-agencias').DataTable({
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



}); // end  $(document).ready(function() {

function abrirModalAgregarAgencia(){
	$('#myModalLabel').html("Agregar Agencia");
}


function submitForm(){
	console.log("parametros a mandar: ");
	console.log($("#form_agregar_agencia").serialize());
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


function consultarAgencia(id_agencia){
	$.ajax({
		  url: path + "consultar",
		  method: "post",
		  data: "id_agencia="+id_agencia,
		  dataType: "json"
		})
		.done(function(res) { 
			console.log(res);	
			mostarDatosAgencia(res);
			//datos_agencia = res;	
  })// end ajax done 
		.fail(function() {
    	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
  });
}

// Se muestran los datos de la gencia
function mostarDatosAgencia(datosAgencia){
	console.log("actulizando datos agencia");

	$("#nombre_agencia").html(datosAgencia.nombre);
	$("#direccion").html(datosAgencia.direccion);
	$("#telefono1").html(datosAgencia.tel1);
	$("#telefono2").html(datosAgencia.tel2);
	$("#cve_usopor_tit").html(datosAgencia.cve_usopor_tit);
	$("#cve_usopor_aux").html(datosAgencia.cve_usopor_aux);
	$("#rfc").html(datosAgencia.rfc);
	$("#id_estatus_icaav").html(datosAgencia.id_estatus_icaav);
	$("#id_estatus_iris").html(datosAgencia.id_estatus_iris);
	$("#factura_electronica").html(datosAgencia.factura_electronica);
	$("#agencias_consolidadas").html(datosAgencia.agencias_consolidadas);
	$("#markup").html(datosAgencia.markup);
	$("#contabilidad_elect").html(datosAgencia.contabilidad_elect);
	$("#ine").html(datosAgencia.ine);

	$("#lic_icaavwin").val(datosAgencia.lic_icaavwin);
	$("#lic_iriswin").val(datosAgencia.lic_iriswin);
	$("#lic_centauro").val(datosAgencia.lic_centauro);
	$("#lic_gvc").val(datosAgencia.lic_gvc);
	$("#cfdi").html(datosAgencia.cfdi);
	$("#prov_timbrado").html(datosAgencia.prov_timbrado);
	$("#bolet_e").html(datosAgencia.boleto_e);
	$("#facturacion_boleto").html(datosAgencia.facturacion_boleto);
	


};

