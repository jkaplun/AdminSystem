//index.js Productos
//ruta para el controlador de Productos
//console.log("loading producto index.js 4nov16"); 

var pathProductoController="public/productos/"; 
var productos_todos={};
var productos_agencia={};
var id_Producto="";
var clave_Producto="";
var id_producto_seleccionado="";
 

// accion que se realiza en el ajax, esta se define en 
var ajaxActionProducto; 
 
//Variable donde se almacena el id que asigna la base de datos ala Producto 
var idDataBaseProducto=""; 
 
 
// borrar en master 
//var falseId=0; 



$(document).ready(function() {

    $('#dataTable-productos-adquiridos').DataTable({
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
			"oAria": {
			    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		}
    });

  $("#addNewProductoBtn").click(function(){ 
     abrirModalAgregarProducto();
  }) 
 
    mostrarProductosEnSelect();

 

}); // end  $(document).ready(function() { 
 
 
 
 function probarAgenciaProducto(){
  //var id_agencia_prueba="id_agencia=156"
    var id_agencia_prueba="id_agencia=" + $("#probarAgenciaProducto").val();

  $.ajax({ 
      url: pathProductoController + "productosdisponiblesadquiridosporidagencia", 
      method: "post", 
      data: id_agencia_prueba,
      dataType: "json" 
    }).done(function(res) {  

      console.log("---------------> respuesta del método: productosdisponiblesadquiridosporidagencia");
      console.log(id_agencia_prueba);
      console.log("objetos en arreglo: "+ res.length);
      console.log(res);
 
 
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  });

}

function submitFormProducto(){   
  //console.log("----------> ajaxActionProducto: "+ajaxActionProducto);
  addIdAgencia="&id_agencia="+idAgenciaActual;
  //console.log("ajaxActionProducto" +ajaxActionProducto);
  var id_producto="&id_producto="+$("#nombre_prod").val();
  //console.log("id_producto: "+ id_product);

  // if(ajaxActionProducto=="actualizar"){

  // }else{

  // }

  $.ajax({ 
      url: pathProductoController + ajaxActionProducto, 
      method: "post", 
      data: $("#formProducto").serialize() + addIdAgencia + id_producto,
      dataType: "json" 
    }).done(function(res) {  
      console.log("ajax submitFormProducto done");

    if (ajaxActionProducto == "agregar"){ 
       agregarProductoAjaxDone(res); 
     }else{ 
       actualizarProductoAjaxDone(res); 
     } 
 
 
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  });
} // end submitFormProducto(){ 

 
 function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
 

function agregarProductoEnTabla(res){ 
      // console.log("entrando a agregarUsuarioAgenciaEnTabla"); 
      // var frontEndId = Object.keys(Productos).length + 1; 
        var productoTable = $('#dataTable-productos-adquiridos').DataTable();   
        var info = productoTable.page.info(); 
 

        var boton = '<button type="button" class="btn btn-primary btn-sm btn-circle" data-toggle="modal" data-target="#modalNuevoProducto" value='+ res.id_producto +   
        ' onclick="datosFormProducto('+ res.id_producto +  ')" >' +  // 
        '<i class="fa fa-info-circle"></i>'+  
        '</button>'   
    

        var id_producto_row = "idProductoRow"+res.id_producto;
       // borrar despues 
        if(ajaxActionProducto=="agregar" || ajaxActionProducto=="productosdisponiblesadquiridosporidagencia"){ 
			var data = [
 
 		       res.id_producto,
 		       productos_todos[res.id_producto].nombre_prod, 
 		       res.numero_licencias, 
 		       res.estatus, 
 		       "x"
        			];

        var rowNode = productoTable
			    .row.add( data )
			    .draw()
			    .node();
			 
			$( rowNode ).attr('id', id_producto_row); ;

        $('#'+id_producto_row+' td:last-child').html(boton);  
        $('#'+id_producto_row+' td:last-child').attr('id', "editarProductoBtn"+res.id_producto); 


        $("#id_producto_"+res.id_producto).hide();

        }else{  //  ajaxActionProducto=="editar"
 
          
          console.log("res after updating");
          console.log(res);
            //var id_Producto_row = "idProductoRow"+res.id_Producto;
            productoTable.row( $("#"+id_producto_row) ).data([
            	 res.id_producto, productos_todos[res.id_producto].nombre_prod, res.numero_licencias, res.estatus, "x"
            						]).draw();
            //console.log( ProductoTable.row( this ).data("x","x","x","x","x","x","x","x","x") );
            productoTable.page(info.page).draw( 'page' );  
    

          $("#"+id_producto_row + " td:last-child").html(boton);  



        } 

      

          if(ajaxActionProducto=="agregar" || ajaxActionProducto=="actualizar" ) {
               $('#modalNuevoProducto').modal('toggle'); 
             //$('#').modal('modalNuevoProducto');  
               //$(".frontEndIdColumn").hide();
          }
           
          // ocultar front-end-id
          //$(".frontEndIdProducto").hide();  

} // end function agregarUsuarioAgenciaEnTabla(res){ 
 

