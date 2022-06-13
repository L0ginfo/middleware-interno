/**
 * Modo de uso:
 * 
 * - Chamar na tela o element Component/Balanca/balanca.ctp
 * - Colocar a classe .lf-balancas-get-peso no input no
 *   lugar que deva aparecer o peso quando clicado no botão do element
 */

var BalancasComponent = {
    countdown: {
        max: 35
    },
    timeIntervalRefreshPeso: 2500,
    intervalRefreshPeso: null,
    init: function() {

        this.getBalancasDisponiveis()
        this.watchBtnShotBalancas()
        this.watchBtnReiniciarServicoBalanca()
        this.watchPreviousBalanca()
        this.setPreviousBalanca()
    },
    setPreviousBalanca: function() {
        var sPreviousBalancaCodigo = localStorage.getItem('previous_balanca')

        if (!sPreviousBalancaCodigo || !$('select.lf-balanca option[value="'+sPreviousBalancaCodigo+'"]').size())
            return;

        $('select.lf-balanca').val(sPreviousBalancaCodigo)
    },
    watchPreviousBalanca: function() {
        $('select.lf-balanca').each(function() {
            $(this).change(function() {
                var sBalancaCodigo = $(this).val()
                localStorage.setItem('previous_balanca', sBalancaCodigo)
            })
        })
    },
    getBalancasDisponiveis: async function() {
        if (!$('select.lf-balanca').size())
            return;

        $('select.lf-balanca').val(1)

        if ($('select.lf-balanca option').first())
            $('select.lf-balanca option').first().prop('selected', true)

        $.fn.doAjax({
            url: 'balancas/get-balancas-disponiveis',
            type: 'GET'
        }).then(function (oResponse) {
            var aOptions = oResponse.dataExtra.balancas
            var sHtmlOptions = ''
            
            if (Object.keys(aOptions).length) {

                for (const key in aOptions) {
                    sHtmlOptions += '<option value="'+key+'">'+aOptions[key]+'</option>'
                }

                $('select.lf-balanca option').remove()
            }
            else {
                sHtmlOptions = '<option value="">Não foi possível obter as balanças!</option>'
            }

            $('select.lf-balanca').html(sHtmlOptions)

            setTimeout(function() {
                BalancasComponent.setPreviousBalanca()
            }, 500)
        })

    },
    watchBtnShotBalancas: function() {
        $('.lf-balancas-content .lf-captura-peso:not(.watched)').each(function () {
            $(this).addClass('watched')
            
            $(this).click(async function() {
                var sBalancaCodigo = $(this).closest('.lf-balancas-content').find('select.lf-balanca').val()
                
                var oResponse = await $.fn.doAjax({
                    url: 'balancas/getPesoBalanca',
                    type: 'POST',
                    data: { balanca_codigo: sBalancaCodigo },
                    loadInfinity: true
                })

                $('.lf-balancas-content .lf-captura-peso.watched').first().addClass('btn-success')
                $('.lf-balancas-content .lf-captura-peso.watched').first().removeClass('btn-purple')

                if (!BalancasComponent.intervalRefreshPeso)
                    BalancasComponent.intervalRefreshPeso = setInterval(async function() {
                        var oResponse = await $.ajax({
                            url: url + 'balancas/getPesoBalanca',
                            type: 'POST',
                            data: { balanca_codigo: sBalancaCodigo }
                        })

                        BalancasComponent.setPeso(oResponse, [3])
                    }, BalancasComponent.timeIntervalRefreshPeso);

                BalancasComponent.setPeso(oResponse)
            })
        })
    },
    removeIntervalPesagens: function() {
        
        if (BalancasComponent && BalancasComponent.intervalRefreshPeso) 
            clearInterval(BalancasComponent.intervalRefreshPeso)
            
        $('.lf-balancas-content .lf-captura-peso.watched').first().removeClass('btn-success')
        $('.lf-balancas-content .lf-captura-peso.watched').first().addClass('btn-purple')
    },
    watchBtnReiniciarServicoBalanca: function() {
        $('.lf-balancas-content .lf-reiniciar-servico-balanca:not(.watched)').each(function () {
            $(this).addClass('watched')
            
            $(this).click(async function() {
                var sBalancaCodigo = $(this).closest('.lf-balancas-content').find('select.lf-balanca').val()

                if ($(this).hasClass('lf-opacity-medium') || !sBalancaCodigo)
                    return;

                var bResponse = await Utils.swalConfirmOrCancel({
                    title: 'Tem certeza disso?',
                    text: 'Deseja realmente reiniciar a balança selecionada?',
                    showConfirmButton: true,
                    showCancelButton: true
                })

                if (!bResponse)
                    return;
                    
                BalancasComponent.removeIntervalPesagens()
                
                var oResponse = await $.fn.doAjax({
                    url: 'balancas/reiniciar-servico-balanca',
                    type: 'POST',
                    data: { balanca_codigo: sBalancaCodigo },
                    loadInfinity: true
                })

                Utils.swalUtil({
                    title: 'Aguarde '+BalancasComponent.countdown.max+' segundos!',
                    timer: 2000
                })

                BalancasComponent.setCountdown($(this))
            })
        })
    },
    setCountdown: function($oScope) {
        var sHtml = '<span class="lf-countdown"> <span class="value">'+this.countdown.max+'</span>s</span>'
        var now = this.countdown.max
        
        $oScope.addClass('lf-opacity-medium')
        $oScope.append(sHtml)

        var fInterval = setInterval(function() {
            now -= 1
            $oScope.find('.lf-countdown .value').html( now )
        }, 1000)

        setTimeout(function() {
            $oScope.removeClass('lf-opacity-medium')
            $oScope.find('.lf-countdown').remove()
            clearInterval(fInterval)
            BalancasComponent.getBalancasDisponiveis()

        }, this.countdown.max * 1000)
    },
    setPeso: function(oResponse, aNaoAplicarParaPesagemTipos = []) {
        $('.lf-balancas-get-peso').each(function() {
            var iPesagemTipoID = $(this).closest('.dados-pesagem').find('.input-tipo').val()
            
            if (aNaoAplicarParaPesagemTipos.length && aNaoAplicarParaPesagemTipos.includes(parseInt(iPesagemTipoID))) {
                return;
            }

            $(this).val( Utils.showFormatFloat(oResponse.dataExtra.peso, 2) )
        }) 
    }
}

$(document).ready(function() {
    BalancasComponent.init()
})