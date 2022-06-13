AssociacoesTernosService = {
    baseUrl: url+'/coletores/PlanejamentoMaritimo',

    renderTernos: function(aDataTernos) {
        aTernos = [{"id":"", "descricao":"Selecione"}];

        if(aDataTernos && Array.isArray(aDataTernos)){
            aTernos = aTernos.concat(aDataTernos);
        }

        var sTemplate = oColetorApp.templates.sSelect;
        var oNestedTree = oColetorApp.nestedTree.select_ternos;
        bResult = simpleRender.render('#select_termo_associacao', sTemplate, oNestedTree, aTernos);
        AssociacoesTernosService.addRemoveAssociacaoEvent();
    },

    renderTernoVsPoroes: function(aAssociacoes, aDataTernos) {
        if(!aDataTernos && !Array.isArray(aDataTernos)) aDataTernos = [];
        aAssociacoes = aAssociacoes.filter(function(value){
            return aDataTernos.find(function(oTerno){
                return oTerno.id == ObjectUtil.getDepth(value, 'terno.id');
            });
        });
        var sTemplate = oColetorApp.templates.sAssociacaoTernos;
        var oNestedTree = oColetorApp.nestedTree.associacao_ternos;
        bResult = simpleRender.render('#associacao-terno-porao tbody', sTemplate, oNestedTree, aAssociacoes);
        AssociacoesTernosService.addRemoveAssociacaoEvent();
    },

    postAssociacao: function(porao, terno, planoCarga){
        RequestService.postRespose({
            url:  this.baseUrl+'/addAssociacaoTermo',
            data:{
                porao_id:porao,
                terno_id:terno,
                plano_carga_id:planoCarga
            }
        });
    },

    removeAssociacao: function(id) {
        RequestService.postRespose({
            url:  this.baseUrl+'/deleteAssociacaoTermo/'+id,
        });
    },

    addRemoveAssociacaoEvent:function(){
        $('#associacao-terno-porao .remove-item').click(function(event){
            var id = event.target.dataset.id;
            AssociacoesTernosService.removeAssociacao(id);
        });
    },

    goTo: function(oPlanoCarga){

        if(!oPlanoCarga){
            return alert('Nenhum Plano de Carga Selecionado;.');
        }

        if(!oPlanoCarga.hasOwnProperty('associacao_ternos')){
            return alert('Solicite ao setor de Operações para associar sua turma ao porão.');
        }

        if(oPlanoCarga.associacao_ternos.length <= 0){
            return alert('Solicite ao setor de Operações para associar sua turma ao porão.');
        }

        oColetorApp.core.router([OperacaoService.getAction(oPlanoCarga)]); 
    }
};