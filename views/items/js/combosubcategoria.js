$(document).ready(function() {
    $("#id_categoria").change(function(){
        var id_categoria = $(this).val();
        alert(id_categoria);
        $("#id_subcategoria").html('');
        combosubcategoria(id_categoria);
        
    });
});

function combosubcategoria(id_categoria){
    $.post(_ruta_ + 'items/getsubCategoriascombo/', {id_categoria : id_categoria} , function (data){
        if (data != "[]"){
            var item = $.parseJSON(data);
            $("#id_subcategoria").append('<option value="0">-SELECCIONE-</option>');
                $.each(item, function(i, valor){
                    if (valor.nombre_subcategoria !== null){
                        $("#id_subcategoria").append('<option value="'+valor.id+'">'+valor.nombre_subcategoria+'</option>');
                    }
                });
        }
        return false;
    });  
}
