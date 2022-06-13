var Services = {

    updateProdutoControleEspecificos: async function (aData) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'controle-especificos/services',
            type: 'POST',
            data: {aData}
        })

        return oReturn
    
    },

    saveOrDeleteInDocMercadoriaItem: async function (aData) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'controle-especificos/services/saveOrDeleteInDocMercadoriaItem',
            type: 'POST',
            data: {aData}
        })

        return oReturn

    },

    getDocMercItensControleEspecificos: async function (aData) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'controle-especificos/services/getDocMercItensControleEspecificos',
            type: 'POST',
            data: {aData}
        })

        return oReturn

    }

}
