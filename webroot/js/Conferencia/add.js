$("#item").change(function () {
    input = $(this)
    $('.ajaxloader').fadeIn()
    $.ajax({
        url: webroot + 'itens/find',
        type: "post",
        data: {
            pesquisa_por: $("#pesquisar-por").val(),
            item: $("#item").val(),
            possui_pack: $('#possui-pack').is(':checked'),
            navio: $("#navio").val(),
            cliente: $("#cliente-id").val(),
        },
        success: function (data) {
            $('.listar-itens').remove()
            input.after('<div class="listar-itens">' + data + '</div>')
            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown)
            location.reload()
        }
    })
})

$("#possui-pack").change(function () {
    atualizaConferencia($(this).is(':checked'))
})

$("#navio").change(function () {
    if ($("#cliente-id").is(':visible')) {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + 'itens/find-cliente/' + $(this).val(),
            type: "post",
            success: function (data) {
                $('#cliente-id').html(data)
                salvarConferencia()
                $('.ajaxloader').fadeOut()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro! ' + errorThrown)
                location.reload()
            }
        })
    }
})

$("#veiculo-id").change(function () {
    if ($("#veiculo-id").is(':visible')) {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + 'transportadoras/find/' + $(this).val(),
            type: "post",
            success: function (data) {
                $('#transportadora-id').html(data)
                $('#transportadora-id').selectpicker('refresh')
                salvarConferencia()
                $('.ajaxloader').fadeOut()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro! ' + errorThrown)
                location.reload()
            }
        })
    }
})

$("#transportadora-id, #motorista-id, #reboque-1, #reboque-2").change(function () {
    if ($(this).val()) {
        salvarConferencia()
    }
})

$(".inserir").click(function (e) {
    e.preventDefault()
    if ($("#item").val() != '' && $("#item-id").val() != '') {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + 'translados/add',
            type: "post",
            data: $('form').serialize(),
            success: function (data) {
                $('#cliente-id').html(data)
                $('.ajaxloader').fadeOut()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro! ' + errorThrown)
                location.reload()
            }
        })
    } else {
        alert('Preencha itens e quantidade!')
    }
})

$(document).on('click', '.listar-itens a', function () {
    $("#item-id").val($(this).attr('id'))
    $("#item").val($(this).html())
    $(".listar-itens").remove()
})

function atualizaConferencia(possuiPak)
{
    if (possuiPak) {
        $("#cliente-id").parent('div').hide()
        $("#quantidade").parent('div').parent('div').hide()
    } else {
        $("#cliente-id").parent('div').show()
        $("#quantidade").parent('div').parent('div').show()
    }

}

function salvarConferencia() {
    $.ajax({
        url: webroot + 'conferencias/add',
        type: "post",
        data: $('form').serialize(),
        success: function (data) {
            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown)
            location.reload()
        }
    })
}