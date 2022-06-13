var ParalisacoesController = {
    ParalisacaoTimer:'paralisacao_timer',
    Paralisacoes:'paralisacoes',
    Paralisacao:'paralisacao',

    observers: function() {
        oSubject.setObserverOnEvent(function () {
            var aParalisacoes = oState.getState(
                ParalisacoesController.Paralisacoes);
            var oPlanoCarga = oState.getState(
                PlanoCargasController.sPlanoCarga);
            var iPoraoId = oState.getState(
                ParalisacoesController.Paralisacoes.porao_id);
            ParalisacoesService.renderPoroesOptions(iPoraoId, oPlanoCarga);
            ParalisacoesRender.index(aParalisacoes);
        }, ['on_paralisacoes_change']);

        oSubject.setObserverOnEvent(function () {
            var iParalisacao = oState.getState(ParalisacoesController.ParalisacaoTimer);
            var oPlanoCarga = oState.getState(
                PlanoCargasController.sPlanoCarga);
            var iPoraoId = oState.getState(
                ParalisacoesController.Paralisacoes.porao_id);
            ParalisacoesService.renderPoroesOptions(iPoraoId, oPlanoCarga);
            ParalisacoesService.startInterval(iParalisacao);
            if(!iPoraoId) $('#porao_id').val(iPoraoId);
        }, ['on_paralisacao_timer_change']);
    },

    init: function() {
        ParalisacoesController.observers();
    },

    index:function(){
        $('#paralisacoes-index').click(function(){
            oColetorApp.core.router(['paralisacoes']); 
        });

        $('#paralisacoes .adicionar').click(function(){
            oColetorApp.core.router(['paralisacoes', 'adicionar']); 
        });

        $('#registrar-paralisacao').click(function(){
            var oPlanejamanto = oState.getState(
                MenuController.sNavioViagemPlanejamento);
            var oPlanoCarga = oState.getState(
                PlanoCargasController.sPlanoCarga);
            var iOperador = oState.getState(
                PlanoCargasController.sPlanoCargaOperador);
            var iPlanoCarga = oPlanoCarga ? oPlanoCarga.id : null;
            ParalisacoesService.save({
                paralisacao_motivo_id: $('#paralisacao-motivo').val(),
                data_hora_inicio : $('#data-inicio').val(),
                data_hora_fim: $('#data-fim').val(),
                descricao: $('#descricao').val(),
                porao_id: $('#porao_id').val(),
                planejamento_maritimo_id:  oPlanejamanto.id,
                plano_carga_id:iPlanoCarga,
                operador_portuario_id:iOperador
            });
        });

        $('#modal-paralisacoes .lf-modal-success').click(function(){
            var iOperador = oState.getState(PlanoCargasController.sPlanoCargaOperador);
            var iLingadaid = oState.getState(LingadaController.sLingadaId);
            var oPlanejamanto = oState.getState(MenuController.sNavioViagemPlanejamento);
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            var iPlanoCarga = oPlanoCarga ? oPlanoCarga.id : null;
            var iParalisacaoMotivoId = $('#modal-paralisacoes [name="modal_paralisacao_motivo_id"]').val();
            var sParalisacaoMotivo = $('#modal-paralisacoes [name="modal_paralisacao_motivo_id"] option:selected').text()

            ParalisacoesService.saveNotify({
                paralisacao_motivo_id: iParalisacaoMotivoId,
                sParalisacaoMotivo: sParalisacaoMotivo,
                descricao:  $('#modal-descricao').val(),
                planejamento_maritimo_id: oPlanejamanto.id,
                plano_carga_id : iPlanoCarga,
                porao_id:$('[name = modal_porao_id]').val(),
                lingada_id: iLingadaid,
                operador_portuario_id:iOperador,
                notificacao:1,
            });

            $('#modal-paralisacoes [name="modal_paralisacao_motivo_id"]').val(null)
            $('#modal-paralisacoes [name="modal_paralisacao_motivo_id"]').selectpicker('refresh')
        });
    },

    add:function(){

        $('#paralisacoes-adicionar .salvar').click(function(){
            var iPlanejamento = oState.getState(MenuController.sNavioViagemId);
            var iOperador = oState.getState(PlanoCargasController.sPlanoCargaOperador);
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            var iPlanoCargaid = oPlanoCarga ? oPlanoCarga.id: null;

            var iParalisacaoMotivoId   = $('#paralisacoes-adicionar [name="paralisacao_motivo_id"]').val();
            var sDataInicio            = $('#paralisacoes-adicionar [name="data_hora_inicio"]').val();
            var sDataFim               = $('#paralisacoes-adicionar [name="data_hora_fim"]').val();
            var iPorao                 = $('#paralisacoes-adicionar [name="porao_id"]').val();
            var sDescricao             = $('#paralisacoes-adicionar [name="descricao"]').val();
            var sParalisacaoMotivo     = $('#modal-paralisacoes [name="modal_paralisacao_motivo_id"] option:selected').text()

            ParalisacoesService.add({
                planejamento_maritimo_id:iPlanejamento,
                operador_portuario_id:iOperador,
                plano_carga_id:iPlanoCargaid,
                paralisacao_motivo_id:iParalisacaoMotivoId,
                sParalisacaoMotivo:sParalisacaoMotivo,
                data_hora_inicio: sDataInicio,
                data_hora_fim:sDataFim,
                porao_id:iPorao,
                descricao:sDescricao,
            });

        });

    },

    edit:function(){
        $('#paralisacoes-editar .salvar').click(function(){
            var iParalisacaoId         = $('#paralisacoes-editar [name="id"]').val();
            var iParalisacaoMotivoId   = $('#paralisacoes-editar [name="paralisacao_motivo_id"]').val();
            var sDataInicio            = $('#paralisacoes-editar [name="data_hora_inicio"]').val();
            var sDataFim               = $('#paralisacoes-editar [name="data_hora_fim"]').val();
            var iPorao                 = $('#paralisacoes-editar [name="porao_id"]').val();
            var sDescricao             = $('#paralisacoes-editar [name="descricao"]').val();
            var sParalisacaoMotivo     = $('#modal-paralisacoes [name="modal_paralisacao_motivo_id"] option:selected').text()

            ParalisacoesService.edit(iParalisacaoId, {
                paralisacao_motivo_id:iParalisacaoMotivoId,
                sParalisacaoMotivo:sParalisacaoMotivo,
                data_hora_inicio: sDataInicio,
                data_hora_fim:sDataFim,
                porao_id:iPorao,
                descricao:sDescricao
            });

        });

    },
};