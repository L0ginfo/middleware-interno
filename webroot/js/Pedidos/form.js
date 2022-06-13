$(function () {
    // colocando icones
    $('label[for="contato"]').before('<span class="glyphicon glyphicon-search fa-fw cursor-pointer getContato"></span> ')
    $('label[for="endereco-entrega"]').before('<span class="glyphicon glyphicon-search fa-fw cursor-pointer getEndereco"></span> ')
})

$(document).on('click', '.getContato', function () {
    cliente_id = $("#cliente-id").val()
    if (cliente_id != "") {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + 'contatos/getContatos/' + cliente_id,
            type: "post",
            success: function (data) {
                $('.ajaxloader').fadeOut()
                $.fancybox({
                    content: data,
                    autoSize: false,
                    width: '800px',
                    height: 'auto'
                })
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro! ' + errorThrown)
                location.reload()
            }
        })
    } else {
        alert("Escolha um cliente por favor")
    }
})

$(document).on('click', '.getEndereco', function () {
//$('.getEndereco').click(function () {
    cliente_id = $("#cliente-id").val()
    if (cliente_id != "") {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + 'enderecos/getEnderecos/' + cliente_id,
            type: "post",
            success: function (data) {
                $('.ajaxloader').fadeOut()
                $.fancybox({
                    content: data,
                    autoSize: false,
                    width: '800px',
                    height: 'auto'
                })
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro! ' + errorThrown)
                location.reload()
            }
        })
    } else {
        alert("Escolha um cliente por favor")
    }
})

$(document).on('click', 'table.contato tr td', function () {
    $("#contato").val($(this).html())
    $.fancybox.close()
})

$(document).on('click', 'table.endereco tr td', function () {
    $("textarea[name='endereco_entrega']").val($(this).html())
    $.fancybox.close()
})
