ParalisacoesRender = {

    index:function(aParalisacoes){
        aParalisacoes = aParalisacoes ? aParalisacoes : [];
        var sTemplate = oColetorApp.templates.paralisacoes;
        var oNestedTree = oColetorApp.nestedTree.paralisacoes;
        simpleRender.render(['#paralisacoes .lf-table-tbody'], sTemplate, oNestedTree, aParalisacoes); 
        ParalisacoesService.initEditEvent();
        ParalisacoesService.initRemoveEvent(); 
    },
    add:function(){
        $('#paralisacoes-adicionar [name="paralisacao_motivo_id"]').val('');
        $('#paralisacoes-adicionar [name="data_hora_inicio"]').val('');
        $('#paralisacoes-adicionar [name="data_hora_fim"]').val('');
        $('#paralisacoes-adicionar [name="descricao"]').val('');
        $('#paralisacoes-adicionar [name="porao_id"]').val('');
    },
    edit:function(oParalisacao){
        if(!oParalisacao){
            return alert('Falha ao localizar a paralisação');
        }

        var sInicio = simpleDate.dateTimeToView(
            oParalisacao.data_hora_inicio, 'T');
        var sFim =simpleDate.dateTimeToView(
            oParalisacao.data_hora_fim, 'T');

        $('#paralisacoes-editar [name="id"]')
            .val(oParalisacao.id);
        $('#paralisacoes-editar [name="paralisacao_motivo_id"]')
            .val(oParalisacao.paralisacao_motivo_id);
        $('#paralisacoes-editar [name="data_hora_inicio"]')
            .val(sInicio);
        $('#paralisacoes-editar [name="data_hora_fim"]')
            .val(sFim);
        $('#paralisacoes-editar [name="descricao"]')
            .val(oParalisacao.descricao);
        $('#paralisacoes-editar [name="porao_id"]')
            .val(oParalisacao.porao_id);
    }

}