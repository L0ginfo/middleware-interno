var LingadaService = {
    baseUrl: url+'/coletores/PlanejamentoMaritimo',
    files:[],

    renderitens: function(oPlanoCarga, porao_id, oResv) {
        var aPlanoPoroes = PlanoCargasService.getPcPoroes(oPlanoCarga);
        var resv_id = oResv && oResv.id ? oResv.id : null;
        var aLingadas = [];
        var aPlanoPoroesValid = [];

        aLingadas = aPlanoPoroes.reduce(function(sum, value){
            if(value.porao_id == porao_id){
                aPlanoPoroesValid.push(value);
                sum = sum.concat(value.ordem_servico_item_lingadas);
            }
            return sum;
        }, []);

        aLingadas = aLingadas.reduce(function(sum, value){
            if(value && value.resv_id == resv_id) sum.push(value);
            return sum;
        }, []);

        var sTemplate = oColetorApp.templates.sLingadas;
        var oNestedTree = oColetorApp.nestedTree.lingadas;
        simpleRender.render('#lingada tbody', sTemplate, oNestedTree, aLingadas);
        LingadaService.addRemoveEvent();
        LingadaService.addAvariasEvent();
        // Loader.hideLoad();
    },

    renderTotal: function(oResv, bGranel){
        var aLingadas = oResv && oResv.ordem_servico_item_lingadas ? 
            oResv.ordem_servico_item_lingadas : [];
        var totalUsado = 0;
        var totalTransportado = 0;
        var totalDisponivel = 0;

        $('#finalizar-lingada').removeAttr('disabled');

        if(oResv && oResv.hasOwnProperty('transportadora') && oResv.transportadora){
            totalTransportado = simpleNumber.parseFloat(
                oResv.transportadora.peso_maximo_merc_por_veiculo);
        }

        for (var key in aLingadas) {
            totalUsado += simpleNumber.parseFloat(aLingadas[key].peso);
        }

        totalDisponivel = totalTransportado - totalUsado;

        if(totalDisponivel < 0){
            if(!bGranel) alert('Peso do veiculo excedido: '+
                simpleNumber.formatPtBr(Math.abs(totalDisponivel), 3)+' TON');
            $('#finalizar-lingada').attr("disabled", 'disabled');
        }

        $('#lingada_total').html(simpleNumber.formatPtBr(totalUsado, 3) +' / '+ simpleNumber.formatPtBr(totalDisponivel, 3));
    },

    clearItens: function() {
        var aLingadas = [];
        var sTemplate = oColetorApp.templates.sLingadas;
        var oNestedTree = oColetorApp.nestedTree.lingadas;
        simpleRender.render('#lingada tbody', sTemplate, oNestedTree, aLingadas);
        this.clearTotal();
    },

    clearTotal: function(){
        var total = 0;
        var totalDisponivel = 0;
        $('#lingada_total').html(simpleNumber.formatPtBr(total) +' / '+ simpleNumber.formatPtBr(totalDisponivel));
    },

    renderProdutos:function(oPlanoCarga, porao_id){
        var aPoroes = oPlanoCarga ? oPlanoCarga.poroes: [];
        var aProdutos = [{id:'', descricao:'Selecione'}];

        if(!aPoroes){
            return;
        }

        var oPorao = aPoroes.find(function(object){
            return object.id == porao_id;
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
    
    post: function(oData) {
        RequestService.postRespose({
            url:  this.baseUrl+'/addLigadas',
            data:oData
        });
    },

    remove: function(id) {
        RequestService.postRespose({
            url:  this.baseUrl+'/deleteLigadas/'+id,
        });
    },

    addRemoveEvent:function(){
        $('#lingada .remove-item').click(function(event){
            // Loader.showLoad(true, 'external', 10000000);
            var id = event.target.dataset.id;
            LingadaService.remove(id);
        });
    },

    addAvariasEvent:function name(params) {
        $('#lingada .avarias').click(function(event){
            oState.setState(
                LingadaController.sLingadaId, 
                event.target.dataset.id);
            oColetorApp.core.router(['avarias']);
        });
    },

    verificaExistResv: function (placa){
        if(!placa) return false;
        RequestService.postRespose({url: this.baseUrl+'/verifyPlate/', data: {placa:placa}, timer: 3000});
    },

    salvarFotos: function(oData){

        if(!oData.avaria_id){
            alert('Selecione um Tipo de Avaria.');
            return;
        }

        // if(!LingadaService.files || LingadaService.files.length < 1){
        //     alert('Por favor adicione uma foto.');
        //     return;
        // }

        oData.files = LingadaService.files;

        RequestService.postRespose({
            url: this.baseUrl+'/uploadAvarias',
            data:oData
        });
    },

    convertFiles:function(e){
        LingadaService.files = [];
        var reader;
        var file;

        for (var index = 0; index < e.target.files.length; index++) {
            file = e.target.files[index];
            reader = new FileReader();
            reader.onload = (function(file) {
                return function(e) {
                    LingadaService.files.push({
                        name:file.name,
                        fileName: file.fileName,
                        data: e.target.result
                    });
                };
            })(file);
            reader.readAsDataURL(file);
        }
    },

    renderAvarias: function(oPlanoCargas, lingada_id) {
        var sTemplate = oColetorApp.templates.sLingadaAvarias;
        var oNestedTree = oColetorApp.nestedTree.lingada_avarias;
        var aAvarias  = this.getAvarias(oPlanoCargas, lingada_id);
        simpleRender.render(
            '#avarias tbody', sTemplate, oNestedTree, aAvarias);
        this.renderFotosAvarias();
        this.addFotosEvent();
    },

    getAvarias:function(oPlanoCargas, lingada_id){
        if(oPlanoCargas && oPlanoCargas.hasOwnProperty('plano_carga_poroes')){
            for (var key in oPlanoCargas.plano_carga_poroes) {
                for (var childKey in oPlanoCargas.plano_carga_poroes[key].ordem_servico_item_lingadas) {
                    if (lingada_id == oPlanoCargas.plano_carga_poroes[key].ordem_servico_item_lingadas[childKey].id) {
                        return oPlanoCargas.plano_carga_poroes[key].ordem_servico_item_lingadas[childKey].lingada_avarias;
                    }
                }
            }
        }

        return [];
    },

    addFotosEvent:function(){
        $('#avarias .show-avarias').click(function(event){
            oState.setState(
                LingadaController.sAvariaId, 
                event.target.dataset.id);
            oColetorApp.core.router(['avaria-fotos']);
        });
    },

    renderFotosAvarias:function(oPlanoCargas, lingada_id, avaria_id){
        var aAvarias = this.getAvarias(oPlanoCargas, lingada_id);
        var aFotos = [];
        for (var key in aAvarias) {
            if(aAvarias[key].avaria_id == avaria_id){
                aFotos = aAvarias[key].lingada_avaria_fotos;
            }
        }

        var sTemplate = oColetorApp.templates.sLingadaAvariaFotos;
        var oNestedTree = oColetorApp.nestedTree.lingada_avaria_fotos;
        simpleRender.render('#avaria-fotos .lf-container', sTemplate, oNestedTree, aFotos);

    },

    showInputs:function(oPlanoCargas, iPoraoId){
        var aCondicoesPoroes = oPlanoCargas ? oPlanoCargas.plano_carga_porao_condicoes:[];

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

        if(!oCondicaoPorao || !oCondicaoPorao.mostra_porao_origem){
            $('.show-porao-origem').hide();
        }else{
            $('.show-porao-origem').show();
        }
    }

};
