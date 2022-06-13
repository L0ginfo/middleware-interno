$(document).on('click', '.marcaItens', function () {
    $('.carregamento').each(function (i) {
        $(this).val($(this).attr('max'))
    });
})

$(document).on('click', '.marcaItens', function () {
    $('.carregamento_select option').each(function (i) {
        this.selected = (this.value == '1');
    });
})

$(document).on('change', '.cbx_todos', function () {
    $('.cbx_marcar').each(function (i) {
        $(this).attr("checked", $(".cbx_todos").is(':checked'));
    });
})

$(document).on('change', '#empresa-id', function () {
    var url = $('#url_retorno').val();

    if (url == 'liberado-clientefinais') {
        window.location.href = webroot + 'agendamentos/liberarEmpresaVinculada/' + $(this).val();
    } else {
        window.location.href = webroot + 'agendamentos/selecionar-itens-carga/' + $("#agendamento_id").val() + '/' + $(this).val();
    }
})

$(document).ready(function () {
    var cod_cliente = $('#empresa-id  option:selected').val()

    $("#pesquisa-doc-saida").mousedown(function () {
        getCombo("#pesquisa-doc-saida", cod_cliente, 'doc_saida', '0')
    });

    $("#pesquisa-lote").mousedown(function () {
        getCombo("#pesquisa-lote", cod_cliente, 'latu_lote', '0')
    });

    $("#pesquisa-item").mousedown(function () {
        getCombo("#pesquisa-item", cod_cliente, 'item', 'desc_produto')
    });

    $("#pesquisa-pack").mousedown(function () {
        getCombo("#pesquisa-pack", cod_cliente, 'pack_bobina', '0')
    });
});

function getCombo(combo_id, cod_cliente, campo, valor) {
    if ($(combo_id + '  option').size() > 1) {
        return
    }

    var $select = $(combo_id);
    $select.find('option').remove();
    $select.append('<option value=0>Aguarde...</option>');
    $.ajax({
        url: webroot + 'agendamentos/getCombo/' + $("#agendamento_id").val() + '/' + campo + '/' + valor + '/' + cod_cliente,
        type: "post",
        //data: $('form').serialize(),
        success: function (data) {
            var $select = $(combo_id);
            $select.find('option').remove();
            $select.append('<option value=0>Selecione</option>');
            $.each(JSON.parse(data), function (key, value) {
                //  key = str.replace(new RegExp('"', ''), key);
                $select.append('<option value="' + key + '">' + value + '</option>');
            });

            //    $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //alert('Erro! ' + errorThrown)
            location.reload()
        }
    })
}

