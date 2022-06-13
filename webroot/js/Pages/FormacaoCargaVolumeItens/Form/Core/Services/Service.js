import { View } from './../Views/View.js'

export const Service = {
    state: {
        form_url: null
    },

    init: function() {
        this.state.form_url = View.getForm().attr('action')
    },
    getItemProdutoData: function(oItem) {
        return {
            id:             oItem.attr('data-os-item-separacao-id'),
            qtde:           parseFloat(oItem.attr('data-os-item-separacao-qtde')),
            qtde_utilizada: parseFloat(oItem.attr('data-os-item-separacao-qtde-utilizada')),
            descricao:      oItem.attr('data-os-item-produto-descricao'),
        }
    },
    setLevelsValidacoes: function(iLevels) {
        var aValidations = new Array()

        for (var i = 0; i < iLevels; i++) 
            aValidations[i] = new Array()

        return aValidations
    },
    valida: async function(sTipo) {
        var aValidationsLevels = null

        if (sTipo == 'submit')
            aValidationsLevels = await this.validaSubmit()
        
        return await View.manageValidate(aValidationsLevels)
    },
    validaSubmit: async function() {
        var aValidations = this.setLevelsValidacoes(2)
            
        if (!View.getInputOSItemID().val())
            aValidations[0].push({
                message: 'Você deve primeiro selecionar algum Pedido/Produto!',
                status: 400,
                libera: false
            })
            
        if (Utils.parseFloat(View.getInputProdutoQuantidade().val()) > parseFloat(View.getInputProdutoQuantidadeDisponivel().val()))
            aValidations[0].push({
                message: 'Você não pode ultrapassar a quantidade disponível!',
                status: 400,
                libera: false
            })

        aValidations[1].push({
            message: 'OK',
            status: 200
        })

        return aValidations
    },
}