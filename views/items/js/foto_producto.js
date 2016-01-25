$(document).ready(function() {

    $(".ventanafoto").fancybox({
        'showCloseButton': false,
        'width': 650,
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

    function borrar_foto(id){
        var valor = $(this).parent().parent().attr('id');
        var parent = $(this).parent().parent();

        fancyConfirm("Est&aacute; seguro que desea eliminar la foto?",
                function() {
                    var respuesta = $.post('http://localhost/sciocco/items/eliminarFotoproducto/'+ id);
                    respuesta.done(function(data) {
                        alert(data);
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