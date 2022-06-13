window.InputCodebar = {
    show: function() {
        $('.lf-leitor-codigo-barras').removeClass('hidden')
        
        $('.lf-leitor-codigo-barras .lf-input-codebar').attr('inputmode', 'none')
        $('.lf-leitor-codigo-barras .lf-input-codebar').val(null)

        oHooks.watchDoubleClick('.lf-leitor-codigo-barras .lf-input-codebar', () => { 
            $('.lf-leitor-codigo-barras .lf-input-codebar').attr('inputmode', 'decimal') 
        })

        setTimeout(function() {
            $('.lf-leitor-codigo-barras .lf-input-codebar').focus()
        }, 500)
    },
    
    hide: function() {
        $('.lf-leitor-codigo-barras').addClass('hidden')
    },

    listenCodebar: async function(iCount) {

        $('.lf-leitor-codigo-barras .shadow-background').click(function() {
            window.InputCodebar.hide()
        })

        return await $.fn.executeFirst(async function(resolve) {
            window.InputCodebar.show()
            return await window.InputCodebar.getCodebar(resolve, iCount)
        })
    },

    getCodebar: async function(resolve, iCount) {
        return await $('.lf-leitor-codigo-barras .lf-input-codebar').keyup(function(event) {
            if (event.keyCode === 13) {
                var codebar = $(this).val()
                
                window.InputCodebar.hide()

                $('html').trigger('lf-input-codebar-listened-'+iCount, [codebar, iCount])

                return resolve(codebar)
            }
        })
    }


}