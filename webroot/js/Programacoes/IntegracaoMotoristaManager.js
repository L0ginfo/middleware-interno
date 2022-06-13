var IntegracaoMotoristaManager = {

    init: async function() {

        await IntegracaoMotoristaManager.watchTransportadora()

    },

    watchTransportadora: async function() {

        $('.selectpicker.watch_transportadora').on('changed.bs.select', function (e) {

            var sCnpj = $(this).closest('form').find('.watch_transportadora').find("option:selected").text()

            if (sCnpj) {
                IntegracaoMotoristaManager.manageSelectMotorista(sCnpj);
                IntegracaoMotoristaManager.manageSelectVeiculo(sCnpj);
            }

        });

    },

    manageSelectMotorista: function(sCnpj) {
        // $(".selectpicker.watch_motorista").attr("data-cnpj", sCnpj)

        var oSelect = $('.copy_motorista').find('select').html()

        $('.div_selectpicker_motorista > div').remove()
        $('.div_selectpicker_motorista > span').remove()

        // $('.div_selectpicker_motorista').html(oSelect)

        $('.copy_motorista').removeClass('hidden')

        Utils.doSelectpickerAjax('select_motorista', url + 'pessoas/filterQuerySelectpicker', {}, {
            q: '{{{q}}}',
            busca: '{{{q}}}',
            value: 'cpf-descricao', 
            key: 'id',
            cnpj: sCnpj
        })

        $('select[name="select_motorista"]').attr('name', 'programacao[pessoa_id]')
        $('select[name="programacao[pessoa_id]"]').closest('.copy_motorista').find('label').text('Morotista')
    },

    manageSelectVeiculo: function(sCnpj) {
        // $(".selectpicker.watch_motorista").attr("data-cnpj", sCnpj)

        var oSelect = $('.copy_veiculo').find('select').html()

        $('.div_selectpicker_veiculo > div').remove()
        $('.div_selectpicker_veiculo > span').remove()

        // $('.div_selectpicker_motorista').html(oSelect)

        $('.copy_veiculo').removeClass('hidden')

        Utils.doSelectpickerAjax('select_veiculo', url + 'veiculos/filterQuerySelectpicker', {}, {
            q: '{{{q}}}',
            busca: '{{{q}}}',
            value: 'cpf-descricao', 
            key: 'id',
            cnpj: sCnpj
        })

        $('select[name="select_veiculo"]').attr('name', 'programacao[veiculo_id]')
        $('select[name="programacao[veiculo_id]"]').closest('.copy_veiculo').find('label').text('Placa (cavalo)')
    }

}