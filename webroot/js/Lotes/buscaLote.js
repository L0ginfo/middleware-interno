$(document).ready(function () {
    if ($('#conhecimento').val() == '') {
        atualizarCamposViagem()
    }

})

$('#conhecimento, #data-conhecimento').change(function () {

    conhecimento = $('#conhecimento').val()
    dataconhecimento = $('#data-conhecimento').val()
    dataconhecimento = dataconhecimento.replace('/', '-')
    dataconhecimento = dataconhecimento.replace('/', '-')
    if (conhecimento && dataconhecimento) {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + 'Lotes/getLote/' + conhecimento + '/' + dataconhecimento, // empresas/index
            type: "post",
            //data: $('form').serialize(),
            success: function (data) {
                dados = JSON.parse(data)
                if (dados.id) {

                    $('#ce-mercante').val(dados.ce_mercante)
                    $('#referencia-cliente').val(dados.referencia_cliente)
                    $('#pais-id').val(dados.pais_id)
                    $('#familia-codigo').val(dados.familia_codigo)
                    $('#moeda-id').val(dados.moeda_id)
                    $('#valor-seguro').val(dados.valor_seguro)
                    $('#valor-fob').val(dados.valor_fob)
                    $('#valor-frete').val(dados.valor_frete)
                    $('#valor-cif-label').val(dados.valor_cif)
                    $('#valor-cif').val(dados.valor_cif)

                }

                $('.ajaxloader').fadeOut()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro! ' + errorThrown)
                location.reload()
            }

        })
    }
})

$('#codigo-viagem-sara').change(function () {

    atualizarCamposViagem()
})

function atualizarCamposViagem() {
    navio = $('#codigo-viagem-sara').val();
    $('.ajaxloader').fadeIn()
    $.ajax({
        url: webroot + 'Lotes/find_recinto/' + navio,
        type: "post",
        //data: $('form').serialize(),
        success: function (data) {
            dados = JSON.parse(data)
            if (dados.rec_id) {
                $('#recinto-id option:selected').removeAttr('selected');
                $("#recinto-id option[value='" + dados.rec_id + "']").prop('selected', true);

                $('#procedencia-id option:selected').removeAttr('selected')
                $("#procedencia-id option[value='" + dados.proc_id_portal + "']").prop('selected', true)
            }

            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.ajaxloader').fadeOut()
        }

    })
}


