jQuery(function ($) {

    $(window).load(function () {
        var sUrlSubmit = $('.gerar-dape').attr('href')
        var newUrl = ''

        setTimeout(function () {
            newUrl = sUrlSubmit + '?beneficiario_id=' + $('#beneficiario-id').val()
            $('.gerar-dape').attr('href', newUrl)
        }, 200)

        $('#beneficiario-id').change(function () {
            newUrl = sUrlSubmit + '?beneficiario_id=' + $(this).val()
            
            $('.gerar-dape').attr('href', newUrl)
        })

    })

})