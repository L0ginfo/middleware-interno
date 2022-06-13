var HistorioService = {

    baseUrl: url+'/coletores/PlanejamentoMaritimo',

    render: function(aPlanoPoroes, aTernos, search) {
        if(!aTernos && !Array.isArray(aTernos)) aTernos = [];
        var sTemplate = oColetorApp.templates.sHistorico;
        var oNestedTree = oColetorApp.nestedTree.lingada_historicos;
        var aLingadas = aPlanoPoroes.reduce(function(sum, value){
            return sum.concat(value.ordem_servico_item_lingadas);
        }, []);

        if (aTernos.length)
            aLingadas = aLingadas.filter(function(value){
                return aTernos.find(function(oTerno){
                    return oTerno.id == value.terno_id;
                });
            });

        aLingadas.sort(function (a, b) {
            if (a.id > b.id) 
                return -1;

            if (a.id < b.id) 
                return 1;
            
            return 0;
        });

        aLingadas = HistorioService.search(aLingadas, search);
        bResult = simpleRender.render('#historico tbody', sTemplate, oNestedTree, aLingadas);
        HistorioService.total(aLingadas);
    },

    search: function(aOrdemServicoItemLingadas, sSearch){
        if(sSearch == null || sSearch == undefined || sSearch == "") return aOrdemServicoItemLingadas;
    
        sSearch = sSearch.toUpperCase();

        return aOrdemServicoItemLingadas.filter(function(value){
            if(value.codigo.toUpperCase().includes(sSearch)) return true;
            return value.resv.hasOwnProperty('veiculo') && 
                value.resv.veiculo.veiculo_identificacao.toUpperCase().includes(sSearch);
        });
    },

    total:function (aLingadas){
        if(!aLingadas && Array.isArray(aLingadas)) aLingadas = [];
        
        var fQtde = 0;
        var fPeso = 0;

        for (var key in aLingadas) {
            fQtde += simpleNumber.parseFloat(aLingadas[key].qtde);
            fPeso += simpleNumber.parseFloat(aLingadas[key].peso);
        }

        fQtde = simpleNumber.formatPtBr(fQtde, 3);
        fPeso = simpleNumber.formatPtBr(fPeso, 3);

        $('#historico_total').html(fQtde +' / '+ fPeso);
    },

    renderRemocoes: function(aPlanoPoroes, aTernos, search) {
        if(!aTernos && !Array.isArray(aTernos)) aTernos = [];
        var sTemplate = oColetorApp.templates.sHistoricoRemocoes;
        var oNestedTree = oColetorApp.nestedTree.lingada_historicos_remocoes;

        aLingadasRemocoes = aPlanoPoroes.reduce(function(array, value){
            return array.concat(value.lingada_remocoes.map(function(map){
                map.qtde = value.qtde_prevista ? value.qtde_prevista:0;
                map.peso = value.tonelagem ? value.tonelagem:0;
                return map;
            }));
        }, []);


        if (aTernos.length)
            aLingadasRemocoes = aLingadasRemocoes.filter(function(value){
                return aTernos.find(function(oTerno){
                    return oTerno.id == value.terno_id;
                });
            });

        aLingadasRemocoes = this.searchRemocao(aLingadasRemocoes, search);
        bResult = simpleRender.render('#historico-remocao tbody', sTemplate, oNestedTree, aLingadasRemocoes);
        HistorioService.totalRemocao(aLingadasRemocoes);
    },

    searchRemocao: function(aLingadasRemocoes, sSearch){
        
        if(sSearch == null || sSearch == undefined || sSearch == "") 
            return aLingadasRemocoes;

        sSearch = sSearch.toUpperCase();

        return aLingadasRemocoes.filter(function(value){
            return value.produto.codigo.toUpperCase().includes(sSearch);
        });
        
    },
    totalRemocao:function (aLingadasRemocoes){
        if(!aLingadasRemocoes && Array.isArray(aLingadasRemocoes))  
            aLingadasRemocoes = [];
        
        var fQtde = 0;
        var fPeso = 0;

        for (var key in aLingadasRemocoes) {
            fQtde += simpleNumber.parseFloat(aLingadasRemocoes[key].qtde);
            fPeso += simpleNumber.parseFloat(aLingadasRemocoes[key].peso);
        }

        fQtde = simpleNumber.formatPtBr(fQtde, 3);
        fPeso = simpleNumber.formatPtBr(fPeso, 3);

        $('#historico_remocao_total').html(fQtde +' / '+ fPeso);
    },

    getPlanoCargaHistoricos:  function() {
        var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga)

        simpleRequest.doAjax({
            url: this.baseUrl + '/getPlanoCargaHistoricos/' + oPlanoCarga.id,
            type: 'GET',
        }, function(oAjaxReturn) {
            if (oAjaxReturn && oAjaxReturn.hasOwnProperty('dataExtra') && oAjaxReturn.dataExtra.hasOwnProperty('oPlanoCarga')) {
                oState.setState(PlanoCargasController.sPlanoCarga, oAjaxReturn.dataExtra.oPlanoCarga)
            }
        });
    }
};
