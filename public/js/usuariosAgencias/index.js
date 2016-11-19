//ruta para el controlador de usuarioAgencia 
var pathUsuarioAgenciaController="public/usuariosAgencia/"; 
var usuariosAgencias={};
var seAgregoNuevoUsuario=false;
var idUsuarioAgenciaToEdit;

// accion que se realiza en el ajax, esta se define en 
// datosform_edita_usuario_agencia() -> 'actualiza' 
// datosform_edita_usuario_agencia() -> 'actualiza' 
var ajaxActionUsuarioAgencia; 
 
//Variable donde se almacena el id que asigna la base de datos al usuario 
var id_usuario_agencia=""; 
var claveUsuarioAgencia="";
 
 
$(document).ready(function() { 
 
  $("#agregarUsuarioAgenciaBtn").click(function(){
    abrirModalAgregarUsuario(); 
  }) 
 
 }); // end  $(document).ready(function() { 
 
 
 
function submitFormUsuarioAgencia(){ 
 
    addIdAgencia="&id_agencia="+idAgenciaActual;
    //console.log("mandando submitFormUsuarioAgencia, clave usuariosagencia: "+claveUsuarioAgencia);
    claveUsuarioAgencia= "&claveUsuarioAgencia=" + $("#emailUsuarioAgencia").val();
    if(ajaxActionUsuarioAgencia == "actualizar")
      id_usuario_agencia_to_send="&id_usuario_agencia="+id_usuario_agencia;
    else
      id_usuario_agencia_to_send="";
 
  $.ajax({ 
      url: pathUsuarioAgenciaController + ajaxActionUsuarioAgencia, 
      method: "post", 
      data: $("#formUsuarioAgencia").serialize() + addIdAgencia +claveUsuarioAgencia + id_usuario_agencia_to_send,
      dataType: "json" 
    }) 
    .done(function(res) {  
 
    if (ajaxActionUsuarioAgencia == "agregar"){ 
      agregarUsuarioAgenciaAjaxDone(res); 
    }else{ 
      actualizarUsuarioAgenciaAjaxDone(res); 
    } 
 
 
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" ); 
  }); 
} // submitForm(){ 
  
 
function agregarUsuarioAgenciaEnTabla(res, counter){ 

     var userTable = $('#dataTable-usuarios-agencias').DataTable();   
     var info = userTable.page.info(); 
     //console.log("-----------------> info page: "+info.page);


      if(ajaxActionUsuarioAgencia=="consultar"){
        var frontEndId = counter;
      }else if (ajaxActionUsuarioAgencia=="actualizar"){
        userTable.order([0, 'asc']).draw();
        var frontEndId = idUsuarioAgenciaToEdit;
      }
      else{
        userTable.order([0, 'asc']).draw();
        var frontEndId = Object.keys(usuariosAgencias).length + 1; 
      }

       
        
        var estatusUsuario; 

        res.descripcion=""; 

        var boton = '<button type="button" class="btn btn-primary btn-sm btn-circle" data-toggle="modal" data-target="#nuevoUsuarioModal" value='+ frontEndId +   
        ' onclick="datosform_edita_usuario_agencia(this.value)" >' +  // 
        '<i class="fa fa-info-circle"></i>'+  
        '</button>'   
        var id_usuario_agencia_row = "idUsuarioAgenciaRow"+frontEndId;
       // borrar despues 

         //$('#dataTable-usuarios-agencias tr:last-child td:first-child').attr('class', 'frontEndIdColumn'); 
         //$('#dataTable-usuarios-agencias tr:last-child td:first-child').css('background-color', 'red'); 
        if(ajaxActionUsuarioAgencia=="agregar" || ajaxActionUsuarioAgencia=="consultar"){ 

          userTable.row.add( [  
          frontEndId, res.nombre, res.apellidos, res.email, res.telefono, res.puesto, "x"  
          ]).draw(); 

        userTable.page( 'last' ).draw( 'page' );  
 

        $('#dataTable-usuarios-agencias tr:last-child td:last-child').html(boton);  
        $('#dataTable-usuarios-agencias tr:last-child td:last-child').attr('id', "editarBtn"+frontEndId); 
        $("#editarBtn"+frontEndId).closest('tr').attr('id', id_usuario_agencia_row); 
 
        }else{ 

           //console.log('--------------> $("#"+id_usuario_agencia_row).length' )
             // console.log($("#"+id_usuario_agencia_row).length)
             //   console.log("----------------> id_usuario_agencia_row");
          // console.log(id_usuario_agencia_row);
            userTable.page(info.page).draw( 'page' );  
            //var id_poliza_row = "idPolizaRow"+res.id_poliza;
            var dataToUpdate=[ frontEndId, res.nombre, res.apellidos, res.email, res.telefono, res.puesto, "x" ]
          //  console.log("--------------> dataToUpdate");
          // console.log(dataToUpdate);
            userTable.row( $("#"+id_usuario_agencia_row) ).data([ frontEndId, res.nombre, res.apellidos, res.email, res.telefono, res.puesto, "x" ]).draw();
            //console.log( polizaTable.row( this ).data("x","x","x","x","x","x","x","x","x") );
 
           userTable.page(info.page).draw( 'page' );  
 
          //$("#editarBtn"+frontEndId).closest('tr').next('tr').attr('id', id_usuario_agencia_row);; 
          //$("#"+res.id_usuario) 
          //userTable.row('#'+id_usuario_agencia_row).remove().draw( false ); 
          $("#"+id_usuario_agencia_row + " td:last-child").html(boton); 
 
 
          // if (!$("#"+id_usuario_agencia_row).length){ // es el último elemento en la tabla 
          //      console.log("ultimoElemento") 
          //      $('#dataTable-usuarios-agencias tr:last-child td:last-child').html(boton);  
          // } 
           
           // Actualizar modelo
           usuariosAgencias[idUsuarioAgenciaToEdit]=res;
 
        } 

        

          if(ajaxActionUsuarioAgencia=="agregar" || ajaxActionUsuarioAgencia=="actualizar" ) {
             $('#nuevoUsuarioModal').modal('toggle');  
               $(".frontEndIdColumn").hide();
          }
             
} // end function agregarUsuarioAgenciaEnTabla(res){ 
 
 
function agregarUsuarioAgenciaAjaxDone(res){ 
  if(res.estado == "ok"){ // si la respuesta es correcta: 
        //console.log(res);  
        seAgregoNuevoUsuario=true;
 
      agregarUsuarioAgenciaEnTabla(res, 0); 
       usuariosAgencias[Object.keys(usuariosAgencias).length + 1] = res;
      swal("el usuario de la agencia ha sido guardado exitosamente", " ", "success");  
 
   } else{ 
     swal(res.descripcion, " ", "error");  
     } 
} // end agregarAjaxDone() 
 
 
 
