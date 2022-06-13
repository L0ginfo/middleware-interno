var PlanoCargasService = {

    baseUrl: '/coletores/PlanejamentoMaritimo/',

    renderMercadorias:function(aPlanosCarga){
        aMercadorias = [{'id':  '', 'descricao': 'Selecione'}];
        for (var iRenderkey in aPlanosCarga) {
            var oMercadoria = aPlanosCarga[iRenderkey].plano_carga_tipo_mercadoria;
            if(oMercadoria && !aMercadorias.find(function(value){return value.id == oMercadoria.id;})){
                aMercadorias.push(oMercadoria);
            }
        }

        simpleRender.render(
            '#tipo-mercadoria', 
            oColetorApp.templates.sSelect, 
            oColetorApp.nestedTree.select, 
            aMercadorias
        );

    },


    renderOperadores:function(oPlanejamento, aPlanosCarga, iMercadoria){
        aOperadores = [{'id':  '', 'descricao': 'Selecione'}];
        aPlanoCargaOperadores = [];

        aPlanosCarga.forEach(function(oPlano){
            var oMercadoria = oPlano.plano_carga_tipo_mercadoria;
            if(oMercadoria && iMercadoria == oMercadoria.id){
                oPlano.plano_carga_documentos.forEach(function(oDoc){
                    if(oDoc.operador_portuario && !aPlanoCargaOperadores.find(function(value){return value.id == oDoc.operador_portuario.id;})){
                        aPlanoCargaOperadores.push(oDoc.operador_portuario);
                    }
                });           
            }
        });

        if(aPlanoCargaOperadores.length == 0){
            aPlanoCargaOperadores.push(oPlanejamento.operacao_portuaria);
        }
        
        aOperadores = aOperadores.concat(aPlanoCargaOperadores);
        
        simpleRender.render(
            '#operador', 
            oColetorApp.templates.sSelect, 
            oColetorApp.nestedTree.select, 
            aOperadores
        );

    },


    selecionarPlanoCarga:function(oData){
        RequestService.ajaxPost(oRequest = {
            url: PlanoCargasService.baseUrl+'getPlanoCarga',
            data:oData
        }, function(oData){

            if(oData.status == 200 && oData.dataExtra.hasOwnProperty('oPlanoCarga')){
                oState.setState(PlanoCargasController.sPlanoCarga, oData.dataExtra.oPlanoCarga);
                oState.setState(ParalisacoesController.ParalisacaoTimer, oData.dataExtra.iTempoParalisacao);
                oColetorApp.core.router(['operacao']);            
            }
            Loader.hideLoad();

        });
    },

    getPcPoroes:function(oPlanoCarga){
        if(!oPlanoCarga || Array.isArray(oPlanoCarga.plano_carga_poroe)){
            return [];
        }
        return oPlanoCarga.plano_carga_poroes;
    }

};
