// $(document).ready(function() {
	// soloNumeros('cp');
	// soloNumeros('tel1');
	// soloNumeros('tel2');
	// soloNumeros('lic_icaavwin');
	// soloNumeros('lic_iriswin');
	// soloNumeros('lic_gvc');
	// soloNumeros('lic_centauro');

	// soloLetrasNumeros('direccion')

	// soloLetras('colonia');
	// soloLetras('nombre');

	// soloLetrasDot('nombre_comercial');


    function soloNumeros(inputElementId) {
        var textbox = document.getElementById(inputElementId);

        textbox.addEventListener("keydown", function _OnNumericInputKeyDown(e) {
		    if(!(e.keyCode == 8 || e.keyCode == 37 || e.keyCode == 39)) {
			    var regex = new RegExp("^[0-9\t]+$");
			    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			    if (regex.test(str)) {
			        return true;
			    }
			    e.preventDefault();
	    		return false;
    		}
        });
	
	}

    function soloLetras(inputElementId) {
        var textbox = document.getElementById(inputElementId);

        textbox.addEventListener("keydown", function _OnNumericInputKeyDown(e) {
        	if(!(e.keyCode == 8 || e.keyCode == 37 || e.keyCode == 39)) {
			    var regex = new RegExp("^[a-zA-Z \t]+$");
			    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			    if (regex.test(str)) {
			        return true;
			    }

			    e.preventDefault();
	    		return false;
    		}
        });
	}

    function soloLetrasDot(inputElementId) {
        var textbox = document.getElementById(inputElementId);

        textbox.addEventListener("keypress", function _soloLetrasDot(e) {
        	if(!(e.keyCode == 8 || e.keyCode == 37 || e.keyCode == 39)) {
			    var regex = new RegExp("^[a-zA-Z. \t]+$");
			    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			    if (regex.test(str)) {
			        return true;
			    }

			    e.preventDefault();
	    		return false;
    		}
        });
	}

	function soloLetrasNumeros(inputElementId) {
        var textbox = document.getElementById(inputElementId);

        textbox.addEventListener("keypress", function _soloLetrasNumeros(e) {
        	if(!(e.keyCode == 8 || e.keyCode == 37 || e.keyCode == 39)) {
			    var regex = new RegExp("^[a-zA-Z0-9 .\t]+$");
			    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			    if (regex.test(str)) {
			        return true;
			    }

			    e.preventDefault();
	    		return false;
    		}
        });
	}


// });