function actualizarUsuarioAgenciaAjaxDone(res){ 
  //var userTable = $('#dataTable-usuarios').DataTable();

 
  if(res.estado == "ok"){ 

    agregarUsuarioAgenciaEnTabla(res, 0); 
   

    swal("el usuario de la agencia ha sido actualizado exitosamente", " ", "success"); 
 
  }else{ 
    swal(res.descripcion, " ", "error"); 
  } 
   
  //dataTable.row('.selected').remove().draw( false ); 
   
 
} 
 
 
 function datosform_edita_usuario_agencia(frontEndId){ 
   //alert("no es necesario llenar los campos, se simulan los datos desde un JSON en el public/js/usuariosagencia/index.js ")
	 
	 
	 //$( "#claveUsuarioAgencia" ).prop( "disabled", true );
   ajaxActionUsuarioAgencia="actualizar"; 
   //console.log("ajaxActionUsuarioAgencia "+ajaxActionUsuarioAgencia); 

   idUsuarioAgenciaToEdit=frontEndId;
   //console.log("usuariosAgencias[frontEndId]: "+usuariosAgencias[frontEndId]);
   id_usuario_agencia = usuariosAgencias[frontEndId].id_usuario_agencia;


    populateUsuarioAgenciaForm(usuariosAgencias[frontEndId ]);
      
 } 
 
 function abrirModalAgregarUsuario(){ 
  //$('#myModalLabel').html("Agregar Usuario"); 
  document.getElementById("formUsuarioAgencia").reset(); 

  ajaxActionUsuarioAgencia="agregar"; 
 
  //console.log("ajaxActionUsuarioAgencia "+ajaxActionUsuarioAgencia); 
   
} 



function mostrarUsuariosAgencia(){
  usuariosAgencias={};
  ajaxActionUsuarioAgencia="consultar"
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
        agregarUsuarioAgenciaEnTabla(res[i], i+1);

      }

   $(".frontEndIdColumn").hide();
 
 // console.log(usuariosAgencias);
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  }); 
}

function pruebaMostrarUsuarios(res, i){
        
        if(i>=res.length){
          //console.log("terminamos "+res.length);
        }else{
              usuariosAgencias[i+1]=res[i];
              agregarUsuarioAgenciaEnTabla(res[i]);
              i++;
         setTimeout(function(){
        pruebaMostrarUsuarios(res, i);
            }, 500); 
        }
             $(".frontEndIdColumn").hide();
}


function populateUsuarioAgenciaForm(data) {  
    //console.log("populating form"); 

    $.each(data, function(key, value){  
      if(key == "nombre"){
          $("#nombreUsuarioAgencia").val(value);
      } else if(key == "email"){
        $("#emailUsuarioAgencia").val(value);
      }else if(key == "clave"){
        //console.log("populating clave:"+value);
         claveUsuarioAgencia="&claveUsuarioAgencia="+value;
        $("#claveUsuarioAgencia").val(value);
      }else{
      //console.log("key: "+key + " value: " +value);
      $("#"+key).val(value);
      }
    });
}



