import { ManageRoutineData } from './ManageRoutineData.js'
import { Separacao } from './OperacaoSeparacaoClass.js'

export const ManageFrontend = {

    init: async function() {

        await this.renderLista()

        this.manageListaPedidos()
        this.setHeightListaPedidos()
        this.manageFocusEndereco()
        this.manageFocusProduto()
        this.manageFocusProdutoSerie()
        this.onDoubleClickEndereco()
        this.onDoubleClickProduto()
        this.onDoubleClickProdutoSerie()
    },
    manageValidate: async function(aValidationsLevels) {
        var bContinueAnyway = null,
            oValidate = null,
            aValidations = new Array(),
            aEscolhasBloqueadas = new Array(),
            aEscolhasLivres = new Array(),
            aEscolhasNegadas = new Array()

        if (aValidationsLevels === null)
            return {
                message:     'Não foi possível realizar as validações!',
                status:      400,
                validate:    oValidate  
            }

        for (var level in aValidationsLevels) {
            aValidations = aValidationsLevels[level]

            for (var i in aValidations) {
                oValidate = aValidations[i]

                if (ObjectUtil.issetProperty(oValidate, 'action')) {
                    await oValidate.action()
                }

                if (oValidate.status === 400) {
                    await Utils.swalUtil({
                        title: oValidate.message,
                        text: oValidate.text,
                        showConfirmButton: true,
                        confirmButtonText: 'Entendido!',
                        defaultConfirmColor: true
                    })
    
                    return {
                        message:     'NOK',
                        status:      400,
                        validate:    oValidate  
                    }
                }
                
                if (oValidate.status === 401) {
                    var bLibera = oValidate.libera,
                        text = bLibera ? 'Deseja continuar mesmo assim?' : 'Favor refazer a conferência!',
                        oData = null
                        
                    text = oValidate.text === false ? '' : text

                    oData = {
                        title:             oValidate.message,
                        text:              text,
                        confirmButtonText: bLibera ? 'Sim, continuar' : 'Vou reconferir',
                        showCancelButton:  bLibera,
                        showConfirmButton: true,
                        showCancelButton:  bLibera,
                        defaultConfirmColor: true
                    }
                    
                    if (bLibera)
                        aEscolhasLivres.push(1)
                    else 
                        aEscolhasBloqueadas.push(1)
    
                    bContinueAnyway = await Utils.swalConfirmOrCancel(oData)
    
                    //Negou em tela, que não queria continuar
                    if (!bContinueAnyway)
                        aEscolhasNegadas.push(1)
                }
            }

            if (aEscolhasLivres.length && aEscolhasNegadas.length || aEscolhasBloqueadas.length)
                return {
                    message:  'NOK',
                    status:   406,
                    validate: oValidate  
                }
        }


        return {
            message:  'OK',
            status:   100,
            validate: oValidate  
        }
    },
    manageFocusEndereco: function() {
        this.getInputEndereco().focusin(function() {
            Utils.focusInShadow('.endereco-digitado, .endereco-barcode')
        })

        this.getInputEndereco().focusout(function() {
            Utils.focusOutShadow('.endereco-digitado, .endereco-barcode')
            $(this).attr('inputmode', 'none')
        })
    },
    manageFocusProduto: function() {
        this.getInputProduto().focusin(function() {
            Utils.focusInShadow('.produto-digitado, .produto-barcode')
        })

        this.getInputProduto().focusout(function() {
            Utils.focusOutShadow('.produto-digitado, .produto-barcode')
            $(this).attr('inputmode', 'none')
        })

        this.getInputProduto().keyup(function(oKey) {
            if (oKey.keyCode == 13) {
                Utils.focusOnElem('.produto-barcode')
                $(this).prop('readonly', true)
            }
        })
    },
    manageFocusProdutoSerie: function() {
        this.getInputProdutoSerie().focusin(function() {
            Utils.focusInShadow('.produto-serie-digitado, .produto-serie-barcode')
        })

        this.getInputProdutoSerie().focusout(function() {
            Utils.focusOutShadow('.produto-serie-digitado, .produto-serie-barcode')
            $(this).attr('inputmode', 'none')
        })

        this.getInputProdutoSerie().keyup(function(oKey) {
            if (oKey.keyCode == 13) {
                Utils.focusOnElem('.produto-serie-barcode')
                $(this).prop('readonly', true)
            }
        })
    },
    onDoubleClickEndereco: function() {
        oHooks.watchDoubleClick('.endereco-digitado', () => { ManageFrontend.getInputEndereco().attr('inputmode', 'decimal') })
    },
    onDoubleClickProduto: function() {
        oHooks.watchDoubleClick('.produto-digitado', () => { ManageFrontend.getInputProduto().attr('inputmode', 'text') })
    },
    onDoubleClickProdutoSerie: function() {
        oHooks.watchDoubleClick('.produto-serie-digitado', () => { ManageFrontend.getInputProdutoSerie().attr('inputmode', 'text') })
    },
    openLista: function() {
        $('.container-pedidos').addClass('active') 
        $('html, body, .container-pedidos').addClass('lf-overflow-hidden')
    },
    closeLista: function() {
        $('.container-pedidos').removeClass('active') 
        $('html, body, .container-pedidos').removeClass('lf-overflow-hidden')
    },
    toggleLista: function() {
        if ($('.container-pedidos').hasClass('active')){
            this.closeLista()
        }else {
            this.openLista()
        }
    },
    manageListaPedidos: function() {
        this.getBtnListaPicking().click(function() {
            ManageFrontend.toggleLista()
        })
        $('.container-pedidos .lf-close').click(function() {
            ManageFrontend.toggleLista()
        })
    },
    setHeightListaPedidos: function() {
        var setHeight = async function() {
            var iWindowHeight = $(window).height()
            $('.separacao-cargas').css({
                height: iWindowHeight - 60
            })
        }
        setHeight()
        $(window).resize(setHeight)
    },
    setValuesPicking: async function(aDadosEndereco, sTipo = 'picking') {
        
        if (!ObjectUtil.isset(aDadosEndereco) && sTipo == 'picking'){
            return await Utils.swalUtil({
                title: 'Ops',
                text: 'O sistema não encontrou nenhuma quantidade desses produtos, favor verificar o inventário!',
                showConfirmButton: true,
                confirmButtonText: 'Entendido!',
                defaultConfirmColor: true
            })
        }

        this.closeLista()

        var $oPicking = this.getPickingContainer()
        var qtde = ManageRoutineData.getQtdeSeparada(aDadosEndereco)
        var endereco = ManageRoutineData.getComposicaoEnderecoSeparado(aDadosEndereco)
        var oState = Separacao.getState()
        
        $oPicking.find('.sku').html(aDadosEndereco.produto.codigo)
        $oPicking.find('.descricao').html(aDadosEndereco.produto.descricao)

        if (aDadosEndereco.localizacao.lote) {
            $oPicking.find('.lote').removeClass('hidden')
            $oPicking.find('.lote span').html(aDadosEndereco.localizacao.lote)
        }else {
            $oPicking.find('.lote').addClass('hidden')
        }

        if (aDadosEndereco.localizacao.serie) {
            $oPicking.find('.serie').removeClass('hidden')
            $oPicking.find('.serie span').html(aDadosEndereco.localizacao.lote)
        }else {
            $oPicking.find('.serie').addClass('hidden')
        }
        
        if (oState.separacao_carga_item.serie) {
            $oPicking.find('.serie').removeClass('hidden')
            $oPicking.find('.serie span').html(oState.separacao_carga_item.serie)
        }else {
            $oPicking.find('.serie').addClass('hidden')
        }

        if (oState.separacao_carga_item.serie) {
            ManageFrontend.getLeituraProdutoSerie().show()
            Separacao.setState('obriga_informar_serie', true)
        }else {
            ManageFrontend.getLeituraProdutoSerie().hide()
            Separacao.setState('obriga_informar_serie', false)
        }
        
        if (aDadosEndereco.localizacao.validade) {
            var sValidade = new Date(aDadosEndereco.localizacao.validade.split('t')[0])
            var ye = new Intl.DateTimeFormat('pt-BR', { year: 'numeric' }).format(sValidade)
            var mo = new Intl.DateTimeFormat('pt-BR', { month: '2-digit' }).format(sValidade)
            var da = new Intl.DateTimeFormat('pt-BR', { day: '2-digit' }).format(sValidade)
            
            $oPicking.find('.validade').removeClass('hidden')
            $oPicking.find('.validade span').html(da + '/' + mo + '/' + ye)
        }else {
            $oPicking.find('.validade').addClass('hidden')
        }

        $oPicking.find('.endereco_sugerido').html(aDadosEndereco.localizacao.endereco.composicao)
        $oPicking.find('.unidade_medida').html(aDadosEndereco.produto.unidade_medida.descricao)
        
        if (qtde && endereco) {
            //estornar
            this.hideSeparar()
            this.showEstornar()
            this.getBtnBarcode().prop('disabled', true) 
            this.getInputEndereco().prop('readonly', true)
            this.getInputProduto().prop('readonly', true)
            this.getInputProdutoSerie().prop('readonly', true)
            this.getInputQtde().prop('readonly', true)
            $oPicking.find('.quantidade_pegar').html(Utils.showFormatFloat(aDadosEndereco.qtde_separada))

            this.getInputProduto().val(oState.separacao_carga_item.produto.codigo_barras)
            this.getInputProdutoSerie().val(oState.separacao_carga_item.serie)
            
        }else {
            //pickar
            this.hideEstornar()
            this.showSeparar()
            this.getBtnBarcode().prop('disabled', false)
            this.getInputEndereco().prop('readonly', false)
            this.getInputProduto().prop('readonly', false)
            this.getInputProdutoSerie().prop('readonly', false)
            this.getInputQtde().prop('readonly', false)
            $oPicking.find('.quantidade_pegar').html(Utils.showFormatFloat(aDadosEndereco.qtde_retirar))
            
            if (!ManageRoutineData.params.libera_campo_quantidade) {
                qtde = aDadosEndereco.qtde_retirar
                Separacao.setState('qtde_separada', qtde)
                this.getInputQtde().prop('readonly', true)
            }
            
            this.getInputProduto().val(null)
            this.getInputProdutoSerie().val(null)
        }
        
        qtde = qtde ? Utils.showFormatFloat(qtde) : qtde

        this.getInputQtde().val( qtde )
        this.getInputEndereco().val( endereco )

        await this.hideBackgroudLoading(null, 300)
    },
    setItemSeparado: async function() {
        await ManageRoutineData.restructureItemSeparado()
        
        this.showBackgroudLoading()
        this.cleanInputs()
        this.cleanLista()

        return await this.renderLista()
    },
    setItemEstornado: async function(oResponse) {
        if (!ObjectUtil.getDepth(oResponse, 'dataExtra.aDadosOperacao'))
            Utils.swalResponseUtil(oResponse)

        await Utils.swalUtil({
            title: 'Estornado com sucesso!',
            type: 'success',
            timer: 2000
        })

        aDadosOperacao = ObjectUtil.getDepth(oResponse, 'dataExtra.aDadosOperacao')
        
        this.showBackgroudLoading()
        this.cleanInputs()
        this.cleanLista()
        
        return await this.renderLista()
    },
    disableActionButtons: function() {
        var $oBtns = $('.separar, .estornar')
        
        console.log('buttons', $oBtns)

        $oBtns.each(function() {
            $(this).attr('disabled', 'disabled')
        });

        setTimeout(function() {
            $oBtns.each(function() {
                $(this).removeAttr('disabled')
            });
        }, 3000);
    },
    hideBackgroudLoading: async function(fAction, iTiming = 1000) {
        return await BackgroundLoading.hide(fAction, iTiming)
    },
    showBackgroudLoading: async function() {
        BackgroundLoading.show()
    },
    hideEstornar() {
        $('.btn.estornar').hide()
    },
    showEstornar() {
        $('.btn.estornar').show()
    },
    hideSeparar() {
        $('.btn.separar').hide()
    },
    showSeparar() {
        $('.btn.separar').show()
    },
    cleanInputs: function() {
        this.getInputQtde().val(null)
        this.getInputEndereco().val(null)
        this.getInputEndereco().prop('readonly', false)
        this.getInputEndereco().removeClass('exibindo-composicao')
    },
    getOrdemServicoID: function() {
        return $('.ordem_servico_id').val()
    },
    getInputQtde: function() {
        return $('.quantidade-digitada')
    },
    getInputEndereco: function() {
        return $('.endereco-digitado')
    },
    getInputProduto: function() {
        return $('.produto-digitado')
    },
    getInputProdutoSerie: function() {
        return $('.produto-serie-digitado')
    },
    getBtnBarcode: function() {
        return $('.btn.endereco-barcode')
    },
    getBtnProdutoBarcode: function() {
        return $('.btn.produto-barcode')
    },
    getBtnProdutoSerieBarcode: function() {
        return $('.btn.produto-serie-barcode')
    },
    getLeituraProdutoSerie: function() {
        return $('.leitura_produto_serie')
    },
    getBtnSeparar: function() {
        return $('.btn.separar')
    },
    getBtnEstornar: function() {
        return $('.btn.estornar')
    },
    getBtnEstornar: function() {
        return $('.btn.estornar')
    },
    getBtnFinalizar: function() {
        return $('.btn.finalizar-operacao-separacao')
    },
    getBtnListaPicking: function() {
        return $('.btn-lista-pedidos')
    },
    getPickingContainer: function() {
        return $('.picking')
    },
    getItensHabilitaPicking: function() {
        return $('.separacao-carga .produto.habilita-picking')
    },
    getItensHabilitaEstorno: function() {
        return $('.separacao-carga .produto.habilita-estorno')
    },
    getListaItens: function() {
        return $('.separacao-carga .produto')
    },
    setComposicaoEndereco: function(sComposicao) {
        if (sComposicao) {
            this.getInputEndereco().val(sComposicao)
            this.getInputEndereco().addClass('exibindo-composicao')
            ManageFrontend.getInputEndereco().prop('readonly', true)
        }else {
            this.getInputEndereco().val(null)
        }
    },
    getTemplateListaSemHeuristica: function(sTipo) {
        if (sTipo === 'separados')
            return $('.copy.hidden .produto.sem-heuristica.separados')
        else if (sTipo === 'sem_localizacoes')
            return $('.copy.hidden .produto.sem-heuristica.sem-localizacao')
    },
    getTemplateListaHabilitaPicking: function() {
        return $('.copy.hidden .produto.habilita-picking')
    },
    getListaSeparacaoCarga: function() {
        return $('.separacao-carga')
    },
    cleanLista: function() {
        this.getListaItens().remove()
    },
    renderLista: async function() {
        Loader.showLoad()

        this.renderListaSepararPicking()
        this.renderListaSemHeuristica('separados')
        this.renderListaSemHeuristica('sem_localizacoes')

        await Utils.waitMoment(1000)

        Loader.hideLoad(100)
    },
    renderListaSepararPicking: function() {
        var sTemplate       = this.getTemplateListaHabilitaPicking()[0].outerHTML,
            aDadosEnderecos = ManageRoutineData.getDadosEndereco(null, null, true),
            oResponse       = new window.ResponseUtil()
        
        Object.keys(aDadosEnderecos).forEach(function(sKeyComposicao, oDataComposicao) {
            oResponse = RenderCopy.render({
                object: aDadosEnderecos[sKeyComposicao],
                template: sTemplate,
                data_to_render: 'habilita_picking',
            })

            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item ' + sKeyComposicao)
            
            //Renderiza
            ManageFrontend.getListaSeparacaoCarga().append(oResponse.getDataExtra())
        })
    },
    renderListaSemHeuristica(sTipo) {
        var sTemplate       = this.getTemplateListaSemHeuristica(sTipo)[0].outerHTML,
            aDadosEnderecos = ManageRoutineData.getDadosEnderecoSemHeuristica(sTipo),
            oResponse       = new window.ResponseUtil()

        Object.keys(aDadosEnderecos).forEach(function(sKeyComposicao, oDataComposicao) {
            oResponse = RenderCopy.render({
                object: aDadosEnderecos[sKeyComposicao],
                template: sTemplate,
                data_to_render: 'informativos',
            })

            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item ' + sKeyComposicao)
            
            //Renderiza
            ManageFrontend.getListaSeparacaoCarga().append(oResponse.getDataExtra())
        })
    }
}