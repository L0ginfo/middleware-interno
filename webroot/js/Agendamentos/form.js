$(document).ready(function () {
    // listaFaixa()
    $('#hora-inicio').mask('00:00', {reverse: true});
})

$('#btnNovoEntrada').click(function (e) {
    $('#novoentrada').val('1')
})

$('.rejeitar').click(function () {
    input = $(this)
    $('.ajaxloader').fadeIn()

    $.ajax({
        url: webroot + 'agendamentos/alterarSituacao/' + input.attr('agendamento_id') + '/-1/calendario/' + $('#comentario').val(), // empresas/index
        type: "post",
        // data: $('form').serialize(),
        success: function (data) {
            alert('Rejeitado com sucesso!')
            location.reload()
            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown)
            location.reload()
        }
    })
})

$('.chegar').click(function () {
    input = $(this)
    window.location = webroot + 'agendamentos/confirmar/' + input.attr('agendamento_id') + '/' + 'chegar' + '/' + $('#comentario').val();
})

$('.liberar').click(function () {
    input = $(this)
    window.location = webroot + 'agendamentos/confirmar/' + input.attr('agendamento_id') + '/' + 'liberar' + '/' + $('#comentario').val();
})

$('.liberarOperacao').click(function () {
    input = $(this)
    window.location = webroot + 'agendamentos/confirmar/' + input.attr('agendamento_id') + '/' + 'liberarOperacao' + '/' + $('#comentario').val();
})

$('.confirmar').click(function (e) {
    if (e.preventDefault) {
        if ($('.duploclick').is(":visible")) {
            $('.duploclick').hide();
            input = $(this)
            window.location = webroot + 'agendamentos/confirmar/' + input.attr('agendamento_id') + '/' + 'confirmado' + '/' + $('#comentario').val();
        }

        e.preventDefault()

    } else {
        e.returnValue = false;
    }
})

$('.anularchegada').click(function () {
    input = $(this)
    window.location = webroot + 'agendamentos/confirmar/' + input.attr('agendamento_id') + '/' + 'anularchegada' + '/' + $('#comentario').val();
})

function  alterarAprovar() {
    input = $('#aprovar_agendamento')
    // alert( input.attr('urlRetorno'))
    window.location = webroot + 'agendamentos/alterarSituacao/' + input.attr('agendamento_id') + '/20/' + input.attr('urlRetorno') + '/' + $('#comentario').val();
}

function  alterarReprovar() {
    input = $('#aprovar_agendamento')
    //  alert( input.attr('urlRetorno'))
    window.location = webroot + 'agendamentos/alterarSituacao/' + input.attr('agendamento_id') + '/20/' + input.attr('urlRetorno') + '/' + $('#comentario').val();
}