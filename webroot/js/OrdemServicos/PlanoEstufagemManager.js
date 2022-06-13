var OvarContainersManager = {

    init: function () {

        OvarContainersManager.watchClickImgContainer()
        OvarContainersManager.watchClickTextPesquisarLotes()
        OvarContainersManager.watchClickBtnPesquisaLotes()
        OvarContainersManager.watchClickBtnDeleteContainer()
        
    },

    watchClickImgContainer: function () {

        $('.click_image').click( function () {

            var oAllImg   = $(this).closest('.div_ovar').find('.img_clicked')
            var aClickeds = []
            oAllImg.each( function () {
                if ($(this).hasClass('clicked')) 
                    aClickeds.push($(this).prop('id'))
            })

            if (aClickeds.length > 0) {
                if (!$(this).hasClass('clicked'))
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Só é permitido selecionar um container por vez!',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 3000 
                    })
                
                $(this).removeClass('clicked')
                $(this).addClass('img-black-white')
                return
            } 

            $(this).addClass('clicked')
            $(this).removeClass('img-black-white')
    
        })
    
    },

    watchClickTextPesquisarLotes: function () {

        $('.click_text').click( function () {
    
            $(this).closest('.container').find('.click_image').click()
   
        })

    },

    watchClickBtnPesquisaLotes: function () {

        $('.button_pesquisa_lotes').click( function () {

            var oDivDescarga = $(this).closest('.div_ovar')
            var oAllImg      = oDivDescarga.find('.img_clicked')
            var aContainerId = []
            oAllImg.each( function () {
                if ($(this).hasClass('clicked')) 
                    aContainerId.push($(this).prop('id'))
            })

            if (!aContainerId.length) {
                return Swal.fire({
                    title: 'Atenção!',
                    text: 'Favor selecionar um container!',
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000 
                })
            }
            
            var oContainerId = oDivDescarga.find('.container_find_lotes')
            oContainerId.prop('value', aContainerId[0])

            var oForm = oDivDescarga.find('.form_find_lotes')
            oForm.submit()
        })

    },

    watchClickBtnDeleteContainer: function () {

        $('.button_delete_container').click( function () {

            var oDivDescarga = $(this).closest('.div_ovar')
            var oAllImg      = oDivDescarga.find('.img_clicked')
            var aItemID = []
            oAllImg.each( function () {
                if ($(this).hasClass('clicked')) 
                    aItemID.push($(this).attr('data-item-id'))
            })

            if (!aItemID.length) {
                return Swal.fire({
                    title: 'Atenção!',
                    text: 'Favor selecionar um container!',
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000 
                })
            }

            window.location =  url + 'ordem-servicos/delete-lotes-container/' + aItemID[0]
        })

    },

}

$(document).ready(function() {

    OvarContainersManager.init()
    $.fn.numericDouble()

})