function agregarProductoAjaxDone(res){ 
  console.log("agregarProductoAjaxDone");
  if(res.estado == "ok"){ // si la respuesta es correcta: 
        console.log(res);  
      

      agregarProductoEnTabla(res); 
      productos_agencia[res.id_producto] = res;
      swal("El producto ha sido actualizado exitosamente", " ", "success");  
 
   } else{ 
     swal(res.descripcion, " ", "error");  
     } 
} // end agregarAjaxDone() 
 
 
 
function actualizarProductoAjaxDone(res){ 
  //var ProductoTable = $('#dataTable-usuarios').DataTable();   
 
  if(res.estado == "ok"){ 
    agregarProductoEnTabla(res); 
    // Actualizar modelo
    productos_agencia[res.id_producto]=res;

    swal("El producto ha sido actualizado exitosamente", " ", "success"); 
 
  }else{ 
    swal(res.descripcion, " ", "error"); 
  } 
   
  //dataTable.row('.selected').remove().draw( false ); 
   
 
} 
 
 
 function datosFormProducto(frontEndIdProducto){ 
   //alert("no es necesario llenar los campos, se simulan los datos desde un JSON en el public/js/usuariosagencia/index.js ") 
   console.log("frontEndId "+frontEndIdProducto);
   //id_producto="&id_producto=" +frontEndIdProducto;
   id_producto_seleccionado=frontEndIdProducto;
   ajaxActionProducto="actualizar"; 

   //console.log("ajaxAction "+ajaxActionProducto); 
   // console.log(usuariosAgencias[frontEndId - 1]);
   //console.log("Productos[frontEndIdProducto]");
   //console.log(Productos[frontEndIdProducto]);
   populateProductoForm(productos_agencia[frontEndIdProducto]);

 } 
 
 function abrirModalAgregarProducto(){ 
  //$('#myModalLabel').html("Agregar Usuario"); 
  document.getElementById("formProducto").reset(); 
  $("#titulo_form_producto").html("Nuevo producto");
  ajaxActionProducto="agregar"; 
 
  //console.log("ajaxActionProducto "+ajaxActionProducto); 
   
} 



function mostrarProductosEnSelect(){

  productos_todos={};
  ajaxActionProducto="consultarproductos"
  //var addIdAgencia="id_agencia="+idAgenciaActual;
 $.ajax({ 
      url: pathProductoController+ajaxActionProducto, 
      method: "post", 
      //data: addIdAgencia,
      dataType: "json" 
    }) 
    .done(function(res) {  
      var i=0;


      for (i;i<res.length;i++){

        if(res[i].vigente_prod=="S"){
        productos_todos[res[i].id_producto]=res[i];
        //agregarProductoEnTabla(res[i]);
        $('#nombre_prod').append($('<option>').text(res[i].nombre_prod)
          .attr('value', res[i].id_producto)
          .attr('id', "id_producto_"+res[i].id_producto)
          .attr('class',"productSelect")
          );
        }
      }

   //$(".frontEndIdColumn").hide();
  console.log("Productos despues de consulta");
  console.log(productos_todos);
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  }); 
}



function populateProductoForm(data) {  
    console.log("populating form"); 
    console.log(data);
    $.each(data, function(key, value){  
     if(key == "id_producto"){
      //$("#id_producto_"+value).show();

      console.log("productos_todos[value].nombre_prod: "+productos_todos[value].nombre_prod);
     	$("#titulo_form_producto").html(productos_todos[value].nombre_prod);
     } else{
      //console.log("key: "+key + " value: " +value);
      $("#"+key).val(value);
     	 }
    });
}

function mostrarProductosEnTabla(){

  $(".productSelect").show();
  productos_agencia={};
  ajaxActionProducto="productosdisponiblesadquiridosporidagencia"
  var addIdAgencia="id_agencia="+idAgenciaActual;
 $.ajax({ 
      url: pathProductoController+ajaxActionProducto, 
      method: "post", 
      data: addIdAgencia,
      dataType: "json" 
    }) 
    .done(function(res) {  
      var i=0;

      
      //pruebaMostrarUsuarios(res, i);
       

      for (i;i<res.length;i++){
        if(res[i].id_agencia!=0){
            productos_agencia[res[i].id_producto]=res[i];
            $("#id_producto_"+res[i].id_producto).hide();
            agregarProductoEnTabla(res[i]);
        }
      
       

      }

   //$(".frontEndIdColumn").hide();
  console.log("productos_agencia despues de consulta");
  console.log(productos_agencia);
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  }); 
}




