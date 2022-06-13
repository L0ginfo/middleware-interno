var PlanoCargasController = {
    sPlanoCarga: 'plano_carga',
    sPlanoCargaTipoMercadoria: 'plano_carga_tipo_mercadoria',
    sPlanoCargaOperador: 'plano_carga_operador',

    observers: function() {
        oSubject.setObserverOnEvent(function () {
            var aPlanoCargas = oState.getState(MenuController.sNavioViagemPlanoCargas); 
            PlanoCargasService.renderMercadorias(aPlanoCargas);
        }, ['on_planejamento_plano_cargas_change']);

        oSubject.setObserverOnEvent(function () {
            var aPlanoCargas = oState.getState(MenuController.sNavioViagemPlanoCargas);
            var oPlanejamento =  oState.getState(MenuController.sNavioViagemPlanejamento);
            var iTipoMercadoria = oState.getState(PlanoCargasController.sPlanoCargaTipoMercadoria);
            PlanoCargasService.renderOperadores(oPlanejamento, aPlanoCargas, iTipoMercadoria);
        }, ['on_plano_carga_tipo_mercadoria_change']);
    },

    init: function() {
        PlanoCargasController.observers();
    },

    index:function() {

        $('#selecionar-plano-carga').click(function() {
            Loader.showLoad(true, 'external', 10000000);
            if(!$('#tipo-mercadoria').val()){
                Loader.hideLoad();
                return alert('Selecione um Tipo de Mercadoria');
            }

            if(!$('#operador').val()){
                Loader.hideLoad();
                return alert('Selecione um Operador Portuário');
            }

            var iMercadoria = oState.getState(PlanoCargasController.sPlanoCargaTipoMercadoria);
            var iOperador = oState.getState(PlanoCargasController.sPlanoCargaOperador);
            var iPlanejamento = oState.getState(MenuController.sNavioViagemId);

            PlanoCargasService.selecionarPlanoCarga({
                planejamento_id: iPlanejamento,
                plano_carga_mercadoria_id: iMercadoria,
                operador_portuario_id: iOperador,
            });
        });

        $('#tipo-mercadoria').change(function(){
            if(this.value) oState.setState(PlanoCargasController.sPlanoCargaTipoMercadoria, this.value);
        });

        $('#operador').change(function(){
            if(this.value) oState.setState(PlanoCargasController.sPlanoCargaOperador, this.value);
        });
    }
};