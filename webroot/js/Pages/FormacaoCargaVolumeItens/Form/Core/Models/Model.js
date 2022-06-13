import { View } from './../Views/View.js'
import { Service } from './../Services/Service.js'

export const Model = {
    init: function() {
        View.init()
        Service.init()
        
        this.watchClickPedidos()
        this.watchClickItens()
        this.watchClickSubmit()
    },
    watchClickPedidos: function() {
        View.getSeparacaoCargas().each(function() {
            $(this).click(function() {
                const iSeparacaoCargaID = $(this).attr('data-separacao-id')

                View.getSeparacaoCargas().removeClass('active')
                $(this).addClass('active')
                
                View.hideItens()
                View.clearInputs()
                
                if (!ObjectUtil.isset(iSeparacaoCargaID) || !$(this).hasClass('active'))
                    return

                View.showItensByID(iSeparacaoCargaID)
            })
        })
    },
    watchClickItens: function() {
        View.getBtnItemAdd().each(function() {
            $(this).click(function() {
                const oData = Service.getItemProdutoData($(this))
                
                View.setProdutoData(oData)
            })
        })
    },
    watchClickSubmit: function() {
        $('.submit').click(async function() {
            var $oBtns = $('.footer .submit')

            $oBtns.each(function() {
                $(this).attr('disabled', 'disabled')
            });

            setTimeout(function() {
                $oBtns.each(function() {
                    $(this).removeAttr('disabled')
                });
            }, 3000);

            const oResponse = await Service.valida('submit')
            
            if (oResponse.status != 100)
                return 
            
            Service.state.form_url = window.location.origin + window.location.pathname + '?separacao_id=' + View.getSeparacaoCargaAtivaID()

            if ($(this).hasClass('continuar_adicionando')) {
                Service.state.form_url += '&continuar=1'
            }

            View.getForm().attr('action', Service.state.form_url)
            View.getForm().submit()
        })
    }
}