var OperacaoController = {
    sOperacaoId: 'operacao',

    observers: function() {
        oSubject.setObserverOnEvent(function () {
            var operacao = oState.getState(
                OperacaoController.sOperacaoId);
            var oPlanoCargas = oState.getState(
                PlanoCargasController.sPlanoCarga);
                
            OperacaoService.renderPoroesOptions(oPlanoCargas);
            OperacaoService.redirect(operacao, oPlanoCargas);
            $('.lf-text-operacao').text(operacao);
        }, ['on_operacao_change']);

        oSubject.setObserverOnEvent(function () {
            $('#operacao_lingada').hide();

            var oPlanoCargas = oState.getState(
                PlanoCargasController.sPlanoCarga);

            if(!oPlanoCargas){
                return;
            }

            if(oPlanoCargas.sentido){
                $('#operacao_lingada').text('1 - ' + oPlanoCargas.sentido.descricao);
                $('#operacao_lingada').show();
            }

            $('#operacao_remocao').show();

        }, ['on_plano_carga_change']);
    },


    init: function() {
        OperacaoController.observers();
    },

    index: function() {
        
        $('#operacao .lf-operacao').click(function(event){
            var oPlanoCargas = oState.getState(PlanoCargasController.sPlanoCarga);
            if(oPlanoCargas.sentido){
                oState.setState(OperacaoController.sOperacaoId, oPlanoCargas.sentido.codigo);
            }
        });

        $('#operacao .lf-paralisacao').click(function(event){
            oColetorApp.core.router(['paralisacoes', 'adicionar']);            
        });

        $('#operacao .lf-remocao').click(function(event){
            oColetorApp.core.router(['remocao']);
        });
    }
};