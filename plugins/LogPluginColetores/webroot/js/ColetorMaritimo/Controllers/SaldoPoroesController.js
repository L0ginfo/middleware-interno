var SaldoPoroesController = {
    observers: function() {

        oSubject.setObserverOnEvent(function () {
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            var aSaldoPoroes = oPlanoCarga.saldo_poroes;
            if(oPlanoCarga && oPlanoCarga.hasOwnProperty('saldo_poroes')){
                SaldoPoroesService.render(aSaldoPoroes);
            }

        }, ['on_plano_carga_change']);

        oSubject.setObserverOnEvent(function () {
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            var aSaldoPoroes = oPlanoCarga.saldo_poroes;
            if(oPlanoCarga && oPlanoCarga.hasOwnProperty('saldo_poroes')){
                SaldoPoroesService.render(aSaldoPoroes);
            }
        }, ['on_terno_change']);
    },

    init: function() {
        SaldoPoroesController.observers();
        SaldoPoroesController.watchBtnSaldoPoroes();
    },

    index: function() {

    },

    
    watchBtnSaldoPoroes: function() {
        $('.lf-btn-saldo-poroes').click(function() {
            SaldoPoroesService.getPlanoCargaSaldoPoroes();
        })
    }
}