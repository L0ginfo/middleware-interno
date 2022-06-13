var LingadasGranelController = {
    
    observers: function() {

        oSubject.setObserverOnEvent(function () {
            var iPoraoId = oState.getState(LingadaController.sPoraoId);
            var oResv = oState.getState(LingadaController.sResv);
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            var bGranel = OperacaoService.isGranel(oPlanoCarga);
            LingadaGranelService.showTermosPorao(
                oPlanoCarga, iPoraoId);
            LingadaGranelService.renderitens(
                oPlanoCarga, iPoraoId, oResv, bGranel);
            $('#select_porao_lingada_granel').val(iPoraoId);
        }, ['on_porao_id_change']);

        oSubject.setObserverOnEvent(function () {
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            var oResv = oState.getState(LingadaController.sResv);
            var iPoraoId = oState.getState(LingadaController.sPoraoId);
            var bGranel = OperacaoService.isGranel(oPlanoCarga);
            LingadaGranelService.showTermosPorao(
                oPlanoCarga, iPoraoId);
            LingadaGranelService.renderitens(
                oPlanoCarga, iPoraoId, oResv, bGranel);
        }, ['on_plano_carga_change']);


        oSubject.setObserverOnEvent(function () {            
            var iPoraoId = oState.getState(LingadaController.sPoraoId);
            var oResv = oState.getState(LingadaController.sResv);
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            var bGranel = OperacaoService.isGranel(oPlanoCarga);
            LingadaGranelService.renderitens(oPlanoCarga, iPoraoId, oResv, bGranel);
            LingadaGranelService.renderTotal( oResv, bGranel);
        }, ['on_resv_change']);
    },

    init: function() {
        LingadasGranelController.observers();
    },

    index:function(){

        $('#add-lingada-granel').click(function(event){ 
            // Loader.showLoad(true, 'external', 10000000);
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            var iOperador = oState.getState(PlanoCargasController.sPlanoCargaOperador);
            var iPorao = oState.getState(LingadaController.sPoraoId);
            var uCaracteristicas = CaracteristicasService.get('#lingada-granel');
            var iProduto = $('#produto-granel').is(':visible') ? $('#produto-granel').val() : '';
            var sCodigo = $('#codigo-granel').is(':visible') ? $('#codigo-granel').val() : '';
            var fPeso = $('#peso-granel').is(':visible') ? $('#peso-granel').val() : '';
            var sPlaca = $('#placa-granel').val();

            if(!uCaracteristicas){
                return alert('Por favor, selecione todas as características disponíveis.');
            }

            
            LingadaGranelService.post({
                plano_carga_id:                 oPlanoCarga.id,
                operador_portuario_id:          iOperador,
                porao_id:                       iPorao,
                plano_carga_caracteristicas:    uCaracteristicas,
                produto_id:                     iProduto,
                codigo:                         sCodigo,
                placa:                          sPlaca,
                peso:                           fPeso,
            });

            setTimeout(function() {
                $('#codigo-granel').val('');
                $('#peso-granel').val('');
                
                if($('#codigo-granel').is(":visible"))
                    $('#codigo-granel').focus();
                else if($('#peso-granel').is(":visible"))
                    $('#peso-granel').focus();
                else
                    $('#add-lingada-granel').focus();
            }, 100);
        });

        $('#select_porao_lingada_granel').change(function(event){
            var porao_id = oState.getState(LingadaController.sPoraoId);
            var value = $(this).val();

            if(value){
                return oState.setState(LingadaController.sPoraoId, value);
            }

            $(this).val(porao_id);
        });

        $('#placa-granel').blur(function(){
            LingadaService.verificaExistResv($(this).val());
        });

        $('#finalizar-lingada-granel').click(function(){
            $('#placa-granel').val('');
            oState.setState(LingadaController.sResv, null);
            setTimeout(function() {$('#placa-granel').focus();}, 100);
        });

    }
};