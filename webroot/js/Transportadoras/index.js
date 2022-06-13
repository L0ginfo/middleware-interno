// inputs - nao alterar
input = input_id = null

$(".motorista").change(function () {
    input_id = $(this).prev()
    input = $(this)
    listar('motoristas/find')
})

$(".veiculo").change(function () {
    input_id = $(this).prev()
    input = $(this)
    listar('veiculos/find')
})

$('.salvarMotorista').click(function () {
    id = $('#motorista_id').val()
    if (id) {
        url = "transportadoras-motoristas/add"
        data = {motorista_id: id}
        salvarDados(data, url)
    } else {
        alert('Selecione um motorista')
    }
})

$('.salvarVeiculo').click(function () {
    id = $('#veiculo_id').val()
    if (id) {
        url = "/transportadoras-veiculos/add"
        data = {veiculo_id: id}
        salvarDados(data, url)
    } else {
        alert('Selecione um veículo')
    }
})

// listando, nao alterar...
$(document).on('click', '.listando span', function () {
    input_id.val($(this).attr('value'))
    input.val($(this).html())
    $('.listando').remove()
})
// listar
function listar(url) {
    $('.ajaxloader').fadeIn()
    $.ajax({
        url: webroot + url + '/' + input.val(),
        type: "post",
        success: function (data) {
            $('.listando').remove()
            input.parent('div').after('<div class="listando">' + data + '</div>')
            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown)
            location.reload()
        }
    })
}
// fim listando

function salvarDados(data, url) {
    $('.ajaxloader').fadeIn()
    data.transportadora_id = $("#transportadora_id").val()
    console.log(data)
    $.ajax({
        url: webroot + url,
        type: "post",
        data: data,
        success: function (data) {
            if (data == 1) {
                location.reload()
            } else {
                alert("Não salvo")
            }
            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown)
            location.reload()
        }
    })
}