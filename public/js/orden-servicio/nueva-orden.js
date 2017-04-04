var pathAgencias="public/agencias/";
var pathPolizaController="public/polizas/"; 
var pathProductoController="public/productos/"; 
var pathUsuarioAgenciaController="public/usuarios-agencia/"; 
var pathOrdenServicioController="public/orden-creacion/";
var pathConsultarTodosLosUsuarios="public/usuarios/consultartodoslosusuarios";
var pathAgregarUsuarioAgencia="public/usuarios-agencia/agregar"; 
var idAgenciaActual;
var idMotivo;
var productos_todos={};
var ejectivos_todos=[];
//var productos_agencia={};

//$('input[name=name_of_your_radiobutton]:checked').val();

//console.log("loading nueva orden")
//var datosAgenciaSeleccionada={};

$(document).ready(function() { 

    $('#dataTable-polizas-vigentes').DataTable({
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
		},
        "paging":   false,
        "ordering": false,
        "info":     false
    });

  // consultar todos los productos disponibles
     consultarProductos();
     consultarTodosLosEjectuvos();
     //consultarTodasLasAgencias();
	// cuando se eliga una agencia de la lista se llama a la función cunslutar agencia
	$("#select_agencias").change(function(){
		idAgenciaActual =$("#select_agencias").val();
		consultarAgencia(idAgenciaActual);
		var tablePolizas = $('#dataTable-polizas-vigentes').DataTable();
		tablePolizas.clear().draw();
		mostrarPolizas();
		mostrarUsuariosAgenciaEnSelect(idAgenciaActual);
		getProductosByAgencia();
  });

  $("#motivo").change(function(){
    idMotivo =$("#motivo").val();
    var des="";
    switch(idMotivo){
      case 'motivo1':   des="Actualización";break;
      case 'motivo2':   des="Configuración";break;
      case 'motivo3':   des="Error del Sistema";break;
      case 'motivo4':   des="Factura Electrónica";break;
      case 'motivo5':   des="Formatos e Impresoras";break;
      case 'motivo6':   des="Implementación";break;
      case 'motivo7':   des="Información";break;
      case 'motivo8':   des="Instalación";break;
      case 'motivo9':   des="Interfases";break;
      case 'motivo10':   des="Operación";break;
      case 'motivo11':   des="Reportarse";break;
      case 'motivo12':   des="Reportarse Urgentemente";break;
      case 'motivo13':   des="Reportes";break;
      case 'motivo14':   des="Seguimiento";break;
    }
    //$("#descripcion").val(des+$("#descripcion").val());
    $("#descripcion").val(des);
  });

  $("#id_tipo_soporte").change(function(){
	  if ($("#id_tipo_soporte").val() == 2) {
		  $(".soporte-sitio-divs").show();
	  } else {
		  $(".soporte-sitio-divs").hide();
	  }
  });
  
  $("#div_otro").hide();
	$("#submitNuevaOrdenBtn").click(function(){
		submitNuevaOrden();
	});

	$( "#id_usuario_agencia_solicito" ).change(function() {
		if ( $( "#id_usuario_agencia_solicito" ).val() == "otro") {
			$("#div_otro").show();
		} else {
			$("#div_otro").hide();
			$("#solicito_otro").val('');
		}
	});

	$( "#id_motivo" ).change(function() {
		
		var id_motivo = $( "#id_motivo" ).val();
		console.log(id_motivo);
		if ( id_motivo == 21) {
			$("#id_tipo_soporte_div").show();
		} else {
			$("#id_tipo_soporte_div").hide();
			$("#id_tipo_soporte").val(1);
			$(".soporte-sitio-divs").hide();
			$("#solicito_otro").val(0);
		}
	});

}); // end  $(document).ready(function() { 


function radioPoliza(){
	$("#dataTable-polizas-vigentes").css("background-color" ,'');
}

function consultarAgencia(id_agencia){
	var datosAgenciaSeleccionada={};
	$.ajax({
		url: pathAgencias + "consultar",
		method: "post",
		data: "id_agencia="+id_agencia,
		dataType: "html"
	})
	.done(function(res) { 
		datosAgenciaSeleccionada=$.parseJSON(res);;
		mostarDatosAgencia(res);
		//console.log("res.id_usuario_soporte_titular: " +datosAgenciaSeleccionada.id_usuario_soporte_titular);
		mostrarEjecutivosEnSelect(datosAgenciaSeleccionada.id_usuario_soporte_titular, datosAgenciaSeleccionada.id_usuario_soporte_auxiliar);
  	})// end ajax done 
		.fail(function() {
    	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
  	});
}

