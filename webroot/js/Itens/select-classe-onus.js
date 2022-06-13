$(document).ready(function() {
    getAjax('selecionaClasseOnus', $("#codigo-onu-id").val(), $("#classe-onus"), 'classe-onus');
});

$("#codigo-onu-id").click(function() {
    getAjax('selecionaClasseOnus', $("#codigo-onu-id").val(), $("#classe-onus"), 'classe-onus');
});

$("#classe-onus").click(function() {
    getAjax('selecionaCodigoOnus', $("#classe-onus").val(), $("#codigo-onus"), 'codigo-onus'); 
});

function getAjax (metodo, id, campo, idSelect) {
    $('.ajaxloader').fadeIn();
    $.ajax
    ({ 
        url: webroot + 'Itens/' + metodo + '/' + id,
        type: "POST",
        success: function (result) {
            campo.empty();
            result = jQuery.parseJSON(result);
            var select = document.getElementById(idSelect);
            $.each(result,function(index, value){
                option = new Option(value, index);
                select.options[select.options.length] = option;
            });
            if (metodo == 'selecionaClasseOnus') {
                getAjax('selecionaCodigoOnus', $("#classe-onus").val(), $("#codigo-onus"), 'codigo-onus'); 
            }
        },
        error: function () {
            window.location.reload()
        }
    });
    $('.ajaxloader').fadeOut();
}
