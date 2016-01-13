$(document).ready(function() {
  
    $(".ventanita").fancybox({
        'showCloseButton': false,
        'width': 460,
        'height': 300,
        'autoSize': false,
        'autoDimensions': false,
        'transitionIn': 'none',
        'transitionOut': 'none',
        'type': 'iframe',
        iframe: {
            scrolling: 'no',
            preload: true
        }

    });
    
    $("#huella").fancybox({
        'showCloseButton': false,
        'width': '500',
        'height': 360,
        'autoSize': false,
        'transitionIn': 'none',
        'transitionOut': 'none',
        'type': 'iframe'
       /* 'beforeClose': function() {
            $("#refrescarpedido").load(_ruta_ + 'cliente/refrescapedido/' + $("#cliente").val());
        }*/

    });


});