// Se muestran los datos de la gencia
function mostarDatosAgencia(datosAgencia){
	var datosAgencia = jQuery.parseJSON( datosAgencia );

	$("#nombre_agencia-info").html(datosAgencia.nombre);
	$("#direccion-info").html(datosAgencia.direccion);
	$("#telefono1-info").html(datosAgencia.tel1);
	$("#telefono2-info").html(datosAgencia.tel2);
	
 	$("#observaciones_agencia-info").html(datosAgencia.observaciones);

 	if(datosAgencia.tel1 != null && datosAgencia.tel1.length != 0){
 		$("#telefono1-info").html(datosAgencia.tel1);
 		$('#te1').show();
 	}else{
 		$('#te1').hide();
 	}
 	if(datosAgencia.tel2 != null && datosAgencia.tel2.length != 0){
 		$("#telefono2-info").html(datosAgencia.tel2);
 		$('#te2').show();
 	}else{
 		$('#te2').hide();
 	}
 	
 	if(datosAgencia.email != null && datosAgencia.email.length != 0){
 		$("#correo1-info").html(datosAgencia.email);
 		$('#co1').show();
 	}else{
 		$('#co1').hide();
 	}
 	if(datosAgencia.email_alt != null && datosAgencia.email_alt.length != 0){
 		$("#correo2-info").html(datosAgencia.email_alt);
 		$('#co2').show();
 	}else{
 		$('#co2').hide();
 	}

	$("#datos-agencia").show();
};

function mostrarPolizas(){
	polizas={};
 	var addIdAgencia="id_agencia="+idAgenciaActual;
 	$.ajax({ 
		url: pathPolizaController+"consultarpolizasvigentes", 
		method: "post", 
		data: addIdAgencia,
		dataType: "json" 
    }) 
    .done(function(res) {  
    	var i=0;
		for (i;i<res.length;i++){
			polizas[res[i].id_poliza]=res[i];
			agregarPolizaEnTabla(res[i]);
		}
		
		if (res.length==0) {
			alert ('No cuenta con polizas');
		}
  	})// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  	}); 
}


function agregarPolizaEnTabla(res){ 
	var polizaTable = $('#dataTable-polizas-vigentes').DataTable();   
	var estatusUsuario; 
	var info = polizaTable.page.info(); 

	if(res.id_poliza_estatus == "1"){ 
		estadoPoliza="Activa"; 
	} else if (res.id_poliza_estatus == "2"){ 
		estadoPoliza="<b>Adeudo</b>"; 
	} else if (res.id_poliza_estatus == "3"){ 
		estadoPoliza="Bloqueado"; 
	} else if (res.id_poliza_estatus == "4"){ 
    estadoPoliza="Cancelado"; 
  } else if (res.id_poliza_estatus == "5"){ 
    estadoPoliza="Caducada"; 
  }
  else{
		estadoPoliza="Agotada";
	}
	//  ACT - Activo
	// ADE - Adeudo
	// BLQ - Bloqueado
	// CAN - Cancelado

	res.descripcion=""; 

	var nombre_producto_poliza="";
	var clave_producto_poliza="";

    nombre_producto_poliza=productos_todos[res.id_producto].nombre_prod;


	var id_poliza_row = "idPolizaRow"+res.id_poliza;
	// borrar despues 

          // calcular horas restantes
  var horas_us;
  if(res.horas_consumidas!=null){
    horas_us= res.horas_poliza-res.horas_consumidas;
  }else{
    horas_us=res.horas_poliza;
  }
  
  if (horas_us < 0){
	  horas_us = "<span style='color: red'><b>" + horas_us + "</b></span>";
  } 
  
	polizaTable.row.add( [ 
		"", res.clave, nombre_producto_poliza + "<br>" + res.tipo_desc, res.horas_poliza, horas_us, res.fecha_ini +" a "+ res.fecha_fin , res.fecha_fin_servicio ,estadoPoliza 
	]).draw(); 
	
	polizaTable.page( 'last' ).draw( 'page' );  

  if(res.id_poliza_estatus == "1"){ 
	if (res.vigente=='si') {
		$('#dataTable-polizas-vigentes tr:last-child td:first-child').html(' <input type="radio" name="id_poliza" value="'+res.id_poliza+'" class"radio-poliza" onclick="radioPoliza()">');	
	}  

	if (res.vigente=='no') {
		$('#dataTable-polizas-vigentes tr:last-child td:first-child').html('');	
	}  
        
    }else if(res.id_poliza_estatus="null"){
      $('#dataTable-polizas-vigentes tr:last-child td:last-child').css('background-color', '#ffd6d6');  
    }
} // end function agregarUsuarioAgenciaEnTabla(res){ 



