//index.js polizas
//ruta para el controlador de polizas
//console.log("loading poliza index.js"); 
var pathPolizaController="public/polizas/"; 
var polizas={};
 

// accion que se realiza en el ajax, esta se define en 
var ajaxActionPoliza; 
 
//Variable donde se almacena el id que asigna la base de datos ala poliza 
var idDataBasePoliza=""; 
 
 
// borrar en master 
//var falseId=0; 


$(document).ready(function() { 
  $('#dataTable-polizas-vigentes, #dataTable-polizas-proximas-vencer, #dataTable-polizas-vencidas, #dataTable-polizas-anticipadas ').DataTable({
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
      // "oAria": {
      //     "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
      //     "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      // }
    }

    });

 
  $("#addNewPolizaBtn").click(function(){ 
     abrirModalAgregarPoliza();
  }) 
 
  $("#submitPolizaBtn").click(function(){
      submitFormPoliza();
  });

//   $(".frontEndIdColumn").hide()//.css("display", "none");

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
  console.log("ajaxActionPoliza" +ajaxActionPoliza);
  var id_product="&id_producto="+ $("#producto").val();
  console.log("id_producto: "+ id_product);
  var clave = "&clave=clave"+getRandomInt(0,1000);
  $.ajax({ 
      url: pathPolizaController + ajaxActionPoliza, 
      method: "post", 
      data: $("#formPoliza").serialize() + addIdAgencia + id_product + clave,
      dataType: "json" 
    }).done(function(res) {  
      console.log("ajax submitFormPoliza done");
    if (ajaxActionPoliza == "agregar"){ 
       agregarPolizaAjaxDone(res); 
     }else{ 
    //   actualizarUsuarioAgenciaAjaxDone(res); 
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
          res.id_poliza, res.clave, res.id_producto, res.horasopor_year, '0', res.cantidad_fact, res.fecha_ini, res.fecha_fin, "x"  
          ]).draw(); 
 
        var boton = '<button type="button" class="btn btn-primary btn-sm btn-circle" data-toggle="modal" data-target="#modalNuevaPoliza" value='+ res.id_poliza +   
        ' onclick="" >' +  // 
        '<i class="fa fa-info-circle"></i>'+  
        '</button>'   
    
       // borrar despues 
        if(ajaxAction=="agregar" || ajaxAction=="consultar"){ 
        userTable.page( 'last' ).draw( 'page' );  
 
        $('#dataTable-polizas-vigentes tr:last-child td:first-child').attr('class', 'frontEndIdColumn'); 
       // $('#dataTable-polizas-vigentes tr:last-child td:first-child').css('background-color', 'red'); 
        $('#dataTable-polizas-vigentes tr:last-child td:last-child').html(boton);  
        $('#dataTable-polizas-vigentes tr:last-child td:last-child').attr('id', "editarBtn"+res.id_poliza); 
        $("#editarBtn"+res.id_usuario_agencia).closest('tr').attr('id', res.id_poliza); 
 
        }else{ 
 
           userTable.page(info.page).draw( 'page' );  
 
          $("#"+res.id_usuario_agencia).closest('tr').next('tr').attr('id', res.id_usuario_agencia);; 
          //$("#"+res.id_usuario) 
          userTable.row('#'+res.id_usuario_agencia).remove().draw( false ); 
          $("#"+res.id_usuario_agencia + " td:last-child").html(boton); 
 
 
          if (!$("#"+res.id_usuario_agencia).length){ // es el último elemento en la tabla 
               console.log("ultimoElemento") 
               $('#dataTable-usuarios-agencias tr:last-child td:last-child').html(boton);  
          } 
           
 
        } 

      

          if(ajaxActionPoliza=="agregar" || ajaxActionPoliza=="actualizar" ) {
               $('#modalNuevaPoliza').modal('toggle'); 
             //$('#').modal('modalNuevaPoliza');  
               //$(".frontEndIdColumn").hide();
          }
             
} // end function agregarUsuarioAgenciaEnTabla(res){ 
 
 
function agregarPolizaAjaxDone(res){ 
  console.log("agregarPolizaAjaxDone");
  if(res.estado == "ok"){ // si la respuesta es correcta: 
        console.log(res);  
 
      agregarPolizaEnTabla(res); 
      swal("el usuario de la agencia ha sido guardado exitosamente", " ", "success");  
 
   } else{ 
     swal(res.descripcion, " ", "error");  
     } 
} // end agregarAjaxDone() 
 
 
 
function actualizarPolizaAjaxDone(res){ 
  //var userTable = $('#dataTable-usuarios').DataTable();   
 
  if(res.estado == "ok"){ 
    agregarUsuarioAgenciaEnTabla(res); 
    swal("el usuario de la agencia ha sido actualizado exitosamente", " ", "success"); 
 
  }else{ 
    swal(res.descripcion, " ", "error"); 
  } 
   
  //dataTable.row('.selected').remove().draw( false ); 
   
 
} 
 
 
 function datosFormPoliza(frontEndId){ 
   //alert("no es necesario llenar los campos, se simulan los datos desde un JSON en el public/js/usuariosagencia/index.js ") 
   ajaxAction="actualizar"; 
   console.log("ajaxAction "+ajaxAction); 
    console.log(usuariosAgencias[frontEndId - 1]);
    populateUsuarioAgenciaForm(usuariosAgencias[frontEndId - 1]);     
 } 
 
 function abrirModalAgregarPoliza(){ 
  //$('#myModalLabel').html("Agregar Usuario"); 
  document.getElementById("formPoliza").reset(); 

  ajaxActionPoliza="agregar"; 
 
  console.log("ajaxAction "+ajaxActionPoliza); 
   
} 



function mostrarPolizas(){

  ajaxAction="consultar"
  var addIdAgencia="id_agencia="+idAgenciaActual;
 $.ajax({ 
      url: pathUsuarioAgenciaController+"consultar", 
      method: "post", 
      data: addIdAgencia,
      dataType: "json" 
    }) 
    .done(function(res) {  
      var i=0;

      
      //pruebaMostrarUsuarios(res, i);
       

      for (i;i<res.length;i++){

        usuariosAgencias[i+1]=res[i];
        agregarUsuarioAgenciaEnTabla(res[i]);

      }

   $(".frontEndIdColumn").hide();
 
  console.log(usuariosAgencias);
       
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



