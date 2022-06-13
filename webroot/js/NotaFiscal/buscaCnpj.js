var input = null
var input_id = null
$('.buscaCnpjDespachante').change(function () {
    input = $(this)
    var tipo = $("#despachante").val()
    var dataArray = { tipo: tipo };
    if (input.val()) {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + input.attr('url') + '/' + input.val(), 
            data: dataArray,
            type: "post",
            success: function (data) {
                //alert(data)
                $("#campoAdquirente").show(""); 
                $('.list-items-box').remove()
                input.after(data)
                $('.ajaxloader').fadeOut()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro! ' + errorThrown)
                location.reload()
            }
        })
    } else {
        $('.list-items-box').remove()
    }
})

$('.buscaCnpjRepresentante').change(function () {
    input = $(this)
    var tipo = $("#livre").val()
    var dataArray = { tipo: tipo };
    if (input.val()) {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + input.attr('url') + '/' + input.val(), 
            data: dataArray,
            type: "post",
            success: function (data) {
                //alert(data)
                $("#campoAdquirente").show(""); 
                $('.list-items-box').remove()
                input.after(data)
                $('.ajaxloader').fadeOut()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro! ' + errorThrown)
                location.reload()
            }
        })
    } else {
        $('.list-items-box').remove()
    }
})

$(document).on('click', '.list-items', function () {

var campo = input.attr('id')
campo = campo.replace('nome-', '');

$('#' + campo).val($(this).attr('value'))
input.val($(this).html())
$('.list-items-box').remove()
})


$(document).ready(function () {
$('.buscaCnpjDespachante').attr('autocomplete', 'off');
});