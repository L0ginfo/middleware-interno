const ManageRoutineData = {

    getStructure: async function(filters) {

        var oResponse = await $.fn.doAjax({
            url: 'movimentacoes-estoques/getStructureMovCnt',
            type: 'POST',
            data: filters
        });

        if (oResponse.status == 200)
            oState.setState('structure', oResponse.dataExtra);
    },

    movimentarContainer: async function(sFormSerialize) {

        var oResponse = await $.fn.doAjax({
            url: 'movimentacoes-estoques/moverContainerResponse',
            type: 'POST',
            data: sFormSerialize
        });

        return oResponse;
    },

    descargaContainer: async function(sFormSerialize, referrer) {

        var oResponse = await $.fn.doAjax({
            url: 'ordens-servico-pendentes/executeOrdemServicoDescargaContainerVisual',
            type: 'POST',
            data: sFormSerialize
        });

        window.location.href = referrer
        return oResponse;
    }
        
}
