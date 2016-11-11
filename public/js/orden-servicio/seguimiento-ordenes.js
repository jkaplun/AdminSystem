var JSON_timers_global={};
var pathOrdenServicioController="public/orden-seguimiento/"

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


  $("#pagination a").click(function(){
    var page = $(this).attr('data-page');
    //alert('pushado'+page+'-'+n_rows);
    $("#filtroform").append('<input type="hidden" name="page" value="'+page+'" id="page">').trigger("submit");
  });


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
  console.log(array_cron_estatus);

// arreglo con tiempo duracion servicio
  var array_duracion_servicio=$("#info_duracion_servicio_todos").html().split(',');
  array_duracion_servicio.shift();
  array_duracion_servicio.pop();
  //console.log(array_duracion_servicio);

  //mostrar duración servicio y status crono
  mostrar_duracion_servicio_status_crono(array_duracion_servicio,array_cron_estatus,array_ordenes_id);



}); // end  $(document).ready(function() { 


function clickPausePlayBtn(button_id){
   //var timer = new Timer();
   var id_orden= button_id.replace("mainBtn_", "");
  //console.log("id_orden: "+id_orden);
    if($("#mainBtn_"+id_orden).attr('value')=="pause"){ // el tiempo está pausado o no ha comenzado
    //timer.start({precision: 'seconds', startValues: {seconds: 90}});
      playBtnFunction(id_orden);

      //-----------------> Ajax cuando se presiona botón play:
      botonPlayAjax(id_orden);
    }else{ // el tiempo está corriendo
      console.log($("#mainBtn_"+id_orden).attr('value'));
      $("#playPauseBtn_"+id_orden).removeClass("fa-pause-circle");
      $("#playPauseBtn_"+id_orden).addClass("fa-play-circle");
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
        JSON_timers_global[ordenes_id[i]].start({precision: 'seconds', startValues: {minutes: parseInt(duracion_servicio[i])}});
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
          JSON_timers_global[ordenes_id].start({precision: 'seconds', startValues: {minutes: parseInt(duracion_servicio)}});
        $("#playPauseBtn_"+ordenes_id).removeClass("fa-play-circle");
        $("#playPauseBtn_"+ordenes_id).addClass("fa-pause-circle");
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

function concluirOrden(button_id){
    var id_orden= button_id.replace("concluirServicio_", "");
  var id_orden_to_send="id_orden_servicio="+id_orden;
  var conformidad= "&conformidad="+$("#conformidad_"+id_orden).val();
  var motivo= "&motivo="+$("#motivo_"+id_orden).val();
  var solucion= "&solucion="+$("#solucion_"+id_orden).val();

      $.ajax({ 
        url: pathOrdenServicioController + "actualizar", 
        method: "post", 
        data: id_orden_to_send+conformidad+motivo+solucion+"&concluido=S",
        dataType: "json" 
      }).done(function(res) { 

  if(res.estado == "ok"){ // si la respuesta es correcta: 
      console.log(res);  
      swal("La orden ha sido concluida exitosamente", " ", "success"); 
      $("#orden_servicio_"+id_orden).hide();
   } else{ 
    //$("#orden_servicio_"+id_orden).hide();
     swal(res.descripcion, " ", "error");  
     } 
   
         
    })// end ajax done  
      .fail(function() { 
        swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
    });
}

