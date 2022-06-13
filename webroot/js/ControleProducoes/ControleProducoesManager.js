var ControleProducoes = {

    init: async function () {

        this.observers()

        ControleProducoes.watchBtn()
        ControleProducoes.watchBtnAlterarPercentual()
        
    },

    observers: function() {

        oSubject.setObserverOnEvent(async function () {

            var oResponse = await ControleProducoesServices.manageWatchBtn(oState.getState('tipo'))
            Swal.fire({
                type: oResponse.type,
                title: oResponse.title,
                text: oResponse.message,
                showConfirmButton: false,
                timer: 5000 
            })

            return window.location.reload()

        }, ['on_tipo_change'])

        oSubject.setObserverOnEvent(async function () {

            var oResponse = await ControleProducoesServices.manageWatchBtn(oState.getState('set_percentual'))
            Swal.fire({
                type: oResponse.type,
                title: oResponse.title,
                text: oResponse.message,
                showConfirmButton: false,
                timer: 5000 
            })

            return window.location.reload()

        }, ['on_set_percentual_change'])

    },

    watchBtn: function () {
    
        var array = [
            'button_iniciar',
            'button_parar',
            'button_retomar',
            'button_efetivar'
        ]

        array.forEach(sClass => {
            ControleProducoes.manageWatchBtn(sClass)
        });

    },

    manageWatchBtn: function (sClass) {

        $('.'+sClass).click( async function () {

            var iControleProducaoID = $('.controle_producao_id').val()

            oState.setState('tipo', {
                iControleProducaoID: iControleProducaoID,
                sType: sClass,
            })

        })

    },

    watchBtnAlterarPercentual: function () {

        $('.btn_alterar_percentual').click( async function () {

            var oDivGlobalPercentual = $(this).closest('.div_percentual_planejado')
            var iControleProducaoID   = $('.controle_producao_id').val()
            var iProdutoComponenteID  = oDivGlobalPercentual.find('.produto_componente_id').val()
            var iPercentual           = oDivGlobalPercentual.find('.percentual_planejado').val()

            oState.setState('set_percentual', {
                iControleProducaoID: iControleProducaoID,
                iProdutoComponenteID: iProdutoComponenteID,
                iPercentual: iPercentual,
                sType: 'button_alterar_percentual'
            })
 
        })

    }

}

$(document).ready(function() {

    ControleProducoes.init()

    $.fn.numericDouble()

    EnderecoUtil.watchChanges('local')
    EnderecoUtil.watchChanges('area')

})
