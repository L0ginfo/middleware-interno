var ButtonActions = {

    init: function() {
        this.manageCallActions()
    },
    getSelectedValues: function() {
        var aValues = new Array()
        $('.select-all-child:checked').each(function() {
            aValues.push($(this).val())
        })
        return aValues
    },
    getPedidosSelected: function() {
        return $('.select-all-child:checked')
    },
    temDivergencia: function() {
        var aDivergencias = new Array()

        $('.select-all-child:checked').each(function() {
            var aListagemProdutosFaltantes = JSON.parse($(this).closest('tr').find('.listagem-produtos-faltantes').html())
            var aSize = Object.keys(aListagemProdutosFaltantes)

            if (aSize.length) {
                aDivergencias.push(aListagemProdutosFaltantes)
            }
        })

        if (aDivergencias.length)
            return true

        return false
    },
    manageCallActions: function() {
        $('.select-all-action-btn').click(function() {
            var sAction = $(this).attr('data-action')
            
            if (sAction == 'gerar-os' ) {

                var sMessageWarning = '';

                if (ButtonActions.temDivergencia()) {
                    sMessageWarning = 'Há estoques faltantes em algum pedido!'
                }else if (ButtonActions.getPedidosSelected().size() > 1 && !iPermiteMultipicking) {
                    sMessageWarning = 'Favor selecionar um pedido por vez!'
                }
 
                if (sMessageWarning) {
                    Utils.swalUtil({
                        type: 'warning',
                        title: sMessageWarning,
                        allowOutsideClick: true
                    })

                    return;
                }
            }
            
            if (sAction == 'definir-operador')
                ButtonActions.goDefinirOperador()
            else
                ButtonActions.doAction(sAction)
        })
    },
    
    goDefinirOperador: function() {
        var sFullUrl = url + 'separacao-cargas/definir-operador',
            aParams = new Array,
            aSelectedSeparacoes = this.getSelectedValues()

        for (i in aSelectedSeparacoes)
            aParams.push({'separacao_cargas[]': aSelectedSeparacoes[i]}) 
          
        Utils.doPost(sFullUrl, aParams)
    },

    doAction: async function(sAction) {
        var aSelectedSeparacoes = this.getSelectedValues()
        
        var oResponse = await $.fn.doAjax({
            url: 'separacao-cargas/manage-page-actions',
            type: 'POST',
            data: {
                aSelectedSeparacoes: aSelectedSeparacoes,
                sAction: sAction
            }
        })

        if (oResponse.status == 200){
            Swal.fire({
                title: oResponse.message,
                type: 'success',
                showConfirmButton: false,
                timer: 3000 
            }).then(function () {
                if (oResponse.dataExtra.refresh == true)
                    location.reload()
            })
        }else if (oResponse.status == 404){

            var sMessage = '<div style="text-align: left">' 
            sMessage += ButtonActions.getMessageEstoqueFaltante(oResponse)
            sMessage += '</div>' 

            oResponse.message = sMessage
            
            Utils.swalResponseUtil(oResponse)
        }else {
            Swal.fire({
                type: 'warning',
                title: oResponse.message
            })
        }
        
        //console.log(oResponse)
    },
    getMessageEstoqueFaltante: function(oResponse) {
        var aMessage = []
        var aProdutoRequisicoes = oResponse.dataExtra.produto_requisicoes

        if (!aProdutoRequisicoes)
            return ''

        for (const sKey in aProdutoRequisicoes) {
            var oProdutoRequisicao = aProdutoRequisicoes[sKey]
            var sColor = oProdutoRequisicao.produto_disponivel < 0 ? 'red' : '#0be66d'

            aMessage.push('<div style="border: 3px dashed '+sColor+'; padding: 10px 15px; margin-bottom: 10px;">')

            aMessage.push('<div><b>Produto</b>: ' + '<b>' + oProdutoRequisicao.produto_codigo + '</b> - ' + oProdutoRequisicao.produto_descricao + ' (<b>'+oProdutoRequisicao.produto_unidade_medida+')</b></div>')
            aMessage.push('<div><b>Requer</b>: ' + Utils.showFormatFloat(oProdutoRequisicao.produto_requer) + '</div>')
            aMessage.push('<div><b>Estoque</b>: ' + Utils.showFormatFloat(oProdutoRequisicao.produto_estoque) + '</div>')
            aMessage.push('<div><b>Pré Reserva</b>: ' + Utils.showFormatFloat(oProdutoRequisicao.produto_pre_reservado) + '</div>')
            aMessage.push('<div><b>Já Reservado</b>: ' + Utils.showFormatFloat(oProdutoRequisicao.produto_reservado) + '</div>')

            if (oProdutoRequisicao.produto_disponivel < 0)
                aMessage.push('<div><b>Qtde Faltante</b>: ' + Utils.showFormatFloat(oProdutoRequisicao.produto_disponivel * -1) + ' ('+oProdutoRequisicao.produto_unidade_medida+')</div>')

            var aSeparacaoOrdens = []

            if (oProdutoRequisicao.separacao_cargas_reservada) {
                for (const sKeySeparacaoOrdens in oProdutoRequisicao.separacao_cargas_reservada) {
                    var oSeparacaoOrdem = oProdutoRequisicao.separacao_cargas_reservada[sKeySeparacaoOrdens]

                    aSeparacaoOrdens.push(oSeparacaoOrdem.separacao_carga_numero + ' (#<b>'+oSeparacaoOrdem.separacao_carga_ordem_servico+'</b>)' )
                }
            }

            if (oProdutoRequisicao.produto_disponivel < 0 && aSeparacaoOrdens.length) {
                aMessage.push("<div><b>Pedidos e OS's</b>: " + aSeparacaoOrdens.join(', ') + '</div>')
            }

            aMessage.push('</div>')
        }

        return aMessage.join("")
    }
}



$(document).ready(function() {

    Utils.MultipleChecksAction.init({
        sBtnAction  : 'select-all-action-btn',
        sCheckAll   : 'select-all-inputs',
        sCheckChild : 'select-all-child',
        sClassToHide: 'lf-opacity-medium',
        sClassToShow: 'lf-opacity-full',
        iQtdToShow  : 1,
        processNow  : true
    })

    ButtonActions.init()
})