var LogBoxServices = {

    init: function() {
        
    },

    findContainer: async function(sContainer, sAction) {
        
        var oReturn = await $.fn.doAjax({
            url: 'documentacao-entrada/log-box-services',
            type: 'POST',
            data: {
                sContainer: sContainer,
                sAction: sAction
            }
        })

        return oReturn

    },

    deleteLacre: async function (iLacreId) {

        var oReturn = await $.fn.doAjax({
            url: 'documentacao-entrada/log-box-services',
            type: 'POST',
            data: {
                sAction: 'delete-lacre',
                iLacreId: iLacreId
            }
        })

        return oReturn

    },

    deleteContainer: async function (iItemContainerId, aCheckeds) {

        var oReturn = await $.fn.doAjax({
            url: 'documentacao-entrada/log-box-services',
            type: 'POST',
            data: {
                sAction: 'delete-item-container',
                iItemContainerId: iItemContainerId,
                aCheckeds: aCheckeds
            }
        })

        return oReturn

    }
}
