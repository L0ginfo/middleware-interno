var ControleProducoesServices = {

    manageWatchBtn: async function (aData) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'ControleProducoes/ControleProducoesServices',
            type: 'POST',
            data: {aData}
        })

        return oReturn
    
    },

}