function consultarProductos(){
 // productos_todos={};// //productosdisponiblesadquiridosporidagencia
  ajaxActionProducto="consultarproductos"
  //var id_agencia_seleccionada="id_agencia="+idAgenciaActual;
  //var addIdAgencia="id_agencia="+idAgenciaActual;
 $.ajax({ 
      url: pathProductoController+ajaxActionProducto, 
      method: "post", 
      data: "",
      dataType: "json" 
    }) 
    .done(function(res) {  
        var i=0;
      for (i;i<res.length;i++){
        productos_todos[res[i].id_producto]=res[i];
      }
    //  console.log("productos_todos");
    // console.log(productos_todos);
 
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  }); 
}

function mostrarUsuariosAgenciaEnSelect(idAgenciaActual){
	

	
	$('#id_usuario_agencia_solicito').html('');
 // productos_todos={};
  //ajaxActionUsuarioAgencia="consultar"
  var id_agencia_seleccionada="id_agencia="+idAgenciaActual;
  //var addIdAgencia="id_agencia="+idAgenciaActual;
 $.ajax({ 
      url: pathUsuarioAgenciaController+"consultar", 
      method: "post", 
      data: id_agencia_seleccionada,
      dataType: "json" 
    }) 
    .done(function(res) {  
        var i=0;
      for (i;i<res.length;i++){
        $('#id_usuario_agencia_solicito').append($('<option>').text(res[i].nombre + " " + res[i].apellidos)
          .attr('value', res[i].id_usuario_agencia)
          .attr('id', "id_usuario_agencia"+res[i].id_usuario_agencia)
          );
        }
      $('#id_usuario_agencia_solicito').append($('<option>').text("[Otro]")
              .attr('value', "otro")
              .attr('id', "id_usuario_agencia")
              );
      
      
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  }); 
}

//consultarejecutivosporid
function mostrarEjecutivosEnSelect(id_ejecutivo_principal, id_ejecutivo_aux){
$('#id_usuario_admin_atiende').html('');
 // productos_todos={};
  //ajaxActionUsuarioAgencia="consultar"
  var id_agencia_seleccionada="id_agencia="+idAgenciaActual;
  // var id_ejecutivos ={
  // 	 "id_usuario_soporte_titular":datosAgenciaSeleccionada.id_usuario_soporte_titular,
  // 	 "id_usuario_soporte_auxiliar":datosAgenciaSeleccionada.id_usuario_soporte_auxiliar
  // }  
  //var addIdAgencia="id_agencia="+idAgenciaActual;
  // console.log("atosAgenciaSeleccionada.id_usuario_soporte_titular"+datosAgenciaSeleccionada.id_usuario_soporte_titular);
 $.ajax({ 
      url: "public/usuarios/consultarejecutivosporid", 
      method: "post", 
      data: "id_usuario_soporte_titular="+id_ejecutivo_principal+"&id_usuario_soporte_auxiliar="+id_ejecutivo_aux,
      dataType: "json" 
    }) 
    .done(function(res) {  

     // agregar a todos los ejectivos asignados a esta agencia
    	var k= 0;
        $.each( res, function( key, value ) {
        	var n = value.includes("[Titular]");
        	if (n){
        		k = key;
        	}
        	
        	 $('#id_usuario_admin_atiende').append($('<option>').text(value).attr('value', key));
        });
        $("#id_usuario_admin_atiende").val(k);
        
       
        
//      for (i;i<res.length;i++){
//
//        $('#id_usuario_admin_atiende').append($('<option>').text(res[i].nombre + " " + res[i].apellido_paterno)
//          .attr('value', res[i].id_usuario)
//          );
//        }


  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  }); 
}


