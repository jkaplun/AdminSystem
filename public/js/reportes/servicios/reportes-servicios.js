var pathReportesController="public/reporteServicios/"; 
var idAgenciaActual;


var actualizarVistas = {"vistaDatos":false, "vistaServicio":false};

$(document).ready(function() { 

    $('#dataTable-servicios-clientes').DataTable({
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
		//consultarAgencia(idAgenciaActual);
		//console.log("idAgenciaActual: "+idAgenciaActual);

		actualizarVistas.vistaUsuarioAgencia=false;
		var tableReporte = $('#dataTable-servicios-clientes').DataTable();
		tableReporte.clear().draw();
    if (window.location.href.indexOf("reporte-servicios-clientes") > -1) {
      mostrarReporte("agencia");
    }else if(window.location.href.indexOf("reporte-servicios-ejecutivos") > -1){
      mostrarReporte("ejecutivo");
    }
		actualizarVistas.vistaUsuarioAgencia =true;
	});

}); // end  $(document).ready(function() { 

function mostrarReporte(tipo){
  var addIdAgencia;
  var path;
  var verficar;
  if(tipo=="agencia"){
    path=pathReportesController+"consultar-reporte-servicios-agencia";
    addIdAgencia="id_agencia="+idAgenciaActual;
    verficar=true;
  }else if(tipo=="ejecutivo"){
    path=pathReportesController+"consultar-reporte-servicios-ejecutivo";
    addIdAgencia="id_ejecutivo="+idAgenciaActual;
    verficar=false;
  }
  ordenes={};
  ajaxActionPoliza="consultar";
  $.ajax({ 
    url: path, 
    method: "post", 
    data: addIdAgencia,
    dataType: "json" 
    }) 
    .done(function(res) {  
      var i=0;
      for (i;i<res.length;i++){
        ordenes[res[i].id_poliza]=res[i];
        agregarEnTabla(res[i],verficar);
      }
      //$(".frontEndIdColumn").hide();
      //console.log("polizas despues de consulta");
      //console.log(polizas);
    })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
    }); 
}

function agregarEnTabla(res,op){ 
	var reporteTable = $('#dataTable-servicios-clientes').DataTable();   
  if(op){
	 reporteTable.row.add( [
        res.id_orden_servicio,res.producto,res.fecha_alta,res.fecha_cierre,res.duracion_servicio,res.nombre_usuario+res.apellidos_usuario,res.nombre_atiende+" "+res.apellido_paterno,res.conformidad
  ]).draw(); 
  }else{
    reporteTable.row.add( [
        res.id_orden_servicio,res.producto,res.fecha_alta,res.fecha_cierre,res.duracion_servicio,res.nombre_usuario+res.apellidos_usuario,res.nombre_agencia,res.conformidad

  ]).draw(); 
  }
	reporteTable.page( 'last' ).draw( 'page' );  
} // end function agregarUsuarioAgenciaEnTabla(res){ 


///////