//index.js polizas
//ruta para el controlador de polizas
//console.log("loading poliza index.js"); 
var pathPolizaController="public/polizas/"; 
var polizas={};
var id_poliza="";
var clave_poliza="";
 

// accion que se realiza en el ajax, esta se define en 
var ajaxActionPoliza; 
 
//Variable donde se almacena el id que asigna la base de datos ala poliza 
var idDataBasePoliza=""; 
 
 
// borrar en master 
//var falseId=0; 


$(document).ready(function() { 
 
  $("#addNewPolizaBtn").click(function(){ 
     abrirModalAgregarPoliza();
  }); 
 
  $("#submitPolizaBtn").click(function(){
	$('#modalNuevaPoliza').modal('hide');
	  
	  
      submitFormPoliza();

  });

 $(".FrontEndIdPoliza").hide();
}); // end  $(document).ready(function() { 
 
 
 
function submitFormPoliza(){
	
	$.blockUI({ css: { 
	    border: 'none', 
	    padding: '15px', 
	    backgroundColor: '#000', 
	    '-webkit-border-radius': '10px', 
	    '-moz-border-radius': '10px', 
	    opacity: .5, 
	    color: '#fff' 
	} }); 
	
  addIdAgencia="&id_agencia="+idAgenciaActual;
  var id_product="&id_producto="+ $("#producto").val();
  var clave;
  if(ajaxActionPoliza=="actualizar"){
    clave="&clave="+clave_poliza;
  }else{
    clave="";
  }

  $.ajax({ 
      url: pathPolizaController + ajaxActionPoliza, 
      method: "post", 
      data: $("#formPoliza").serialize() + addIdAgencia + id_product + clave + id_poliza,
      dataType: "json" 
    }).done(function(res) { 
    	mostrarPolizas(); 
    	mostrarProductosEnTabla();
    	$.unblockUI();
    })// end ajax done  
    .fail(function() {
    	swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
    	$.unblockUI();
  });
} // end submitFormPoliza(){ 

 
 function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
 
 
// function editarUsuarioAgenciaForm(json_values){ 
//   $('#myModalLabel').html("Editar Datos de la Agencia"); 
//   var obj = jQuery.parseJSON( json_values ); 
//   populate(obj); 
//   $("#action-form-agencia").attr('onclick','submitFormUpdateAgencia()'); 
// } 
 
// function populate(data) {    
//     $.each(data, function(key, value){   
//       $("#"+key).val(value); 
//     }); 
// } 
 
 
 
function agregarPolizaEnTabla(res){ 

        if (res.vigencia != "Caducada" && res.vigencia != "Cancelada") {
	        var boton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalNuevaPoliza" value='+ res.id_poliza +   
	        ' onclick="datosFormPoliza('+ res.id_poliza +  ')" >' +  // 
	        '<i class="fa fa-pencil-square-o"></i>'+  
	        '</button>'   ;
		} else {
	        var boton = '';        	
        }
        
        
        var nombre_producto_poliza="";
        if ($(productos_todos[res.id_producto]).length){

        	nombre_producto_poliza=productos_todos[res.id_producto].nombre_prod;

        }else{
        	nombre_producto_poliza="no vigente";
        }

        // calcular horas restantes
        var horas_us;
        if(res.horas_consumidas!=null){
        	horas_us= res.horas_poliza-res.horas_consumidas;
        }else{
        	horas_us=res.horas_poliza;
        }

        var id_poliza_row = "idPolizaRow"+res.id_poliza;
       // borrar despues 
        if(ajaxActionPoliza=="agregar" || ajaxActionPoliza=="consultar"){ 

 
        	$( "#polizas-table" ).append( "<tr>" +
        	
        			 "<td>" + '<a class="btn btn-info btn-xs" target="_new" href="public/orden-seguimiento/consultar-ordenes-por-poliza/id_poliza/'+res.id_poliza+'">'+res.clave+'</a>' + '</td>' + 
		    
        			 "<td>" +nombre_producto_poliza  + '</td>' + 
		    
        			 "<td>" +res.tipo_poliza_descripcion  + '</td>' +  
		    
        			 "<td>" +res.horas_poliza  + '</td>' + 
		    
        			 "<td>" +horas_us + '</td>' + 
		    
        			 "<td>" +res.costo_poliza + '</td>' +  
		    
        			 "<td>" +res.fecha_ini + '</td>' + 
		    
        			 "<td>" +res.fecha_fin  + '</td>' + 
		    
        			 "<td>" + res.vigencia + '</td>' + 
		    
        			 "<td>" + boton  + '</td></tr>'	);
	 
        }else{ 

//			polizaTable.row( $("#"+id_poliza_row) ).data([res.id_poliza, res.clave, nombre_producto_poliza, res.descripcion, res.horas_poliza, horas_us, res.costo_poliza, res.fecha_ini, res.fecha_fin, estadoPoliza , "x"]).draw();
//			polizaTable.page(info.page).draw( 'page' );  
//			$('#'+id_poliza_row + " td:first-child").css('background-color', 'red'); 
//			$('#'+id_poliza_row + " td:first-child").attr('class', 'frontEndIdPoliza');
//			
//			$("#"+id_poliza_row + " td:last-child").html(boton);  
//			// Actualizar modelo
//			polizas[res.id_poliza]=res;

        } 

          if(ajaxActionPoliza=="agregar" || ajaxActionPoliza=="actualizar" ) {
               $('#modalNuevaPoliza').modal('toggle'); 
          }
           
          // ocultar front-end-id
          //$(".frontEndIdPoliza").hide();  

} // end function agregarPolizaEnTabla(res){ 
 

 
function agregarPolizaAjaxDone(res){ 
	if(res.estado == "ok"){ // si la respuesta es correcta: 
      agregarPolizaEnTabla(res); 

      swal("La póliza ha sido actualizado exitosamente", " ", "success");  
      $('#modalNuevaPoliza').modal('hide');

   } else{ 
	   $('#modalNuevaPoliza').modal('show');
	   swal(res.descripcion, " ", "error");  
     } 
} // end agregarAjaxDone() 
 
