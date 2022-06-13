aAssocIncrement = (typeof aAssocIncrement === "undefined") ? new Array() : aAssocIncrement

jQuery(function ($) {

    var ServicosAdder = {
        init: function () {

            ServicosAdder.watchAdd()
            ServicosAdder.watchChanges()
        },

        watchAdd: function () {
            $oAddServico = $('.add-servico')
            $oAddServico.removeClass('no-watched')
            $oAddServico.addClass('watched')

            $oAddServico.click(function () {
                var $oServico = $('#servico-id option:selected')

                ServicosAdder.addLine($oServico)
            })
        },

        watchChanges: function () {
            $('.quantidade, .valor_unitario').each(function () {
                $(this).on('change keydown keyup', function () {
                    ServicosAdder.calcValorTotal()
                })
            })
        },

        watchRemove: function () {
            $('.table.servicos .remove-servico').each(function () {
                $(this).click(function () {
                    
                    $(this).closest('tr').remove()

                })
            })
        },

        addLine: async function ($oServico) {
            var sHtml = ServicosAdder.getHtml();
            var $oTabaleServico = await ServicosAdder.getServico($oServico.val());
            var $fValorUnitario = $oTabaleServico ? $oTabaleServico.valor : 0;
            var $fValorMinimo = $oTabaleServico ? $oTabaleServico.valor_minimo : 0;
            var $oHtml = $(sHtml);

            $('.table.servicos tbody').append($oHtml[0].outerHTML);
            $.fn.numericDouble();

            $('.table.servicos tbody tr').last().find('.servico_id').val($oServico.val());
            $('.table.servicos tbody tr').last().find('.descricao').val($oServico.html())
            $('.table.servicos tbody tr').last().find('.valor_unitario').val($fValorUnitario);
            $('.table.servicos tbody tr').last().find('.valor_minimo').val($fValorMinimo);
        
            ServicosAdder.calcValorTotal()
            ServicosAdder.watchChanges()
            ServicosAdder.watchRemove()
        },

        calcValorTotal: function () {
            $('.table.servicos tbody tr').each(function () {
                var valor_unitario = Utils.parseFloat($(this).find('.valor_unitario').val());
                var valor_minimo = Utils.parseFloat($(this).find('.valor_minimo').val());
                var qtd =  Utils.parseFloat($(this).find('.quantidade').val());
                var total = valor_unitario * qtd;
                total = valor_minimo > total ? valor_minimo : total;
                total =  Utils.showFormatFloat(total);
                total = total != 'NaN' ? total : '0';
                $(this).find('.valor_total').val( total );
            })
        },

        getValorServico: async function (iServicoID) {
            var iValor = 0,
                oAjaxReturn = await $.fn.doAjax({
                    url: 'tabelas-precos/get-valor-servico-by-id',
                    data: {
                        servico_id: iServicoID,
                        tabela_preco_id: ServicosAdder.getTabelaPreco().val()
                    },
                    type: 'POST'
                })

            if (typeof oAjaxReturn.dataExtra.valor != 'undefined') {
                iValor = (oAjaxReturn.dataExtra.valor)
            }

            return iValor
        },

        getServico: async function (iServicoID) {
            var servico = null;

            oAjaxReturn = await $.fn.doAjax({
                url: 'tabelas-precos/get-servico-by-id',
                data: {
                    servico_id: iServicoID,
                    tabela_preco_id: ServicosAdder.getTabelaPreco().val()
                },
                type: 'POST'
            });

            if (typeof oAjaxReturn.dataExtra.servico != 'undefined') {
                servico = oAjaxReturn.dataExtra.servico;
            }

            return servico;
        },

        getTabelaPreco: function () {
            return $('#tabela-preco-id')
        },

        getHtml: function () {
            var sHtmlNonFormated = $('.copy-hidden.servicos').html(),
                sHtmlFormated = ServicosAdder.formatHtml(sHtmlNonFormated)

            return sHtmlFormated
        },

        formatHtml: function (sHtmlNonFormated) {
            var iLastAssoc,
                sToReplaceIncrement = '__servico_increment__'
        
            //faz a verificacao e gravacao das associacoes entre cada linha de servicos
            if (aAssocIncrement.length){
                iLastAssoc = aAssocIncrement[ aAssocIncrement.length - 1 ] + 1
            }else {
                iLastAssoc = 1
                aAssocIncrement.push(iLastAssoc)
            }

            sHtmlNonFormated = sHtmlNonFormated.replace(new RegExp(sToReplaceIncrement, 'g'), iLastAssoc)
            sHtmlNonFormated = sHtmlNonFormated.replace(new RegExp('tr_copy', 'g'), 'tr')
            sHtmlNonFormated = sHtmlNonFormated.replace(new RegExp('td_copy', 'g'), 'td')

            return sHtmlNonFormated;
        }
    }

    $(document).ready(function () {
        ServicosAdder.init()
    })
})