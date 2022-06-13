var ContainersServices = {

    checkDriveEspaco: async function(oData) {
        var oResponse = await $.fn.doAjax({
            url: 'drive-espacos/check-drive-espaco',
            type: 'POST',
            data: oData
        })

        return oResponse
    },

    getIdFromValue: async function(sTable, sColumn, uValue, iContainerID = null) {
        
        var oReturn = await $.fn.doAjax({
            url: 'resvs/containers-services',
            type: 'POST',
            data: {
                sTable: sTable,
                sColumn: sColumn,
                uValue: uValue,
                iContainerID: iContainerID
            }
        })

        return oReturn

    },

    getContainersDocumento: async function(iDocEntradaSaida, iOperacaoDocEntradaSaida) {
        
        var oReturn = await $.fn.doAjax({
            url: 'resvs/get-containers-documento',
            type: 'POST',
            data: {
                iDocEntradaSaida: iDocEntradaSaida,
                iOperacaoDocEntradaSaida: iOperacaoDocEntradaSaida
            }
        })

        return oReturn

    },

    validaEstoqueContainer: async function (iContainerID, sTipoContainer) {

        var oReturn = await $.fn.doAjax({
            url: 'containers/validaEstoqueContainer/' + iContainerID + '/' + sTipoContainer,
            type: 'GET'
        });

        return oReturn;

    },

    verifyExistsAgendamentoDocumento: async function (iNumeroDocEntrada, oDocumentoContainers, iProgramacaoID, oDriveEspacos) {

        var oReturn = await $.fn.doAjax({
            url : 'programacoes/verifyExistsAgendamentoDocumento',
            type: 'POST',
            data: {
                iNumeroDocEntrada   : iNumeroDocEntrada,
                oDocumentoContainers: oDocumentoContainers,
                iProgramacaoID      : iProgramacaoID,
                oDriveEspacos       : oDriveEspacos
            }
        })

        return oReturn
    },
    
    getDriveEspacoByContainerID: async function (iContainerID, iOperacaoID) {
        var oResponse = await $.fn.doAjax({
            url: 'drive-espacos/get-drive-by-container/',
            type: 'POST',
            data: {
                container_id: iContainerID,
                operacao_id: iOperacaoID
            }
        });

        if (oResponse.status != 200)
            return null;

        return oResponse.dataExtra.drive_espaco;
    },

    getParamObrigaDriveEspaco: async function () {
        var oResponse = await $.fn.doAjax({
            url: 'drive-espacos/getParamObrigaDriveEspaco/',
            type: 'POST'
        });

        if (oResponse.status != 200)
            return null;

        return oResponse.dataExtra;
    },

    getArmadorByContainerID: async function (iContainerID) {
        var oResponse = await $.fn.doAjax({
        url: 'containers/get-armador-by-container/' + iContainerID,
            type: 'GET'
        });

        if (oResponse.status != 200)
            return null;

        return oResponse.dataExtra.armador;
    },

    getClienteDocumento: async function (iContainerID, iOperacaoID, iDocumento) {
        var oResponse = await $.fn.doAjax({
        url: 'containers/get-cliente-documento/' + iContainerID + '/' + iOperacaoID + '/' + iDocumento,
            type: 'GET'
        });

        if (oResponse.status != 200)
            return null;

        return oResponse.dataExtra.cliente;
    },

}
