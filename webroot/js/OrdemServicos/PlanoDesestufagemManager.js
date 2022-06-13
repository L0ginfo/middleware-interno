var PlanoDesestufagemManager = {

    init: function () {

        PlanoDesestufagemManager.watchClickBtnTipoDesovaTotal()
        PlanoDesestufagemManager.watchClickBtnTipoDesovaParcial()
        
    },

    watchClickBtnTipoDesovaTotal: function () {

        $('.tipo_desova_total').click( function () {

            var oAddLotesContainers = $(this).closest('.adicionar_lotes_containers')
            var oInputsReadonly     = oAddLotesContainers.find('.inputs_readonly')

            oInputsReadonly.each( function () {
                $(this).attr('readonly', true)
            })

        })

    },

    watchClickBtnTipoDesovaParcial: function () {

        $('.tipo_desova_parcial').click( function () {

            var oAddLotesContainers = $(this).closest('.adicionar_lotes_containers')
            var oInputsReadonly     = oAddLotesContainers.find('.inputs_readonly')

            oInputsReadonly.each( function () {
                $(this).attr('readonly', false)
            })

        })

    }

}


$(document).ready(function() {

    PlanoDesestufagemManager.init()
    $.fn.numericDouble()

})