function submitNuevaOrden(){
	
	var validar = $('input[name=id_poliza]:checked').val();
	if ( validar ===  undefined){
		$("#dataTable-polizas-vigentes").css("background-color" ,'#F5A9BC');
		alert('No hay poliza selecionada.');
		return;
	}
	
	var datos_orden= "Agencia : " + $("#select_agencias option:selected").text() + 
                   "\n Producto :    " +  $("#producto option:selected").text() + 
                   "\n Clave poliza :    " +  polizas[$('input[name=id_poliza]:checked').val()].clave  +
                   "\n Solicitó :    " + $("#id_usuario_agencia_solicito option:selected").text() +
                   "\n Ejecutivo :    " +  $("#id_usuario_admin_atiende option:selected").text() +
                   "\n Motivo :    " + $("#id_motivo option:selected").text() + 
                   "\n Tipo de soporte :    "  + $("#id_tipo_soporte option:selected").text(); 
                   //"\n Descripción: "+  $("#descripcion").val();

	swal({
	  title: "Verifique que los datos sean correctos",
	  text: datos_orden,
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Continuar",
	  closeOnConfirm: false
	},
	function(){
	  $.ajax({ 
	      url: pathOrdenServicioController + "agregar", 
	      method: "post", 
	      data: $("#datosFormServicio").serialize()+"&id_agencia="+idAgenciaActual ,
	      dataType: "json" 
	    }).done(function(res) {  
	      if(res.estado=="ok"){
	          //swal("La orden de servicio ha sido registrada exitosamente", " ", "success");
	          swal({title: "La orden de servicio ha sido registrada exitosamente",   
	           text: "Redireccionando . .", 
	           type: "success",   
	           timer: 2800,   
	           showConfirmButton: false
	          });
	
	        setTimeout(function(){location.reload();}, 2600);
	        
	      }else{
	          swal(res.descripcion, " ", "error"); 
	      }
	  })// end ajax done  
	    .fail(function() { 
	      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
	  });
	});
}

function consultarTodosLosEjectuvos(){
  $.ajax({ 
      url: pathConsultarTodosLosUsuarios, 
      method: "post", 
      data: "",
      dataType: "json" 
    }).done(function(res) {  
      // console.log("mostrar todos los usuarios");
      //  console.log(res);

        for (var i=0; i<res.length;i++){
            if(res[i].es_ejecutivo=="S"){
              //console.log("es eje");
              ejectivos_todos.push(res[i]);
            }
        }
  //  console.log("mostrar todos los ejectivos");
  //  console.log(ejectivos_todos);
               
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
  });
}



function submitFormUsuarioAgencia(){

  //console.log("idAgenciaActual")
  //console.log(idAgenciaActual);
  // en la siguiente variable se almacenan en String los parametros que se deben de incluir para dar de alta un usuario y que no pueden ser nulos
  var parametros_obligatorios="&activo=S" +
                              "&id_agencia="+idAgenciaActual +  
                              "&lider_proy=N" + 
                              "&director=N" + 
                              "&admin_fe=N" + 
                              "&nuevo=N" + 
                              "&actualizar_pass=N" +
                              "&enviar_reporte_portal_mig=N" +
                              "&bajar_updates=N"+
                              "&puesto=" +
                              "&pwd=" + 
                              "&clave=" +$("#emailUsuarioAgencia").val(); 

  //console.log('$("#formUsuarioAgencia").serialize(),');
  //console.log($("#formUsuarioAgencia").serialize());
  $.ajax({ 
      url: pathAgregarUsuarioAgencia , 
      method: "post", 
      data: $("#formUsuarioAgencia").serialize() + parametros_obligatorios,
      dataType: "json" 
    }) 
    .done(function(res) {  
  
  //console.log(res);
  if(res.estado == "ok"){ // si la respuesta es correcta:
        //console.log(res); 
          $('#id_usuario_agencia_solicito').append($('<option>').text(res.nombre + " " + res.apellidos)
          .attr('value', res.id_usuario_agencia)
          .attr('id', "id_usuario_agencia"+res.id_usuario_agencia)
          );
  
          $('#id_usuario_agencia_solicito').val(res.id_usuario_agencia);

      swal("el usuario ha sido guardado exitosamente", " ", "success"); 

  } else{
    swal(res.descripcion, " ", "error"); 
    }

    $('#nuevoUsuarioModal').modal('toggle')
       
  })// end ajax done  
    .fail(function() { 
      swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
      $('#nuevoUsuarioModal').modal('toggle')
  }); 
}

function getProductosByAgencia(){
	var select_agencias = $("#select_agencias").val();
	
	$.ajax({
		  method: "POST",
		  url: "public/productos/consultarproductosdisponiblesporagencia",
		  data: { id_agencia : select_agencias },
		  dataType: "json"
		})
		  .done(function( msg ) {
			  $('#id_producto').find('option').remove();
			  
			  $.each(msg, function( index, value ) {
				  $('#id_producto').append('<option value="'+value.id_producto+'">'+value.nombre_prod+'</option>');
				});
		  });
}

