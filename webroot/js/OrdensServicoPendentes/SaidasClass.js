aEtiquetaProdutosCarregadas  = (typeof aEtiquetaProdutosCarregadas === "undefined") ? new Array() : aEtiquetaProdutosCarregadas
aEtiquetaCodBarrasCarregadas = (typeof aEtiquetaCodBarrasCarregadas === "undefined") ? new Array() : aEtiquetaCodBarrasCarregadas
aSaldosHouses        = (typeof aSaldosHouses        === "undefined") ? [] : aSaldosHouses
aAssocEntradas       = (typeof aAssocEntradas       === "undefined") ? new Array() : aAssocEntradas
aAssocAvarias        = (typeof aAssocAvarias        === "undefined") ? new Array() : aAssocAvarias
ajaxInProgress       = false
bEstornarModal       = false
var isCarregamentoOuEstorno = ''

var Saidas = {
    init: function () {

        Saidas.disableEnterKey()

        $('.documentos.side .liberacao_documental .owl-carousel').owlCarousel({
            loop:false,
            nav:false,
            autoHeight:true,
            singleItem:true,
            items:1,
            autoplay:false,
            dots:false,
            autoHeight:true,
            stagePadding:0,
            touchDrag:false,
            mouseDrag:false,
            pullDrag:false,
            freeDrag:false
        })

        Form.refreshAll(1)

        Saidas.manageWatch()
        Saidas.manageToggleTriggerDadosLiberacao()
        Saidas.onToggleCarousel()

        Saidas.manageWatcherFinalizarCarregamento()
        Saidas.manageWatcherSalvarSaida()
        Saidas.addMaskNumericAll()
        
        Saidas.loadEtiquetasCarregadas()
        Saidas.manageWatchCodebar()

        Saidas.updateHeight()
        
    },

    disableEnterKey: function() {
        $('html').bind('keypress', function(e){
            if(e.keyCode == 13 && ajaxInProgress) {
               return false;
            }
        });
    },

    onFocusOutCodebar: function() {
        $('.input-codigo-barras.watched').focusout(function() {
            $(this).attr('inputmode', 'none')
        })
    },
    
    onDoubleClickCodebar: function() {
        oHooks.watchDoubleClick('.input-codigo-barras.watched', () => { 
            $('.saidas-fisicas.watched.active .input-codigo-barras.watched').attr('inputmode', 'decimal') 
        })
    },

    updateHeight: function() {
        setTimeout(() => {
            Utils.updateHeightBasedElement(
                $('.saidas-fisicas.watched.active'), 
                $('.documentos.side .copy-inputs .owl-height'), 
                - 10, 
                0
            )
        }, 500);
    },

    manageWatchCodebar: function() {
        var $oInputCodebars = $('.saidas-fisicas .input-codigo-barras:not(.watched)')

        $oInputCodebars.each(function () {
            $(this).addClass('watched')

            $oInputCodebar = $(this)

            // $oInputCodebar.inputFilter(function(value) {
            //     return /^\d*$/.test(value);
            //   });

            $oInputCodebar.keyup(function (e) {

                if(e.which != 8 && e.keyCode == 9)
                    return false                

                if ( $(this).val().length < 15 ) 
                    return false

                if (!ajaxInProgress) 
                    Saidas.sendCodebar()
            })

            $oInputCodebar.keypress(function (e) {
                if (e.keyCode == 13)  { // enter

                    if ( $(this).val().length < 15 ) 
                        return false

                    if (!ajaxInProgress) 
                        Saidas.sendCodebar()
                }
            })

        })
    },

    getTipoLeitura: function() {
        return $('.tipo-leitura.active').attr('tipo')
    },

    checkIfCodebarExists: async function ($oCodebar) {

        return await new Promise(async function (resolver) {

            await new Promise(async function (resolve) {
                setTimeout(async () => {
                    resolve()
                }, 500);
            })

            var existe = false 
            var sCodebarInformado = $oCodebar.val()
            var $carousel = $('.liberacoes')
            var $oCarregamentosCarousel = $carousel.find('.owl-item')
            var indexActive = $oCarregamentosCarousel.index( $carousel.find('.owl-item.active') )
            var indexFinded  = null
            var sTipoLeitura = Saidas.getTipoLeitura()
            
            $oCarregamentosCarousel.each(function () {
                var $oLiberacaoCarousel = $(this)
                var indexFinding = $oCarregamentosCarousel.index( $oLiberacaoCarousel )
                var $oEtiquetaCodebars = $oLiberacaoCarousel.find('.hidden.codebars li')

                $oEtiquetaCodebars.each(function () {
                    var sEtiquetaCodebar = $(this).html()
                    var sCodebarFind = sTipoLeitura + '_' + sCodebarInformado
                    
                    if (sEtiquetaCodebar == sCodebarFind) {
                        return indexFinded = indexFinding
                    }
                })

                return indexFinded
            })
            
            if (indexFinded === null){
                return resolver(false)
            }else if (indexFinded == indexActive) {
                existe = true
            }else{
                existe = true

                $('.saidas-fisicas.watched.active .input-codigo-barras.watched').val(null)
                
                if (indexFinded > indexActive) {
                    var steps = indexFinded - indexActive
                    
                    while (steps > 0) {
                        
                        await new Promise(async function (resolve) {
                            setTimeout(async () => {
                                $('.liberacao .next-data').click()
                                // $carousel.trigger('next.owl.carousel')    
                                // $('body').trigger('toggledPageHouse', { dir: 'next' })
                                resolve()
                            }, 500);
                        })
                        
                        //Form.refreshAll(400)

                        steps--
                    }
                    
                }else {                
                    var steps = indexActive - indexFinded
                    
                    while (steps > 0) {
                        await new Promise(async function (resolve) {
                            setTimeout(async () => {
                                $('.liberacao .prev-data').click()
                                // $carousel.trigger('prev.owl.carousel')    
                                // $('body').trigger('toggledPageHouse', { dir: 'prev' })
                                resolve()
                            }, 500);
                        })

                        //Form.refreshAll(400)

                        steps--
                    }
                }
                
                await new Promise(async function (resolve) {
                    setTimeout(async () => {
                        $('.saidas-fisicas.watched.active .input-codigo-barras.watched').val(sCodebarInformado)
                        resolve()
                    }, 300);
                })
                
            }
            
            return resolver(existe)
        })
    },

    sendCodebar: function () {
        $('.saidas-fisicas.watched.active .salvar-carregamento.watched').click()
    },

    onToggleCarousel: function () {
        var $saidas = $('form .documentos.side')
        
        $saidas.find('.liberacao_documental .toggle').click(function () {
            Saidas.manageToggleLiberacoes( $(this) )

            Form.refreshAll(400)
            
            Saidas.updateHeight()
        })

    },

    manageToggleLiberacoes: function ($oBtnDirection) {
        var $carousel = $oBtnDirection.closest('fieldset').find('.owl-carousel'),
            $itemActive = $carousel.find('.owl-item.active'),
            $itens = $carousel.find('.owl-item'),
            totalItens = $itens.size() - 1
            indexActive = $itens.index($itemActive)

        if ($oBtnDirection.hasClass('prev')) {
            $carousel.trigger('prev.owl.carousel')

            if (indexActive != 0)
                $('body').trigger('toggledPageHouse', { index: indexActive, dir: 'prev' })
            
        }else if ($oBtnDirection.hasClass('next')) {
            $carousel.trigger('next.owl.carousel')
            
            if (indexActive != totalItens)
                $('body').trigger('toggledPageHouse', { index: indexActive, dir: 'next' })
        }

        //Form.refreshPaginator()
        
    },

    addMaskNumericAll: function () {

        $('.numeric:not(.watched):not([name*="_increment__"])').each(function () {
            $(this).addClass('watched')
            
            var precision = $(this).attr('data-precision');

            if (typeof precision == 'undefined' || !precision)
                precision = 2

            $(this).maskMoney({
                prefix: "",
                decimal: ",",
                thousands: ".",
                precision: precision,
                reverse: true
            });
        })

        $('.numeric.watched').each(function () {            
            $(this).trigger('mask.maskMoney')
        })

    },

    manageWatch: function () {
        var i = 0;
        $('.liberacao_documental .owl-item').each(function () {
            var $oSaidas = $(this).find('.saidas-fisicas.no-watched')

            $oSaidas.removeClass('no-watched')
            $oSaidas.addClass('watched')
            
            if (i == 0) {
                $oSaidas.addClass('active')

                setTimeout(function () {
                    Saidas.onDoubleClickCodebar()
                    Saidas.onFocusOutCodebar()
                    
                    if ($('.saidas-fisicas.watched.active .input-codigo-barras').size()) {
                        setTimeout(function() {
                            $('.saidas-fisicas.watched.active .input-codigo-barras').focus();
                            
                            $([document.documentElement, document.body]).animate({
                                scrollTop: $('.saidas-fisicas.watched.active .input-codigo-barras').offset().top - 350
                            }, 400);
    
                        }, 400)
                    }

                }, 1400)
            }

            i++

            $oSaidas.appendTo('.os-estoque .saidas.side')
        })
    },

    manageToggleTriggerDadosLiberacao: function () {

        $('body').on('toggledPageHouse', async function (event, $obj) {
            Loader.showLoad(false)
            Saidas.loadEtiquetasCarregadas()
            var $oSaidasSide   = $('.saidas.side')
            var $oSaidas       = $oSaidasSide.find('.saidas-fisicas')
            var $oSaidasActive = $oSaidasSide.find('.saidas-fisicas.active')
            var indexActive    = $oSaidas.index($oSaidasActive)
            
            $oSaidasActive.addClass('go-up')
            
            setTimeout(() => {
                $oSaidasActive.addClass('hidden')
                $oSaidasActive.removeClass('active')
                $oSaidasActive.removeClass('go-up')

                setTimeout(() => {
                    if ($obj.dir){                        
                        if ($obj.dir == 'next'){
                            $oSaidas.eq($obj.index + 1).addClass('active')
                        } else {              
                            $oSaidas.eq($obj.index - 1).addClass('active')
                        }

                        $oSaidasActive = $oSaidasSide.find('.saidas-fisicas.active')
                        $oSaidasActive.removeClass('hidden')
                    }

                    setTimeout(function () {
                        if (!bEstornarModal)
                            $('.saidas-fisicas.watched.active .input-codigo-barras').focus();

                    }, 1000)

                    Loader.hideLoad()

                }, 150);

            }, 100);
        })
    },

    manageAjaxFinalizarCarregamento: async function () {
        var qtdCarregado = 0;

        $('.quantidade_retirado').each(function () {
            qtdCarregado += Utils.parseFloat( $(this).val() )
        })

        var data = { 
            id: $('.ordem_servico_id').first().val(),
            qtde_carregado: qtdCarregado 
        }

        var action = 'finaliza-carregamento',
            controller = 'ordens-servico-pendentes'

        return await Saidas.doAjax(data, action, controller)
    },

    doAjax: async function (data, action, controller = null, async = true) {
        controller = !controller ? 'ordens-servico-pendentes/remove-data-ajax/' : '/' + controller + '/'
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

    validaSeFoiCarregado: function(sCodebar) {
        if (Saidas.getTipoLeitura() == 'volume') 
            return aVolumesCodBarrasCarregados.includes( sCodebar )
        else if (Saidas.getTipoLeitura() == 'etiqueta')
            return aEtiquetaCodBarrasCarregadas.includes( sCodebar )

        return true
    },
    
    manageWatcherSalvarSaida: function () {

        var $oSaidasFisica = $('.saidas-fisicas'); 

        $oSaidasFisica.find('.salvar-carregamento.no-watched').each(function () {
            if ($(this).hasClass('por-produtos'))
                return;
                
            $(this).removeClass('no-watched')
            $(this).addClass('watched')

            $(this).click(async function (e) {
                ajaxInProgress = true
                var existeCodebar = false
                var $oCodebar = $('.saidas-fisicas.watched.active').find('.input-codigo-barras')
                Loader.showLoad()

                await Saidas.checkIfCodebarExists( $oCodebar ).then(async function (existe) {
                    await Utils.waitMoment(500)

                    var $oInputCodebar = $('.saidas-fisicas.watched.active').find('.input-codigo-barras')

                    existeCodebar = existe

                    if (!existeCodebar) {
                        ajaxInProgress = false
                        
                        $oInputCodebar.val(null)
                        Loader.hideLoad()

                        return await Swal.fire({
                            title: 'Código de barras inexistente',
                            text: '',
                            type: 'warning',
                            timer: 4000,
                            showConfirmButton: false
                        })
                    }

                    Loader.showLoad()
                    
                    await Utils.waitMoment(500)
    
                    Loader.showLoad()

                    var message = text = false
                    var sCodebar = $oInputCodebar.val(),
                        iMaxLenEtiqueta = $oInputCodebar.attr('maxlength'),
                        iMinLenEtiqueta = $oInputCodebar.attr('minlength'),
                        aEstoquesIDs    = new Array(),
                        oEstoquesIDs    = $('.owl-item.active .item-carregamento.liberacao .estoque-saidas.status-carga .estoque_id')
                        
                    isCarregamentoOuEstorno = 'carregamento'

                    oEstoquesIDs.each(function () { 
                        aEstoquesIDs.push( $(this).val() )
                    })

                    if (sCodebar.length > iMaxLenEtiqueta && sCodebar.length < iMinLenEtiqueta) 
                        message = 'Código de etiqueta inválido!',
                        text = 'São necessários no minimo' +iMinLenEtiqueta+ ' e no maximo '+ iMaxLenEtiqueta + ' caracteres!'
                    else if (Saidas.getTipoLeitura() == 'etiqueta' && (!oEstoquesIDs.size() || !aEstoquesIDs.length))
                        message = 'Faltam parâmetros para a requisição!',
                        text = 'Erro interno, favor contatar os administradores'
    
                    if (message && text) {
                        ajaxInProgress = false
                        
                        $oInputCodebar.val(null)
                        Loader.hideLoad()

                        return await Swal.fire({
                            title: message,
                            text: text,
                            type: 'warning',
                            timer: 5000,
                            showConfirmButton: false
                        })
                    }
    
                    if (Saidas.validaSeFoiCarregado(sCodebar)) {
                        bEstornarModal = true

                        await Swal.fire({
                            title: 'Código de Barras já carregado, deseja Estornar?',
                            text: '',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#41B314',
                            cancelButtonColor: '#ac2925',
                            confirmButtonText: 'Sim, estornar',
                            cancelButtonText: 'Não',
                            preConfirm: async () => {
                                isCarregamentoOuEstorno = 'estorno'
                            },
                            allowOutsideClick: false
                        })

                        bEstornarModal = false
                        
                        //caso não deseja estornar, nao deixa seguir o fluxo de estorno
                        if (isCarregamentoOuEstorno !== 'estorno') {
                            ajaxInProgress = false
                            $oInputCodebar.val(null)
                            Loader.hideLoad()
                            return false
                        } 
                        Loader.showLoad()
                    }
    
                    var aData = {
                        sCodebar: sCodebar,
                        sTipoCodebar: Saidas.getTipoLeitura(),
                        aEstoquesIDs: aEstoquesIDs,
                        iOSID: $('.ordem_servico_id').val(),
                        isCarregamentoOuEstorno: isCarregamentoOuEstorno
                    }
    
                    var sController = 'ordens-servico-pendentes'
                    var sAction = 'save-saida-fisica'

                    $oInputCodebar.focusout()

                    var oReturn = Saidas.doAjax(aData, sAction, sController, false)

                    await oReturn.then(async function (oResponse) {
                        Loader.hideLoad(1)
                        
                        return await setTimeout(async function() {
                            ajaxInProgress = false
                            $oInputCodebar.val(null)
    
                            if (oResponse.status == 200){
                                
                                await Utils.swalResponseUtil(oResponse, {
                                    timer: 2500
                                })
    
                                Saidas.manageCarregamentoCodebar(sCodebar)
                                Saidas.manageSaldosSaidas(oResponse, 'desktop')
                                Saidas.manageSaldosSaidas(oResponse, 'responsive')
                            }else {
                                await Utils.swalResponseUtil(oResponse)
                            }
                            
                            $oInputCodebar.focus()
                        }, 400);
                    })
                    
                    // setTimeout(() => {
                    //     $oInputCodebar.focus()
                    // }, 400);
                })

            })
        })
    },

    loadEtiquetasCarregadas: function () {
        var $oStatusCarga       = $('.documentos.side .owl-item.active .estoque-saidas.status-carga'),
            $oUnidadeMedidaEstoque = $oStatusCarga.find('[class*="unidade_medida_"]')
        
        $oUnidadeMedidaEstoque.each(function () {

            var $oUnidadeMedidaEstoqueAtual = $(this),
                $oQuantidadeEstoque    = $oUnidadeMedidaEstoqueAtual.find('.quantidade_estoque'),
                $oQuantidadeRetirado   = $oUnidadeMedidaEstoqueAtual.find('.quantidade_retirado'),
                $oQuantidadeSaldo      = $oUnidadeMedidaEstoqueAtual.find('.quantidade_saldo'),
                quantidadeEstoque      = Utils.parseFloat( $oQuantidadeEstoque.val() ),
                quantidadeRetirado     = Utils.parseFloat( $oQuantidadeRetirado.val() ),
                red    = 'red-label',
                orange = 'orange-label',
                green  = 'green-label'

            resultQtdRetirado  = quantidadeRetirado
            
            if (resultQtdRetirado > quantidadeEstoque){
                $oQuantidadeSaldo.addClass('diverge')
                $oQuantidadeSaldo.addClass(red)
                $oQuantidadeSaldo.removeClass(orange)
                $oQuantidadeSaldo.removeClass(green)
            }else if (resultQtdRetirado < quantidadeEstoque) {   
                $oQuantidadeSaldo.addClass('diverge')
                $oQuantidadeSaldo.addClass(orange)
                $oQuantidadeSaldo.removeClass(red)
                $oQuantidadeSaldo.removeClass(green)
            }else {            
                $oQuantidadeSaldo.addClass(green)
                $oQuantidadeSaldo.removeClass('diverge')
                $oQuantidadeSaldo.removeClass(red)
                $oQuantidadeSaldo.removeClass(orange)
            }
        })
    },

    loadProdutosCarregados: function () {
        var $oStatusCarga = $('.documentos.side .owl-item.active .estoque-saidas.status-carga'),
            $oProduto     = $oStatusCarga.find('.desktop[class*="produto_id"], .responsive[class*="produto_id"]')
        
        $oProduto.each(function () {

            var $oProdutoAtual = $(this),
                $oQuantidadeEstoque    = $oProdutoAtual.find('.quantidade_estoque'),
                $oQuantidadeRetirado   = $oProdutoAtual.find('.quantidade_retirado'),
                $oQuantidadeSaldo      = $oProdutoAtual.find('.quantidade_saldo'),
                quantidadeEstoque      = Utils.parseFloat( $oQuantidadeEstoque.val() ),
                quantidadeRetirado     = Utils.parseFloat( $oQuantidadeRetirado.val() ),
                red    = 'red-label',
                orange = 'orange-label',
                green  = 'green-label'

            resultQtdRetirado  = quantidadeRetirado
            
            if (resultQtdRetirado > quantidadeEstoque){
                $oQuantidadeSaldo.addClass('diverge')
                $oQuantidadeSaldo.addClass(red)
                $oQuantidadeSaldo.removeClass(orange)
                $oQuantidadeSaldo.removeClass(green)
            }else if (resultQtdRetirado < quantidadeEstoque) {   
                $oQuantidadeSaldo.addClass('diverge')
                $oQuantidadeSaldo.addClass(orange)
                $oQuantidadeSaldo.removeClass(red)
                $oQuantidadeSaldo.removeClass(green)
            }else {            
                $oQuantidadeSaldo.addClass(green)
                $oQuantidadeSaldo.removeClass('diverge')
                $oQuantidadeSaldo.removeClass(red)
                $oQuantidadeSaldo.removeClass(orange)
            }
        })
    },

    manageCarregamentoCodebar: function(sCodebar) {
        if (isCarregamentoOuEstorno == 'estorno') {
            if (Saidas.getTipoLeitura() == 'etiqueta') {
                delete aEtiquetaCodBarrasCarregadas[ aEtiquetaCodBarrasCarregadas.indexOf(sCodebar) ]
            }else if (Saidas.getTipoLeitura() == 'volume') {
                delete aVolumesCodBarrasCarregados[ aVolumesCodBarrasCarregados.indexOf(sCodebar) ]
            }
        }else {
            if (Saidas.getTipoLeitura() == 'etiqueta') {
                aEtiquetaCodBarrasCarregadas.push(sCodebar)
            }else if (Saidas.getTipoLeitura() == 'volume') {
                aVolumesCodBarrasCarregados.push(sCodebar)
            }
        }
    },

    manageSaldosSaidas: function (oResponse, ambiente, isPorProduto = false) {

        if (isPorProduto == true)
            Saidas.setSaldosByProduto(oResponse, ambiente)
        else if (Saidas.getTipoLeitura() == 'etiqueta')
            Saidas.setSaldosByEtiqueta(oResponse, ambiente)
        else if (Saidas.getTipoLeitura() == 'volume')
            Saidas.setSaldosByVolume(oResponse, ambiente)
        
    },

    setSaldosByVolume: function(oResponse, ambiente) {
        var oDataExtra       = oResponse.dataExtra,
            oObject          = oDataExtra.object,
            sCodebar         = oObject.codigo_barras,
            sCodBarrasAgroup = Saidas.getTipoLeitura() + '_' + oObject.codigo_barras, 
            $oStatusCarga    = $('.documentos.side .owl-item.active .estoque-saidas.status-carga'),
            $oSaidasFisica   = $('.saidas-fisicas.watched.active'),
            $oItemStatus     = $oStatusCarga.find('.'+ambiente+'[codigo-barras*="'+sCodBarrasAgroup+'"]'),
            $oCarregados     = $oSaidasFisica.find('.estoque-saidas')
            $oItemCarregado  = $oCarregados.find('.'+ambiente+'[codigo-barras*="'+sCodBarrasAgroup+'"]')
        
        if (Saidas.validaSeFoiCarregado(sCodebar)) {
            $oItemStatus.find('select')
                .val(1)
                .removeClass('diverge red-label')
                .addClass('green-label')
            $oItemCarregado.find('select')
                .val(1)
                .removeClass('diverge red-label')
                .addClass('green-label')
        }else {
            $oItemStatus.find('select')
                .val(0)
                .removeClass('green-label')
                .addClass('diverge red-label')
            $oItemCarregado.find('select')
                .val(0)
                .removeClass('green-label')
                .addClass('diverge red-label')
        }
    },

    setSaldosByProduto: function(oResponse, ambiente){
        var sParamBusca = '',
            oDataExtra  = oResponse.dataExtra,
            oObject     = oDataExtra.object

        sParamBusca = '.produto_id_' + oObject.produto_id + '_lote_codigo_' + oObject.lote_codigo + '_liberacao_documental_item_id_' + oObject.id 

        var $oStatusCarga          = $('.documentos.side .owl-item.active .estoque-saidas.status-carga'),
            $oSaidasFisica         = $('.saidas-fisicas.watched.active'),
            $oProdutoEstoque       = $oStatusCarga.find('.'+ambiente+sParamBusca),
            $oCarregados           = $oSaidasFisica.find('.estoque-saidas'),
            $oQuantidadeCarregado  = $oCarregados.find(sParamBusca),
            $oQuantidadeEstoque    = $oProdutoEstoque.find('.quantidade_estoque'),
            $oQuantidadeRetirado   = $oProdutoEstoque.find('.quantidade_retirado'),
            $oQuantidadeSaldo      = $oProdutoEstoque.find('.quantidade_saldo'),
            quantidadeCarregado    = Utils.parseFloat( $oQuantidadeCarregado.val() ),
            quantidadeEstoque      = Utils.parseFloat( $oQuantidadeEstoque.val() ),
            quantidadeRetirado     = Utils.parseFloat( $oQuantidadeRetirado.val() ),
            quantidadeSaldo        = Utils.parseFloat( $oQuantidadeSaldo.val() ),
            isEstorno              = (ObjectUtil.issetProperty(oDataExtra, 'estorno') && oDataExtra.estorno) ? true : false,
            red    = 'red-label',
            orange = 'orange-label',
            green  = 'green-label'
        
        console.log('oStatusCarga')
        console.log($oStatusCarga)
        console.log('oSaidasFisica')
        console.log($oSaidasFisica)
        console.log('oProdutoEstoque')
        console.log($oProdutoEstoque)
        console.log('oCarregados')
        console.log($oCarregados)
        console.log('oQuantidadeCarregado')
        console.log($oQuantidadeCarregado)
        console.log('oQuantidadeEstoque')
        console.log($oQuantidadeEstoque)
        console.log('oQuantidadeRetirado')
        console.log($oQuantidadeRetirado)
        console.log('oQuantidadeSaldo')
        console.log($oQuantidadeSaldo)
        console.log('isEstorno')
        console.log(isEstorno)

        if (!isEstorno){
            resultQtdCarregadoFormated = parseFloat(resultQtdCarregado = quantidadeCarregado + oObject.qtde_referente)
            resultQtdRetiradoFormated  = parseFloat(resultQtdRetirado  = quantidadeRetirado + oObject.qtde_referente)
            resultQtdSaldoFormated     = parseFloat(resultQtdSaldo     = quantidadeSaldo - oObject.qtde_referente)
        }else {
            resultQtdCarregadoFormated = parseFloat(resultQtdCarregado = quantidadeCarregado - oObject.qtde_referente)
            resultQtdRetiradoFormated  = parseFloat(resultQtdRetirado  = quantidadeRetirado - oObject.qtde_referente)
            resultQtdSaldoFormated     = parseFloat(resultQtdSaldo     = quantidadeSaldo + oObject.qtde_referente)
        }
        
        if (ambiente == 'desktop')
            $oQuantidadeCarregado.val( resultQtdCarregadoFormated.toFixed(3) )

        $oQuantidadeRetirado.val(  resultQtdRetiradoFormated.toFixed(3) )
        $oQuantidadeSaldo.val(     resultQtdSaldoFormated.toFixed(3) )

        if (resultQtdRetirado > quantidadeEstoque){
            $oQuantidadeSaldo.addClass('diverge')
            $oQuantidadeSaldo.addClass(red)
            $oQuantidadeSaldo.removeClass(orange)
            $oQuantidadeSaldo.removeClass(green)
        }else if (resultQtdRetirado < quantidadeEstoque) {   
            $oQuantidadeSaldo.addClass('diverge')
            $oQuantidadeSaldo.addClass(orange)
            $oQuantidadeSaldo.removeClass(red)
            $oQuantidadeSaldo.removeClass(green)
        }else {            
            $oQuantidadeSaldo.addClass(green)
            $oQuantidadeSaldo.removeClass('diverge')
            $oQuantidadeSaldo.removeClass(red)
            $oQuantidadeSaldo.removeClass(orange)
        }

        Saidas.addMaskNumericAll()
    },

    setSaldosByEtiqueta: function(oResponse, ambiente){
        var sParamBusca = '',
            oDataExtra  = oResponse.dataExtra,
            oObject     = oDataExtra.object

        sParamBusca = '.unidade_medida_' + oObject.unidade_medida_id

        var sCodBarras             = oObject.codigo_barras, 
            $oStatusCarga          = $('.documentos.side .owl-item.active .estoque-saidas.status-carga'),
            $oSaidasFisica         = $('.saidas-fisicas.watched.active'),
            $oUnidadeMedidaEstoque = $oStatusCarga.find('.'+ambiente+sParamBusca+'[codigo-barras*="'+sCodBarras+'"]'),
            $oCarregados           = $oSaidasFisica.find('.estoque-saidas'),
            $oQuantidadeCarregado  = $oCarregados.find(sParamBusca+'[codigo-barras*="'+sCodBarras+'"]'),
            $oQuantidadeEstoque    = $oUnidadeMedidaEstoque.find('.quantidade_estoque'),
            $oQuantidadeRetirado   = $oUnidadeMedidaEstoque.find('.quantidade_retirado'),
            $oQuantidadeSaldo      = $oUnidadeMedidaEstoque.find('.quantidade_saldo'),
            quantidadeCarregado    = Utils.parseFloat( $oQuantidadeCarregado.val() ),
            quantidadeEstoque      = Utils.parseFloat( $oQuantidadeEstoque.val() ),
            quantidadeRetirado     = Utils.parseFloat( $oQuantidadeRetirado.val() ),
            quantidadeSaldo        = Utils.parseFloat( $oQuantidadeSaldo.val() ),
            isEstorno              = (ObjectUtil.issetProperty(oDataExtra, 'estorno') && oDataExtra.estorno) ? true : false,
            red    = 'red-label',
            orange = 'orange-label',
            green  = 'green-label'
        
        console.log('oStatusCarga')
        console.log($oStatusCarga)
        console.log('oSaidasFisica')
        console.log($oSaidasFisica)
        console.log('oUnidadeMedidaEstoque')
        console.log($oUnidadeMedidaEstoque)
        console.log('oCarregados')
        console.log($oCarregados)
        console.log('oQuantidadeCarregado')
        console.log($oQuantidadeCarregado)
        console.log('oQuantidadeEstoque')
        console.log($oQuantidadeEstoque)
        console.log('oQuantidadeRetirado')
        console.log($oQuantidadeRetirado)
        console.log('oQuantidadeSaldo')
        console.log($oQuantidadeSaldo)
        console.log('isEstorno')
        console.log(isEstorno)

        if (!isEstorno){
            resultQtdCarregadoFormated = parseFloat(resultQtdCarregado = quantidadeCarregado + oObject.qtde)
            resultQtdRetiradoFormated  = parseFloat(resultQtdRetirado  = quantidadeRetirado + oObject.qtde)
            resultQtdSaldoFormated     = parseFloat(resultQtdSaldo     = quantidadeSaldo - oObject.qtde)
        }else {
            resultQtdCarregadoFormated = parseFloat(resultQtdCarregado = quantidadeCarregado - oObject.qtde)
            resultQtdRetiradoFormated  = parseFloat(resultQtdRetirado  = quantidadeRetirado - oObject.qtde)
            resultQtdSaldoFormated     = parseFloat(resultQtdSaldo     = quantidadeSaldo + oObject.qtde)
        }
        
        if (ambiente == 'desktop')
            $oQuantidadeCarregado.val( resultQtdCarregadoFormated.toFixed(2) )

        $oQuantidadeRetirado.val(  resultQtdRetiradoFormated.toFixed(2) )
        $oQuantidadeSaldo.val(     resultQtdSaldoFormated.toFixed(2) )

        if (resultQtdRetirado > quantidadeEstoque){
            $oQuantidadeSaldo.addClass('diverge')
            $oQuantidadeSaldo.addClass(red)
            $oQuantidadeSaldo.removeClass(orange)
            $oQuantidadeSaldo.removeClass(green)
        }else if (resultQtdRetirado < quantidadeEstoque) {   
            $oQuantidadeSaldo.addClass('diverge')
            $oQuantidadeSaldo.addClass(orange)
            $oQuantidadeSaldo.removeClass(red)
            $oQuantidadeSaldo.removeClass(green)
        }else {            
            $oQuantidadeSaldo.addClass(green)
            $oQuantidadeSaldo.removeClass('diverge')
            $oQuantidadeSaldo.removeClass(red)
            $oQuantidadeSaldo.removeClass(orange)
        }

        Saidas.addMaskNumericAll()
    },

    manageWatcherFinalizarCarregamento: function () {
        var $oFooter = $('.footer'); 

        $oFooter.find('.finalizar-carregamento.no-watched').each(function () {
            $(this).removeClass('no-watched')
            $(this).addClass('watched')

            $(this).click(async function (e) {
                e.preventDefault()
                
                var temDivergencia = $('.status-carga').find('.diverge').size()

                if (temDivergencia){
                    title = 'Você tem certeza?'
                    text = 'Há divergências entre os Conhecimentos'
                }else {
                    title = 'Deseja prosseguir?'
                    text = 'A Ordem de Serviço será finalizada ao prosseguir'
                }

                await Swal.fire({
                    title: title,
                    text: text,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#41B314',
                    cancelButtonColor: '#ac2925',
                    confirmButtonText: 'Sim, continuar',
                    cancelButtonText: 'Não',
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        var retorno

                        retorno = await Saidas.manageAjaxFinalizarCarregamento()
                        
                        if (retorno.status === 200){
                            return true
                        }else{
                            Swal.showValidationMessage('A requisição falhou retornando: ' + retorno.message)
                            return false
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then (async result => {
                    
                    if (result.dismiss != 'cancel'){
                        var iOSID = $('.ordem_servico_id').first().val()
                        var url_finalizar = url + 'ordens-servico-pendentes/finalizar-carga/' + iOSID  
                        
                        window.location.href = url_finalizar
                    }else {
                        return false
                    }
        
                })  

                return true;              
            })
        })
    },

}

$(document).ready(function () {

})