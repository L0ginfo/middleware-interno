var ExibeEscondeDadosTable = {

    init: function() {

        this.watchButtonExibeEscondeDados()

    },

    watchButtonExibeEscondeDados: function() {

        $('.button_exibe_dados').each(function () {

            $(this).click( function (e) {

                ExibeEscondeDadosTable.verifyExibeEscondeDados($(this))

            })

        })
    
    },

    verifyExibeEscondeDados: function($this) {

        var oClose = $this.find(".glyphicon.glyphicon-eye-close")

        if (oClose.length) {

            oClose.removeClass("glyphicon-eye-close")
            oClose.addClass("glyphicon-eye-open")
            $this.closest('.coluna_hidden').find('.div_hidden').toggleClass('hidden')

        } else {

            var oOpen = $this.find(".glyphicon.glyphicon-eye-open")

            if (oOpen.length) {

                oOpen.removeClass("glyphicon-eye-open")
                oOpen.addClass("glyphicon-eye-close")
                $this.closest('.coluna_hidden').find('.div_hidden').toggleClass('hidden')
                
            }
        }

    }

}

$(document).ready(function() {
    if (!$('.mapas').length)
        ExibeEscondeDadosTable.init()
})