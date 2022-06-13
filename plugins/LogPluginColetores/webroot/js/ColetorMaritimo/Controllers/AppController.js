var AppController = {

    init: function() {

        MenuController.init();
        MenuController.index();

        ParalisacoesController.init();
        ParalisacoesController.index();
        ParalisacoesController.add();
        ParalisacoesController.edit();

        PlanoCargasController.init();
        PlanoCargasController.index();

        OperacaoController.init();
        OperacaoController.index();

        AssociacaoTernosController.init();
        AssociacaoTernosController.index();

        CaracteristicasController.init();
        CaracteristicasController.index();

        LingadaController.init();
        LingadaController.index();
        LingadaController.poroes();
        LingadaController.avarias();

        LingadasGranelController.init();
        LingadasGranelController.index();
        
        HistoricoController.init();
        HistoricoController.index();

        SaldoPoroesController.init();
        SaldoPoroesController.index();

        RemocoesController.init();
        RemocoesController.index();
        
    }
};



$(document).ready(function(){
    AppController.init();
});

