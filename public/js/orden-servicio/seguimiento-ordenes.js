var JSON_timers_global={};
var pathOrdenServicioController="public/orden-seguimiento/"
var current_total_ordenes_global=0;

$(document).ready(function() { 
	
	$( ".prevent-default" ).click(function( event ) {
		  event.preventDefault();
	});
	
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

  $("#pagination a").click(function(){
    var page = $(this).attr('data-page');
    //alert('pushado'+page+'-'+n_rows);
    $("#filtroform").append('<input type="hidden" name="page" value="'+page+'" id="page">').trigger("submit");
  });

  Array.prototype.forEach.call(document.body.querySelectorAll("*[data-mask]"), applyDataMask);

// ocultar boton de recording
$(".recSVG").hide();

  //ordenesEjecutivo()

// crear arreglo con todos los id de las ordenes
   var array_ordenes_id=  $("#info_id_ordenes").html().split(',');
   array_ordenes_id.shift();
   array_ordenes_id.pop();  

// crear un json con todos los timers de cada orden
   var JSON_timers=createJsonForTimers(array_ordenes_id);
   JSON_timers_global=JSON_timers;

// arreglo con status del cronomentro
  var array_cron_estatus=$("#info_control_cron_estatus_todos").html().split(',');
  array_cron_estatus.shift();
  array_cron_estatus.pop();
  //console.log(array_cron_estatus);

// arreglo con tiempo duracion servicio
  var array_duracion_servicio=$("#info_duracion_servicio_todos").html().split(',');
  array_duracion_servicio.shift();
  array_duracion_servicio.pop();
  //console.log(array_duracion_servicio);

  // // arreglo con tiempo duracion servicio
  // var array_motivo=$("#info_motivo_todos").html().split(',');
  // array_motivo.shift();
  // array_motivo.pop();

  //mostrar duración servicio y status crono
  mostrar_duracion_servicio_status_crono(array_duracion_servicio,array_cron_estatus,array_ordenes_id);
  current_total_ordenes_global=array_cron_estatus.length;
  
  $("#total_ordenes").html(current_total_ordenes_global);

}); // end  $(document).ready(function() { 

function clickPausePlayBtn(id){
   //var timer = new Timer();
   var id_orden= id;
  //console.log("id_orden: "+id_orden);
    if($("#mainBtn_"+id_orden).attr('value')=="pause"){ // el tiempo está pausado o no ha comenzado
    //timer.start({precision: 'seconds', startValues: {seconds: 90}});
      playBtnFunction(id_orden);

      //-----------------> Ajax cuando se presiona botón play:
      botonPlayAjax(id_orden);
      $("#playPauseBtn_"+id_orden).removeClass("botton-play_green");
      $("#playPauseBtn_"+id_orden).addClass("botton-play_red");

    }else{ // el tiempo está corriendo
      console.log($("#mainBtn_"+id_orden).attr('value'));
      $("#playPauseBtn_"+id_orden).removeClass("fa-pause-circle botton-play_red");
      $("#playPauseBtn_"+id_orden).addClass("fa-play-circle botton-play_green");
      JSON_timers_global[id_orden].pause();
      $("#recSVG_"+id_orden).hide();
      $("#mainBtn_"+id_orden).attr('value','pause')
      //-----------------> Ajax cuando se presiona botón pause:      
      botonPauseAjax(id_orden)
    }

}

function createJsonForTimers(array_ordenes_id){
  var i=0;
  var jsonTimers={};
  for(i;i<array_ordenes_id.length;i++){
    var timer = new Timer();
    //console.log(array_ordenes_id[i]);
    jsonTimers[array_ordenes_id[i]]=timer;
  }
  return  jsonTimers;
}

function botonPlayAjax(id_orden){   

  var id_orden_to_send="id_orden_servicio="+id_orden;

  $.ajax({ 
      url: pathOrdenServicioController + "play", 
      method: "post", 
      data: id_orden_to_send,
      dataType: "json" 
    }).done(function(res) { 
    console.log("resupuesta del ajax") ;
      //console.log(res);
 
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  });
} // end submitFormPoliza(){ 

function botonPauseAjax(id_orden){   

  var id_orden_to_send="id_orden_servicio="+id_orden;

  $.ajax({ 
      url: pathOrdenServicioController + "pause", 
      method: "post", 
      data: id_orden_to_send,
      dataType: "json" 
    }).done(function(res) { 
    console.log("resupuesta del ajax") ;
      console.log(res);
    
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  });
} // end submitFormPoliza(){ 

function ordenesEjecutivo(){


  $.ajax({ 
      url: pathOrdenServicioController + "obtenerordenesporejecutivo", 
      method: "post", 
      data: "",//id_orden_to_send,
      dataType: "json" 
    }).done(function(res) { 
    console.log("resupuesta del ajax") ;
      console.log(res);
 
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  });
}


