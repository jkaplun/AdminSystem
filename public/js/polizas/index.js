//index.js polizas
//ruta para el controlador de polizas
//console.log("loading poliza index.js"); 
var pathPolizaController="public/polizas/"; 
var polizas={};
var id_poliza="";
 

// accion que se realiza en el ajax, esta se define en 
var ajaxActionPoliza; 
 
//Variable donde se almacena el id que asigna la base de datos ala poliza 
var idDataBasePoliza=""; 
 
 
// borrar en master 
//var falseId=0; 


$(document).ready(function() { 
  $('#dataTable-polizas-vigentes,#dataTable-polizas-proximas-vencer,#dataTable-polizas-vencidas,#dataTable-polizas-anticipadas').DataTable({
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
 
  $("#addNewPolizaBtn").click(function(){ 
     abrirModalAgregarPoliza();
  }) 
 
  $("#submitPolizaBtn").click(function(){
      submitFormPoliza();
  });

 $(".FrontEndIdPoliza").hide()//.css("display", "none");

//   $("#tabUsuariosAgencia").click(function(){
//         if(actualizarVistas.vistaUsuarioAgencia == false){
//           console.log("actualizarVistas.vistaUsuarioAgencia: "+actualizarVistas.vistaUsuarioAgencia);
//           mostrarUsuariosAgencia();
//             actualizarVistas.vistaUsuarioAgencia =true;
//         }
      
//   })


// $('#dataTable-usuarios-agencias').on( 'page.dt', function () {
//     console.log("cambiando de página");
//     $(".frontEndIdColumn").hide();
// } );

 

}); // end  $(document).ready(function() { 
 
 
 
function submitFormPoliza(){   
  addIdAgencia="&id_agencia="+idAgenciaActual;
  //console.log("ajaxActionPoliza" +ajaxActionPoliza);
  var id_product="&id_producto="+ $("#producto").val();
  //console.log("id_producto: "+ id_product);
  var clave = "&clave=claveX";
  $.ajax({ 
      url: pathPolizaController + ajaxActionPoliza, 
      method: "post", 
      data: $("#formPoliza").serialize() + addIdAgencia + id_product + clave + id_poliza,
      dataType: "json" 
    }).done(function(res) {  
      console.log("ajax submitFormPoliza done");

    if (ajaxActionPoliza == "agregar"){ 
       agregarPolizaAjaxDone(res); 
     }else{ 
       actualizarPolizaAjaxDone(res); 
     } 
 
 
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
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
 
      // console.log("entrando a agregarUsuarioAgenciaEnTabla"); 
      // var frontEndId = Object.keys(polizas).length + 1; 
        var userTable = $('#dataTable-polizas-vigentes').DataTable();   
        var estatusUsuario; 
        var info = userTable.page.info(); 
 
 
        // if(res.activo == "S"){ 
        //   estatusUsuario="Activo"; 
        // } else{ 
        //   estatusUsuario="Inactivo"; 
        // } 
 
 
 
        //var apellido = res.apellido_paterno+ " " + res.apellido_materno;  
 
 
        //res.id_usuario_agencia=falseId; 
        res.descripcion=""; 
        // se agrega la nueva columna a la tabla  
        //$(".frontEndIdColumn").show()
        userTable.row.add( [  
          res.id_poliza, res.clave, res.id_producto, res.horas_poliza, '0', res.costo_poliza, res.fecha_ini, res.fecha_fin, "x" , "x"
          ]).draw(); 
 
        var boton = '<button type="button" class="btn btn-primary btn-sm btn-circle" data-toggle="modal" data-target="#modalNuevaPoliza" value='+ res.id_poliza +   
        ' onclick="datosFormPoliza('+ res.id_poliza +  ')" >' +  // 
        '<i class="fa fa-info-circle"></i>'+  
        '</button>'   
    
       // borrar despues 
        if(ajaxActionPoliza=="agregar" || ajaxActionPoliza=="consultar"){ 
        userTable.page( 'last' ).draw( 'page' );  
        var id_poliza_row = "idPolizaRow"+res.id_poliza;
 
        $('#dataTable-polizas-vigentes tr:last-child td:first-child').attr('class', 'frontEndIdPoliza'); 
        $('#dataTable-polizas-vigentes tr:last-child td:first-child').css('background-color', 'red'); 
        $('#dataTable-polizas-vigentes tr:last-child td:last-child').html(boton);  
        $('#dataTable-polizas-vigentes tr:last-child td:last-child').attr('id', "editarPolizaBtn"+res.id_poliza); 
        //$('#dataTable-polizas-vigentes tr:last-child td:last-child').attr('class', "frontEndIdPoliza"); 
        $("#editarPolizaBtn"+res.id_poliza).closest('tr').attr('id', id_poliza_row); 
 
        }else{ 
 
           userTable.page(info.page).draw( 'page' );  
          var id_poliza_row = "idPolizaRow"+res.id_poliza;
          $("#editarPolizaBtn"+res.id_poliza).closest('tr').next('tr').attr('id', id_poliza_row);

          //$("#"+res.id_usuario) 
          userTable.row('#'+id_poliza_row).remove().draw( false ); 
          $('#'+id_poliza_row + " td:first-child").css('background-color', 'red'); 
          $('#'+id_poliza_row + " td:first-child").attr('class', 'frontEndIdPoliza');

          $("#"+id_poliza_row + " td:last-child").html(boton);  
          if (!$("#"+id_poliza_row).length){ // es el último elemento en la tabla 
               console.log("ultimoElemento") 
               $('#dataTable-polizas-vigentes tr:last-child td:last-child').html(boton);  
          } 
           
 
        } 

      

          if(ajaxActionPoliza=="agregar" || ajaxActionPoliza=="actualizar" ) {
               $('#modalNuevaPoliza').modal('toggle'); 
             //$('#').modal('modalNuevaPoliza');  
               //$(".frontEndIdColumn").hide();
          }
           
          // ocultar front-end-id
          $(".frontEndIdPoliza").hide();  

} // end function agregarUsuarioAgenciaEnTabla(res){ 
 
 
function agregarPolizaAjaxDone(res){ 
  console.log("agregarPolizaAjaxDone");
  if(res.estado == "ok"){ // si la respuesta es correcta: 
        console.log(res);  
 
      agregarPolizaEnTabla(res); 

      swal("La póliza ha sido actualizado exitosamente", " ", "success");  
 
   } else{ 
     swal(res.descripcion, " ", "error");  
     } 
} // end agregarAjaxDone() 
 
 
 
function actualizarPolizaAjaxDone(res){ 
  //var userTable = $('#dataTable-usuarios').DataTable();   
 
  if(res.estado == "ok"){ 
    agregarPolizaEnTabla(res); 
    swal("La póliza ha sido actualizado exitosamente", " ", "success"); 
 
  }else{ 
    swal(res.descripcion, " ", "error"); 
  } 
   
  //dataTable.row('.selected').remove().draw( false ); 
   
 
} 
 
 
 function datosFormPoliza(frontEndIdPoliza){ 
   //alert("no es necesario llenar los campos, se simulan los datos desde un JSON en el public/js/usuariosagencia/index.js ") 
   console.log("frontEndId "+frontEndIdPoliza);
   id_poliza="&id_poliza=" +frontEndIdPoliza;
   ajaxActionPoliza="actualizar"; 

   //console.log("ajaxAction "+ajaxActionPoliza); 
   // console.log(usuariosAgencias[frontEndId - 1]);
    populatePolizaForm(polizas[frontEndIdPoliza - 1]);

 } 
 
 function abrirModalAgregarPoliza(){ 
  //$('#myModalLabel').html("Agregar Usuario"); 
  document.getElementById("formPoliza").reset(); 

  ajaxActionPoliza="agregar"; 
 
  console.log("ajaxAction "+ajaxActionPoliza); 
   
} 



function mostrarPolizas(){

  ajaxActionPoliza="consultar"
  var addIdAgencia="id_agencia="+idAgenciaActual;
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

        polizas[i+1]=res[i];
        agregarPolizaEnTabla(res[i]);

      }

   //$(".frontEndIdColumn").hide();
  console.log("polizas");
  console.log(polizas);
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  }); 
}



function populatePolizaForm(data) {  
    //console.log("populating form"); 
    $.each(data, function(key, value){  
      if(key == "nombre"){
          $("#nombreUsuarioAgencia").val(value);
      } else if(key == "email"){
        $("#emailUsuarioAgencia").val(value);
      }else{
      //console.log("key: "+key + " value: " +value);
      $("#"+key).val(value);
      }
    });
}



