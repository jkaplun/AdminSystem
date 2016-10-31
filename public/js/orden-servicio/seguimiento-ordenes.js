$(document).ready(function() { 
  $('#dataTable-seguimientoOrdenes').DataTable({
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
          }
        }
    });
}); // end  $(document).ready(function() { 

$(document).ready(function(){
	$("#pagination a").click(function(){
		var page = $(this).attr('data-page');
		//alert('pushado'+page+'-'+n_rows);
		$("#filtroform").append('<input type="hidden" name="page" value="'+page+'" id="page">').trigger("submit");
	});

});
