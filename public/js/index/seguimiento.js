$(document).ready(function(){
	$("#pagination a").click(function(){
		var page = $(this).attr('data-page');
		//alert('pushado'+page+'-'+n_rows);
		$("#filtroform").append('<input type="hidden" name="page" value="'+page+'" id="page">').trigger("submit");
	});
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        startView: 0,
        language: "es",
        autoclose: true
    });
});
