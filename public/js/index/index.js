/**
 * 
 */

$(function() {
	$( "#guardar" ).click(function( event ) {
		event.preventDefault();
	});	
	$( "#guardar" ).click(function( event ) {

		var textError='';
		var form_correcto = 'si';
		
		if($.trim($('#nombre').val())==''){
			form_correcto = 'no';
			textError += '- Nombre \n';
		}
		/*
		if($.trim($('#email').val())==''){
			form_correcto = 'no';
			textError += '- Email \n';
		}
		
		if($.trim($('#fechanacimiento').val())==''){
			form_correcto = 'no';
			textError += '- Falta la fecha de nacimiento. \n';
		}*/
		
		if(form_correcto == 'si'){
			$("#form").submit();
			//document.getElementById("form").submit();
			//console.log('Correcto.');
			//alert('correcto');
		} else {
			alert('Llene los siguientes campos obligatorios: \n'+textError);
			//$("#form").submit();
		}
	});	
	$('#cuenta_documentos_otro_div').hide();
	
	$('#cuenta_documentos-ot').click(function() {
	   if($('#cuenta_documentos-ot').is(':checked')) { 
		   	   $('#cuenta_documentos_otro_div').show('fast');
		   } else {
			   $('#cuenta_documentos_otro_div').hide('fast');
			   $('#cuenta_documentos_otro').val('');
		   }
	});

	$('#donde_nacio_otro_div').hide();
	
	$('#sabe_donde_nacio_otro').click(function() {
	   if($('#sabe_donde_nacio_otro').is(':checked')) { 
		   	   $('#donde_nacio_otro_div').show('fast');
		   } else {
			   $('#donde_nacio_otro_div').hide('fast');
			   $('#donde_nacio_otro').val('');
		   }
	});
	  if($('#sabe_donde_nacio-ot').is(':checked')) { 
	   	   $('#donde_nacio_otro_div').show('fast');
	   }
	  
	$('#desc_cuenta_con_persona').hide();
	$('#si_cuenta_con_personas_aux').click(function() {
		   if($('#si_cuenta_con_personas_aux').is(':checked')) { 
			   	   $('#desc_cuenta_con_persona').show('fast');
			   } else {
				   $('#desc_cuenta_con_persona').hide('fast');
				   $('#desc_cuenta_con_persona').val('');
			   }
		});
	if($('#si_cuenta_con_personas_aux').is(':checked')) { 
	   	   $('#desc_cuenta_con_persona').show('fast');
	   }
    $('.datepicker').datepicker({
        format: "dd-mm-yyyy",
        startView: 2,
        language: "es",
        autoclose: true
    });
});

function otroDondeNacio(value){
	//alert(value);
	if(value=='ot'){
		 $('#donde_nacio_otro_div').show('fast');
		   $('#donde_nacio_otro').val('');
	} else {
		 $('#donde_nacio_otro_div').hide('fast');
		   $('#donde_nacio_otro').val('');
	}
}

function traerMunDel( clave_entidad ){
	
	if( clave_entidad == '0'){
		 $("#mun_del").html('<option>No sabe</option>');
	}
	$.ajax({
		  url: "public/index/ajax",
		  method: "post",
		  data: { accion_ajax : 'trae_mun_del' , clave_entidad : clave_entidad},
		  dataType: "json"
		})  .done(function( item ) {
		    $("#mun_del").html('');
		    $("#mun_del").append('<option value="0" >No sabe</option>');
		    $.each( item ,function ( i , value)  {
		    	$("#mun_del").append('<option value="'+ value.clave_municipio +'" >'+ value.nombre_municipio +'</option>');
		    });
		  });
}