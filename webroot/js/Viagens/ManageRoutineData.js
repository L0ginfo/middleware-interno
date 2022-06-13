export const ManageRoutineData = {

    state: {
        vagoes: {},
        prog_entradas: [],
        prog_saidas: [],
        vagoes_selected: {},
        prog_containers: []
    },

    getState(sPositionDepth = null) {

        if (sPositionDepth)
            return ObjectUtil.getDepth(ManageRoutineData.state, sPositionDepth)

        return ManageRoutineData.state
    },

    setState(sProperty, uVal) {
        return ManageRoutineData.state[sProperty] = uVal
    },
    
    saveVagao: async function(iViagemId, iVeiculoId) {

        const oResponseUtil = new window.ResponseUtil();

        if (!iVeiculoId)
            return oResponseUtil
                .setTitle('Necessário informar o vagão!')
                .setStatus(400);

        var oResponse = await $.fn.doAjax({
            url: 'viagens/gerarProgramacaoVagao/' + iViagemId + '/' + iVeiculoId,
            type: 'GET'
        });

        return oResponse;
    },

    deleteVagao: async function(iProgramacaoId) {

        const oResponseUtil = new window.ResponseUtil();

        if (!iProgramacaoId)
            return oResponseUtil
                .setTitle('Necessário informar o vagão!')
                .setStatus(400);

        var oResponse = await $.fn.doAjax({
            url: 'programacoes/removeProgramacao/' + iProgramacaoId,
            type: 'GET'
        });

        return oResponse;
    },

    getVagoes: async function(iViagemId) {

        var oResponse = await $.fn.doAjax({
            url: 'viagens/buscaViagemVagoes/' + iViagemId,
            type: 'GET'
        });

        return oResponse;
    },

    getDocEntradas: async function(iViagemId) {

        var oResponse = await $.fn.doAjax({
            url: 'viagens/buscaDocEntradasViagem/' + iViagemId,
            type: 'GET'
        });

        return oResponse;
    },

    getContainers: async function(iViagemId) {

        var oResponse = await $.fn.doAjax({
            url: 'viagens/buscaContainersViagem/' + iViagemId,
            type: 'GET'
        });

        return oResponse;
    },

    getDocSaidas: async function(iViagemId) {

        var oResponse = await $.fn.doAjax({
            url: 'viagens/buscaDocSaidasViagem/' + iViagemId,
            type: 'GET'
        });

        return oResponse;
    },

    manageResvs: async function(aProgramacoes, sTipo) {

        var oResponse = await $.fn.doAjax({
            url: 'programacoes/manageResvEmLote',
            type: 'POST',
            data: {
                aProgramacoes: aProgramacoes,
                sTipo: sTipo
            }
        });

        return oResponse;
    },

    saveContainerFromDocumento: async function(iDocumentoId, aContainers, iOperacaoId, iDriveEspacoId, sTipoContainer, iProgramacaoId) {

        var oResponse = await $.fn.doAjax({
            url: 'programacoes/saveContainersFromDocumento',
            type: 'POST',
            data: {
                documento: iDocumentoId,
                documento_containers: aContainers,
                operacao_id_doc_entrada_saida: iOperacaoId,
                drive_espaco_id: iDriveEspacoId,
                tipo_container: sTipoContainer,
                iProgramacaoId: iProgramacaoId
            }
        });

        return oResponse;
    },

    deleteProgDocEntrada: async function(iProgramacaoDocEntradaId) {

        const oResponseUtil = new window.ResponseUtil();

        if (!iProgramacaoDocEntradaId)
            return oResponseUtil
                .setTitle('Necessário informar qual Doc. Entrada deve ser excluído!')
                .setStatus(400);

        var oResponse = await $.fn.doAjax({
            url: 'programacoes/removeProgramacaoDocEntrada/' + iProgramacaoDocEntradaId,
            type: 'POST',
            data: {
                iProgramacaoDocEntradaId: iProgramacaoDocEntradaId
            }
        });

        return oResponse;
    },

    deleteProgDocSaida: async function(iProgramacaoDocSaidaId) {

        const oResponseUtil = new window.ResponseUtil();

        if (!iProgramacaoDocSaidaId)
            return oResponseUtil
                .setTitle('Necessário informar qual Doc. Saída deve ser excluído!')
                .setStatus(400);

        var oResponse = await $.fn.doAjax({
            url: 'programacoes/removeProgramacaoDocSaida/' + iProgramacaoDocSaidaId,
            type: 'POST',
            data: {
                iProgramacaoDocSaidaId: iProgramacaoDocSaidaId
            }
        });

        return oResponse;
    },

    deleteProgContainer: async function(iProgramacaoContainerID) {

        const oResponseUtil = new window.ResponseUtil();

        if (!iProgramacaoContainerID)
            return oResponseUtil
                .setTitle('Necessário informar qual é o container que deve ser excluído!')
                .setStatus(400);

        var oResponse = await $.fn.doAjax({
            url: 'programacoes/deleteContainer',
            type: 'POST',
            data: {
                iProgramacaoContainerID: iProgramacaoContainerID
            }
        });

        return oResponse;
    },

    setObjInState: async function(object, key, sState) {
        return await $.fn.executeFirst(async function(resolve) {
            var aArray = ManageRoutineData.getState(sState),
                obj  = object;
    
            aArray = Object.assign(aArray, {[key]: obj});

            ManageRoutineData.setState('sState', aArray);

            return resolve()
        })
    },

    setVagoesSelected: async function(oVagao) {
        return await $.fn.executeFirst(async function(resolve) {
            var aVagoes = ManageRoutineData.getState('vagoes_selected'),
                sVagao  = oVagao.text,
                iVagaoId= oVagao.value;
    
              aVagoes = Object.assign(aVagoes, {[iVagaoId]: sVagao});

            ManageRoutineData.setState('vagoes_selected', aVagoes);

            return resolve()
        })
    },

    removeInStateByVagao: async function(iVagaoId, sState = 'vagoes') {
        var aVagoes = ManageRoutineData.getState(sState);
        delete aVagoes[iVagaoId];
        await ManageRoutineData.setState(sState, aVagoes);
    },

    removeDocumentoLista: async function(iVagaoId, iProgDocId, sState) {

        if (!iVagaoId || !iProgDocId || !sState)
            return;

        var aDocumentos = ManageRoutineData.getState(sState);

        aDocumentos[iVagaoId].forEach(function(documento, index) {
            
            if (documento.id == iProgDocId)
                aDocumentos[iVagaoId].splice(index, 1);
        });

        await ManageRoutineData.setState(sState, aDocumentos);
    },

    selectVagao: async function(oVagao) {
        return await $.fn.executeFirst(async function(resolve) {

            var aVagoes = ManageRoutineData.getState('vagoes_selected');
            
            aVagoes = Object.assign(aVagoes, oVagao);
            ManageRoutineData.setState('vagoes_selected', aVagoes);

            return resolve()
        })
    },

    getIfDocHasContainer: async function(iProgramacaoid, iDocEntradaSaida, iOperacaoDocEntradaSaida) {

        var oResponse = await $.fn.doAjax({
            url: 'viagens/saveProgramacaoDescarga',
            type: 'POST',
            data: {
                iProgramacaoId: iProgramacaoid,
                iDocEntradaSaida: iDocEntradaSaida,
                iOperacaoDocEntradaSaida: iOperacaoDocEntradaSaida
            }
        });

        return oResponse;
    },

    saveDocSaida: async function(iProgramacaoId, iDocSaidaId, iTipoDocSaidaId) {

        var oResponse = await $.fn.doAjax({
            url: 'viagens/saveProgramacaoCarga',
            type: 'POST',
            data: {
                iProgramacaoId: iProgramacaoId,
                iNumDocSaidaId: iDocSaidaId,
                iTipoDocumentoId: iTipoDocSaidaId
            }
        });

        return oResponse;
    },

    getNumeroDocumento: function (aVagaoDocs, iProgDocumentoId, sTipoDoc) {

        var sNumeroDoc = '';
        switch (sTipoDoc) {
            case 'entrada':
                sNumeroDoc = aVagaoDocs.filter(function(oDocumento) {
                    if (oDocumento.id == iProgDocumentoId)
                        return oDocumento.documentos_transporte.numero;
                }).map(function(oDoc) { return oDoc.documentos_transporte.numero; });
                break;
            case 'saida':
                sNumeroDoc = aVagaoDocs.filter(function(oDocumento) {
                    if (oDocumento.id == iProgDocumentoId)
                        return oDocumento.liberacoes_documental.numero;
                }).map(function(oDoc) { return oDoc.liberacoes_documental.numero; });
                break;
            case 'container':
                sNumeroDoc = aVagaoDocs.filter(function(oContainer) {
                    if (oContainer.id == iProgDocumentoId)
                        return oContainer.container.numero;
                }).map(function(oContainer) { return oContainer.container.numero; });
                break;
        
            default:
                break;
        }

        return sNumeroDoc;
    },

    saveContainer: async function(sFormSerialize) {
        
        var oResponse = await $.fn.doAjax({
            url: 'programacoes/addContainer',
            type: 'POST',
            data: sFormSerialize
        });

        return oResponse;
    },

    saveHorarioResvs: async function(aResvs, sType) {
        
        var oResponse = await $.fn.doAjax({
            url: 'viagens/registradaHorariosResv',
            type: 'POST',
            data: {
                resvs: aResvs,
                tipo: sType
            }
        });

        return oResponse;
    }
    
}
