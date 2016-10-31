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
  console.log("----------> ajaxActionPoliza: "+ajaxActionPoliza);
  addIdAgencia="&id_agencia="+idAgenciaActual;
  //console.log("ajaxActionPoliza" +ajaxActionPoliza);
  var id_product="&id_producto="+ $("#producto").val();
  //console.log("id_producto: "+ id_product);
  var clave;
  if(ajaxActionPoliza=="actualizar"){
    console.log("mandando clave poliza")
    clave="&clave="+clave_poliza;
    console.log("mandando clave poliza: "+clave);
  }else{
    clave=""
  }

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
        var polizaTable = $('#dataTable-polizas-vigentes').DataTable();   
        var estatusUsuario; 
        var info = polizaTable.page.info(); 
 
         if(res.estatus == "ACT"){ 
           estadoPoliza="Activa"; 
         } else if (res.estatus == "ADE"){ 
           estadoPoliza="Adeudo"; 
         } else if (res.estatus == "BLQ"){ 
           estadoPoliza="Bloqueado"; 
         } else{
           estadoPoliza="Cancelado";
         }
 
          //  ACT - Activo
          // ADE - Adeudo
          // BLQ - Bloqueado
          // CAN - Cancelado
           
 
        //var apellido = res.apellido_paterno+ " " + res.apellido_materno;  
 
 
        //res.id_usuario_agencia=falseId; 
        res.descripcion=""; 

        // se agrega la nueva columna a la tabla  
        //$(".frontEndIdColumn").show()
        // polizaTable.row.add( [  
        //   res.id_poliza, res.clave, res.id_producto, res.horas_poliza, '0', res.costo_poliza, res.fecha_ini, res.fecha_fin, estadoPoliza , "x"
        //   ]).draw(); 
 
        var boton = '<button type="button" class="btn btn-primary btn-sm btn-circle" data-toggle="modal" data-target="#modalNuevaPoliza" value='+ res.id_poliza +   
        ' onclick="datosFormPoliza('+ res.id_poliza +  ')" >' +  // 
        '<i class="fa fa-info-circle"></i>'+  
        '</button>'   
        var nombre_producto_poliza="";
        var clave_producto_poliza="";
        if ($(productos_todos[res.id_producto]).length){
          nombre_producto_poliza=productos_todos[res.id_producto].nombre_prod
        }else{
          nombre_producto_poliza="no vigente"
        }

        var id_poliza_row = "idPolizaRow"+res.id_poliza;
       // borrar despues 
        if(ajaxActionPoliza=="agregar" || ajaxActionPoliza=="consultar"){ 
        //console.log("productos_todos[res.id_producto].nombre_prod: "+productos_todos[res.id_producto].nombre_prod);
        polizaTable.row.add( [  
        res.id_poliza, res.clave, nombre_producto_poliza, res.horas_poliza, '0', res.costo_poliza, res.fecha_ini, res.fecha_fin, estadoPoliza , "x"
        ]).draw(); 

        polizaTable.page( 'last' ).draw( 'page' );  
        
 
        $('#dataTable-polizas-vigentes tr:last-child td:first-child').attr('class', 'frontEndIdPoliza'); 
        $('#dataTable-polizas-vigentes tr:last-child td:first-child').css('background-color', 'red'); 
        $('#dataTable-polizas-vigentes tr:last-child td:last-child').html(boton);  
        $('#dataTable-polizas-vigentes tr:last-child td:last-child').attr('id', "editarPolizaBtn"+res.id_poliza); 
        //$('#dataTable-polizas-vigentes tr:last-child td:last-child').attr('class', "frontEndIdPoliza"); 
        $("#editarPolizaBtn"+res.id_poliza).closest('tr').attr('id', id_poliza_row); 
 
        }else{ 
 
          
            console.log("res after updating: ");
            console.log(res);
            //console.log("")
            //var id_poliza_row = "idPolizaRow"+res.id_poliza;
            polizaTable.row( $("#"+id_poliza_row) ).data([res.id_poliza, res.clave, nombre_producto_poliza, res.horas_poliza, '0', res.costo_poliza, res.fecha_ini, res.fecha_fin, estadoPoliza , "x"]).draw();
            //console.log( polizaTable.row( this ).data("x","x","x","x","x","x","x","x","x") );
            polizaTable.page(info.page).draw( 'page' );  
    

          // $("#editarPolizaBtn"+res.id_poliza).closest('tr').next('tr').attr('id', id_poliza_row);

          //$("#"+res.id_usuario) 
          // polizaTable.row('#'+id_poliza_row).remove().draw( false ); 
          $('#'+id_poliza_row + " td:first-child").css('background-color', 'red'); 
          $('#'+id_poliza_row + " td:first-child").attr('class', 'frontEndIdPoliza');

          $("#"+id_poliza_row + " td:last-child").html(boton);  
          // if (!$("#"+id_poliza_row).length){ // es el último elemento en la tabla 
          //      console.log("ultimoElemento") 
          //      $('#dataTable-polizas-vigentes tr:last-child td:last-child').html(boton);  
          // } 
           
            // Actualizar modelo
           polizas[res.id_poliza]=res;

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
      polizas[res.id_poliza] = res;
      swal("La póliza ha sido actualizado exitosamente", " ", "success");  
 
   } else{ 
     swal(res.descripcion, " ", "error");  
     } 
} // end agregarAjaxDone() 
 
 
 
function actualizarPolizaAjaxDone(res){ 
  //var polizaTable = $('#dataTable-usuarios').DataTable();   
 
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
   console.log("polizas[frontEndIdPoliza]");
   console.log(polizas[frontEndIdPoliza]);
    populatePolizaForm(polizas[frontEndIdPoliza]);

 } 
 
 function abrirModalAgregarPoliza(){ 
  //$('#myModalLabel').html("Agregar Usuario"); 
  document.getElementById("formPoliza").reset(); 

  ajaxActionPoliza="agregar"; 
 
  console.log("ajaxAction "+ajaxActionPoliza); 
   
} 



function mostrarPolizas(){

  polizas={};
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

        polizas[res[i].id_poliza]=res[i];
        agregarPolizaEnTabla(res[i]);

      }

   //$(".frontEndIdColumn").hide();
  console.log("polizas despues de consulta");
  console.log(polizas);
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  }); 
}



function populatePolizaForm(data) {  
    console.log("populating form"); 
    console.log(data);
    $.each(data, function(key, value){  
    if(key == "clave"){
        console.log("asignando valor a poliza en populate: "+value);
        clave_poliza=value;
    } else if(key == "observaciones"){
        $("#observaciones_poliza").val(value);
        
    } else{
      //console.log("key: "+key + " value: " +value);
      $("#"+key).val(value);
      }
    });
}



