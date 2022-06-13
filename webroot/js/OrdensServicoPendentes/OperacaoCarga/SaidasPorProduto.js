const SaidasPorProdutos = {
    enderecos: {},
    init: async function() {

        this.watchBtnCarregar()
        this.watchBtnEstornar()
        this.watchClickEnderecos()
        
        await Utils.waitMoment(800)

        this.manageEnderecos()

        await Utils.waitMoment(1200)

        Saidas.loadProdutosCarregados()

    },
    /**
     * Watchers
     */
    manageEnderecos: function() {
        var $oSaidaFisica = $('.saidas-fisicas.watched.active')
        var $oEnderecoOperacao = $oSaidaFisica.find('.endereco-operacao')

        $oEnderecoOperacao.find('option').each(function() {
            var sComposicaoEndereco = $(this).val()
            var sComposicaoEnderecoText = $(this).text()

            if (!sComposicaoEndereco)
                return;

            $(this).remove()

            SaidasPorProdutos.enderecos[sComposicaoEndereco] = sComposicaoEnderecoText
        })

        $oSaidaFisica.find('.produto-carregar').change(function() {
            var sComposicaoProduto = $(this).val()
            var aComposicaoProduto = sComposicaoProduto.split('_')
            sComposicaoProduto = aComposicaoProduto[0] + '_' + aComposicaoProduto[1]

            $oEnderecoOperacao.val(null)
            $oEnderecoOperacao.find('option:not([value=""])').remove()

            for (const sComposicaoEndereco in SaidasPorProdutos.enderecos) {
                console.log(sComposicaoEndereco, sComposicaoProduto)
                if (sComposicaoProduto && sComposicaoEndereco.indexOf(sComposicaoProduto) > -1) {
                    $oEnderecoOperacao.append('<option value="'+sComposicaoEndereco+'">'+SaidasPorProdutos.enderecos[sComposicaoEndereco]+'</option>')
                }else {
                    $oEnderecoOperacao.find('option[value="'+sComposicaoEndereco+'"]').remove()
                }
            }

        })
    },
    watchClickEnderecos: function() {
        var $oCapaLiberacao = $('.item-carregamento.liberacao');

        $oCapaLiberacao.find('.endereco-agroup .endereco_id').each(function () {
            $(this).removeClass('no-watched')
            $(this).addClass('watched')

            $(this).click(async function (e) {
                var iEnderecoID = $(this).val()
                var $oSaidaFisica = $('.saidas-fisicas.watched.active')
                $oSaidaFisica.find('.endereco-operacao').val(iEnderecoID)
                $oSaidaFisica.find('.endereco-operacao').change()
            })
        })
        
    },
    watchBtnCarregar: function() {
        var $oSaidasFisica = $('.saidas-fisicas'); 

        $oSaidasFisica.find('.salvar-carregamento.por-produtos.no-watched').each(function () {
            $(this).removeClass('no-watched')
            $(this).addClass('watched')

            $(this).click(async function (e) {
                SaidasPorProdutos.doCarregar()
            })
        })
    },
    watchBtnEstornar: function() {
        var $oSaidasFisica = $('.saidas-fisicas'); 

        $oSaidasFisica.find('.estornar-carregamento.por-produtos.no-watched').each(function () {
            $(this).removeClass('no-watched')
            $(this).addClass('watched')

            $(this).click(async function (e) {
                SaidasPorProdutos.doEstornar()
            })
        })
    },


    /**
     * Actions
     */
    doCarregar: async function() {
        var $oSaidaFisica = $('.saidas-fisicas.watched.active')
        var dQtde = $oSaidaFisica.find('.quantidade-operacao').val()
        var iEnderecoID = $oSaidaFisica.find('.endereco-operacao').val().split('_')[2]
        var iProdutoID = $oSaidaFisica.find('.produto-carregar').val().split('_')[0]
        var sLoteCodigo = $oSaidaFisica.find('.produto-carregar').val().split('_')[1]
        var iLiberacaoDocumentalItemID = $oSaidaFisica.find('.produto-carregar').val().split('_')[2]
        var iLiberacaoDocID = $oSaidaFisica.find('.quantidade-operacao').attr('data-liberacao-documental-id')
        dQtde = dQtde ? Utils.parseFloat(dQtde) : 0

        if (Utils.manageRequiredCustom($oSaidaFisica) || !dQtde || !iEnderecoID)
            return;

        var oResponse = await $.fn.doAjax({
            url: 'ordens-servico-pendentes/saveSaidaFisica',
            type: 'POST',
            data: {
                qtde: dQtde,
                produto_id: iProdutoID,
                isCarregamentoOuEstorno: 'carregamento',
                sTipoCodebar: 'por-produto',
                iOSID: $('.ordem_servico_id').val(),
                liberacao_documental_id: iLiberacaoDocID,
                lote_codigo: sLoteCodigo,
                endereco_id: iEnderecoID,
                liberacao_documental_item_id: iLiberacaoDocumentalItemID
            }
        })

        Utils.swalResponseUtil(oResponse)
        
        Saidas.manageSaldosSaidas(oResponse, 'desktop', true)
        Saidas.manageSaldosSaidas(oResponse, 'responsive', true)

        $oSaidaFisica.find('.quantidade-operacao').val(null)

        $oSaidaFisica.find('.endereco-operacao').val(null)
        $('.item-carregamento.liberacao input:checked').prop('checked', false)
    },
    doEstornar: async function() {
        var $oSaidaFisica = $('.saidas-fisicas.watched.active')
        var dQtde = $oSaidaFisica.find('.quantidade-operacao').val()
        var iEnderecoID = $oSaidaFisica.find('.endereco-operacao').val().split('_')[2]
        var iProdutoID = $oSaidaFisica.find('.produto-carregar').val().split('_')[0]
        var sLoteCodigo = $oSaidaFisica.find('.produto-carregar').val().split('_')[1]
        var iLiberacaoDocumentalItemID = $oSaidaFisica.find('.produto-carregar').val().split('_')[2]
        var iLiberacaoDocID = $oSaidaFisica.find('.quantidade-operacao').attr('data-liberacao-documental-id')
        dQtde = dQtde ? Utils.parseFloat(dQtde) : 0

        if (Utils.manageRequiredCustom($oSaidaFisica) || !dQtde || !iEnderecoID)
            return;

        var oResponse = await $.fn.doAjax({
            url: 'ordens-servico-pendentes/saveSaidaFisica',
            type: 'POST',
            data: {
                qtde: dQtde,
                produto_id: iProdutoID,
                isCarregamentoOuEstorno: 'estorno',
                sTipoCodebar: 'por-produto',
                iOSID: $('.ordem_servico_id').val(),
                liberacao_documental_id: iLiberacaoDocID,
                lote_codigo: sLoteCodigo,
                endereco_id: iEnderecoID,
                liberacao_documental_item_id: iLiberacaoDocumentalItemID
            }
        })

        Utils.swalResponseUtil(oResponse)
        
        Saidas.manageSaldosSaidas(oResponse, 'desktop', true)
        Saidas.manageSaldosSaidas(oResponse, 'responsive', true)
        
        $oSaidaFisica.find('.quantidade-operacao').val(null)

        $oSaidaFisica.find('.endereco-operacao').val(null)
        $('.item-carregamento.liberacao input:checked').prop('checked', false)
    }
}


$(document).ready(function() {
    SaidasPorProdutos.init()
})