$(document).ready(function() {

    $(document.body).on('click', ".pagina", function() {
        paginacion($(this).attr("pagina"));
    });

    var paginacion = function(pagina) {
        var pagina = 'pagina=' + pagina;
        
        $.post(_ruta_ + 'configuracion/paginacionDinamicat_novedades', pagina , function(data) {
            $("#lista_registros").html('');
            $("#lista_registros").html(data);
        });

    };

    $(".ventanat_novedad").fancybox({
        'showCloseButton': true,
        'width': 670,
        'height': 370,
        'autoSize': false,
        'autoDimensions': false,
        'transitionIn': 'none',
        'transitionOut': 'none',
        'type': 'iframe',
        'beforeClose': function() {
            window.location.reload();
        }

    });
    
});

function borrar_t_novedad(id){
        var valor = $(this).parent().parent().attr('id');
        var parent = $(this).parent().parent();

        fancyConfirm("Est&aacute; seguro que desea eliminar el registro?",
                function() {
                    var respuesta = $.post(_ruta_ + 'configuracion/eliminart_novedad/'+ id);
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