var pathReportesController="public/reporte-agencias/"; 
var actualizarVistas = {"vistaDatos":false, "vistaServicio":false};

$(document).ready(function() {
    mostrarProductosEnSelect();

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

}); // end  $(document).ready(function() { 

function agregarEnTabla(res){ 
	var reporteTable = $('#dataTable-agencias').DataTable();   
  	reporteTable.row.add( [
    	res.id_agencia,res.clave,res.nombre,res.direccion+" Col. "+res.colonia,res.cp,res.clave_ciudad,res.tel1,res.email
  	]).draw(); 
	reporteTable.page( 'last' ).draw( 'page' );  
} // end function agregarUsuarioAgenciaEnTabla(res){ 


function submitFormBusquedaAgencia(){
	actualizarVistas.vistaUsuarioAgencia=false;
	var tableReporte = $('#dataTable-agencias').DataTable();
	tableReporte.clear().draw();
	var lic= new Array($("#licencias").val());
	//console.log("parametros a mandar: ");
	//console.log($("#form_agregar_agencia").serialize());
	//alert($("#licencias option:selected").text());
	//alert($("#licencias").val());
	//alert(lic);
	//alert($("#form-busqueda-agencia").serialize());
	$.ajax({
		  url: pathReportesController + "consulta-avanzada",
		  method: "post",
		  data: $("#form-busqueda-agencia").serialize()+"&lice="+lic,
		  dataType: "json"
		})
		.done(function(res) {
			if(res=="No"){
				swal({
				  title: "Agencia no Encontrada",
				  text: "No se encontró ninguna agencia con esos parámetros.",
				  // timer: 5000,
				  // showConfirmButton: false,
				  type: "warning"
				});
			}else{
				console.log("Paco");
				console.log(res);
			      var i=0;
			      for (i;i<res.length;i++){
			        agregarEnTabla(res[i]);
			      }
			}
			//swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
  		})
		.fail(function() {
    	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
  	});
	actualizarVistas.vistaUsuarioAgencia =true;
} // submitForm(){

function mostrarProductosEnSelect(){
  	productos_todos={};
  	ajaxActionProducto="public/productos/consultarproductos"

	$.ajax({ 
		url: ajaxActionProducto, 
	  	method: "post", 
	  	dataType: "json" 
	}) 
	.done(function(res) {  
		var i=0;
	  	for (i;i<res.length;i++){
	    	productos_todos[res[i].id_producto]=res[i];
	    	$('#licencias').append($('<option>').text(res[i].nombre_prod)
	      	.attr('value', res[i].id_producto)
		    //.attr('id', "id_producto_"+res[i].id_producto)
	      	// .attr('class',"productSelect")
	      	);
	  	}
		$('#licencias').multiSelect();
	})// end ajax done  
	.fail(function() { 
	  swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
	}); 
}


