var OsContainerServicoManager = {

    init: function () {

        OsContainerServicoManager.watchClickImgContainer()
        OsContainerServicoManager.watchClickTextContainer()
        OsContainerServicoManager.watchButtonAdicionarServico()
        OsContainerServicoManager.watchClickBtnFinalizarOS()
        OsContainerServicoManager.functionNull()

    },

    watchClickImgContainer: function () {

        $('.click_image').click( function () {

            OsContainerServicoManager.selectImage($(this))
    
        })
    
    },

    watchClickTextContainer: function () {

        $('.click_text').click( function () {
    
            $(this).closest('.container').find('.click_image').click()
   
        })

    },

    watchButtonAdicionarServico: function () {

        $('.button_adicionar_servico').click( function () {

            OsContainerServicoManager.adicionarServico($(this))

        })

    },

    watchClickBtnFinalizarOS: function () {

        $('.button_finalizar_os').click( function () {

            OsContainerServicoManager.finalizarOs($(this))

        })

    },

    selectImage: function ($this) {

        var oAllImg = $this.closest('.div_global_containers').find('.img_clicked')
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

    adicionarServico: function ($this) {

        var oDivGlobalContainer = $this.closest('.div_global_containers')
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
        
        var oContainerId = oDivGlobalContainer.find('.container_id')
        oContainerId.prop('value', aContainerId[0])

        var oForm = oDivGlobalContainer.find('.form_os_container_servico')
        oForm.submit()

    },

    finalizarOs: function ($this) {

        var iOSID = $this.attr('data-os-id')
        
        return Swal.fire({

            title: 'Deseja prosseguir?',
            text: 'A Ordem de Serviço será finalizada ao prosseguir',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#41B314',
            cancelButtonColor: '#ac2925',
            confirmButtonText: 'Sim, continuar',
            cancelButtonText: 'Não',
            showLoaderOnConfirm: true

        }).then (result => {

            if (result.dismiss != 'cancel') {
                var url_finalizar = url + 'ordem-servicos/finalizar/' + iOSID 
                window.location.href = url_finalizar
                Loader.showLoad();
            } else {
                return false
            }

        })

    },

    functionNull: function () {

        return ''

    },

}

$(document).ready( function () {

    OsContainerServicoManager.init()

})