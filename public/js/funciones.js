
function fancyConfirm(msg, callbackYes, callbackNo,aswers) { /*FUNCION QUE ABRE UN CUADRO DE DIALOGO DE CONFIRMACION*/
    var btn1, btn2
    //truquillo javascript
    if(aswers){
        //hago split de la variable
        aswers = aswers.split("-");
        btn1 = aswers[0];
        btn2 = aswers[1];
    }else{
        btn1 = 'Aceptar';
        btn2 = 'Cancelar';
    }
    $.fancybox({
        'modal': true,
        'content': "<div style='margin:1px;width:320px; height:100px;font-size: 14px;' class='alert alert-success'> " +
                msg + "<div style='text-align:right;margin-top:2px;'>" +
                "<a  id='fancyconfirm_cancel' class='btn btn-danger'> " +
                "<i class='icon-white icon-remove'></i> "+btn2+" </a>&nbsp;&nbsp;" +
                "<a  id='fancyConfirm_ok' class='btn btn-success'> " +
                "<i class='icon-white icon-ok'></i> "+btn1+" </a>" +
                "</div></div>",
        'beforeShow': function() {
            $("#fancyconfirm_cancel").click(function() {
                $.fancybox.close();
                callbackNo();

            });

            $("#fancyConfirm_ok").click(function() {
                $.fancybox.close();
                callbackYes();
            });

        }
    });
}

function fancyAlert(msg) {
    jQuery.fancybox({
        'modal': true,
        'padding': 5,
        'margin': 0,
        'content': "<div style='margin:1px;width:320px; height:100px;' class='alert alert-danger'>" + msg +
                "<div style='text-align:right;margin-top:10px;'>" +
                "<a  id='fancyconfirm_cancel' class='btn btn-danger' onclick='jQuery.fancybox.close();'> " +
                "<i class='icon-white icon-ok'></i> Aceptar </a>" +
                "</div></div>"

    });
}

function fancySucces(msg, callbackYes) {
    jQuery.fancybox({
        'modal': true,
        'padding': 5,
        'margin': 0,
        'content': "<div style='margin:1px;width:300px; height:80px;' class='alert alert-success'>" + msg +
                "<div style='text-align:right;margin-top:10px;'>" +
                "<a  id='fancyconfirm_cancel' class='btn btn-success' onclick='jQuery.fancybox.close();'> " +
                "<i class='icon-white icon-ok'></i> Aceptar </a>" +
                "</div></div>",
        'beforeShow': function() {
            $("#fancyconfirm_cancel").click(function() {
                $.fancybox.close();
                callbackYes();

            });
        }

    });
}


function popupwindow(url, w, h) {
    var day = new Date();
    var id = day.getTime();
    var left = (screen.width / 2) - (w / 2);
    var top = ((screen.height / 2) - (h / 2)) - 20;
    return window.open(url, id, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}

function popupwindow2(url, w, h,idu) {
    var left = (screen.width / 2) - (w / 2);
    var top = ((screen.height / 2) - (h / 2)) - 20;
    return window.open(url, idu, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}


function printPage() {
    if (document.all) {
        document.all.divButtons.style.visibility = 'hidden';
        window.print();
        document.all.divButtons.style.visibility = 'visible';
    } else {
        document.getElementById('divButtons').style.visibility = 'hidden';
        window.print();
        document.getElementById('divButtons').style.visibility = 'visible';
    }

}