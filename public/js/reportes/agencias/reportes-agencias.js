var pathReportesController="public/reporteAgencias/"; 
var idAgenciaActual;


var actualizarVistas = {"vistaDatos":false, "vistaServicio":false};

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
		idAgenciaActual =$("#select_agencias").val();
		//consultarAgencia(idAgenciaActual);
		//console.log("idAgenciaActual: "+idAgenciaActual);

		actualizarVistas.vistaUsuarioAgencia=false;
		var tableReporte = $('#dataTable-agencias').DataTable();
		tableReporte.clear().draw();
    //alert(window.location.href.indexOf("reporte-agencias-productos"));
    if (window.location.href.indexOf("reporte-agencias-productos") > -1) {
      mostrarReporte("productos");
    }else if(window.location.href.indexOf("reporte-agencias-poliza") > -1){
      mostrarReporte("polizas");
    }
		actualizarVistas.vistaUsuarioAgencia =true;
	});

}); // end  $(document).ready(function() { 

function mostrarReporte(tipo){
  var addIdAgencia;
  var path;
  var verficar;
  if(tipo=="productos"){
    path=pathReportesController+"consultar-reporte-agencia-productos";
    addIdAgencia="id_producto="+idAgenciaActual;
    verficar=true;
  }else if(tipo=="polizas"){
    path=pathReportesController+"consultar-reporte-agencia-polizas";
    addIdAgencia="id_poliza="+idAgenciaActual;
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
	var reporteTable = $('#dataTable-agencias').DataTable();   
  // if(op){
	 // reporteTable.row.add( [
  //       res.id_agencia,res.clave,res.nombre,res.cp,res.clave_ciudad,res.tel1,res.email
  // ]).draw(); 
  // }else{
  //   reporteTable.row.add( [
  //       res.id_orden_servicio,res.producto,res.fecha_alta,res.fecha_cierre,res.duracion_servicio,res.nombre_usuario+res.apellidos_usuario,res.nombre_agencia,'Pots'

  // ]).draw(); 
  // }
  reporteTable.row.add( [
        res.id_agencia,res.clave,res.nombre,res.direccion+" Col. "+res.colonia,res.cp,res.clave_ciudad,res.tel1,res.email
  ]).draw(); 
	reporteTable.page( 'last' ).draw( 'page' );  
} // end function agregarUsuarioAgenciaEnTabla(res){ 


///////