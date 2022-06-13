var RemocoesService = {

    baseUrl: url+'/coletores/PlanejamentoMaritimo',

    render: function(iPoraoId, oPlanoCarga, aTernos) {
        if(!aTernos && !Array.isArray(aTernos)) aTernos = [];
        var aLingadasRemocoes = [];

        if(oPlanoCarga && oPlanoCarga.plano_carga_poroes){
            aLingadasRemocoes = oPlanoCarga.plano_carga_poroes;
        }

        aLingadasRemocoes =  aLingadasRemocoes
            .filter(function(value){
            return value.porao_id == iPoraoId;
        }).reduce(function(array, value){
            return array.concat(value.lingada_remocoes.map(function(map){
                map.qtde = value.qtde_prevista ? value.qtde_prevista:0;
                map.peso = value.tonelagem ? value.tonelagem:0;
                return map;
            }));
        }, []);

        aLingadasRemocoes = aLingadasRemocoes.filter(function(value){
            return aTernos.find(function(oTerno){
                return oTerno.id == value.terno_id;
            });
        });

        var sTemplate = oColetorApp.templates.sLingadaRemocoes;
        var oNestedTree = oColetorApp.nestedTree.lingada_remocoes;
        bResult = simpleRender.render('#remocao tbody', sTemplate, oNestedTree, aLingadasRemocoes);
        this.addRemoveEvent();
        this.renderTotal(aLingadasRemocoes);
        Loader.hideLoad();

    },
    renderTotal:function(aLingadasRemocoes){
        QtdeTotal = 0;
        PesoTotal = 0;
        
        for (var key in aLingadasRemocoes) {
            if(typeof aLingadasRemocoes.hasOwnProperty(key)){
                QtdeTotal += parseFloat(aLingadasRemocoes[key].qtde);
                PesoTotal += parseFloat(aLingadasRemocoes[key].peso);
            }
        }

        QtdeTotal = simpleNumber.formatPtBr(QtdeTotal, 3);
        PesoTotal = simpleNumber.formatPtBr(PesoTotal, 3);
        $("#remocao_total").html(QtdeTotal +' / '+ PesoTotal);

    },
    renderProdutos:function(iPoraoId, oPlanoCarga){
        aPoroes = [];
        var aProdutos = [{id:'', descricao:'Selecione'}];

        if(oPlanoCarga && oPlanoCarga.poroes){
            aPoroes = oPlanoCarga.poroes;
        }

        var oPorao = aPoroes.find(function(object){
            return object.id == iPoraoId;
        });

        if(oPorao && oPorao.hasOwnProperty('plano_carga_poroes')){
            for (var key in oPorao.plano_carga_poroes) {
                var oPlanoCargaPoroes = oPorao.plano_carga_poroes[key];
                oProduto = ObjectUtil.getDepth(oPlanoCargaPoroes, 'produto');                
                if(oProduto && !aProdutos.find(function(value){return value.id == oProduto.id;})){
                    aProdutos.push(oProduto);
                }
            }
        }

        simpleRender.render(
            '.select-produto', 
            oColetorApp.templates.sSelect, 
            oColetorApp.nestedTree.select_produto, 
            aProdutos
        );
    },

    renderPoroesOptions: function(iPoraoId, oPlanoCarga){

        aPoroes = [];

        if(oPlanoCarga){
            aPoroes = oPlanoCarga.poroes;
        }

        aPoroes = [{id: '' , descricao:'Selecione'}].concat(aPoroes);
        var sTemplate = oColetorApp.templates.sSelect;
        var oNestedTree = oColetorApp.nestedTree.select_poroes;

        bResult = simpleRender.render([
            '#select_porao_remocao',
        ], sTemplate, oNestedTree, aPoroes);

        $('#select_porao_remocao').val(iPoraoId);
    },

    post: function(oData) {
        RequestService.postRespose({
            url:  this.baseUrl+'/addRemocao',
            data:oData
        });
    },

    remove: function(id) {
        RequestService.postRespose({
            url:  this.baseUrl+'/deleteRemocao/'+id,
        });
    },

    addRemoveEvent:function(){
        $('#remocao .remove-item').click(function(event){
            // Loader.showLoad(true, 'external', 10000000);
            var id = event.target.dataset.id;
            RemocoesService.remove(id);
        });
    },

    showInputs:function(iPoraoId, oPlanoCarga){
        aCondicoesPoroes = [];

        if(oPlanoCarga && oPlanoCarga.plano_carga_porao_condicoes){
            aCondicoesPoroes = oPlanoCarga.plano_carga_porao_condicoes;
        }

        oCondicaoPorao = aCondicoesPoroes.find(function(value){
            return value.porao_id == iPoraoId;
        });

        if(!oCondicaoPorao || !oCondicaoPorao.mostra_codigo){
            $('.show-produto').show();
            $('.show-codigo').hide();

        }else{

            $('.show-produto').hide();
            $('.show-codigo').show();
        }

        if(!oCondicaoPorao || !oCondicaoPorao.mostra_qtd){
            $('.show-quantidade').hide();
        }else{
            $('.show-quantidade').show();
        }

        if(!oCondicaoPorao || !oCondicaoPorao.mostra_peso){
            $('.show-peso').hide();
        }else{
            $('.show-peso').show();
        }
    }
   
};
