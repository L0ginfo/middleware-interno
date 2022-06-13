var PlanoOsContainerServico =  {

    init: function () {

        PlanoOsContainerServico.watchClickImgContainer()
        PlanoOsContainerServico.watchClickTextContainer()
        PlanoOsContainerServico.watchClickDeleteContainer()

    },

    watchClickImgContainer: function () {

        $('.click_image').click( function () {

            PlanoOsContainerServico.selectImage($(this))
    
        })
    
    },

    watchClickTextContainer: function () {

        $('.click_text').click( function () {
    
            $(this).closest('.container').find('.click_image').click()
   
        })

    },

    watchClickDeleteContainer: function () {

        $('.button_delete_container').click( function () {

            PlanoOsContainerServico.deleteContainer($(this))
    
        })

    },

    selectImage: function ($this) {

        var oAllImg = $this.closest('.div_global_delete_container').find('.img_clicked')
        var aItemID = []
        oAllImg.each( function () {
            if ($(this).hasClass('clicked')) 
                aItemID.push($(this).prop('id'))
        })

        if (aItemID.length > 0) {
            if (!$this.hasClass('clicked'))
                Swal.fire({
                    title: 'Atenção!',
                    text: 'Só é permitido selecionar um container por vez!',
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000 
                })
            
            $this.removeClass('clicked')
            $this.addClass('img-black-white')
            return
        } 

        $this.addClass('clicked')
        $this.removeClass('img-black-white')

    },

    deleteContainer: function ($this) {

        var oDivGlobalContainer = $this.closest('.div_global_delete_container')
        var oAllImg             = oDivGlobalContainer.find('.img_clicked')
        var aContainerId        = []
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
        
        var oContainerId = oDivGlobalContainer.find('.os_item_id_delete')
        oContainerId.prop('value', aContainerId[0])

        var oForm = oDivGlobalContainer.find('.form_delete_container')
        oForm.submit()

    },
    
}

$(document).ready(function() {

    PlanoOsContainerServico.init()

})
