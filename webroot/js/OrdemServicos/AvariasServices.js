var AvariasServices = {

    saveAvaria: async function(oData) {

        var oResponse = await $.fn.doAjax({
            url: 'ordens-servico-pendentes/avariaServices',
            type: 'POST',
            data: {
                oData: oData,
                sTipo: 'saveAvaria'
            }
        });

        return oResponse;
    },

    removeAvaria: async function(iAvariaID) {

        var oResponse = await $.fn.doAjax({
            url: 'ordens-servico-pendentes/avariaServices',
            type: 'POST',
            data: {
                oData: {
                    iOSAvairaID: iAvariaID
                },
                sTipo: 'removeAvaria'
            }
        });

        return oResponse;
    },

    getAvarias: async function (iOSID, iContainerID) {

        var oResponse = await $.fn.doAjax({
            url: 'ordens-servico-pendentes/avariaServices',
            type: 'POST',
            data: {
                oData: {
                    iOSID: iOSID,
                    iContainerID: iContainerID
                },
                sTipo: 'getAvarias'
            }
        });

        return oResponse;

    },

}
