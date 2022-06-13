const ManageRoutineData = {

    validaBalanca: async function(balanca) {

        var oResponse = await $.fn.doAjax({
            showLoad: false,
            url: 'portarias/buscaPesoBalanca/' + balanca,
            headers: {
                'private-key': 'b7bfa428b69fe6fa658cd09ead92e12c'
            },
            type: 'GET'
        });

        return oResponse;
    },

    getPassagens: async function(iFluxo) {

        var oResponse = await $.fn.doAjax({
            showLoad: false,
            url: 'portarias/getPassagens/' + iFluxo,
            type: 'GET'
        });

        return oResponse;
    },

    getProgramacao: async function(sPlaca, sReboque1, sReboque2, iBalancaId) {

        var oResponse = await $.fn.doAjax({
            showLoad: false,
            url: 'portarias/getProgramacao',
            type: 'POST',
            data: {
                placa: sPlaca,
                reboque1: sReboque1,
                reboque2: sReboque2,
                balanca_id: iBalancaId
            }
        });

        return oResponse;
    },

    getCracha: async function(iBalancaId) {

        var oResponse = await $.fn.doAjax({
            showLoad: false,
            url: 'portarias/getValidaCracha',
            type: 'POST',
            data: {
                balanca: iBalancaId
            }
        });

        return oResponse;
    },

    consisteResv: async function(iProgramacaoId) {

        var oResponse = await $.fn.doAjax({
            showLoad: false,
            url: 'portarias/consisteResv',
            type: 'POST',
            data: {
                programacao_id: iProgramacaoId
            }
        });

        return oResponse;
    },

    consistePeso: async function(iResvId, peso, iBalancaId) {

        var oResponse = await $.fn.doAjax({
            showLoad: false,
            url: 'portarias/consistePeso',
            type: 'POST',
            data: {
                resv_id: iResvId,
                peso: peso,
                balanca_id: iBalancaId
            }
        });

        return oResponse;
    },

    finalizarOperacao: async function(iBalancaId, iProgramacaoId, fotos, dataRegistro, passagemId, aContainers) {

        var oResponse = await $.fn.doAjax({
            showLoad: false,
            url: 'portarias/finalizarOperacao',
            type: 'POST',
            data: {
                balanca_id: iBalancaId,
                programacao_id: iProgramacaoId,
                fotos: fotos,
                dataRegistro: dataRegistro,
                passagem_id: passagemId,
                containers: aContainers
            }
        });

        return oResponse;
    },

    setMovimentacaoBalanca: async function(iBalancaId) {

        var oResponse = await $.fn.doAjax({
            showLoad: false,
            url: 'portarias/setMovimentacaoBalanca/' + iBalancaId,
            type: 'GET'
        });

        return oResponse;
    },

    setComandoCancela: async function(iCancelaId, sTipo, iAtivo) {

        var oResponse = await $.fn.doAjax({
            showLoad: false,
            url: 'portarias/setComandoCancela/' + iCancelaId + '/' + sTipo + '/' + iAtivo,
            type: 'GET'
        });

        return oResponse;
    },

    consisteUsuarioTela: async function(iBalancaId, bTipoRegistro = 0) {

        var oResponse = await $.fn.doAjax({
            showLoad: false,
            url: 'portarias/consisteUsuarioTela/' + iBalancaId + '/' + bTipoRegistro,
            type: 'GET'
        });

        return oResponse;
    },

    setSituacaoGate: async function(iBalancaId, mensagem) {

        var oResponse = await $.fn.doAjax({
            showLoad: false,
            url: 'portarias/saveSituacaoGate',
            type: 'POST',
            data: {
                balanca: iBalancaId,
                mensagem: mensagem
            }
        });

        return oResponse;
    },

}
