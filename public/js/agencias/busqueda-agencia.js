var path="public/agencias/";

$(document).ready(function() {
    mostrarProductosEnSelect();
}); // end  $(document).ready(function() { 



function submitFormBusquedaAgencia(){
	//console.log("parametros a mandar: ");
	//console.log($("#form_agregar_agencia").serialize());
	//alert($("#licencias option:selected").text());
	//alert($("#licencias").val());
	//alert($("#form-busqueda-agencia").serialize());

	$.ajax({
		  url: path + "busqueda",
		  method: "post",
		  data: $("#form-busqueda-agencia").serialize() ,
		  dataType: "json"
		})
		.done(function(res) {
			alert("Hola");
  		})
		.fail(function() {
    	swal("Error :(", "ocurrió un error con el servidor, por favor intentelo más tarde ", "error" );
  });
} // submitForm(){

function mostrarProductosEnSelect(){
  	productos_todos={};
  	ajaxActionProducto="public/productos/consultarproductos"

	$.ajax({ 
		url: ajaxActionProducto, 
	  	method: "post", 
	  	dataType: "json" 
	}) 
	.done(function(res) {  
		var i=0;
	  	for (i;i<res.length;i++){
	    	productos_todos[res[i].id_producto]=res[i];
	    	$('#licencias').append($('<option>').text(res[i].nombre_prod)
	      	.attr('value', res[i].id_producto)
		    //.attr('id', "id_producto_"+res[i].id_producto)
	      	// .attr('class',"productSelect")
	      	);
	  	}
		$('#licencias').multiSelect();
	})// end ajax done  
	.fail(function() { 
	  swal("Error :(", "ocurrió un error con el servidor, por favor inténtelo más tarde ", "error" ); 
	}); 
}


