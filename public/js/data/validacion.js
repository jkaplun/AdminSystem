$(document).ready(function() {
	soloNumeros('cp');
	soloNumeros('tel1');
	soloNumeros('tel2');
	soloNumeros('lic_icaavwin');
	soloNumeros('lic_iriswin');
	soloNumeros('lic_gvc');
	soloNumeros('lic_centauro');

	soloLetrasNumeros('direccion')

	soloLetras('colonia');
	soloLetras('nombre');

	soloLetrasDot('nombre_comercial');


    function soloNumeros(inputElementId) {
        var textbox = document.getElementById(inputElementId);

        textbox.addEventListener("keydown", function _OnNumericInputKeyDown(e) {
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 || //190 Dot
		         // Allow: Ctrl+A, Command+A
		        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
		         // Allow: home, end, left, right, down, up
		        (e.keyCode >= 35 && e.keyCode <= 40)) {
		             // let it happen, don't do anything
		             return;
		    }
		    // Ensure that it is a number and stop the keypress
		    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		        e.preventDefault();
		    }
        });
	
	}

    function soloLetras(inputElementId) {
        var textbox = document.getElementById(inputElementId);

        textbox.addEventListener("keydown", function _OnNumericInputKeyDown(e) {
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 || //190 Dot
		         // Allow: Ctrl+A, Command+A
		        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
		         // Allow: home, end, left, right, down, up
		        (e.keyCode >= 35 && e.keyCode <= 40)) {
		             // let it happen, don't do anything
		             return;
		    }
		    // Ensure that it is a number and stop the keypress
		    if (!(e.keyCode >= 65 && e.keyCode <= 120) && (e.keyCode != 32 && e.keyCode != 0)){
		        e.preventDefault();
		    }
        });
	}

    function soloLetrasDot(inputElementId) {
        var textbox = document.getElementById(inputElementId);

        textbox.addEventListener("keydown", function _OnNumericInputKeyDown(e) {
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || //190 Dot
		         // Allow: Ctrl+A, Command+A
		        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
		         // Allow: home, end, left, right, down, up
		        (e.keyCode >= 35 && e.keyCode <= 40)) {
		             // let it happen, don't do anything
		             return;
		    }
		    // Ensure that it is a number and stop the keypress
		    if (!(e.keyCode >= 65 && e.keyCode <= 120) && (e.keyCode != 32 && e.keyCode != 0)){
		        e.preventDefault();
		    }
        });
	}

	    function soloLetrasNumeros(inputElementId) {
        var textbox = document.getElementById(inputElementId);

        textbox.addEventListener("keydown", function _OnNumericInputKeyDown(e) {
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || //190 Dot
		         // Allow: Ctrl+A, Command+A
		        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
		         // Allow: home, end, left, right, down, up
		        (e.keyCode >= 35 && e.keyCode <= 40)) {
		             // let it happen, don't do anything
		             return;
		    }
		    // Ensure that it is a number and stop the keypress
		    if (!(e.keyCode >= 65 && e.keyCode <= 120) && (e.keyCode != 32 && e.keyCode != 0) || (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)){
		        e.preventDefault();
		    }
        });
	}


});