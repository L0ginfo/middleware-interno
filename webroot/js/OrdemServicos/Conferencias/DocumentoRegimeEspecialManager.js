var DocumentoRegimeEspecialManager = {
    itens:function(array){
        if(!Array.isArray(array) || array.length <= 0) array = [{id:''}];
        array = array.map((value, index) =>  {
            value.key = index; 
            let fDisponivel = ObjectUtil.getDepth(value, 'documento_regime_especial_adicao_item.quantidade');
            let fAferido = ObjectUtil.getDepth(value, 'quantidade');
            let fPeso = ObjectUtil.getDepth(value, 'peso');
            let fTotal = ObjectUtil.getDepth(value, 'total');
            fAferido = fAferido ? fAferido :0;
            fPeso = fPeso ? fPeso :0;
            fDisponivel = fDisponivel ? fDisponivel : 0;
            fTotal = fTotal ? fTotal :0;
            fSaldo = parseFloat(fDisponivel) - parseFloat(fTotal);
            value.disponivel = Utils.showFormatFloat(parseFloat(fDisponivel));
            value.saldo = Utils.showFormatFloat(parseFloat(fSaldo));
            value.aferida = Utils.showFormatFloat(parseFloat(fAferido));
            value.peso = Utils.showFormatFloat(parseFloat(fPeso));

            if(value.hasOwnProperty('documento_regime_especial_adicao_item'))
                value.documento_regime_especial_adicao_item.sequencia = 
                value.documento_regime_especial_adicao_item.sequencia.toString().padStart(3, '0');

            return value;
        });
        DocumentoRegimeEspecialRender.itens(array);
        setTimeout(function(){
            DocumentoRegimeEspecialController.watchAdicaoChange();
            DocumentoRegimeEspecialController.watchItensChange();
        }, 1000);
    },
    adicaoItens:function(array){
        if(!Array.isArray(array) || array.length <= 0) array = [];
        array = array.map((value, index) =>  {
            if(value.hasOwnProperty('sequencia')) 
                value.sequencia = value.sequencia.toString().padStart(3, '0');
            return  value;
        });
        DocumentoRegimeEspecialRender.adicao_itens([{id:''}].concat(array));
        setTimeout(function(){
            DocumentoRegimeEspecialController.watchItensChange();
        }, 1000);
    },
    adicaoItem:function(object){
        let aItens = oState.getState(DocumentoRegimeEspecialController.sItens);
        if(!Array.isArray(aItens) || aItens.length <= 0) aItens = [];
        if(!object || object === undefined || typeof object !== 'object') object = {id:0};

        const aItemValidos = aItens.filter(function(value){
            return value.documento_regime_especial_adicao_item_id == object.id;
        });

        DocumentoRegimeEspecialRender.adicao_item(object);
    },
    adicao:function(oAdicao){
        const array = oAdicao.documento_regime_especial_adicao_itens;
        oState.setState(DocumentoRegimeEspecialController.sAdicaoItens, array);
    },
    item:function(oItem){
        oState.setState(DocumentoRegimeEspecialController.sAdicaoItem, oItem);
    },
    add:function(){
        const aNewItem  = [{id:'', active:'active'}];
        const aItens    = oState.getState(DocumentoRegimeEspecialController.sItens);
        const aItenNew  = !Array.isArray(aItens) || aItens.length <= 0 ? aNewItem : aItens.concat(aNewItem);
        DocumentoRegimeEspecialManager.itens(aItenNew);
        $('.conforme').attr('disabled', false);
    },
    remove:function(that, e){
        const aNewItem      = [{id:''}];
        const iOrdemServico = $('[name="ordem_servico_id"]').val();
        const iId = $('.os-conferencia .lf-body-data-item.active .lf-adicao-id').val();
        if(iId) return DocumentoRegimeEspecialService.remove(iOrdemServico, iId);
        const aItens = oState.getState(DocumentoRegimeEspecialController.sItens);
        oState.setState(DocumentoRegimeEspecialController.sItens, aItens);
    },

    buttons: function (){
        const uDocNaoConforme = $('[name="nao_conforme"]').val();
        const uDesconsolidado = $('[name="desconsolidado"]').val();
        const uId = $('.lf-body-data-item.active').find('.lf-adicao-id').val();
        const uNaoConforme =  $('.lf-body-data-item.active').find('.lf-adicao-nao-conforme').val();
        const iId = uId ? parseInt(uId) : 0;
        const iNaoConforme = uNaoConforme ? parseInt(uNaoConforme) : 0;
        const iDocNaoConforme = uDocNaoConforme ? parseInt(uDocNaoConforme) : 0;
        const iDesconsolidado = uDesconsolidado ? parseInt(uDesconsolidado) : 0;

        console.log(iDesconsolidado);

        if(iDesconsolidado || iDocNaoConforme || iNaoConforme || iId){
            $('.conforme').attr('disabled', true); 
        }else{
            $('.conforme').removeAttr('disabled');
        }

        if(iDesconsolidado || iNaoConforme){
            $('.nao-conforme').attr('disabled', true);
        }else{
            $('.nao-conforme').removeAttr('disabled');
        }
    }
};