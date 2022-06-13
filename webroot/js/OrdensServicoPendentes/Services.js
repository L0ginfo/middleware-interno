var Services = {

    setInformacoesAdicionais: async function (oData, sParam) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'ordem-servicos/services/' + sParam,
            type: 'POST',
            data: {oData}
        })

        return oReturn
    
    },

    getInformacoesAdicionais: async function (oData, sParam) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'ordem-servicos/services/' + sParam,
            type: 'POST',
            data: {oData}
        })

        return oReturn
    
    }

}
