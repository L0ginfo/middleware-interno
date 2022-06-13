var setTimerSelectProdutoId = null;

var ControleEspecificos = {

    init: async function () {

        this.observers()
        ControleEspecificos.watchSelectpickerControleEspecificos()
        ControleEspecificos.watchSelectpickerDocMercItemControleEspecificos()
        ControleEspecificos.watchSelectProdutoId()

    },

    observers: function() {

        oSubject.setObserverOnEvent(async function () {

            var oReturn = await Services.updateProdutoControleEspecificos(oState.getState('selected'))

            if (oReturn.status != 200) {
                Swal.fire({
                    type: 'warning',
                    title: oReturn.message
                })
            }

        }, ['on_selected_change'])

        oSubject.setObserverOnEvent(async function () {

            var oReturn = await Services.saveOrDeleteInDocMercadoriaItem(oState.getState('selected_mercadoria_item'))

            if (oReturn.status != 200) {
                Swal.fire({
                    type: 'warning',
                    title: oReturn.message
                })
            }

        }, ['on_selected_mercadoria_item_change'])

        oSubject.setObserverOnEvent(async function () {

            var $this = $(oState.getState('change_produto').this)

            var oStateChangeProduto = {
                produto_id: oState.getState('change_produto').produto_id,
                doc_merc_id: oState.getState('change_produto').doc_merc_id,
                unidade_id: oState.getState('change_produto').unidade_id,
            }

            var oReturn = await Services.getDocMercItensControleEspecificos(oStateChangeProduto)

            if (oReturn.status == 200)
                ControleEspecificos.insertSelectControleEspecificos(oReturn.dataExtra, $this)
            

        }, ['on_change_produto_change'])

    },

    watchSelectpickerControleEspecificos: function() {

        $(".watch_controle_especificos:not(.watched)").on("changed.bs.select", function(e, iClickedIndex, bSelected) {

            $(this).addClass('watched')

            var iControleEspecificoID = $(this).find('option').eq(iClickedIndex).val()
            var iProdutoID            = $(this).closest('.global_div_form').find('.get_produto_id').val()

            oState.setState('selected', {
                controle_especifico_id: iControleEspecificoID,
                produto_id: iProdutoID,
                selected: bSelected
            })

         });

    },

    watchSelectpickerDocMercItemControleEspecificos: function() {

        $(".select_controle_especificos:not(.watched)").on("changed.bs.select", function(e, iClickedIndex, bSelected) {

            $(this).addClass('watched')

            var iControleEspecificoID = $(this).closest('.input.select').find('select.select_controle_especificos').find('option').eq(iClickedIndex).attr('value')
            var oDocMercItemID        = $(this).closest('.item-mercadoria').find('.container-checkbox').val()

            oState.setState('selected_mercadoria_item', {
                controle_especifico_id: iControleEspecificoID,
                item_id: oDocMercItemID,
                selected: bSelected
            })

        })

    },

    watchSelectProdutoId: function() {

        $('html').on('hook-watch-changes', function(e, elem) {

            //if(setTimerUpdateHeigth) clearTimeout(setTimerSelectProdutoId);
            
            setTimerSelectProdutoId = setTimeout(function () {

                var iProdutoID    = $(elem).val()
                var iDocMercID    = $(elem).closest('.full-item-owl').find('.documento_mercadoria_id').val()
                var iUnidadeIndex = $(elem).closest('.full-item-owl').find('select.unidade_medida_id').val()
                var iUnidadeID    = $(elem).closest('.full-item-owl').find('select.unidade_medida_id').find('option').eq(iUnidadeIndex).attr('value')

                
                var oDivControleEspecificos    = $(elem).closest('.full-item-owl').find('.controle_especifico_display')
                var oSelectControleEspecificos = oDivControleEspecificos.find('.param_label_controle_especificos')
                if (!oSelectControleEspecificos.val()) {

                    oSelectControleEspecificos.find('option').remove()
                    oSelectControleEspecificos.selectpicker('refresh')
                    oDivControleEspecificos.hide()

                    if (iProdutoID)
                        oState.setState('change_produto', {
                            produto_id: iProdutoID,
                            doc_merc_id: iDocMercID,
                            unidade_id: iUnidadeID,
                            this: $(elem)
                        })

                } else {
                    oDivControleEspecificos.show()
                }
                
            }, 600)
            
        })

    },

    insertSelectControleEspecificos: function(oDataExtra, $this) {

        var oDivControleEspecificos    = $this.closest('.full-item-owl').find('.controle_especifico_display')
        var oSelectControleEspecificos = oDivControleEspecificos.find('select.param_label_controle_especificos')

        oSelectControleEspecificos.find('option').remove()

        $.each(oDataExtra, function(iID, sDescricao) {

            oSelectControleEspecificos.append($('<option>', { 
                value: parseInt(iID),
                text : String(sDescricao),
            }))

        })

        oSelectControleEspecificos.selectpicker('refresh')
        oDivControleEspecificos.show()

    }


}