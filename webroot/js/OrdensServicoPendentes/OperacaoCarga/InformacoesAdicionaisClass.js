var InformacoesAdicionais = {

    init: function() {

        this.observers()
        InformacoesAdicionais.watchBtnSave()
        InformacoesAdicionais.watchBtnGet()

    },

    observers: function() {

        oSubject.setObserverOnEvent(async function () {

            var oReturn = await Services.setInformacoesAdicionais(oState.getState('set_info'), 'setInformacoesAdicionais')

            $('#modal-info-adicionais').modal('toggle');

            return Utils.swalResponseUtil(oReturn)

        }, ['on_set_info_change'])

        oSubject.setObserverOnEvent(async function () {

            var oReturn = await Services.getInformacoesAdicionais(oState.getState('get_info'), 'getInformacoesAdicionais')

            if (oReturn.status != 200)
                return Utils.swalResponseUtil(oReturn)

            InformacoesAdicionais.setInputs(oReturn.dataExtra)

        }, ['on_get_info_change'])

    },

    watchBtnSave: function() {

        $('.button_salvar_info_adicionais').click( function() {

            var oGlobalDiv = $(this).closest('.global_info_adicionais')
            var oData      = {
                os_id       : oGlobalDiv.find('.os_id_info_adicionais').val(),
                porao       : oGlobalDiv.find('.input_porao').val(),
                viagem      : oGlobalDiv.find('.input_viagem').val(),
                camada_tier : oGlobalDiv.find('.input_camada_tier').val(),
                numero_programacao : oGlobalDiv.find('.input_numero_programacao').val(),
                posicao : oGlobalDiv.find('.input_posicao').val()
            }

            oState.setState('set_info', {
                oData: oData
            })

        })

    },

    watchBtnGet: function() {

        $('.button_get_info_adicionais').click( function() {

            var oData = {
                os_id : $(this).data('id')
            }

            oState.setState('get_info', {
                oData: oData
            })

        })

    },

    setInputs: function(aDataExtra) {

        $('.input_porao').val(aDataExtra.porao)
        $('.input_viagem').val(aDataExtra.viagem)
        $('.input_camada_tier').val(aDataExtra.camada_tier)
        $('.input_numero_programacao').val(aDataExtra.numero_programacao)
        $('.input_posicao').val(aDataExtra.posicao)
    }

}

$(document).ready(function() {

    InformacoesAdicionais.init()

})
