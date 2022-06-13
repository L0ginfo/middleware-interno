var OperacaoService = {

    
    renderPoroesOptions: function(oPlanoCarga){
        aPoroes = [];

        if(oPlanoCarga){
            aPoroes = oPlanoCarga.poroes;
        }

        aPoroes = [{id: '' , descricao:'Selecione'}].concat(aPoroes);
        var sTemplate = oColetorApp.templates.sSelect;
        var oNestedTree = oColetorApp.nestedTree.select_poroes;
        bResult = simpleRender.render([
            '#select_poroes', 
            '#select_liganda_porao' ,
            '#select_porao_associacao', 
            '#select_porao_lingada',
            '#select_porao_lingada_granel',
        ], sTemplate, oNestedTree, aPoroes);
    },

    redirect:function(operacao, oPlanoCarga){
        
        if(!oPlanoCarga){
            return alert('Não existe plano de carga para a operação solicitada.');        
        }

        if(!oPlanoCarga.plano_carga_tipo_mercadoria){
            return alert('Tipo de Mercadoria não definido no Plano de Carga.');        
        }

        oColetorApp.core.router(['associacao-terno-porao']);
    },

    getAction:function(oPlanoCarga){

        if(!oPlanoCarga){
            return 'lingada'; 
        }

        if(!oPlanoCarga.hasOwnProperty('plano_carga_tipo_mercadoria')){
            return 'lingada';
        }

        if(!oPlanoCarga.plano_carga_tipo_mercadoria.hasOwnProperty('granel')){
            return 'lingada';
        }

        if(!oPlanoCarga.plano_carga_tipo_mercadoria.granel){
            return 'lingada';
        }

        return 'lingada-granel';
    },

    isGranel:function(oPlanoCarga){

        if(!oPlanoCarga){
            return false; 
        }

        if(!oPlanoCarga.hasOwnProperty('plano_carga_tipo_mercadoria')){
            return false;
        }

        if(!oPlanoCarga.plano_carga_tipo_mercadoria.hasOwnProperty('granel')){
            return 'lingada';
        }

        return oPlanoCarga.plano_carga_tipo_mercadoria.granel;
    }
};
