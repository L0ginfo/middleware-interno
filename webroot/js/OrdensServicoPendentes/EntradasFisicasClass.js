
aSaldosHouses  = (typeof aSaldosHouses === "undefined") ? [] : aSaldosHouses
aAssocEntradas = (typeof aAssocEntradas === "undefined") ? new Array() : aAssocEntradas
aAssocAvarias  = (typeof aAssocAvarias === "undefined") ? new Array() : aAssocAvarias

uClickDuploTimer = null
teste = null

var EntradasFisicas = {
    init: async function() {

        Loader.showLoad()

        $('.entradas.side .entradas-fisicas .owl-carousel').owlCarousel({
            loop:false,
            nav:false,
            autoHeight:false,
            singleItem:true,
            items:1,
            autoplay:false,
            dots:false,
            stagePadding:0,
            //autoWidth
            touchDrag:false,
            mouseDrag:false,
            pullDrag:false,
            freeDrag:false
        })

        setTimeout(() => {
            EntradasFisicas.fixHeightOwl()
        }, 600);
        
        EntradasFisicas.manageWatch()
        EntradasFisicas.manageToggleTriggerHouse()
        EntradasFisicas.onAddDataCarousel()
        EntradasFisicas.onToggleCarouselEntradaFisica()
        EntradasFisicas.onRemoveCarousel()
        EntradasFisicas.manageAddDataAvarias()
        EntradasFisicas.manageRemoveAvarias()
        EntradasFisicas.manageWatcherFinalizarRecebimento()
        EntradasFisicas.refreshAllInputs()
        EntradasFisicas.watchChangesProdutoID()

        setTimeout(() => {
            var returnSearchEnderecos = SearchEnderecos.searchForAlreadyInFrontEnd(false)

            if (returnSearchEnderecos == 'nenhum_selecionado')
                Loader.hideLoad()
            
            EntradasFisicas.manageWatchTipoProdutos()
            EntradasFisicas.calculateQtdProdutos()
        }, 400);

        $(window).load(async function() {
            await Utils.waitMoment(500)
            Utils.updateHeightBasedElement(
                $('.entradas-fisicas.watched.active'), 
                $('.os-estoque'), 
                120, 
                0, 
                EntradasFisicas.casesToUpdateHeigth()
            )
        })

        Utils.updateHeightBasedElement(
            $('.entradas-fisicas.watched.active'), 
            $('.os-estoque'), 
            120, 
            0, 
            EntradasFisicas.casesToUpdateHeigth()
        )
    },

    casesToUpdateHeigth: function() {
        return [
            {
                width: 1224,
                value_to_use: '100%'
            }
        ]
    },

    fixHeightOwl: function() {
        $('.owl-stage-outer.owl-height').each(function() {
            $(this).attr('style', "height: '100%'")
        })
    },

    executeHookProduto: function() {
        $('.copy-inputs .hook-watch-changes:not(.watched)').addClass('can-execute')
        oHooks.watchChangesAndCopyChanges()
    },

    watchChangesProdutoID: function() {
        $('html').on('hook-watch-changes', function(e, elem) {
            EntradasFisicas.calculateQtdProdutos()
        })
    },

    calculateQtdProdutos: async function() {
        //aguarda trocar o id do produto pelo selectpicker
        await Utils.waitMoment(300)

        $('.copy-inputs .qtd-produto').each(function() {
            var $oCopyInputs = $(this).closest('.copy-inputs'),
                produto_id = $(this).find('.produto_referente_id').val(),
                dQtdAdicionada = 0,
                $oQtdProduto = $oCopyInputs.find('.qtd-produto')
            
            var iProdutoPrecision = $(this).find('.adicionado')
                .attr('data-precision');   
                
            if (typeof iProdutoPrecision == 'undefined' || !iProdutoPrecision)
                iProdutoPrecision = 2;

            //Limpa quantidade na página atual para re-calcular
            $(this).find('.adicionado').html('0')

            if (produto_id != ''){
                $oCopyInputs.find('.owl-item').each(function() {
                    var produto_target_id = $(this).find('.produto_referente_id').val()

                    if (produto_target_id == produto_id) {
                        dQtdAdicionada += parseFloat($(this).closest('.owl-item').find('.quantidade-input').val().replace('.', '').replace(',', '.'))
                    }
                })
            }

            $(this).find('.adicionado').html(Utils.showFormatFloat(dQtdAdicionada, iProdutoPrecision));
        })
    },

    getProdutosControles: function() {
        return JSON.parse($('.produtos_controles').val())
    },

    setExibitionControles: function(iProdutoID, oItemActive) {
        var aProdutosControles = EntradasFisicas.getProdutosControles()

        if (!iProdutoID || !oItemActive || !aProdutosControles[iProdutoID])
            return false

        var aProdutoControles = Object.entries(aProdutosControles[iProdutoID])

        for (key in aProdutoControles) {
            var classControle = aProdutoControles[key][0],
                valorControle = aProdutoControles[key][1],
                objControle = oItemActive.find('.controles .'+classControle)

            if (valorControle == 1) 
                objControle.removeClass('hidden')
            else
                objControle.addClass('hidden')
        }
    },

    setExibitionUnidadeMedida: function(iProdutoID, oItemActive) {
        var aProdutosControles = EntradasFisicas.getProdutosControles()
        
        if (!iProdutoID || !oItemActive || !aProdutosControles[iProdutoID])
            return false
        
        var iProdutoUnidadeMedidaID = aProdutosControles[iProdutoID].unidade_medida_id

        oItemActive.find('select.unidade_medida_id option').removeAttr('selected')
        oItemActive.find('select.unidade_medida_id').val(iProdutoUnidadeMedidaID)
        oItemActive.find('select.unidade_medida_id option[value="'+iProdutoUnidadeMedidaID+'"]').attr('selected', 'selected')
        oItemActive.find('select.unidade_medida_id').selectpicker('refresh')
    },

    manageWatchTipoProdutos: function() {
        $('.copy-inputs .produto_referente_id.can-execute:not(.watched-controles)').each(function() {
            $(this).addClass('watched-controles')

            var oComboProdutos = $(this).closest('.owl-item').find('select.produto_id.watched')
            
            var fAction = function(iProdutoID, oItemActive) {
                EntradasFisicas.setExibitionControles( iProdutoID, oItemActive )
                EntradasFisicas.setExibitionUnidadeMedida( iProdutoID, oItemActive )
            }

            fAction($(this).val(), $(this).closest('.owl-item'))

            oComboProdutos.change(function() {
                fAction($(this).val(), $(this).closest('.owl-item.active'))
            })
        })
    },

    refreshAllInputs: function() {

        $('.entradas-fisicas').each(function() {
            var $oEntradasFisicaActive = $(this)

            $oEntradasFisicaActive.find('.copy-inputs.entradas').owlCarousel('update')
            
            setTimeout(() => {

                SearchEnderecos.init()
                EntradasFisicas.addMaskNumericAll()
                EntradasFisicas.manageAddDataAvarias()
                EntradasFisicas.manageRemoveAvarias()                
                EntradasFisicas.manageWatchSelectPickers('.selectpickerentradas:not(.armazem)')
                EntradasFisicas.manageWatchSelectPickers('.selectpickerentradas.armazem')
                EntradasFisicas.manageWatcherSalvarEntrada()

                Utils.toUppercase('.copy-inputs')
                
                $oEntradasFisicaActive.find('.copy-inputs.entradas .bt-impressao-etiqueta').each(function() {
                    EntradasFisicas.onClickEtiqueta( $(this) )
                })
                
                EntradasFisicas.manageSaldosEntradas()

            }, 400)

        })

    },

    manageWatcherSalvarEntrada: function() {

        var $oEntradasFisicaActive = $('.entradas-fisicas.watched'); 
        
        $oEntradasFisicaActive.find('.copy-inputs .salvar-entrada.no-watched').each(function() {
            $(this).removeClass('no-watched')
            $(this).addClass('watched')

            $(this).click(async function(e) {
                // teste = $(this).closest('form')
                // return;
                if(uClickDuploTimer) return false;
            
                uClickDuploTimer = setTimeout(function(){
                    uClickDuploTimer = null;
                }, 1000);

                var aData = $(this).closest('form').serialize()
                var iHouseAtivo = $('.conhecimento.house .owl-carousel .owl-item.active .id').val()
                var $oItemActive = $('.entradas-fisicas.watched.active .owl-item.active')
                var iEntradaAtiva = $oItemActive.find('.full-item-owl').attr('data-entrada-count')
                var sController = 'ordens-servico-pendentes'
                var sAction = 'save-entrada-fisica/' + iHouseAtivo + '/' + iEntradaAtiva
                var bValidaQuantidade = !!$('#validar-quantidade').val()

                if (Utils.manageRequiredCustom($oItemActive))
                    return false

                if (bValidaQuantidade) {
                    await EntradasFisicas.calculateQtdProdutos();
                    iQuantidadeFisica = parseFloat($('.copy-inputs .qtd-produto').find('.adicionado')[0].innerHTML.replace('.', '').replace(',', '.'));
                    oQuantidades = await EntradasFisicas.getQuantidades();
                    if (iQuantidadeFisica < oQuantidades.quantidadesDoc) {
                        let iFaltante = oQuantidades.quantidadesDoc - iQuantidadeFisica;
                        dismiss = false;
                        await Swal.fire({
                            title: 'Faltam ' + (Utils.showFormatFloat(iFaltante, 
                                2)) + ' unidades para finalizar o Documento de entrada, deseja continuar?',
                            text: '',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#41B314',
                            cancelButtonColor: '#ac2925',
                            confirmButtonText: 'Sim, continuar',
                            cancelButtonText: 'Não',
                        }).then (result => {
                            if (result.dismiss == 'cancel'){
                                dismiss = true;
                            }
                        })
                        if (dismiss) {
                            return false
                        }  
                    }
                }
                var oReturn = EntradasFisicas.doAjax(aData, sAction, sController, false)
                
                Loader.showLoad()

                oReturn.then(function(retorno) {
                    Loader.hideLoad(1)
                    
                    setTimeout(() => {
                        if (retorno.status == 200){

                            EntradasFisicas.doLinksWithDB(retorno)
                            
                            Swal.fire({
                                title: 'Dados cadastrados com sucesso!',
                                text: '',
                                type: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            })
                            
                            EntradasFisicas.manageSaldosEntradas()
                            EntradasFisicas.calculateQtdProdutos()
                            EntradasFisicas.bloqueiaAlteracaoControles($oItemActive)
                            
                        }
                        else {
                            Swal.fire({
                                title: retorno.message,
                                text: '',
                                type: 'warning',
                                showConfirmButton: false
                            })
                        }
                    }, 400);
                })
            })
        })
    },

    bloqueiaAlteracaoControles: function($oItemActive) {
        $oItemActive.find('.controles .required-custom').attr('readonly', 'readonly')
        $oItemActive.find('select.produto_id').attr('readonly', 'readonly')
        $oItemActive.find('select.produto_id').selectpicker('refresh')
        $oItemActive.find('.bootstrap-select.produto_id .dropdown-toggle').attr('disabled', 'disabled')
        $oItemActive.find('.produto-barcode').attr('disabled', 'disabled')
        $oItemActive.find('select.param_label_controle_especificos').attr('disabled', 'disabled')
        $oItemActive.find('select.param_label_controle_especificos').selectpicker('refresh')
        $oItemActive.find('.bootstrap-select.param_label_controle_especificos .dropdown-toggle').attr('disabled', 'disabled')

        if ($oItemActive.find('.controles .required-custom:visible').size()){
            $oItemActive.find('.controles .already-inserted-message').removeClass('hidden')
        }
    },
    
    doLinkEntrada: function(data) {

        var toReplace = '_id_entrada_not_incremented_'
        var $oInputEntradaID = $('.entradas-fisicas.watched.active .copy-inputs .owl-item.active input[name*="'+toReplace+'"]')
        
        if ($oInputEntradaID.size()) {
            var oldName = $oInputEntradaID.attr('name')
            var newName = oldName.replace(toReplace, 'id')
            $oInputEntradaID.attr('name', newName)
            $oInputEntradaID.val(data.os_id)
    
            $oInputEntradaID.removeClass(toReplace)
            $oInputEntradaID.addClass('id')
        }         

    },

    doLinkAvarias: function(iAvariaID) {

        var toReplace = '_id_avaria_not_incremented_'
        var $oEntradasFisicaActive = $('.entradas-fisicas.watched.active .copy-inputs .owl-item.active')
        var $inputAvaria = $oEntradasFisicaActive.find('.copy-inputs.avarias input[name*="'+toReplace+'"]').first()
        
        if ($inputAvaria.size()) {
            var oldName = $inputAvaria.attr('name')
            var newName = oldName.replace(toReplace, 'id')
            $inputAvaria.attr('name', newName)
    
            $inputAvaria.removeClass(toReplace)
            $inputAvaria.addClass('id')
            $inputAvaria.val(iAvariaID)
        }
    },

    doLinkEtiquetaProduto: function(etiqueta_produto_id) {
        var toReplace = '_id_etiqueta_produto_not_incremented_'
        var $oInputEtiquetaID = $('.entradas-fisicas.watched.active .copy-inputs .owl-item.active input[name*="'+toReplace+'"]')
        
        if ($oInputEtiquetaID.size()) {
            var oldName = $oInputEtiquetaID.attr('name')
            var newName = oldName.replace(toReplace, 'etiqueta_produto_id')
            $oInputEtiquetaID.attr('name', newName)
            $oInputEtiquetaID.val(etiqueta_produto_id)
            $oInputEtiquetaID.removeClass(toReplace)

            //Caso o produto nao precisar gerar etiqueta
            if (!etiqueta_produto_id)
                return;

            var $oBtnImprimir = $oInputEtiquetaID.closest('.salvar-recebimento').find('.bt-impressao-etiqueta')
            $oBtnImprimir.removeClass('no-watched')
            $oBtnImprimir.addClass('watched')
            $oBtnImprimir.addClass('btn-success')
            $oInputEtiquetaID.addClass('etiqueta_produto_id')

            
            EntradasFisicas.manageWatcherImprimirEtiqueta()
        }
    },

    doLinksWithDB: function(retorno) {
        
        EntradasFisicas.doLinkEntrada(retorno.dataExtra)
        EntradasFisicas.doLinkEtiquetaProduto(retorno.dataExtra.etiqueta_produto)

        if (typeof retorno.dataExtra.avarias != undefined && retorno.dataExtra.avarias != null)
            retorno.dataExtra.avarias.forEach( function(oAvariaID, index, array) {
                EntradasFisicas.doLinkAvarias(oAvariaID.id)
            })

    },

    manageWatcherFinalizarRecebimento: function() {
        var $oFooter = $('.footer'); 

        $oFooter.find('.finalizar-recebimento.no-watched').each(async function() {
            $(this).removeClass('no-watched')
            $(this).addClass('watched');

            
            $(this).click(async function(e) {
                e.preventDefault()
                
                if ($('.entradas.side').find('.form-control.os_id').first().val()) {
                    var oResponseLacre = await Lacres.consisteLacre($('.entradas.side').find('.form-control.os_id').first().val());
        
                    if (!oResponseLacre)
                        return;
                }

                iOrdemServicoId = $('.get_ordem_servico_id').val();
                iTransporteId = $('.get_documento_transporte_id').val();

                var oReturn = await EntradasFisicas.doAjax({}, 
                    'verificaDivergencias'+'/'+iOrdemServicoId+'/'+iTransporteId, 
                    'OrdensServicoPendentes', true
                );

                if(!oReturn) {
                    title = 'Ops, ocorreu um problema, ainda assim deseja prosseguir?';
                    text = 'Falha ao validar divergencias.';
                }else{
                    title = oReturn.title;
                    text = oReturn.message;
                }
    
                return await Swal.fire({
                    title: title,
                    html: text,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#41B314',
                    cancelButtonColor: '#ac2925',
                    confirmButtonText: 'Sim, continuar',
                    cancelButtonText: 'Não',
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        var retorno
        
                        retorno = await EntradasFisicas.manageAjaxFinalizarRecebimento()
                        
                        if (retorno.status === 200){
                            return true
                        }else{
                            Swal.showValidationMessage('A requisição falhou retornando: ' + retorno.message)
                            return false
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then (async result => {
                    if (!result.dismiss && result.dismiss != 'cancel'){
                        var iTransporteID = $('.documentos.side .form-control.transporte.id').val()
                        var iOSID = $('.entradas.side').find('.form-control.os_id').first().val()
                        var url_finalizar = url + '/ordens-servico-pendentes/finalizar-descarga/' + iOSID + '/' + iTransporteID 
                        
                        window.location.href = url_finalizar
                        Loader.showLoad();
                    }else {
                        return false
                    }
        
                })                
            })
        })
    },

    manageWatchSelectPickers: function(classCustom) {

        $('.copy-inputs .full-item-owl '+classCustom+':not(.watched)').each(function() {
            $(this).addClass('watched')
            $(this).removeClass('no-watched')
            $(this).selectpicker({
                dropupAuto: false
            })
        })

    },

    manageOnRemovePages: function($pageToRemove, $carousel) {
        var $itens = $carousel.find('.owl-item')
        var indexToRemove = $itens.index( $pageToRemove )
        
        if ( $itens.size() != (indexToRemove + 1) )
            EntradasFisicas.manageToggleCarousel('next', $carousel)
        else
            EntradasFisicas.manageToggleCarousel('prev', $carousel)
        
        setTimeout(() => {
            $carousel.trigger('remove.owl.carousel', [indexToRemove]).trigger('refresh.owl.carousel')

            setTimeout(() => {                
                EntradasFisicas.manageSaldosEntradas()
            }, 200);

        }, 200)
    },
    
    onRemoveCarousel: function() {

        var $entradas = $('.entradas-fisicas.watched')
        
        $entradas.find('.remove-data-entradas:not(watched)').each(function() {
            var $oBtnRemoveDataEntrada = $(this)

            $oBtnRemoveDataEntrada.removeClass('no-watched')
            $oBtnRemoveDataEntrada.addClass('watched')

            $(this).click(async function() {
                var $oEntradasFisicaActive = $(this).closest('.entradas-fisicas.active')
                var $carousel    = $oEntradasFisicaActive.find('.copy-inputs.entradas')
                var $pageToRemove = $carousel.find('.owl-item.active')
                var childHaveID = $pageToRemove.find('.form-control.id_entrada:not(._id_entrada_not_incremented_)')[0];
                var retorno = null
                
                if (typeof childHaveID !== 'undefined') {
                    retorno = await EntradasFisicas.manageAjaxDelete($pageToRemove)
                }

                if ( (retorno !== null && retorno && childHaveID !== 'undefined') || typeof childHaveID === 'undefined' ) {
                    EntradasFisicas.manageOnRemovePages($pageToRemove, $carousel)
                }
    
                EntradasFisicas.manageSaldosEntradas()
                
                Form.refreshAll()
            })

        })
        
    },

    onToggleCarouselEntradaFisica: function() {
        var $entradas = $('form .entradas.side')
        
        $entradas.find('.entradas-fisicas .toggle').click(function() {
            var $oEntradasFisicaActive = $(this).closest('.entradas-fisicas.active')
            var $carousel    = $oEntradasFisicaActive.find('.copy-inputs.entradas')

            setTimeout(() => {

                if ($(this).hasClass('next'))
                    EntradasFisicas.manageToggleCarousel('next', $carousel)
                else 
                    EntradasFisicas.manageToggleCarousel('prev', $carousel)

                Form.refreshAll(1)

                EntradasFisicas.fixHeightOwl()
            }, 200)

        })

    },

    goToLastPageCarousel: function($oEntradasFisicaActive) {
        
        var $carousel = $oEntradasFisicaActive.find('.copy-inputs')
        var $itens = $carousel.find('.owl-item')
        var $lastItem = $itens.last()
        var indexLastItem = $itens.index( $lastItem )

        EntradasFisicas.manageToggleCarousel('next', $carousel, indexLastItem)

    },

    manageToggleCarousel: function(dir, $carousel, index = null) {

        if (!$carousel) 
            return false;
        
        var $itens       = $carousel.find('.owl-item')
        var $itemActive  = $carousel.find('.owl-item.active')
        var indexActive  = $carousel.find('.owl-item').index( $itemActive ) 
        var indexToGo    = dir == 'next' ? indexActive + 1 : indexActive - 1 
        indexToGo        = index != null ? index : indexToGo

        if ($itens.size() == 1 || ((indexActive + 1) == $itens.size() && dir == 'next') || indexToGo < 0)
            return false
            
        if (indexToGo >= 0)
            $carousel.trigger('to.owl', indexToGo)

        Form.refreshAll()

        setTimeout(() => {
            EntradasFisicas.fixHeightOwl()
        }, 1000);
    },

    addMaskNumericAll: function() {

        $('.copy-inputs .numeric:not(.watched):not([name*="_increment__"])').each(function() {
            $(this).addClass('watched')

            var precision = $(this).attr('data-precision');            
            var allowNegative = $(this).hasClass('allow-negative') ? true : false

            if (typeof precision == 'undefined' || !precision)
                precision = 2

            $(this).maskMoney({
                prefix: "",
                decimal: ",",
                thousands: ".",
                allowZero: true,
                defaultZero: true,
                precision: precision,
                reverse: true,
                allowNegative: allowNegative
            });

            $(this).maskMoney('mask')

            if (Utils.isMobile()) {
                $(this).on('keydown keyup change blur', function() {
                    $(this).trigger('mask.maskMoney')
                })
            }

        })
    },

    onAddDataCarousel: function() {

        var $entradas = $('form .entradas.side')
        
        $entradas.find('.entradas-fisicas .add-data-entradas').click(function() {
            var $oEntradasFisicaActive = $(this).closest('.entradas-fisicas.active')
            var $copy_data             = $oEntradasFisicaActive.find('.copy.entradas')
            var html                   = EntradasFisicas.manageAssocEntradaFisica( $copy_data.html() )

            $oEntradasFisicaActive.find('.owl-carousel').owlCarousel('add', html).owlCarousel('update')
            
            EntradasFisicas.addMaskNumericAll()

            Form.refreshAll(1)

            setTimeout(() => {
                
                EntradasFisicas.goToLastPageCarousel($oEntradasFisicaActive)
                EntradasFisicas.manageAddDataAvarias()
                EntradasFisicas.manageRemoveAvarias()                
                EntradasFisicas.manageWatchSelectPickers('.selectpickerentradas:not(.armazem)')
                EntradasFisicas.manageWatchSelectPickers('.selectpickerentradas.armazem')
                EntradasFisicas.manageWatcherSalvarEntrada()
                SearchEnderecos.init()
                Utils.toUppercase('.copy-inputs')

                EntradasFisicas.fixHeightOwl()
                EntradasFisicas.executeHookProduto()
                $.fn.numericDouble();
            }, 20)

            setTimeout(() => {
                //Avarias Padroes: Amassado, Rasgado, Furado
                EntradasFisicas.addAvariasPadroes($entradas)
                
                EntradasFisicas.manageWatchTipoProdutos()
            }, 300);

            setTimeout(() => {
                Utils.updateHeightBasedElement(
                    $('.entradas-fisicas.watched.active'), 
                    $('.os-estoque'), 
                    20, 
                    900, 
                    EntradasFisicas.casesToUpdateHeigth()
                )
            }, 600);
        })
    },

    addAvariasPadroes: function($entradas) {
        var $oBtnAddAvaria = $entradas.find('.entradas-fisicas.watched.active .owl-carousel .owl-item.active .add-data-avarias.avarias-btn.watched')
        var $oLastAvaria = null;

        //aAvariasIDs é setado por um parametro
        //se encontra ao final do .ctp

        if (aAvariasIDs){
            for ($key in aAvariasIDs) {
                $oBtnAddAvaria.click()
                $oLastAvaria = $oBtnAddAvaria.closest('.base-avarias').find('.copy-inputs.avarias .item-avaria').last()
                $oLastAvaria.find('.avarias.watched select').val(aAvariasIDs[$key])
                $oLastAvaria.find('.avarias.watched select').selectpicker('refresh');
                $oLastAvaria.find('.volume-avaria input').val(1)
            }
        }

    },

    manageWatcherImprimirEtiqueta: function() {

        $('.entradas-fisicas.watched.active .copy-inputs .bt-impressao-etiqueta').each(function() {
            var $oBtEtiqueta = $(this)

            EntradasFisicas.onClickEtiqueta( $oBtEtiqueta )
            
        })
        
    },

    onClickEtiqueta: function($oBtEtiqueta) {
        $oBtEtiqueta.removeClass('no-watched')
        $oBtEtiqueta.addClass('watched')

        $oBtEtiqueta.click(function() {
            var iEtiquetaProdutoID = $(this).closest('div').find('.etiqueta_produto_id').val()
            
            if (iEtiquetaProdutoID) {
                var linkImpressaoEtiquetaProduto = url + '/etiqueta-produtos/imprimir-etiqueta-produto/' + iEtiquetaProdutoID + '/1'                
                window.open( linkImpressaoEtiquetaProduto )
            }
        })
    },
    
    manageAssocEntradaFisica: function(html) {
        
        var sToReplace = '__entrada_increment__'
        var iLastAssoc
        
        //faz a verificacao e gravacao das associacoes de entradas para o house ser vinculado corretamente
        if (aAssocEntradas.length){
            iLastAssoc = aAssocEntradas[ aAssocEntradas.length - 1 ] + 1
        }else {
            iLastAssoc = 1
        }

        aAssocEntradas.push(iLastAssoc)
        
        return html.replace(new RegExp(sToReplace, 'g'), iLastAssoc)

    },
    
    manageAssocAvaria: function(html) {
        
        var sToReplace = '__avaria_increment__'
        var iLastAssoc
            
        //faz a verificacao e gravacao das associacoes de avarias para as entradas serem vinculadas corretamentes
        if (aAssocAvarias.length){
            iLastAssoc = aAssocAvarias[ aAssocAvarias.length - 1 ] + 1
        }else {
            iLastAssoc = 1
        }
        
        aAssocAvarias.push(iLastAssoc)

        return html.replace(new RegExp(sToReplace, 'g'), iLastAssoc)
    },
    
    manageRemoveAvarias: function() {
        $('.entradas-fisicas.watched .copy-inputs .full-item-owl .base-avarias .remove-data-avarias:not(.watched)').each(function() {
            $(this).removeClass('no-watched')
            $(this).addClass('watched')

            $(this).click(async function() {                    
                var $oBaseAvarias   = $(this).closest('.base-avarias')
                var $lastChild      = $oBaseAvarias.find('.copy-inputs .item-avaria:last-child')
                var lastChildHaveID = $lastChild.find('.form-control.id_avaria:not(._id_avaria_not_incremented_)')[0];
                var retorno         = null
                lastChildHaveID     = (typeof lastChildHaveID !== 'undefined') ? true : false

                if (lastChildHaveID) {
                    retorno = await EntradasFisicas.manageAjaxDelete($lastChild, true)
                }

                if ( (retorno !== null && retorno && lastChildHaveID) || ( !lastChildHaveID ) ) {
                    $lastChild.slideUp().remove()
                    Form.refreshAll(1)
                }

            })
        })
    },

    manageAddDataAvarias: function() {

        var $oEntradasFisicas = $('.entradas-fisicas.watched')
        var $carousel = $oEntradasFisicas.find('.copy-inputs')
        var $oBaseAvarias = $carousel.find('.base-avarias')
        
        $oBaseAvarias.find('.add-data-avarias:not(.watched)').each(function() {
            $(this).removeClass('no-watched')
            $(this).addClass('watched')
            
            $(this).click(function(e) {
                var $oCopy = $(this).closest('.base-avarias').find('.copy.hidden.avarias')
                var html   = EntradasFisicas.manageAssocAvaria( $oCopy.html() )
                $(this).closest('.base-avarias').find('.copy-inputs.avarias').append( html )
                
                EntradasFisicas.manageWatchSelectPickers('.base-avarias .copy-inputs .selectpickeravarias')

                Utils.fixDropdownClipped('.owl-item.active .base-avarias .copy-inputs.avarias ', 'watched-fix-overflow')

                Form.refreshAll(1)
                
                EntradasFisicas.addMaskNumericAll()
                
                Utils.updateHeightBasedElement(
                    $('.entradas-fisicas.watched.active'), 
                    $('.os-estoque'), 
                    20, 
                    900, 
                    EntradasFisicas.casesToUpdateHeigth()
                )
            })
        })

    },

    manageWatch: function() {
        var i = 0;
        $('.conhecimento' + classHouse + ' .owl-item').each(function() {
            var $oEntradasFisicas = $(this).find('.entradas-fisicas.no-watched')

            $oEntradasFisicas.removeClass('no-watched')
            $oEntradasFisicas.addClass('watched')
            
            if (i == 0) {
                $oEntradasFisicas.addClass('active')
            }

            i++

            $oEntradasFisicas.appendTo('.os-estoque .entradas.side')
            EntradasFisicas.fixHeightOwl()
            EntradasFisicas.executeHookProduto()
            Form.refreshAll(1)
        })
    },

    manageToggleTriggerHouse: function() {
        $('body').on('toggledPageHouse', function(event, $obj) {
            EntradasFisicas.manageWatcherSalvarEntrada()

            var $oEntradas = $('.entradas.side')
            var $oEntradasFisicas = $oEntradas.find('.entradas-fisicas')
            var $oEntradasFisicasActive = $oEntradas.find('.entradas-fisicas.active')
            var indexActive = $oEntradasFisicas.index($oEntradasFisicasActive)
            

            $oEntradasFisicasActive.addClass('go-up')

            setTimeout(() => {
                $oEntradasFisicasActive.removeClass('active')
                $oEntradasFisicasActive.removeClass('go-up')

                console.log($obj, indexActive);

                setTimeout(() => {



                    if ($obj.dir){

                        if($obj.dir == 'current'){
                            $oEntradasFisicas.eq($obj.step).addClass('active')
                        }else if ($obj.dir == 'next'){
                            $oEntradasFisicas.eq(indexActive + $obj.step).addClass('active')
                        } else {
                            $oEntradasFisicas.eq(indexActive - $obj.step).addClass('active')
                        }
                    }
                    EntradasFisicas.fixHeightOwl()
                    EntradasFisicas.manageSaldosEntradas()
                }, 150);

            }, 100);
        })
    },

    manageAjaxDelete: async function($obj, isAvaria = false) {
        
        var $oEntradasFisicas = $('form .entradas.side')
        var $carousel = $oEntradasFisicas.find('.copy-inputs')
        var $active = $carousel.find('.owl-item.active')
        var childHaveID = $active.find('.id').size();

        if (!childHaveID)
            return true;


        return await Swal.fire({
            title: 'Você tem certeza?',
            text: "O registro será apagado assim que confirmar",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#41B314',
            cancelButtonColor: '#ac2925',
            confirmButtonText: 'Sim, deletar',
            cancelButtonText: 'Não',
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                var retorno

                if (isAvaria)
                    retorno = await EntradasFisicas.manageAjaxDeleteAvaria($obj)
                else
                    retorno = await EntradasFisicas.manageAjaxDeleteEntrada($obj)
                
                if (retorno.status === 200){
                    return true
                }else{
                    Swal.showValidationMessage('A requisição falhou retornando: ' + retorno.message)
                    return false
                }

            },

            allowOutsideClick: () => !Swal.isLoading()

        }).then (async result => {

            if (result.value) {

                await Swal.fire({
                    title: 'Registro deletado!',
                    text: "",
                    type: 'success',
                    timer: 1500,
                    showConfirmButton: false
                })

                return true

            }else {
                return false
            }

        })

    },

    manageAjaxFinalizarRecebimento: async function() {
        var data = { 
            id: $('.entradas.side').find('.form-control.os_id').first().val(),
            qtde: EntradasFisicas.manageSaldosEntradas(),
            etiqueta_produto_id: $('.entradas-fisicas.watched.active .copy-inputs .owl-item.active .form-control.etiqueta_produto_id').first().val()
        }

        var action = 'finaliza-recebimento',
            controller = 'ordens-servico-pendentes'

        return await EntradasFisicas.doAjax(data, action, controller)
    },

    manageAjaxDeleteEntrada: async function($obj) {
        var iEtiquetaProdutoID = $('.entradas-fisicas.watched.active .copy-inputs .owl-item.active .form-control.etiqueta_produto_id').first().val()

        var data = { 
            id: $obj.find('.form-control.id_entrada').val(),
            endereco_id: $obj.find('select.form-control.endereco_id').val(),
            etiqueta_produto_id: iEtiquetaProdutoID ? iEtiquetaProdutoID : ''
        }

        var action = 'EntradaFisica'

        return await EntradasFisicas.doAjax(data, action)
    },

    manageAjaxDeleteAvaria: async function($obj) {

        var data = { id: $obj.find('.form-control.id_avaria').val() }
        var action = 'Avaria'

        return await EntradasFisicas.doAjax(data, action)
    },

    doAjax: async function(data, action, controller = null, async = true) {
        controller = !controller ? '/ordens-servico-pendentes/remove-data-ajax/' : '/' + controller + '/'
        var target = controller + action

        if (async) {
            return await $.ajax({
                type: 'POST',
                data: data,
                url: url + target
            })
        }
        
        return $.ajax({
            type: 'POST',
            data: data,
            url: url + target
        })
    },

    manageSaldosEntradas: function() {
        var $oStatusDescarga = $('.conhecimento.house .owl-item.active .status-descarga')
        var oQuantidades = EntradasFisicas.getQuantidades();
        var quantidadesFisica = oQuantidades.quantidadesFisica,
            pesosFisica = oQuantidades.pesosFisica,
            quantidadesDoc = oQuantidades.quantidadesDoc,
            pesosDoc       = oQuantidades.pesosDoc,
            $oQuantidadesFisico = $oStatusDescarga.find('.quantidade.fisico'),
            $oPesosFisico = $oStatusDescarga.find('.peso.fisico'),
            red = '#ed1b2461',
            yellow = '#f0ad4ead',
            green = '#41b3147d'

        var iPrecisionQtd = $oQuantidadesFisico.attr('data-precision');  
        var iPrecisionPeso = $oPesosFisico.attr('data-precision');
        
        if (typeof iPrecisionQtd == 'undefined' || !iPrecisionQtd)
            iPrecisionQtd = 2;

        if (typeof iPrecisionPeso == 'undefined' || !iPrecisionPeso)
            iPrecisionPeso = 2;
        
        $oQuantidadesFisico.val( Utils.showFormatFloat(quantidadesFisica,
            iPrecisionQtd))
        $oPesosFisico.val( Utils.showFormatFloat(pesosFisica, 
            iPrecisionPeso))

        if (quantidadesDoc > quantidadesFisica){
            $oQuantidadesFisico.css('backgroundColor', red)
            $oQuantidadesFisico.addClass('diverge')
        }else if (quantidadesDoc < quantidadesFisica) {            
            $oQuantidadesFisico.css('backgroundColor', yellow)
            $oQuantidadesFisico.addClass('diverge')
        }else {            
            $oQuantidadesFisico.css('backgroundColor', green)
            $oQuantidadesFisico.removeClass('diverge')
        }

        if (pesosDoc > pesosFisica){
            $oPesosFisico.css('backgroundColor', red)
            $oPesosFisico.addClass('diverge')
        }else if (pesosDoc < pesosFisica) {   
            $oPesosFisico.css('backgroundColor', yellow)
            $oPesosFisico.addClass('diverge')
        }else {            
            $oPesosFisico.css('backgroundColor', green)
            $oPesosFisico.removeClass('diverge')
        }
        
        return { quantidadeFisica: quantidadesFisica, pesoFisica: pesosFisica };
    },

    getQuantidades: function() {
        var $oStatusDescarga = $('.conhecimento.house .owl-item.active .status-descarga')
        var quantidadesFisica = 0.00,
            pesosFisica = 0.00,
            $oQuantidadesDoc = $oStatusDescarga.find('.quantidade.documento'),
            $oPesosDoc = $oStatusDescarga.find('.peso.documento'),
            quantidadesDoc = parseFloat($oQuantidadesDoc.val().replace('.', '').replace(',', '.')),
            pesosDoc       = parseFloat($oPesosDoc.val().replace('.', '').replace(',', '.')),
            $oQuantidadesFisico = $oStatusDescarga.find('.quantidade.fisico'),
            $oPesosFisico = $oStatusDescarga.find('.peso.fisico')

        $('.entradas-fisicas.watched.active .copy-inputs .owl-item').each(function() {
            
            if ($(this).find('.salvar-recebimento ._id_etiqueta_produto_not_incremented_').size())
                return;

            var $oItem = $(this)

            auxQuantidadeFisica = $oItem.find('.quantidade-input').val().replace('.', '').replace(',', '.')
            auxPesoFisica       = $oItem.find('.peso-input').val().replace('.', '').replace(',', '.')

            quantidadesFisica += parseFloat( auxQuantidadeFisica)
            pesosFisica       += parseFloat( auxPesoFisica)
        })

        return {quantidadesFisica: quantidadesFisica, pesosFisica: pesosFisica, quantidadesDoc: quantidadesDoc, pesosDoc: pesosDoc}
    }

}