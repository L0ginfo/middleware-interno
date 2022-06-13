var LingadaController = {
    sPoraoId: 'porao_id',
    sLingadaId: 'lingada_id',
    sAvariaId:'avaria_id',
    sResvid:'resv_id',
    sResv:'resv',


    observers: function() {
        oSubject.setObserverOnEvent(function () {
            var iPorao = oState
                .getState(LingadaController.sPoraoId);
            var oResv = oState
                .getState(LingadaController.sResv);
            var oPlanoCarga = oState
                .getState(PlanoCargasController.sPlanoCarga);
            var bGranel = OperacaoService.isGranel(oPlanoCarga);
            LingadaService.renderitens(oPlanoCarga, iPorao, oResv, bGranel);
            LingadaService.renderProdutos(oPlanoCarga, iPorao);
            LingadaService.showInputs(oPlanoCarga, iPorao);
            $('#select_liganda_porao').val(iPorao);
            $('#plano_carga_id').val(oPlanoCarga.id);
        }, ['on_porao_id_change']);

        oSubject.setObserverOnEvent(function () {
            var iPorao = oState
                .getState(LingadaController.sPoraoId);
            var oResv = oState
                .getState(LingadaController.sResv);
            var oPlanoCarga = oState
                .getState(PlanoCargasController.sPlanoCarga);
            var lingada_id = oState
                .getState(LingadaController.sLingadaId);
            var avaria_id = oState
                .getState(LingadaController.sAvariaId);
            var bGranel = OperacaoService
                .isGranel(oPlanoCarga);
            LingadaService
                .renderitens(oPlanoCarga, iPorao, oResv, bGranel);
            LingadaService
                .renderProdutos(oPlanoCarga, iPorao);
            LingadaService
                .renderAvarias(oPlanoCarga, lingada_id);
            LingadaService
                .renderFotosAvarias(oPlanoCarga, lingada_id, avaria_id);
        }, ['on_plano_carga_change']);

        oSubject.setObserverOnEvent(function () {
            var oPlanoCarga = oState
                .getState(PlanoCargasController.sPlanoCarga);
            var iLingadaid = oState
                .getState(LingadaController.sLingadaId);
            LingadaService.renderAvarias(oPlanoCarga, iLingadaid);
        }, ['on_lingada_id_change']);


        oSubject.setObserverOnEvent(function () {
            var oPlanoCarga = oState
                .getState(PlanoCargasController.sPlanoCarga);
            var iLingadaId = oState
                .getState(LingadaController.sLingadaId);
            var iAvariaId = oState
                .getState(LingadaController.sAvariaId);
            LingadaService
                .renderFotosAvarias(oPlanoCarga, iLingadaId, iAvariaId);
        }, ['on_avaria_id_change']);

        oSubject.setObserverOnEvent(function () {    
            var iPorao = oState
                .getState(LingadaController.sPoraoId);
            var oResv = oState
                .getState(LingadaController.sResv);
            var oPlanoCarga = oState
                .getState(PlanoCargasController.sPlanoCarga);
            var bGranel = OperacaoService.isGranel(oPlanoCarga);
            LingadaService.renderitens(oPlanoCarga, iPorao, oResv, bGranel);
            LingadaService.renderTotal(oResv, bGranel);
        }, ['on_resv_change']);
        
    },

    init: function() {
        LingadaController.observers();
    },
    poroes:function(){

        $('#selecionar-porao').click(function(){
            var iPorao = $('#select_poroes').val();
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            if(!iPorao) return alert('por favor, selecione um porão');
            oState.setState(LingadaController.sPoraoId, iPorao);
            oColetorApp.core.router([OperacaoService.getAction(oPlanoCarga)]); 
            setTimeout(function() { $('#placa').focus(); }, 20);
        });

    },
    index: function() {
        $('#select_liganda_porao').change(function(event){
            var value = $(this).val();
            if(value) return oState.setState(LingadaController.sPoraoId, value);
        });

        $('#placa').blur(function(){
            LingadaService.verificaExistResv($(this).val());
        });
        
        $('#add-lingada').click(function(){
            // Loader.showLoad(true, 'external', 10000000);
            var $oThat = $(this)

            $oThat.css({
                pointerEvents: 'none',
                opacity: '0.3'
            })

            setTimeout(function() {
                $oThat.css({
                    pointerEvents: 'all',
                    opacity: '1'
                })
            }, 5000)

            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            var iOperador = oState.getState(PlanoCargasController.sPlanoCargaOperador);
            var iPorao = oState.getState(LingadaController.sPoraoId);
            var uCaracteristicas = CaracteristicasService.get('#lingada');
            var iProduto = $('#produto').is(':visible') ? $('#produto').val() : '';
            var sCodigo = $('#codigo').is(':visible') ? $('#codigo').val() : '';
            var fPeso = $('#peso').is(':visible') ? $('#peso').val() : '';
            var iQtde = $('#qtd').is(':visible') ? $('#qtd').val() : '';
            var iPoraoOrigem = $('#porao_origem').is(':visible') ? $('#porao_origem').val() : '';
            var sPlaca = $('#placa').val();

            if(!uCaracteristicas){
                Loader.hideLoad();
                return alert('Por favor, selecione todas as características disponíveis.');
            }

            LingadaService.post({
                plano_carga_id:                 oPlanoCarga.id,
                operador_portuario_id:          iOperador,
                porao_id:                       iPorao,
                plano_carga_caracteristicas:    uCaracteristicas,
                produto_id:                     iProduto,
                codigo:                         sCodigo,
                placa:                          sPlaca,
                qtde:                           iQtde,
                peso:                           fPeso,
                porao_origem:                   iPoraoOrigem
            });

            setTimeout(function() {
                
                var codigo = $('#codigo').is(":visible");
                var qtd = $('#qtd').is(":visible");
                var peso = $('#peso').is(":visible");

                $('#codigo').val('');

                if ($('#codigo').hasClass('selectpicker')) {
                    $('#codigo').val(null)
                    $('#codigo').selectpicker('refresh')
                }
            
                // $('#produto').val('');
                $('#qtd').val('');
                $('#peso').val('');
                // $('#porao_origem').val('');

                if($('#codigo:visible'))
                    $('#codigo').focus();
                else if($('#produto:visible'))
                    $('#produto').focus();
                else if($('#qtd:visible'))
                    $('#qtd').focus();
                else if($('#peso:visible'))
                    $('#peso').focus();
                else if($('#porao_origem:visible'))
                    $('#porao_origem').focus();   
                else
                    $('#add-lingada').focus();
            }, 100);
        });

        $('#finalizar-lingada').click(function(){
            $('#placa').val('');
            $('#codigo').val('');
            $('#qtd').val('');
            $('#peso').val('');
            // $('#produto').val('');
            // $('#porao_origem').val('');
            oState.setState(LingadaController.sResv, null);
            setTimeout(function() { $('#placa').focus(); }, 100);
        });

        $('#codigo').blur(function(){
            CaracteristicasService.display({
                codigo: this.value
            });
        });

        $('#placa').on("keydown", function(e) {
            if (e.keyCode === 13) {
                setTimeout(function() {
                    if($('#codigo:visible'))
                        $('#codigo').focus();
                    else if($('#produto:visible'))
                        $('#produto').focus();
                    else if($('#qtd:visible'))
                        $('#qtd').focus();
                    else if($('#peso:visible'))
                        $('#peso').focus();   
                    else
                        $('#add-lingada').focus();
                }, 100);
            }
        });

        $('#codigo').on("keydown", function(e) {
            if (e.keyCode === 13) {
                setTimeout(function() {
                    if($('#qtd:visible'))
                        $('#qtd').focus();
                    else if($('#peso:visible'))
                        $('#peso').focus();
                    else
                        $('#add-lingada').focus();
                }, 100);
            }
        });

        $('#produto').on("keydown", function(e) {
            if (e.keyCode === 13) {
                setTimeout(function() {
                    if($('#qtd:visible'))
                        $('#qtd').focus();
                    else if($('#peso:visible'))
                        $('#peso').focus();
                    else
                        $('#add-lingada').focus();
                }, 100);
            }
        });

        $('#qtd').on("keydown", function(e) {

            if (e.keyCode === 13) {
                setTimeout(function() { 
                    if($('#peso:visible'))
                        $('#peso').focus();
                    else
                        $('#add-lingada').focus();
                }, 100);
            }

        });

        $('#peso').on("keydown", function(e) {
            if (e.keyCode === 13) {
                setTimeout(function() {
                    if($('#porao_origem:visible'))
                        $('#porao_origem').focus();
                    else
                        $('#add-lingada').focus();
                }, 100);
            }
        });

        $('#porao_origem').on("keydown", function(e) {
            if (e.keyCode === 13) {
                setTimeout(function() {
                    $('#add-lingada').focus(); 
                }, 100);
            }
        });

    },
    avarias:function(){
        $('#capture').click(function(){
            try {
                document.getElementById("fotos-avarias").click();
            } catch (error) {
                alert(error);
            }
        });

        $('#fotos-avarias').change(function(e){
            LingadaService.convertFiles(e);
        });

        $('#salvar-fotos').click(function(){
            var oPlanoCarga = oState.getState(PlanoCargasController.sPlanoCarga);
            var sNavioId = oState.getState(MenuController.sNavioViagemId);
            var iLingadaid = oState.getState(LingadaController.sLingadaId);
            var iTipoAvariaId = $('#tipo-avaria-id').val();
            var sAvariaDescricao = $('#avaria-descricao').val();
            LingadaService.salvarFotos({
                planejamento_maritimo_id:sNavioId,
                ordem_servico_item_lingada_id:iLingadaid,
                avaria_id:iTipoAvariaId,
                descricao:sAvariaDescricao,
                plano_carga_id:oPlanoCarga.id
            });
        });
    }
};