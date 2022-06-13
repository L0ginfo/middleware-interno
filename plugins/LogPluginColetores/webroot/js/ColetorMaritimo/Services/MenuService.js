var MenuService = {
    baseUrl: url+'/coletores/PlanejamentoMaritimo',
    get:function(sId, _callback) {
        RequestService.ajaxGet({url: this.baseUrl+'/get/'+sId}, _callback);
    },

    onPlanejamentoChange:function(){
        var oNavioViagemPlanejamento = oState.getState(MenuController.sNavioViagemPlanejamento);
        if(oNavioViagemPlanejamento){
        
            var navio_viagem = 
                oNavioViagemPlanejamento.veiculo.descricao+' - '+
                simpleMask.mask(oNavioViagemPlanejamento.viagem_numero, '###/####');
            $('.lf-text-navio-viagem').text(navio_viagem);
        }
    },
};
