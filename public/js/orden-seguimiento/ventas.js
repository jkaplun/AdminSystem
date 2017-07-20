/**
 * 
 */
function editarLlamada( obj , id ) {
	console.log('editar');
	// Disable #x
	$( "#motivo_"+ id ).prop( "disabled", false );
	$( "#solucion_"+ id ).prop( "disabled", false );
	$( obj ).prop( "disabled", true );
	$( "#button-guardar-"+id ).prop( "disabled", false );
}
	
	
function guardarLlamada( obj , id ) {
	 
	$( "#motivo_"+ id ).prop( "disabled", true );
	$( "#solucion_"+ id ).prop( "disabled", true );
	$( obj ).prop( "disabled", true );
	$( "#button-editar-"+id ).prop( "disabled", false );

	$.ajax({
		  method: "post",
		  url: "public/orden-seguimiento/edita-llamada",
		  data: {
			  id_orden_ventas : id,
			  motivo :  $( "#motivo_"+ id ).val(),
			  solucion : $( "#solucion_"+ id ).val()
		  },
		  dataType: "json"
		})  .done(function(msg) {
			$( "#llamada-"+ id ).removeClass('bg-info');
			$( "#estatus-label-"+ id ).html(' Atendida');			
		  })
		  .fail(function() {
			   alert( "error" );
		  })
		  .always(function() {

		  });

}

function borrarLlamada( obj , id ) {
	
	swal({
		  title: "¿Confirma que va a eliminar la llamada?",
		  text: '',
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Si",
		  cancelButtonText: "No",
		  closeOnConfirm: true
		},
		function(){
			
	    	blockUI();
	    	
	    	$.ajax({
	    		  method: "post",
	    		  url: "public/orden-seguimiento/borrar-llamada",
	    		  data: {
	    			  id_orden_ventas : id
	    		  },
	    		  dataType: "json"
	    		})  .done(function(msg) {
	    			
	    			$( "#llamada-"+ id ).remove();
	    			
	    			
			          swal({title: "Confirmación",   
				           text: "El registro ha sido borrado exitosamente.", 
				           type: "success",   
				           timer: 2800,   
				           showConfirmButton: false
				          });
	    			
	    		  })
	    		  .fail(function() {
	    			
	    		  })
	    		  .always(function() {

	    		  });
		  
		});
	
}

$(document).ready(function() {


$("#pagination a").click(function(){
    var page = $(this).attr('data-page');
    //alert('pushado'+page+'-'+n_rows);
    $("#filtroform").append('<input type="hidden" name="page" value="'+page+'" id="page">').trigger("submit");
  });

});


$(function() {
    $('input[name="daterange"]').daterangepicker({ 
    	autoUpdateInput: false,
        locale: {
        format: 'YYYY-MM-DD'},
	    "applyLabel": "Aplicar",
	    "cancelLabel": "Limpiar",
	    "fromLabel": "De",
	    "toLabel": "Hasta",
	    "customRangeLabel": "Custom",
	    "daysOfWeek": [
	        "Do",
	        "Lu",
	        "Ma",
	        "Mi",
	        "Ju",
	        "Vi",
	        "Sa"
	    ],
	    "monthNames": [
	        "Enero",
	        "Febrero",
	        "Marzo",
	        "Abril",
	        "Mayo",
	        "Junio",
	        "Julio",
	        "Agusto",
	        "Septiembre",
	        "Octubre",
	        "Noviembre",
	        "Diciembre"
	    ]
    }, function(start, end, label) {

       // console.log("New date range selected: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
		$("#fecha_de").val(start.format('YYYY-MM-DD'));
		$("#fecha_hasta").val(end.format('YYYY-MM-DD'));

      
    });

    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
		$("#fecha_de").val('');
		$("#fecha_hasta").val('');
        
        $(this).val('');
        
    });
    
    
});