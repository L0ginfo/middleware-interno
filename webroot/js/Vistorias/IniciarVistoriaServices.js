var IniciarVistoriaServices = {

    getIdFromValue: async function(sColumn, uValue, iRegistroID, sTipoRegistro) {
        
        var oReturn = await $.fn.doAjax({
            url: 'vistorias/iniciar-vistoria-services',
            type: 'POST',
            data: {
                sColumn: sColumn,
                uValue: uValue,
                iRegistroID: iRegistroID,
                sTipoRegistro: sTipoRegistro
            }
        })

        return oReturn

    },

    finalizaVistoriaCarga: async function(iVistoriaID, sTipoCarga, iVeiculoId, iPessoaId, sPlaca, sCpfMotorista) {
        
        var oReturn = await $.fn.doAjax({
            url: 'vistorias/finalizar-vistoria-carga-ajax',
            type: 'POST',
            data: {
                vistoria_id: iVistoriaID,
                sTipoCarga: sTipoCarga,
                iVeiculoId: iVeiculoId,
                iPessoaId: iPessoaId,
                sPlaca: sPlaca,
                sCpfMotorista: sCpfMotorista,
            }
        })

        return oReturn

    }

}
