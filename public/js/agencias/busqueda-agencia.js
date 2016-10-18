var path="public/agencias/";


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