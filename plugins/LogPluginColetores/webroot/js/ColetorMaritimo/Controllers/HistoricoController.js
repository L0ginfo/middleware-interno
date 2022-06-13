var HistoricoController = {

    observers: function() {

        oSubject.setObserverOnEvent(function () {
            var aTernos = oState.getState(MenuController.sNavioViagemTernos);
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            if(oPlanoCarga && oPlanoCarga.hasOwnProperty('plano_carga_poroes')){
                HistorioService.render(oPlanoCarga.plano_carga_poroes, aTernos);
                HistorioService.renderRemocoes(oPlanoCarga.plano_carga_poroes, aTernos);
            }

        }, ['on_plano_carga_change']);

        oSubject.setObserverOnEvent(function () {
            var aTernos = oState.getState(MenuController.sNavioViagemTernos);
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            if(oPlanoCarga && oPlanoCarga.hasOwnProperty('plano_carga_poroes')){
                HistorioService.render(oPlanoCarga.plano_carga_poroes, aTernos);
                HistorioService.renderRemocoes(oPlanoCarga.plano_carga_poroes, aTernos);
            }
        }, ['on_terno_change']);
    },

    init: function() {
        HistoricoController.observers();
        HistoricoController.watchBtnHistorico();
    },

    index: function() {

        $('#search-field').change(function(event){
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            var aTernos = oState.getState(MenuController.sNavioViagemTernos);
            if(oPlanoCarga && oPlanoCarga.hasOwnProperty('plano_carga_poroes'))
                HistorioService.render(oPlanoCarga.plano_carga_poroes, aTernos, $(this).val());

        });

        $('#search-remocao-field').change(function(event){
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            var aTernos = oState.getState(MenuController.sNavioViagemTernos);
            if(oPlanoCarga && oPlanoCarga.hasOwnProperty('plano_carga_poroes'))
                HistorioService.renderRemocoes(oPlanoCarga.plano_carga_poroes, aTernos, $(this).val());
        });

    },

    watchBtnHistorico: function() {
        $('.lf-btn-historico').click(function() {
            HistorioService.getPlanoCargaHistoricos();
        })
    }
};