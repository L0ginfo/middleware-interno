const VeiculosPesagensData = {
    getStateVeiculoByPlaca: function(sPlaca) {
        var aVeiculosPesagens = oState.getState('veiculos_pesagens')
        var oVeiculoPesagemFinded = {}

        try {
            aVeiculosPesagens.forEach(oVeiculoPesagem => {
                if (oVeiculoPesagem.veiculo.veiculo_identificacao == sPlaca) {
                    oVeiculoPesagemFinded = oVeiculoPesagem
                    return;
                }
            })
        } catch (e) { }

        return oVeiculoPesagemFinded
    },
    getPesagemID: function() {
        return iConstPesagemID
            ? iConstPesagemID 
            : oState.getState('pesagem_id')
    }
}