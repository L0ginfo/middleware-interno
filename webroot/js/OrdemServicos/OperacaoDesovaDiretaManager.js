var OperacaoDesovaDireta = {

    init: async function () {

        this.observers()

        OperacaoDesovaDireta.watchBtnDesovar()
        OperacaoDesovaDireta.watchBtnEstornar()
        OperacaoDesovaDireta.watchBtnFinalizar()
        OperacaoDesovaDireta.watchBtnVistoriaCargaGeral()
        OperacaoDesovaDireta.watchBtnGerarVistoria()
        OperacaoDesovaDireta.watchBtnDesovarIncremental()
        OperacaoDesovaDireta.watchButtonShowDescricaoProd()

    },

    observers: function() {

        oSubject.setObserverOnEvent(async function () {

            var oResponse = await Services.desovarItens(oState.getState('desovar'))
            Swal.fire({
                type: oResponse.type,
                title: oResponse.title,
                text: oResponse.message,
                showConfirmButton: false,
                timer: 5000 
            })

            return window.location.reload()

        }, ['on_desovar_change'])

        oSubject.setObserverOnEvent(async function () {

            var oResponse = await Services.estornarItens(oState.getState('estornar'))
            Swal.fire({
                type: oResponse.type,
                title: oResponse.title,
                text: oResponse.message,
                showConfirmButton: false,
                timer: 5000 
            })

            return window.location.reload()

        }, ['on_estornar_change'])

        oSubject.setObserverOnEvent(async function () {

            var oResponse = await Services.gerarVistoria(oState.getState('gerar_vistoria'))
            Swal.fire({
                type: oResponse.type,
                title: oResponse.title,
                text: oResponse.message,
                showConfirmButton: false,
                timer: 5000 
            })
            
            return window.location.reload()

        }, ['on_gerar_vistoria_change'])

        oSubject.setObserverOnEvent(async function () {

            var oResponse = await Services.desovarItensIncremental(oState.getState('desovar_incremental'))
            Swal.fire({
                type: oResponse.type,
                title: oResponse.title,
                text: oResponse.message,
                showConfirmButton: false,
                timer: 5000 
            })

            return window.location.reload()

        }, ['on_desovar_incremental_change'])

    },

    watchBtnDesovar: function () {

        $('.button_desovar').click( async function () {

            var oDivGlobal        = $(this).closest('.div_global_item_desovar')
            var iOSID             = $('.ordem_servico_id').val()
            var aInputQuantidades = oDivGlobal.find('.qtde_desovar_item_container')
            var aInputVolumes     = oDivGlobal.find('#volumes')
            var iEnderecoID       = oDivGlobal.find('.busca-endereco.endereco option:selected').val()
            var iContainerID      = oDivGlobal.find('.container_id').val()

            var iCountQtdeZerada = 0;
            aInputQuantidades.each( function() {
                if (!parseFloat($(this).val().replace(',', '.')))
                    iCountQtdeZerada++;
            });

            if (iCountQtdeZerada == aInputQuantidades.length)
                return Swal.fire({
                    title: 'Atenção',
                    html: 'É necessário selecionar quantidades antes de Desovar!',
                    type: 'warning'
                });

            if (!iEnderecoID)
                return Swal.fire({
                    title: 'Atenção',
                    html: 'É necessário selecionar um Endereço antes de Desovar!',
                    type: 'warning'
                })

            var aQtdDesovar = []

            var iQuantidadeMaior = false
            if (aInputQuantidades.length > 1) {
                aInputQuantidades.each( function() {
                    var iEmbalagemId = $(this).closest('.quantidade-volume').find('select[name="embalagem_id"]').val();
                    if (parseInt($(this).val().split('.').join("")) > parseInt($(this).attr('max').split('.').join("")))
                        iQuantidadeMaior = true

                    aQtdDesovar.push({docMercId: $(this).data('doc-merc-id'), quantidade: $(this).val(), embalagem_id: iEmbalagemId, volumes: $(this).closest('.quantidade-volume').find('input[name="volumes"]').val()})
                })
            } else {        
                var iEmbalagemId = aInputQuantidades.closest('.quantidade-volume').find('select[name="embalagem_id"]').val();        
                if (parseInt(aInputQuantidades.val().split('.').join("")) > parseInt(aInputQuantidades.attr('max').split('.').join("")))
                    iQuantidadeMaior = true

                aQtdDesovar.push({docMercId: aInputQuantidades.data('doc-merc-id'), quantidade: aInputQuantidades.val(), embalagem_id: iEmbalagemId, volumes: aInputVolumes.val()})
            }

            if (iQuantidadeMaior)
                return Swal.fire({
                    title: 'Atenção',
                    html: 'Não é possível adicionar uma quantidade maior do que há no Documento Mercadoria Item!',
                    type: 'warning'
                });
            
            oState.setState('desovar', {
                data: aQtdDesovar,
                endereco: iEnderecoID,
                type: 'desovar',
                os_id: iOSID,
                container_id: iContainerID
            })

        })

    },

    watchBtnEstornar: function () {

        $('.button_estornar').click( async function () {

            var oGlobalItemEstorno = $(this).closest('.global_item_estorno')
            var iDocMercId         = oGlobalItemEstorno.find('.doc_merc_item_id_estorno').val()
            var iOsItem            = oGlobalItemEstorno.find('.os_item_id_estorno').val()

            oState.setState('estornar', {
                iDocMercId: iDocMercId,
                iOsItem: iOsItem,
                type: 'estornar',
            })

        })

    },

    watchBtnFinalizar: function () {

        $('.button_finalizar_os').click( async function () {

            var iOSID = $(this).attr('data-os-id')

            var isTransbordo = $('.desova_is_transbordo').val()
            if (isTransbordo) {

                var iResvDestinoID = $('.selectpicker.resv_destino_id').find("option:selected").val()
                if (!iResvDestinoID)
                    return Swal.fire({
                        type: 'warning',
                        title: 'Ops!',
                        text: 'Para Desova de Transbordo é necessário selecionar uma Programação de Destino!',
                        showConfirmButton: false,
                        timer: 3000 
                    })

                OperacaoDesovaDireta.finalizarDesovaTransbordo(iOSID, iResvDestinoID)

            } else {

                OperacaoDesovaDireta.finalizarDesovaArmazem(iOSID)

            }

        })

    },

    finalizarDesovaArmazem: async function (iOSID) {

        return Swal.fire({

            title: 'Atenção',
            text: 'Deseja realmente finalizar essa OS?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#41B314',
            cancelButtonColor: '#ac2925',
            confirmButtonText: 'Sim, continuar',
            cancelButtonText: 'Não',
            showLoaderOnConfirm: true

        }).then (async result => {

            if (result.dismiss != 'cancel'){

                var sUrlFinalizar = url + 'ordens-servico-pendentes/finalizarDesova/' + iOSID 
                window.location.href = sUrlFinalizar
                Loader.showLoad();

            } else {

                return false

            }

        })

    },

    finalizarDesovaTransbordo: function (iOSID, iResvDestinoID) {
        
        return Swal.fire({

            title: 'Atenção',
            html: 'Deseja realmente finalizar essa OS? </br> E realizar o transbordo para a <b>Programação: ' + iResvDestinoID + '?</b>',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#41B314',
            cancelButtonColor: '#ac2925',
            confirmButtonText: 'Sim, continuar',
            cancelButtonText: 'Não',
            showLoaderOnConfirm: true

        }).then (result => {

            if (result.dismiss != 'cancel'){

                var sUrlFinalizar = url + 'ordens-servico-pendentes/finalizarDesova/' + iOSID + '/' + iResvDestinoID
                window.location.href = sUrlFinalizar
                Loader.showLoad();

            } else {

                return false

            }

        })

    },

    watchBtnVistoriaCargaGeral: function () {

        $('.button_vistoria_carga_solta').click( function () {

            var iOSID = $(this).attr('data-os-id')

            window.open(webroot + 'vistorias/iniciar-vistoria/0/0/0/' + iOSID + '/1', '_blank');

        })
    
    },
    
    functionNull: function () {

        return '';

    },

    watchBtnGerarVistoria: function () {

        $('.button_gerar_vistoria').click( function () {

            var oDivGlobalVistoria = $(this).closest('.div_global_vistoria')
            var iVistoriaTipoID    = oDivGlobalVistoria.find('.vistoria_tipo_id option:selected').val()

            if (!iVistoriaTipoID)
                return Swal.fire({
                    title: 'Atenção',
                    html: 'É necessário selecionar um Tipo de Vistoria!',
                    type: 'warning'
                })

            oState.setState('gerar_vistoria', {
                type:                   'gerar_vistoria',
                vistoria_tipo_id:       iVistoriaTipoID,
                vistoria_tipo_carga_id: oDivGlobalVistoria.find('.vistoria_tipo_carga_id').val(),
                documento_entrada_id:   oDivGlobalVistoria.find('.documento_entrada_id').val(),
                container_id:           oDivGlobalVistoria.find('.container_id').val(),
                busca_estoque:          oDivGlobalVistoria.find('.busca_estoque').val(),
                ordem_servico_id:       oDivGlobalVistoria.find('.ordem_servico_id').val()
            })

        })

    },

    watchBtnDesovarIncremental: function () {

        $('.button_desovar_incremental').click( function () {

            var oDivGlobal        = $(this).closest('.div_global_item_desovar_incremental')
            var iOSID             = $('.ordem_servico_id').val()
            var iContainerID      = oDivGlobal.find('.container_id').val()
            var iDocTransporteID  = oDivGlobal.find('.documento_transporte_id').val()
            var iProdutoID        = oDivGlobal.find('.produto_id_incremental option:selected').val()
            var iUnidadeMedidaID  = oDivGlobal.find('.unidade_medida_id_incremental option:selected').val()

            var iQuantidade       = oDivGlobal.find('.qtde_produto_incremental').val()
            var iVolume           = oDivGlobal.find('.volume_incremental').val()
            var iEnderecoID       = oDivGlobal.find('.busca-endereco.endereco option:selected').val()
            var iEmbalagemID      = oDivGlobal.find('select[name="embalagem_id"]').val()
            var iQtdeXVolume      = oDivGlobal.find('.qtde_volume_incremental').val()

            if (!iEnderecoID || !iProdutoID || !iUnidadeMedidaID || !iQuantidade)
                return Swal.fire({
                    title: 'Atenção',
                    html: 'Falta preencher alguns campos para poder realizar a Desova!',
                    type: 'warning'
                })

            oState.setState('desovar_incremental', {
                iContainerID: iContainerID,
                iOSID: iOSID,
                iDocTransporteID: iDocTransporteID,
                iProdutoID: iProdutoID,
                iUnidadeMedidaID: iUnidadeMedidaID,
                iQuantidade: iQtdeXVolume,
                iVolume: iVolume,
                iEnderecoID: iEnderecoID,
                iEmbalagemID: iEmbalagemID,

                type: 'desovar_incremental',
            })

        })

    },

    watchButtonShowDescricaoProd: function() {
        $('.button_open_desc').click(function() {
            $('.button_exibe_dados').each(function() {
                $(this).click();
            });
        });
    }

}

$(document).ready(function() {

    OperacaoDesovaDireta.init()

    $.fn.numericDouble()

    EnderecoUtil.watchChanges('local')
    EnderecoUtil.watchChanges('area')

})
