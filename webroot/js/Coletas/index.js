jQuery(function ($) {

    $(window).load(function () {
        var $oBtnMultiplosDL = $('.multiplos-dl')
        $oBtnMultiplosDL.attr('urloriginal', $oBtnMultiplosDL.attr('href') )

        var sSelected = ''
        var aSelected = Array()

        $('.doc_lib_id').change(function () {
            aSelected = Array()
            sSelected = ''

            //passa por todos os selecionados para pegar o id da dl
            $('.doc_lib_id:checked').each(function () {
                aSelected.push( $(this).val() )
            })

            if (aSelected.length > 1) {
                sSelected = aSelected.join(',')
                var sOldHref = $oBtnMultiplosDL.attr('urloriginal')
                var sNewHref = ''

                sNewHref = sOldHref + '/' + sSelected
                $oBtnMultiplosDL.attr('href', sNewHref)   
                $oBtnMultiplosDL.removeClass('hidden')             
            }else {
                $oBtnMultiplosDL.addClass('hidden')             
                $oBtnMultiplosDL.attr('href', $oBtnMultiplosDL.attr('urloriginal') )
            }
            
            console.log(sSelected)

        })

    })


})