function mostrar_duracion_servicio_status_crono(duracion_servicio, cron_estatus, ordenes_id){
  var i=0;
  var ii=0;
  var current_orden_id=[];
  for(i;i<duracion_servicio.length;i++){
    current_orden_id=ordenes_id;
    ii=i;
    //console.log("cron_estatus[i]: "+cron_estatus[i]);
    if(cron_estatus[i]=="0") {
      //console.log("cron_estatus[i]=='0'")
         $('#cron_'+ordenes_id[i]).html('00:00:00');
    }else if(cron_estatus[i]=="1"){
      //console.log("cron_estatus[i]=='1'")

        cron_estatus_caso_1(ordenes_id[i], duracion_servicio[i]);

    }else{
      //console.log("cron_estatus[i]=='2'")
        console.log("duracion_servicio[i]: "+duracion_servicio[i]);
         console.log("ordenes_id[i]: "+ordenes_id[i]);
        JSON_timers_global[ordenes_id[i]].start({precision: 'seconds', startValues: {seconds: parseInt(duracion_servicio[i])}});
        $('#cron_'+ordenes_id[i]).html( JSON_timers_global[ordenes_id[i]].getTimeValues().toString());
        JSON_timers_global[ordenes_id[i]].pause(); 
    }

  }
}

function playBtnFunction(id_orden){
        JSON_timers_global[id_orden].start();
      $("#playPauseBtn_"+id_orden).removeClass("fa-play-circle");
      $("#playPauseBtn_"+id_orden).addClass("fa-pause-circle");
      $("#recSVG_"+id_orden).show();
      JSON_timers_global[id_orden].addEventListener('secondsUpdated', function (e) {
        $('#cron_'+id_orden).html( JSON_timers_global[id_orden].getTimeValues().toString());
      });
      $("#mainBtn_"+id_orden).attr('value','play');
}


function cron_estatus_caso_1(ordenes_id,duracion_servicio){
          
	JSON_timers_global[ordenes_id].start({precision: 'seconds', startValues: {seconds: parseInt(duracion_servicio)}});
    
	$("#playPauseBtn_"+ordenes_id).removeClass("fa-play-circle botton-play_green");
    
	$("#playPauseBtn_"+ordenes_id).addClass("fa-pause-circle botton-play_red");
    
	$("#recSVG_"+ordenes_id).show();
    
	//$('#cron_'+ordenes_id[i]).html( JSON_timers_global[ordenes_id[i]].getTimeValues().toString());
    
	JSON_timers_global[ordenes_id].addEventListener('secondsUpdated', function (e) {
    
		$('#cron_'+ordenes_id).html(JSON_timers_global[ordenes_id].getTimeValues().toString());
        
		//console.log("current_orden_id: "+current_orden_id[ii]);
        
	});
    
	$("#mainBtn_"+ordenes_id).attr('value','play');
}

function concluirSercicioAjax(button_id){

    swal({
    title: "¿Desea concluir la orden de servicio?",
    text: "",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Concluir orden",
    closeOnConfirm: true
  },
  function(){
    concluirOrden(button_id);
  });
}

function guardarServicioAjax(id_orden_servicio,estado){

      $.ajax({ 
        url: pathOrdenServicioController + "actualizar", 
        method: "post", 
        data: $("#formOrSr_"+id_orden_servicio).serialize()+"&accion_orden_servicio="+estado,
        dataType: "json" 
      }).done(function(res) { 

  if(res.estado == "ok"){ // si la respuesta es correcta: 
      console.log(res);  
      swal("La orden ha sido guardada exitosamente", " ", "success"); 
   } else{ 
     swal(res.descripcion, " ", "error");  
   }
  	
  if( res.administrador == 0 ){
	  if(res.cambio_ejecutivo == 'S' || estado == 6){
		  $("#orden_servicio_"+id_orden_servicio ).remove();
		  var total = $("#total_ordenes").html();
		  
		  $("#total_ordenes").html((total-1));
		  
		  
	  }
  }
  
  
    })// end ajax done  
      .fail(function() { 
        swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
    });

}

function applyDataMask(field) {

    var mask = field.dataset.mask.split('');
    
    // For now, this just strips everything that's not a number
    function stripMask(maskedData) {
        function isDigit(char) {
            return /\d/.test(char);
        }
        return maskedData.split('').filter(isDigit);
    }
    
    // Replace `_` characters with characters from `data`
    function applyMask(data) {
        return mask.map(function(char) {
            if (char != '_') return char;
            if (data.length == 0) return char;
            return data.shift();
        }).join('')
    }
    
    function reapplyMask(data) {
        return applyMask(stripMask(data));
    }
    
    function changed() {   
        var oldStart = field.selectionStart;
        var oldEnd = field.selectionEnd;
        
        field.value = reapplyMask(field.value);
        
        field.selectionStart = oldStart;
        field.selectionEnd = oldEnd;
    }
    
    field.addEventListener('click', changed)
    field.addEventListener('keyup', changed)
    
    
}


function ajaxPrueba(){   


  $.ajax({ 
      url: pathOrdenServicioController + "obtenerordenesporejecutivo", 
      method: "post", 
      data: "",
      dataType: "json" 
    }).done(function(res) { 
    console.log(res) ;
      //console.log(res);
 
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  });
} // end submitFormPoliza(){ 



function showEditOrdServ(id){
	$( "#panel-body-"+id ).toggle("blind");
}