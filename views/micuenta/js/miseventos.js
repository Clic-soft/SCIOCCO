function borrar_mievento(id){
        fancyConfirm("Est&aacute; seguro que desea eliminar el registro?",
                function() {
                    var respuesta = $.post(_ruta_ + 'micuenta/eliminarMiEvento/' + id);
					
                    respuesta.done(function(data) {
                        if ($.isEmptyObject(data)) {
                            window.location.reload();
                        } else {
                            fancyAlert('Error eliminando el registro tiene datos asociados.');
                        }
                    });
                },
                function() {
                    return false;
                });	
	}

$(document).ready(function() {

    $(document.body).on('click', ".pagina", function() {
        paginacion($(this).attr("pagina"));
    });

    var paginacion = function(pagina) {
        var pagina = 'pagina=' + pagina;
		
        $.post(_ruta_ + 'micuenta/paginacionDinamicaMiseventos', pagina , function(data) {
            $("#lista_registros").html('');
            $("#lista_registros").html(data);
        });

    };
	
});