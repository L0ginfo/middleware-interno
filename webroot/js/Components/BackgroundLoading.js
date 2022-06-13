var BackgroundLoading = {
    hide: async function(fAction, iTiming = 1000, bShowBlank = false) {

        return await $.fn.executeFirst(function(resolve) {

            setTimeout(async function() {
                await fAction ? fAction() : null
                
                if (!bShowBlank)
                    $('.lf-content-background-loading').hide()
                
                $('.lf-content-background-loading').addClass('show-blank')

                return resolve()
            }, iTiming)

        })

    },
    show: function() {
        $('.lf-content-background-loading').removeClass('show-blank')
        $('.lf-content-background-loading').show()
    }
}