var Services = {

    desovarItens: async function (aData) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'OrdensServicoPendentes/OperacaoDesovaServices',
            type: 'POST',
            data: {aData}
        })

        return oReturn
    
    },

    estornarItens: async function (aData) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'OrdensServicoPendentes/OperacaoDesovaServices',
            type: 'POST',
            data: {aData}
        })

        return oReturn
    
    },

    gerarVistoria: async function (aData) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'OrdensServicoPendentes/OperacaoDesovaServices',
            type: 'POST',
            data: {aData}
        })

        return oReturn
    
    },

    desovarItensIncremental: async function (aData) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'OrdensServicoPendentes/OperacaoDesovaServices',
            type: 'POST',
            data: {aData}
        })

        return oReturn
    
    },

}
