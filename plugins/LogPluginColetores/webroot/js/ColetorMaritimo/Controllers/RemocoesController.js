var RemocoesController = {
    sRemocaoPorao : 'remocao_porao',

    observers: function() {

        oSubject.setObserverOnEvent(function () {
            var aTernos = oState.getState(
                MenuController.sNavioViagemTernos);
            var oPlanoCarga = oState.getState(
                PlanoCargasController.sPlanoCarga);
            var iPoraoId = oState.getState(
                LingadaController.sPoraoId);
            RemocoesService.render(iPoraoId, oPlanoCarga, aTernos);
            RemocoesService.renderPoroesOptions(iPoraoId, oPlanoCarga);
            RemocoesService.renderProdutos(iPoraoId, oPlanoCarga);
            RemocoesService.showInputs(iPoraoId, oPlanoCarga);
        }, ['on_plano_carga_change']);

        oSubject.setObserverOnEvent(function () {
            var aTernos = oState.getState(
                MenuController.sNavioViagemTernos);
            var oPlanoCarga = oState.getState(
                PlanoCargasController.sPlanoCarga);
            var iPoraoId = oState.getState(
                LingadaController.sPoraoId);
            RemocoesService.render(iPoraoId, oPlanoCarga, aTernos);
            RemocoesService.renderProdutos(iPoraoId, oPlanoCarga);
            RemocoesService.showInputs(iPoraoId, oPlanoCarga);
            if(!iPoraoId) $('#select_porao_remocao').val(iPoraoId);
        }, ['on_porao_id_change']);
    },

    init: function() {
        RemocoesController.observers();
    },

    index: function() {

        $('#select_porao_remocao').change(function(event){
            var porao = oState.getState(RemocoesController.sRemocaoPorao);
            var value = $(this).val();

            if(value) return oState.setState(
                LingadaController.sPoraoId, value);
                
            $(this).val(porao);
        });


        $('#remocao-lingada').click(function(event){
            // Loader.showLoad(true, 'external', 10000000);
            var oPlanoCarga = oState.getState(
                PlanoCargasController.sPlanoCarga);
            var iOperadorid = oState.getState(
                PlanoCargasController.sPlanoCargaOperador);
            var iPoraoId = oState.getState(
                LingadaController.sPoraoId);
            var iRemocaoId = $('#select-remocao').val();
            var uCaracteristicas = CaracteristicasService.get('#remocao');
            var iProdutoId = $('#produto-remocao').is(':visible') ? 
                $('#produto-remocao').val() : '';
            var sCodigo = $('#codigo-remocao').is(':visible') ? 
                $('#codigo-remocao').val() : '';
            var fPeso = $('#peso').is(':visible') ? $('#peso').val() : '';
            var iQtde = $('#quantidade').is(':visible') ? $('#quantidade').val() : '';
    
            if(!uCaracteristicas){
                return alert('Por favor, selecione todas as características disponíveis.');
            }

            if(!iRemocaoId){
                return alert('Por favor, selecione uma remocão.');
            }

            if(!iPoraoId){
                return alert('Por favor, selecione uma porão.');
            }

            RemocoesService.post({
                plano_carga_caracteristicas:    uCaracteristicas,
                operador_portuario_id:          iOperadorid,
                plano_carga_id:                 oPlanoCarga.id,
                remocao_id:                     iRemocaoId,
                porao_id:                       iPoraoId,
                produto_id:                     iProdutoId,
                codigo:                         sCodigo,
                quantidade:                     iQtde,
                peso:                           fPeso,
            });

        });

        $('#finalizar-remocao').click(function(){
            oState.setState(MenuController.sNavioViagemId, null);
            oState.setState(MenuController.sNavioViagemPLanoCargas, null);
            oState.setState(MenuController.sNavioViagemPlanejamento, null);
            oState.setState(MenuController.sNavioViagemLinagdasRemocoes, null);
            oState.setState(LingadaController.sResv, null);
            oState.setState(LingadaController.sResvid, null);
            oState.setState(LingadaController.sPoraoId, null);
            oState.setState(CaracteristicasController.caracterisca, null);
            oState.setState(CaracteristicasController.tipo_caracterisca, null);
            oColetorApp.core.router(['/']);            
        });
    }
};