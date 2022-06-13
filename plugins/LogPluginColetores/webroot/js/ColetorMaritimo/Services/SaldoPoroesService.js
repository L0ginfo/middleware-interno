var SaldoPoroesService = {

    baseUrl: url+'/coletores/PlanejamentoMaritimo',

    render: function(aSaldoPoroes) {
        var sTemplate = oColetorApp.templates.sSaldoPoroes;
        var oNestedTree = oColetorApp.nestedTree.lingada_saldo_poroes;
        console.log(aSaldoPoroes)
        bResult = simpleRender.render('#saldo-poroes tbody', sTemplate, oNestedTree, aSaldoPoroes);
    },

    getPlanoCargaSaldoPoroes:  function() {

        var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga)

        simpleRequest.doAjax({
            url: this.baseUrl + '/getPlanoCargaSaldoPoroes/' + oPlanoCarga.id,
            type: 'GET',
        }, function(oAjaxReturn) {
            if (oAjaxReturn && oAjaxReturn.hasOwnProperty('dataExtra') && oAjaxReturn.dataExtra.hasOwnProperty('oPlanoCarga')) {
                oState.setState(PlanoCargasController.sPlanoCarga, oAjaxReturn.dataExtra.oPlanoCarga)
            }
        });
    }
};