function actualizarPolizaAjaxDone(res){ 
  if(res.estado == "ok"){ 
    agregarPolizaEnTabla(res); 
   
    swal("La póliza ha sido actualizado exitosamente", " ", "success");
    $('#modalNuevaPoliza').modal('hide');
  }else{ 
	$('#modalNuevaPoliza').modal('show');
    swal(res.descripcion, " ", "error"); 
  } 
} 
 
 
 function datosFormPoliza(frontEndIdPoliza){ 
   //alert("no es necesario llenar los campos, se simulan los datos desde un JSON en el public/js/usuariosagencia/index.js ") 

   id_poliza="&id_poliza=" +frontEndIdPoliza;
   ajaxActionPoliza="actualizar"; 

   $('#fecha_ini').hide();
   $('#fecha_fin').hide();
   
   $('#fecha_ini_txt').show();
   $('#fecha_fin_txt').show();

    populatePolizaForm(polizas[frontEndIdPoliza]);

    $('#producto').attr("disabled","disabled");
    $('#tipo').attr("disabled","disabled");
    
    
    
    
	$("#div-id-poliza-estatus").show();

 } 
 
 function abrirModalAgregarPoliza(){ 
  //$('#myModalLabel').html("Agregar Usuario"); 
  document.getElementById("formPoliza").reset(); 
  
  
  $('#fecha_ini').val('');
  $('#fecha_fin').val('');
  
  
  ajaxActionPoliza="agregar"; 
   
  $('#fecha_ini').show();
  $('#fecha_fin').show();
  
  $('#fecha_ini_txt').hide();
  $('#fecha_fin_txt').hide();
  
  $('#producto').removeAttr("disabled");
  $('#tipo').removeAttr("disabled");
} 

function mostrarPolizas(){
  polizas={};
  ajaxActionPoliza="consultar"
  var addIdAgencia="id_agencia="+idAgenciaActual;
  $( "#polizas-table" ).html( "" );
  
 $.ajax({ 
      url: pathPolizaController+"consultar", 
      method: "post", 
      data: addIdAgencia,
      dataType: "json" 
    }) 
    .done(function(res) {
      var i=0;

      
      //pruebaMostrarUsuarios(res, i);
       

      for (i;i<res.length;i++){

        polizas[res[i].id_poliza]=res[i];
        agregarPolizaEnTabla(res[i]);

      }

   //$(".frontEndIdColumn").hide();
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  }); 
}

function populatePolizaForm(data) {  
	// limpiar select producto de polizas
	//$('#producto').empty();
	
    $.each(data, function(key, value){  
	    if(key == "clave"){
	        clave_poliza=value;
	    } else if(key == "observaciones"){
	        $("#observaciones_poliza").val(value);
	        
	    } else if(key=="id_producto"){
	      $("#producto").val(value);
	    }else{
	      //console.log("key: "+key + " value: " +value);
	      $("#"+key).val(value);
	      }
	    if(key == "fecha_ini"){
	    	$("#fecha_ini").datepicker("update",value);
	    	$('#fecha_ini_txt').html(value);	
	    	
	    }
	    if(key == "fecha_fin"){
			$("#fecha_fin").datepicker("update",value);
			$('#fecha_fin_txt').html(value);
			
	    }
	    if(key == "fecha_fin_servicio"){
	    	console.log(key + " - " + value);
	    	if (value == "0000-00-00") {
	    		value = '';
	    	}
			$("#fecha_fin_servicio").datepicker("update",value);
	    }
    });
}

function mostrarProductosEnSelectPolizas(){
	$('#producto').find('option').remove().end();
  for (var key in productos_agencia) {
    if (productos_agencia.hasOwnProperty(key)) {
      var val = productos_agencia[key];
      //console.log(val);
      if(val.tiene_poliza=='S'){
            $('#producto').append($('<option>').text(val.nombre_prod)
            .attr('value', val.id_producto)
            );
    	}
    }
  }
}


function agregarProductoEnSelectPoliza(val){
           // console.log(val);
                $('#producto').append($('<option>').text(productos_todos[val.id_producto].nombre_prod)
                .attr('value', val.id_producto)
                );
}
