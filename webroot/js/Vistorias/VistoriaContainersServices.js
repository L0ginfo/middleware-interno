var VistoriaContainersServices = {

    getIdFromValue: async function(sColumn, uValue, iContainerId) {
        
        var oReturn = await $.fn.doAjax({
            url: 'vistorias/vistoria-containers-services',
            type: 'POST',
            data: {
                sColumn: sColumn,
                uValue: uValue,
                iContainerId: iContainerId
            }
        })

        return oReturn

    },

    finalizaVistoria: async function(iVistoriaID) {

        var oReturn = await $.fn.doAjax({
            url: 'vistorias/finalizar-vistoria-container-ajax',
            type: 'POST',
            data: {
                vistoria_id: iVistoriaID
            }
        })

        return oReturn

    }

}
