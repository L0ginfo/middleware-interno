var MenuController = {
    sNavioViagemId: 'navioViagem',
    sNavioViagemPlanejamento: 'planejamento',
    sNavioViagemPlanoCargas: 'planejamento_plano_cargas',
    sNavioViagemLinagdasRemocoes: 'lingada_remocoes',
    sNavioViagemTernos: 'ternos',

    observers: function() {
        oSubject.setObserverOnEvent(function () {
            MenuService.onPlanejamentoChange();
            oState.setState(CaracteristicasController.tipo_caracterisca, null);
            oState.setState(CaracteristicasController.caracterisca, null);
        }, ['on_planejamento_change']);
    },

    init: function() {
        MenuController.observers();  
        $('.double').mask('000.000.000,000', {reverse: true});
    },

    index: function() {

        $('#menu-btn').click(function(){
            oState.setState(MenuController.sNavioViagemId, null);
            oState.setState(MenuController.sNavioViagemPLanoCargas, null);
            oState.setState(MenuController.sNavioViagemPlanejamento, null);
            oState.setState(MenuController.sNavioViagemLinagdasRemocoes, null);
            oState.setState(LingadaController.sResv, null);
            oState.setState(LingadaController.sResvid, null);
            oState.setState(LingadaController.sPoraoId, null);
            oState.setState(CaracteristicasController.caracterisca, null);
            oState.setState(CaracteristicasController.tipo_caracterisca, null);
            oColetorApp.core.router(['menu']);
        });

        $('#menu button').click( function(){
            Loader.showLoad(true, 'external', 10000000);
            var sIdNavioViagem = $(this).attr('data-value');

            MenuService.get(sIdNavioViagem, function(oResponse){
                if(oResponse.status == 200){
                    oState.setState(MenuController.sNavioViagemId, sIdNavioViagem);
                    oState.setState(MenuController.sNavioViagemPlanejamento, oResponse.dataExtra.oPlanejamento);
                    oState.setState(MenuController.sNavioViagemPlanoCargas, oResponse.dataExtra.aPlanoCargas);
                    oState.setState(MenuController.sNavioViagemTernos, oResponse.dataExtra.aTernos);
                    oState.setState(ParalisacoesController.Paralisacoes, oResponse.dataExtra.aParalisacoes);

                    $('#tipo-mercadoria').val('');
                    $('#operador').val('');
                    oColetorApp.core.router(['selecao-plano-cargas']);
                    Loader.hideLoad(true)
                }
            });
            
        });
    }
};