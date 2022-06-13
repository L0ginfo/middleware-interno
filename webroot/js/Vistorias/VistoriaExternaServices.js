var VistoriaExternaServices = {

    saveLacre: async function(sLacre, iLacreTipoId, iVistoriaId, iVistoriaItemId = null) {

        var oResponse = await $.fn.doAjax({
            url: 'vistoria-lacres/saveLacre',
            type: 'POST',
            data: {
                lacre: sLacre,
                lacre_tipo: iLacreTipoId,
                vistoria: iVistoriaId,
                vistoria_item: iVistoriaItemId,
            }
        });

        return oResponse;
    },

    removeLacre: async function(iLacreId) {

        var oResponse = await $.fn.doAjax({
            url: 'vistoria-lacres/removeLacre',
            type: 'POST',
            data: {
                lacre_id: iLacreId
            }
        });

        return oResponse;
    },

    getLacres: async function (iVistoriaId, iVistoriaItemId = null) {

        var oResponse = await $.fn.doAjax({
            url: 'vistoria-lacres/getLacres/' + iVistoriaId + '/' + (iVistoriaItemId ? iVistoriaItemId : ''),
            type: 'GET'
        });

        return oResponse;
        
    },

}
