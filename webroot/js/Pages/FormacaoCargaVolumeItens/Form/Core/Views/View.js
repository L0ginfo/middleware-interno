export const View = {
    init: async function() {

    },
    getForm: function() {
        return $('form.formacao-carga-volume-itens')
    },
    getSeparacaoCargaAtivaID: function() {
        return $('.separacao_carga.active').attr('data-separacao-id')
    },
    getSeparacaoCargas: function() {
        return $('.separacao_cargas .separacao_carga')
    },
    getItens: function() {
        return $('.separacao_carga_itens .separacao_carga_item')
    },
    getInputOSItemID: function() {
        return $('.os-item-id')
    },
    getInputProdutoDescricao: function() {
        return $('.produto-descricao')
    },
    getInputProdutoQuantidade: function() {
        return $('.produto-quantidade')
    },
    getInputProdutoQuantidadeDisponivel: function() {
        return $('.qtde-disponivel')
    },
    getBtnItemAdd: function() {
        return this.getItens().find('.item-add')
    },
    hideItens: function() {
        const aItens = this.getItens()
        aItens.addClass('hidden')
    },
    showItensByID: function(iSeparacaoCargaID) {
        const aItensSeparacao = $('.separacao_carga_itens .separacao_carga_item.item-separacao-id-'+iSeparacaoCargaID)
        aItensSeparacao.removeClass('hidden')
    },
    clearInputs: function() {
        this.getInputProdutoDescricao().val()
        this.getInputProdutoQuantidade().val()
        this.getInputProdutoQuantidadeDisponivel().val()
    },
    setProdutoData: function(oData) {
        this.getInputOSItemID().val(oData.id)
        this.getInputProdutoDescricao().val(oData.descricao)
        this.getInputProdutoQuantidade().val(Utils.showFormatFloat(oData.qtde - oData.qtde_utilizada))
        this.getInputProdutoQuantidadeDisponivel().val( (oData.qtde - oData.qtde_utilizada).toFixed(2)  )
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
}