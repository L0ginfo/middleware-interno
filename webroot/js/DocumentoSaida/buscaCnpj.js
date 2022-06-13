var input = null
var input_id = null

$('.buscaCnpjCliente').change(function () {
    input = $(this)
    var tipo = $("#cliente").val()
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

$('.buscaCnpjAdquirente').change(function () {
    input = $(this)
    var tipo = $("#adquirente").val()
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

// $(document).ready(function () {
//     $('.buscaCnpjCliente').attr('autocomplete', 'off');
// });

$(document).ready(function () {
    $('.buscaCnpjDespachante').attr('autocomplete', 'off');
});

// $(document).ready(function () {
//     $('.buscaCnpjAdquirente').attr('autocomplete', 'off');
// });