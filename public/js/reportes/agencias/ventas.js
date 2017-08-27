/**
 * 
 */

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
    
    $( "#fecha_base" ).change(function() {
    	//console.log("cambio");
    	var singleValues = $( "#fecha_base" ).val();
    	  if (singleValues=="0") {
    	    	//console.log("si cero " + fecha_base);
    		  $("#daterange").val("");
    		  $("#fecha_de").val("");
    		  $("#fecha_hasta").val("");
    		  $("#daterange").attr("disabled",true);
    	  }
    	  
    	  if (singleValues!=0) {
    		  //console.log("no cero " + fecha_base);
    		  $("#daterange").attr("disabled",false);
    	  }

    	});
	var singleValues = $( "#fecha_base" ).val();
	  if (singleValues=="0") {
	    	//console.log("si cero " + fecha_base);
		  $("#daterange").val("");
		  $("#fecha_de").val("");
		  $("#fecha_hasta").val("");
		  $("#daterange").attr("disabled",true);
	  }
	  
	  if (singleValues!=0) {
		  //console.log("no cero " + fecha_base);
		  $("#daterange").attr("disabled",false);
	  }
});