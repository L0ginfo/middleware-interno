CaracteristicasService = {
    baseUrl: url+'/coletores/PlanejamentoMaritimo',

    show:function(){
        $('.modal-caracteristicas').show();
    },

    hide:function(){
        $('.modal-caracteristicas').hide();
        $('.modal-caracteristicas-body').html('');
    },

    get:function(sPageHtml) {
        var isOK = true;
        var aCaracteristicas = [];

        if(!sPageHtml) return [];

        $(sPageHtml+' .caracteristicas').each(function(element){
            aCaracteristicas.push({
                tipo_caracteristica_id: $(this).data('id'),
                caracteristica_id: $(this).val(),
                element: $(this).attr('id')
            });

            if(!$(this).val()){
                isOK = false;
            }

        });

        if(isOK) return aCaracteristicas;

        return false;
    },

    display:function(oItem){

        aPnCaracteriscas = [];

        if(oItem && oItem.hasOwnProperty('codigo')){
            aPnCaracteriscas = CaracteristicasService.getPnCaracteristicas('codigo', oItem.codigo);
        }

        if(oItem && oItem.hasOwnProperty('produto_id')){
            aPnCaracteriscas = CaracteristicasService.getPnCaracteristicas('id', oItem.produto_id);
        }

        CaracteristicasService.render(aPnCaracteriscas);
       
    },

    getPnCaracteristicas:function(coluna, valor){

        var iPorao = oState.getState(LingadaController.sPoraoId);
        var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
        var aPnCaracteriscas = [];

        if(!iPorao || !oPlanoCarga || !oPlanoCarga.hasOwnProperty('poroes')) return;
        
        var oPorao = oPlanoCarga.poroes.find(function(object){
            return object.id == iPorao;
        });

        if(oPorao && oPorao.hasOwnProperty('plano_carga_poroes')){
            oPorao.plano_carga_poroes.forEach(function(value){
                if(value && value.produto && value.produto[coluna] == valor){
                    aPnCaracteriscas = aPnCaracteriscas.concat(value.plano_carga_porao_caracteristicas);
                }
            });
        }

        return aPnCaracteriscas;
    },

    render:function(aPnCaracteristicas){
        var aTipoCaracteristicas = {};

        if(!aPnCaracteriscas || aPnCaracteriscas.length == 0) return CaracteristicasService.hide();

        aPnCaracteristicas.forEach(function(value){
            aTipoCaracteristicas[value.tipo_caracteristica_id] = CaracteristicasService.buildItem(
                aTipoCaracteristicas[value.tipo_caracteristica_id], value
            );
        });

        aTipoCaracteristicas = CaracteristicasService.renderOptions(aTipoCaracteristicas);

        simpleRender.render(
            '.modal-caracteristicas-body', 
            oColetorApp.templates.sCaracteriscas, 
            oColetorApp.nestedTree.caracteriscas, 
            aTipoCaracteristicas
        );

        CaracteristicasService.show();
    },

    buildItem:function(oItem, oPnCaracteristica){

        if(!oItem){
            oItem = oPnCaracteristica.tipo_caracteristica;
            oItem.itens = [oPnCaracteristica.caracteristica];
            return oItem;
        }

        if(!oItem.hasOwnProperty('itens')){
            return oItem;
        }
        
        if(oItem.itens.find(function(item){return item.id != oPnCaracteristica.caracteristica_id;})){
            oItem.itens.push(oPnCaracteristica.caracteristica);
        }

        return oItem;
    },

    renderOptions:function(aTipoCaracteristicas){

        for (var key in aTipoCaracteristicas) {
            aTipoCaracteristicas[key].options = simpleRender.getRender(
                oColetorApp.templates.sSelect, 
                oColetorApp.nestedTree.select, 
                aTipoCaracteristicas[key].itens
            );
        }

        return aTipoCaracteristicas;
    }

};