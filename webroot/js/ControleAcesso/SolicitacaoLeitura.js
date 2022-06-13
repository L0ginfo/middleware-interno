var SolicitacaoLeitura = {

    watchClickSolicitacaoLeituraGravadora: function(iCredenciamentoPessoaId) {
        $('.processa-solicitacao').click(async function(e) {
            e.preventDefault();
        
            var oResponse = await $.fn.doAjax({
                showLoad: false,
                url: 'ControleAcessoSolicitacaoLeituras/add/' + iCredenciamentoPessoaId,
                type: 'POST',
                data: $('form').serialize()
            });
        
            if (oResponse.status != 200)
                return Utils.swalResponseUtil(oResponse);
        
            SolicitacaoLeitura.manageIntervalSolicGravadora();
        })
    },

    manageIntervalSolicGravadora: async function() {

        let responseValidacao = await $.fn.doAjax({
            showLoad: false,
            url: 'ControleAcessoSolicitacaoLeituras/validaRetornoLeitoraGravacao/' + $('select[name="controle_acesso_equipamento_id"]').val(),
            type: 'GET'
        });

        Swal.fire({
            title: 'Processando',
            imageUrl: url + '/custom_pontanegra/img/loader.gif',
            html: 'Registre o cartão/biometria na leitora.',
            showConfirmButton: false,
            showCloseButton: true,
            allowOutsideClick: false
        }).then((result) => {
            if (result.dismiss)
                SolicitacaoLeitura.desativaSolicitacao($('select[name="controle_acesso_equipamento_id"]').val());
        });

        console.log(responseValidacao)

        if (responseValidacao.status == 201) {
            Swal.close();
            Swal.fire({
                title: responseValidacao.message,
                imageUrl: url + '/custom_pontanegra/img/biometria.gif',
                imageWidth: 400,
                imageAlt: responseValidacao.message,
            })
        } else {
            Swal.close();
            Utils.swalResponseUtil(responseValidacao);
        }

    },

    desativaSolicitacao: async function(iControleAcessoEquipamentoId) {
        var oResponse = await $.fn.doAjax({
            showLoad: false,
            url: 'ControleAcessoSolicitacaoLeituras/desativarLeitura/' + iControleAcessoEquipamentoId,
            type: 'GET'
        });

        return Utils.swalResponseUtil(oResponse);
    }


}


