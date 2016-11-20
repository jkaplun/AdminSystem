var pathAgencias="public/agencias/";
var pathPolizaController="public/polizas/"; 
var pathProductoController="public/productos/"; 
var pathUsuarioAgenciaController="public/usuariosAgencia/"; 
var pathOrdenServicioController="public/ordenCreacion/"
var idAgenciaActual;
var idMotivo;
var productos_todos={};

//$('input[name=name_of_your_radiobutton]:checked').val();

//console.log("loading nueva orden")
//var datosAgenciaSeleccionada={};
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
});
