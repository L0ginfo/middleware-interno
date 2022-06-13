var ParalisacoesService = {

    baseUrl: url+'/coletores/PlanejamentoMaritimo',

    saveNotify:function(oData){
        if(!oData.paralisacao_motivo_id){
            return alert('Por favor, selecione o motivo da paralisação.');
        }

        if(!oData.porao_id && oData.sParalisacaoMotivo != 'Não é uma Paralisação'){
            return alert('Por favor, selecione o porão.');
        }

        RequestService.ajaxPost({
            url: this.baseUrl+'/addParalisacao/',
            data:oData,
        }, function (oResponse) {

            alert(oResponse.message);

            if(oResponse.dataExtra.iTempoParalisacao){
                oState.setState(ParalisacoesController.ParalisacaoTimer, oResponse.dataExtra.iTempoParalisacao);
            }

            if(oResponse.dataExtra.aParalisacoes){
                oState.setState(ParalisacoesController.Paralisacoes, oResponse.dataExtra.aParalisacoes);
            }
    
            $('#modal-paralisacoes').hide();
            $('#modal-paralisacoes select').val('');
            $('#modal-paralisacoes textarea').val('');
        });
    },

    startInterval: function(iParalisacao){

        if(!iParalisacao){
            return;
        }

        iParalisacaTime = iParalisacao;
        window.interval = window.setInterval(this.interval, 1000);
    },

    interval: function(){
        var iTimestamp = (new Date().getTime() / 1000);
        var iParalizacaoTimestamp = oState.getState(ParalisacoesController.ParalisacaoTimer);
        if(iParalizacaoTimestamp > 0 && (iTimestamp > iParalizacaoTimestamp)){
            $('#modal-paralisacoes').show();
            clearInterval(window.interval);
        }
    },

    finishIntevalo:function (){
        window.clearInterval(window.interval);
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
            '.porao_id',
        ], sTemplate, oNestedTree, aPoroes);

        $('.porao_id').val(iPoraoId);
    },

    add:function(oData){

        if(!oData.paralisacao_motivo_id){
            alert('Por favor, selecione  o motivo da paralisação.');
            return;
        }

        if(!oData.data_hora_inicio){
            alert('Por favor, preencha data inicio.');
            return;

        }

        if(!oData.data_hora_fim){
            alert('Por favor, preencha data fim.');
            return;
        }

        if(!oData.porao_id && oData.sParalisacaoMotivo != 'Não é uma Paralisação'){
            alert('Por favor selecione o porão');
            return;
        }

        RequestService.postRespose({
            url:  this.baseUrl+'/addParalisacao/',
            type: 'POST',
            data:oData
        });
    },

    edit:function(iId, oData){

        if(!iId){
            alert('Falha ao localizar id.');
            return;
        }

        if(!oData.paralisacao_motivo_id){
            alert('Por favor, selecione  o motivo da paralisação.');
            return;
        }

        if(!oData.data_hora_inicio){
            alert('Por favor, preencha data inicio.');
            return;
        }

        if(!oData.data_hora_fim){
            alert('Por favor, preencha data fim.');
            return;
        }

        if(!oData.porao_id && oData.sParalisacaoMotivo != 'Não é uma Paralisação'){
            alert('Por favor selecione o porão');
            return;
        }

        RequestService.postRespose({
            url:  this.baseUrl+'/editParalisacao/'+iId,
            type: 'POST',
            data:oData
        });
    },

    initEditEvent:function(){
        $('#paralisacoes .edit').click(function(){
            var iId = $(this).data('id');

            var aParalisacoes = oState.getState(
                ParalisacoesController.Paralisacoes);

            aParalisacoes = aParalisacoes ? aParalisacoes: [];

            oParalisacao = aParalisacoes.find(function(value){
                return value.id == iId;
            });

            ParalisacoesRender.edit(oParalisacao);
            oColetorApp.core.router(['paralisacoes', 'editar']);
        });
    },

    initRemoveEvent:function(){
        $('#paralisacoes .remove').click(function(){
            var iId = $(this).data('id');

            if(!iId){
                return alert('Falha ao buscar id.');
            }

            RequestService.postRespose({
                url:  ParalisacoesService.baseUrl+'/deleteParalisacao/'+iId,
                type: 'POST'
            });
        });
    }
};
