var DocumentoRegimeEspecialRender = {
    itens:function(array){
        const sTemplate = ObjectUtil.getDepth(window, 'templates.item')
        DocumentoRegimeEspecialRender.render({
            template: sTemplate,
            data:array,
            data_to_render:'item',
            tree:window.nest_tree,
            element: '.lf-item-body .lf-item-body-data'
        });
        DocumentoRegimeEspecialRender.fixSelectPicker();
        $.fn.numericDouble();
    },
    adicoes:function(array){
        let eElement = $(ObjectUtil.getDepth(window, 'templates.item'));
        const sTemplate = ObjectUtil.getDepth(window, 'templates.adicoes');
        const sHtml = DocumentoRegimeEspecialRender.renderData({
            template: sTemplate ? sTemplate:'',
            data:array,
            data_to_render:'adicoes',
            tree:window.nest_tree,
            element: 'select.lf-adicoes',
            type:'selectpicker'
        });
        eElement.find('select.lf-adicoes').html(sHtml);
        window.templates.item = eElement[0].outerHTML;
    },

    adicao_itens:function(array){
        const sTemplate = ObjectUtil.getDepth(window, 'templates.adicao_itens');   
        const sHtml = DocumentoRegimeEspecialRender.renderData({
            template: sTemplate ? sTemplate:'',
            data:array,
            data_to_render:'adicao_itens',
            tree:window.nest_tree,
            element: 'select.lf-adicao-itens',
            type:'selectpicker'
        });

        $('select.lf-adicao-itens').html(sHtml);
        $('select.lf-adicao-itens').selectpicker('render');
        $('select.lf-adicao-itens').selectpicker('refresh');

    },

    adicao_item:function(object, fAferido){

        let fTotal = ObjectUtil.getDepth(object, 'ordem_servico_documento_regime_especial_itens[0].total');
        let fQuantidade = ObjectUtil.getDepth(object, 'quantidade');
        let sDescricao = ObjectUtil.getDepth(object, 'descricao_completa');
        let sUnidade = ObjectUtil.getDepth(object, 'unidade_medida.descricao');
        let Id = ObjectUtil.getDepth(object, 'unidade_medida_id');
        sDescricao = sDescricao ? sDescricao :'';
        sUnidade = sUnidade ? sUnidade:Id;
        fAferido = fAferido ? fAferido: 0;
        fQuantidade = fQuantidade ? fQuantidade :0;
        fTotal = fTotal ? fTotal :0;
        let fSaldo = fQuantidade - fTotal;
        const sAddClass = fSaldo > 0? 'success': 'danger';
        const sRemoveClass = sAddClass == 'danger' ? 'success': 'danger';


        $('.lf-item-body-data .active .lf-adicao-quantidade')
            .val(Utils.showFormatFloat(fQuantidade));
        $('.lf-item-body-data .active .lf-adicao-quantidade-aferida')
            .val(Utils.showFormatFloat(fAferido));
        $('.lf-item-body-data .active .lf-adicao-saldo')
            .val(Utils.showFormatFloat(fSaldo));
        $('.lf-item-body-data .active .lf-adicao-saldo')
            .val(Utils.showFormatFloat(fSaldo));
        $('.lf-item-body-data .active .lf-adicao-descricao-completa')
            .val(sDescricao);

        $('.lf-item-body-data .active .lf-adicao-quantidade').addClass('warning');
        $('.lf-item-body-data .active .lf-adicao-saldo').removeClass(sRemoveClass);
        $('.lf-item-body-data .active .lf-adicao-saldo').addClass(sAddClass);

        DocumentoRegimeEspecialRender.renderSelectPicker(
            $('.lf-item-body-data select.lf-adicao-unidade-medida'), Id, sUnidade);
    },
    
    renderData:function (oData){
        let oResponse = new window.ResponseUtil();
        let sListTemplate = '';
        oData.data.forEach(function(oDataComposicao, sKeyComposicao) {
            oResponse = RenderCopy.render({
                object: oDataComposicao,
                template: oData.template,
                data_to_render: oData.data_to_render,
                nested_tree: oData.tree,
            });

            if (oResponse.getStatus() !== 200){
                console.log(oResponse.getMessage() + ' Falha ao renderizar item ' + sKeyComposicao);
                return oResponse;
            }

            sListTemplate += oResponse.getDataExtra();
        });

        return sListTemplate;
    },
    
    render:function(oData){
        const sListTemplate = this.renderData(oData);
        $(oData.element).html(sListTemplate);
    },

    renderSelectPicker:function(eSelectPicker, uKey, uValue){
        eSelectPicker.html(`<option value="${uKey}">${uValue}</option>`);
        eSelectPicker.val(uKey);
        eSelectPicker
            .find('option[selected]').removeAttr('selected');
        eSelectPicker
            .find('option[checked]').removeAttr('checked');
        eSelectPicker
            .find(`option[value="${uKey}"]`).attr('checked', 'checked');
        eSelectPicker
            .find(`option[value="${uKey}"]`).attr('selected', 'selected');
        eSelectPicker
            .selectpicker('render');
        eSelectPicker
            .selectpicker('refresh');
        eSelectPicker
            .closest('.btn-group')
            .find('button')
            .attr('title', uValue);
        eSelectPicker
            .closest('.btn-group')
            .find('.filter-option')
            .html(uValue);

    },

    fixSelectPicker:function(){

        $('.lf-item-body-data .selectpicker').each(function(){
            const uKey = $(this).data('selected');
            if(uKey) {

                $(this).find(`option[value="${uKey}"]`)
                    .attr('checked', 'checked');
                $(this).find(`option[value="${uKey}"]`)
                    .attr('selected', 'selected');
            }
        });

        $('.lf-item-body-data .selectpicker').selectpicker();
    }
};