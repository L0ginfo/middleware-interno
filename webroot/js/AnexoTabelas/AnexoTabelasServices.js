var AnexoTabelasServices = {

    getAnexoTabelas: async function (aData) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'anexo-tabelas/services/getAnexos',
            type: 'POST',
            data: {aData}
        })

        return oReturn
    
    },

    setAnexoSituacao: async function (aData) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'anexo-tabelas/services/setAnexoSituacao',
            type: 'POST',
            data: {aData}
        })

        return oReturn
    
    },

    getInfoRemove: async function (iDataID) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'anexo-tabelas/services/getInfoRemove',
            type: 'POST',
            data: {'aData' : iDataID}
        })

        return oReturn

    }
    
}