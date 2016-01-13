$(document).ready(function() {

    $(document.body).on('click', ".pagina", function() {
        paginacion($(this).attr("pagina"));
    });

    var paginacion = function(pagina) {
        var pagina = 'pagina=' + pagina;
		
        $.post(_ruta_ + 'micuenta/paginacionDinamicaPedido', pagina , function(data) {
            $("#lista_registros").html('');
            $("#lista_registros").html(data);
        });

    };
	
});