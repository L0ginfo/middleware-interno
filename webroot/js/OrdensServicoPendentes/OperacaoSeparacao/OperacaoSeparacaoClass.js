import { ManageFrontend } from './ManageFrontend.js'
import { ManageRoutineData } from './ManageRoutineData.js'

const Separacao = {
    doingAjax: false,

    state: {
        qtde_separada: 0,
        endereco_separado: {},
        dados_endereco_picking: null,
        chave_endereco_composicao: null,
        separacao_carga_item: null,
        obriga_informar_serie: false
    },

    init: function() {
        this.setFirstPicking()
        this.watchOnClickSKU()
        this.watchOnClickBtnEnderecoBarcode()
        this.watchOnClickBtnProdutoBarcode()
        this.watchOnClickBtnProdutoSerieBarcode()
        this.watchOnFocusoutProduto()
        this.watchOnFocusoutProdutoSerie()
        this.watchInputEndereco()
        this.watchInputQtde()
        this.watchBtnSeparar()
        this.watchBtnEstornar()
        this.watchBtnFinalizar()
    },
    getState(sPositionDepth = null) {

        if (sPositionDepth)
            return ObjectUtil.getDepth(Separacao.state, sPositionDepth)

        return Separacao.state
    },
    setState(sProperty, uVal) {
        return Separacao.state[sProperty] = uVal
    },
    setFirstPicking: async function() {        
        this.setEnderecoToPick(null, 0)
    },
    watchInputQtde: function() {
        ManageFrontend.getInputQtde().keyup(function() {
            Separacao.setState('qtde_separada', Utils.parseFloat($(this).val()))
        })
    },
    watchOnClickBtnEnderecoBarcode: function() {
        var prepareInput = async function() {
            ManageFrontend.getInputEndereco().removeClass('exibindo-composicao')
            ManageFrontend.getInputEndereco().val(null)
            ManageFrontend.getInputEndereco().prop('readonly', false)
            setTimeout(() => Utils.focusOnElem('.endereco-digitado'), 500)
        }

        ManageFrontend.getBtnBarcode().click(async function() {

            if (ManageFrontend.getInputEndereco().prop('readonly')) {
                await Utils.swalConfirmOrCancel({
                    title: 'Deseja ler outro endereço?',
                    confirmButtonText: 'Sim, ler outro',
                    showConfirmButton: true,
                    showCancelButton: true
                }, prepareInput)
            }else {
                prepareInput()
            }

        })
    },
    watchOnClickBtnProdutoBarcode: function() {
        var prepareInput = async function() {
            ManageFrontend.getInputProduto().val(null)
            ManageFrontend.getInputProduto().prop('readonly', false)
            setTimeout(() => Utils.focusOnElem('.produto-digitado'), 300)
        }

        ManageFrontend.getBtnProdutoBarcode().click(async function() {

            if (ManageFrontend.getInputProduto().prop('readonly')) {
                await Utils.swalConfirmOrCancel({
                    title: 'Deseja ler outro produto?',
                    confirmButtonText: 'Sim, ler outro',
                    showConfirmButton: true,
                    showCancelButton: true
                }, prepareInput)
            }else {
                prepareInput()
            }

        })
    },
    watchOnClickBtnProdutoSerieBarcode: function() {
        var prepareInput = async function() {
            ManageFrontend.getInputProdutoSerie().val(null)
            ManageFrontend.getInputProdutoSerie().prop('readonly', false)
            setTimeout(() => Utils.focusOnElem('.produto-serie-digitado'), 500)
        }

        ManageFrontend.getBtnProdutoSerieBarcode().click(async function() {

            if (ManageFrontend.getInputProdutoSerie().prop('readonly')) {
                await Utils.swalConfirmOrCancel({
                    title: 'Deseja ler outra Série?',
                    confirmButtonText: 'Sim, ler outra',
                    showConfirmButton: true,
                    showCancelButton: true
                }, prepareInput)
            }else {
                prepareInput()
            }

        })
    },
    watchOnFocusoutProduto: function () {
        ManageFrontend.getInputProduto().focusout(function() {

            if ($(this).val() && $(this).val() != Separacao.getState().separacao_carga_item.produto.codigo_barras) {
                Utils.swalUtil({
                    title: 'Produto bipado diverge!',
                    type: 'warning',
                    timer: 3000
                })
                
                ManageFrontend.getInputProduto().val(null)
                ManageFrontend.getInputProduto().prop('readonly', false)
            }
        })
    },
    watchOnFocusoutProdutoSerie: function () {
        ManageFrontend.getInputProdutoSerie().focusout(function() {

            if ($(this).val() && $(this).val() != Separacao.getState().separacao_carga_item.serie) {
                Utils.swalUtil({
                    title: 'Série bipada diverge!',
                    type: 'warning',
                    timer: 3000
                })
                
                ManageFrontend.getInputProdutoSerie().val(null)
                ManageFrontend.getInputProdutoSerie().prop('readonly', false)
            }
        })
    },
    watchOnClickSKU: function() {
        this.routineSeparar()
        this.routineEstornar()
    },
    routineSeparar: function() {
        ManageFrontend.getItensHabilitaPicking().each(function() {
            if ($(this).hasClass('watched-to-pick'))
                return

            $(this).addClass('watched-to-pick')

            $(this).click(async function() {
                var sEnderecoComposicao = $(this).attr('endereco-composicao')
                
                ManageFrontend.showBackgroudLoading()
                ManageFrontend.cleanInputs()
                Loader.showLoad()
                Loader.hideLoad(100)
                ManageFrontend.hideBackgroudLoading(null, 1600)
    
                await Utils.waitMoment(1000)
                
                Separacao.setEnderecoToPick(sEnderecoComposicao)
            })
        })
    },
    routineEstornar: function() {
        ManageFrontend.getItensHabilitaEstorno().each(function() {
            if ($(this).hasClass('watched-to-estorno'))
                return

            $(this).addClass('watched-to-estorno')

            $(this).click(async function() {
                var sEnderecoComposicao = $(this).attr('endereco-composicao')
                
                ManageFrontend.showBackgroudLoading()
                ManageFrontend.cleanInputs()
                Loader.showLoad()
                Loader.hideLoad(100)
                ManageFrontend.hideBackgroudLoading(null, 1600)
    
                await Utils.waitMoment(1000)
                
                Separacao.setEnderecoToEstorno(sEnderecoComposicao)
            })
        })
    },
    setEnderecoToEstorno: async function(sEnderecoComposicao) {
        var aDadosEndereco = ManageRoutineData.getDadosEnderecoEstorno(sEnderecoComposicao)
        var sChaveEnderecoComposicao = sEnderecoComposicao
        
        if (!ObjectUtil.isset(aDadosEndereco))
            return

        this.setState('separacao_carga_item', aDadosEndereco.separacao_carga_item)

        await ManageFrontend.setValuesPicking(aDadosEndereco, 'estorno')
        
        this.setState('chave_endereco_composicao',  sChaveEnderecoComposicao)
        this.setState('dados_endereco_picking',     aDadosEndereco)
        this.setState('qtde_separada',              ManageRoutineData.getQtdeSeparada(aDadosEndereco))
        this.setState('endereco_separado',          ManageRoutineData.getEnderecoSeparado(aDadosEndereco))
    },
    setEnderecoToPick: async function(sEnderecoComposicao, iPosition = null) {
        var aDadosEndereco = ManageRoutineData.getDadosEndereco(sEnderecoComposicao, iPosition)
        var sChaveEnderecoComposicao = ManageRoutineData.getChaveEnderecoComposicao(sEnderecoComposicao, iPosition)
        
        if (!ObjectUtil.isset(aDadosEndereco)) {
            BackgroundLoading.hide(null, 300, true)
            return ManageFrontend.getBtnListaPicking().click() 
        }
            
        this.setState('separacao_carga_item',       aDadosEndereco.separacao_carga_item)
        this.setState('qtde_separada', null)

        await ManageFrontend.setValuesPicking(aDadosEndereco, 'picking')

        this.setState('chave_endereco_composicao',  sChaveEnderecoComposicao)
        this.setState('dados_endereco_picking',     aDadosEndereco)

        if (!this.getState('qtde_separada'))
            this.setState('qtde_separada', ManageRoutineData.getQtdeSeparada(aDadosEndereco))

        this.setState('endereco_separado', ManageRoutineData.getEnderecoSeparado(aDadosEndereco))

        var oState = this.getState()

        if (!aParams.leitura_endereco) {
            this.setState('endereco_separado', oState.dados_endereco_picking.localizacao.endereco)
        }

        console.log(this.getState())
    },
    /**
     * Fara o ajax para obter a composicao de um endereco 
     * Obtido pelo ID do endereco contido no codigo de barras
     */
    watchInputEndereco: function() {
        ManageFrontend.getInputEndereco().keyup(async function() {

            //remove letras
            $(this).val( $(this).val().replace(/[^0-9]/, '') )

            // Se estiver exibindo uma composicao ou está aguardando retorno não faz o ajax
            if (ManageFrontend.getInputEndereco().hasClass('exibindo-composicao') || Separacao.doingAjax)
                return

            await Utils.waitMoment(500)

            var sBarcode = $(this).val()
            
            if (sBarcode.length == 11){
                var iEnderecoID = parseInt(sBarcode)
                
                ManageFrontend.getInputEndereco().prop('readonly', true)
                ManageFrontend.getInputEndereco().focusout()
                
                Separacao.doingAjax = true

                var oRetorno = await EnderecoUtil.getComposicao(iEnderecoID)

                Separacao.doingAjax = false

                Separacao.setState('endereco_separado', oRetorno.endereco)

                ManageFrontend.getInputEndereco().prop('readonly', false)
                ManageFrontend.setComposicaoEndereco(oRetorno.composicao)
            }
        })
    },
    watchBtnSeparar: function() {
        ManageFrontend.getBtnSeparar().click(async function() {
            ManageFrontend.disableActionButtons()
            
            var oValidacao = await ManageRoutineData.valida('separacao'),
                sEnderecoComposicao = ''
            
            if (oValidacao.status !== 100)
                return

            var oResponse = await $.fn.doAjax({
                url: 'ordens-servico-pendentes/operacao-separacao/' + aDadosOperacao.ordem_servico_id + '/separar',
                type: 'POST',
                data: {
                    state: Separacao.getState()
                }
            })

            var oOrdemServicoItemSeparacao = oResponse.dataExtra.ordem_servico_item_separacao

            if (oResponse.status !== 200 || typeof oOrdemServicoItemSeparacao === 'undefined')
                return await Utils.swalResponseUtil(oResponse)
            
            await Utils.swalResponseUtil(oResponse)

            sEnderecoComposicao = ObjectUtil.getDepth(oOrdemServicoItemSeparacao, 'endereco_composicao')
            Separacao.state.dados_endereco_picking.ordem_servico_item_separacao = oOrdemServicoItemSeparacao

            await ManageFrontend.setItemSeparado()
            Separacao.watchOnClickSKU()
            
            await Separacao.setEnderecoToPick(null, 0)
            //await Separacao.setEnderecoToEstorno(sEnderecoComposicao)
        })
    },
    watchBtnEstornar: function() {
        ManageFrontend.getBtnEstornar().click(async function() {
            ManageFrontend.disableActionButtons()

            var sEnderecoComposicao = '',
                oResponse = null,
                oValidacao = await ManageRoutineData.valida('estorno')
            
            if (oValidacao.status !== 100)
                return

            oResponse = await $.fn.doAjax({
                url: 'ordens-servico-pendentes/operacao-separacao/' + aDadosOperacao.ordem_servico_id + '/estornar',
                type: 'POST',
                data: {
                    state: Separacao.getState()
                }
            })

            if (oResponse.status !== 200)
                return await Utils.swalResponseUtil(oResponse)

            sEnderecoComposicao = Separacao.getState('chave_endereco_composicao')

            await ManageFrontend.setItemEstornado(oResponse)
            Separacao.watchOnClickSKU()
            await Separacao.setEnderecoToPick(sEnderecoComposicao)
        })
    },
    watchBtnFinalizar: function() {
        ManageFrontend.getBtnFinalizar().click(async function() {
            var oValidacao = await ManageRoutineData.valida('finalizacao')
            
            if (oValidacao.status !== 100)
                return

            Loader.showLoad()

            window.location.href = url + controller + '/posicionar-separacao/' + ManageFrontend.getOrdemServicoID()   
        })
    }
}

export { ManageFrontend, ManageRoutineData, Separacao }