var LingadaGranelService = {

    baseUrl: url+'/coletores/PlanejamentoMaritimo',

    renderSelectTernos: function(aAssociacoes) {
        var sTemplate = oColetorApp.templates.sSelect;
        var oNestedTree = oColetorApp.nestedTree.select_termos;
        bResult = simpleRender.render(['#select_termo_associacao_porao'], sTemplate, oNestedTree, aAssociacoes);
    },

    showTermosPorao:function (oPlanoCarga, porao_id){
        var aAssociacaoTernos = oPlanoCarga ? 
            oPlanoCarga.associacao_ternos : [];
        var aData = [];

        for (var key in aAssociacaoTernos) {
            if(aAssociacaoTernos[key].porao_id == porao_id){
                aData = LingadaGranelService.filterContainsAlready(aAssociacaoTernos[key], aData);
            }
        }

        LingadaGranelService.renderSelectTernos(aData);
    },

    filterContainsAlready: function (value, array){

        for (var childrenKey in array) {
            if(array[childrenKey].terno_id == value.terno_id){
                return array;
            }
        }

        array.push(value);
        return array;
    },


    renderitens: function(oPlanoCarga, porao_id, oResv, bGranel) {
        var aPlanoPoroes = PlanoCargasService.getPcPoroes(oPlanoCarga);
        var resv_id = oResv && oResv.id ? oResv.id : null;
        var aLingadas = [];
        var aPlanoPoroesValid = [];

        aLingadas = aPlanoPoroes.reduce(function(sum, value){
            if(value && value.porao_id == porao_id){
                aPlanoPoroesValid.push(value);
                sum = sum.concat(value.ordem_servico_item_lingadas);
            }
            return sum;
        }, []);

        aLingadas = aLingadas.reduce(function(sum, value){
            if(value && value.resv_id == resv_id) sum.push(value);
            return sum;
        }, []);
        
        var sTemplate = oColetorApp.templates.sLingadasgGranel;
        var oNestedTree = oColetorApp.nestedTree.lingadas_granel;
        bResult = simpleRender.render('#lingada-granel tbody', sTemplate, oNestedTree, aLingadas);
        LingadaGranelService.addRemoveEvent();
        Loader.hideLoad();
    },


    renderTotal: function(oResv, bGranel){
        var aLingadas = oResv && oResv.ordem_servico_item_lingadas ? 
            oResv.ordem_servico_item_lingadas : [];
        var totalUsado = 0;
        var totalTransportado = 0;
        var totalDisponivel = 0;

        $('#finalizar-lingada-granel').removeAttr('disabled');

        if(oResv && oResv.hasOwnProperty('transportadora') && oResv.transportadora){
            totalTransportado = simpleNumber.parseFloat(
                oResv.transportadora.peso_maximo_merc_por_veiculo);
        }

        for (var key in aLingadas) {
            totalUsado += simpleNumber.parseFloat(aLingadas[key].peso);
        }

        totalDisponivel = totalTransportado - totalUsado;

        if(totalDisponivel < 0){
            if(bGranel) alert('Peso do veiculo excedido: '+
                simpleNumber.formatPtBr(Math.abs(totalDisponivel), 3)+' TON');
            $('#finalizar-lingada-granel').attr("disabled", 'disabled');
        }

        $('#lingada_granel_total').html(simpleNumber.formatPtBr(totalUsado, 3) +' / '+ simpleNumber.formatPtBr(totalDisponivel, 3));
    },

    clearItens: function() {
        var aLingadas = [];

        var sTemplate = oColetorApp.templates.sLingadasgGranel;
        var oNestedTree = oColetorApp.nestedTree.lingadas_granel;
        bResult = simpleRender.render('#lingada-granel tbody', sTemplate, oNestedTree, aLingadas);
        this.clearTotal();
    },

    clearTotal: function(){
        var total = 0;
        var totalDisponivel = 0;

        $('#lingada_granel_total').html(simpleNumber.formatPtBr(total, 3) +' / '+ simpleNumber.formatPtBr(totalDisponivel, 3));
    },

    post: function(oData){
        RequestService.postRespose({
            url:  this.baseUrl+'/addLigadaGranel',
            data:oData
        });
    },

    remove: function(id) {
        RequestService.postRespose({
            url:  this.baseUrl+'/deleteLigadaGranel/'+id,
            type: 'POST'
        });
    },

    addRemoveEvent:function(){
        // Loader.showLoad(true, 'external', 10000000);
        $('#lingada-granel .remove-item').click(function(event){
            var id = event.target.dataset.id;
            LingadaGranelService.remove(id);
        });
    },
};
