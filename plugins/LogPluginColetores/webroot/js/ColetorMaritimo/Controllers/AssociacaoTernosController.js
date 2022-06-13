var AssociacaoTernosController = {
    
    observers: function() {
        oSubject.setObserverOnEvent(function () {
            var aTernos = oState.getState(MenuController.sNavioViagemTernos);
            var oPlanoCarga =  oState.getState(PlanoCargasController.sPlanoCarga);
            if(oPlanoCarga) AssociacoesTernosService.renderTernoVsPoroes(oPlanoCarga.associacao_ternos, aTernos);
        }, ['on_plano_carga_change']);

        oSubject.setObserverOnEvent(function () {
            var aTernos = oState.getState(MenuController.sNavioViagemTernos);
            AssociacoesTernosService.renderTernos(aTernos);

        }, ['on_ternos_change']);
    },


    init: function() {
        AssociacaoTernosController.observers();
    },

    index:function() {
        $('#add-association').click(function(event){
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            var porao_id = $('#select_porao_associacao').val();
            var term_id = $('#select_termo_associacao').val();
            AssociacoesTernosService.postAssociacao(porao_id, term_id, oPlanoCarga.id);
        });

        $('#save-association').click(function(event){
            var oPlanoCarga =  oState.getState(PlanoCargasController.sPlanoCarga);
            AssociacoesTernosService.goTo(oPlanoCarga);
        });
    }
};