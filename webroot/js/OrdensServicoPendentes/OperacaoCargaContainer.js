var OperacaoDescargaContainer = {

    init: function () {

        OperacaoDescargaContainer.watchClickImgCarregar()
        OperacaoDescargaContainer.watchClickTextCarregar()
        OperacaoDescargaContainer.watchClickBtnExecuteOs()
        OperacaoDescargaContainer.watchClickImgEstornar()
        OperacaoDescargaContainer.watchClickTextEstorno()
        OperacaoDescargaContainer.watchClickBtnEstornarContainer()
        OperacaoDescargaContainer.watchFinalizarCargaContainer()
        OperacaoDescargaContainer.watchInformarSemContainer()
        OperacaoDescargaContainer.watchClickBtnVistoria()

    },

    watchClickImgCarregar: function () {

        $('.click_image').click( function () {

            var oAllImg   = $(this).closest('.div_carga').find('.img_clicked')
            var aClickeds = []
            oAllImg.each( function () {
                if ($(this).hasClass('clicked')) 
                    aClickeds.push($(this).prop('id'))
            })

            if (aClickeds > 0) {
                if (!$(this).hasClass('clicked'))
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Só é permitido carregar um container por vez!',
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

    watchClickTextCarregar: function () {

        $('.click_text').click( function () {
    
            $(this).closest('.container').find('.click_image').click()
   
        })

    },

    watchClickBtnExecuteOs: function () {

        $('.button_execute_os').click( function () {

            var oDivCarga = $(this).closest('.div_carga')
            var oAllImg      = oDivCarga.find('.img_clicked')
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
            
            var oContainerId = oDivCarga.find('.container_id')
            oContainerId.prop('value', aContainerId[0])

            var oForm = oDivCarga.find('.form_os_carga')
            oForm.submit()
        })

    },

    watchClickImgEstornar: function () {

        $('.click_image_estornar').click( function () {

            var oAllImg   = $(this).closest('.div_estornar').find('.img_clicked_estornar')
            var aClickeds = []
            oAllImg.each( function () {
                if ($(this).hasClass('clicked_estornar')) 
                    aClickeds.push($(this).prop('id'))
            })

            if (aClickeds > 0) {
                if (!$(this).hasClass('clicked_estornar'))
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Só é permitido estornar um container por vez!',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 3000 
                    })
                
                $(this).removeClass('clicked_estornar')
                $(this).addClass('img-black-white')
                return
            } 

            $(this).addClass('clicked_estornar')
            $(this).removeClass('img-black-white')
    
        })
    
    },

    watchClickTextEstorno: function () {

        $('.click_text_estornar').click( function () {
    
            $(this).closest('.container').find('.click_image_estornar').click()
   
        })

    },

    watchClickBtnEstornarContainer: function () {

        $('.button_estornar_os').click( function () {

            var oDivCarga = $(this).closest('.div_estornar')
            var oAllImg      = oDivCarga.find('.img_clicked_estornar')
            var aContainerId = []
            oAllImg.each( function () {
                if ($(this).hasClass('clicked_estornar')) 
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
            
            var oContainerId = oDivCarga.find('.container_id')
            oContainerId.prop('value', aContainerId[0])

            var oForm = oDivCarga.find('.form_estornar_container')
            oForm.submit()
        })

    },

    watchFinalizarCargaContainer: function () {

        $('.finalizar_carregamento').click( function () {

            var oDivContainer        = $('.div_carga')
            var oContainersPendentes = oDivContainer.find('.click_image')

            if (oContainersPendentes.length > 0){
                title = 'Você tem certeza?'
                text  = 'Há containers pendentes de carga'
            } else {
                title = 'Deseja prosseguir?'
                text  = 'A Ordem de Serviço será finalizada ao prosseguir'
            }

            return Swal.fire({
                title: title,
                text: text,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#41B314',
                cancelButtonColor: '#ac2925',
                confirmButtonText: 'Sim, continuar',
                cancelButtonText: 'Não',
                showLoaderOnConfirm: true
            }).then (result => {

                if (result.dismiss != 'cancel'){
                    var iOSID         = oDivContainer.find('.os_id').val()

                    var url_finalizar = url + '/ordens-servico-pendentes/finalizar-carga-container/' + iOSID
                    
                    window.location.href = url_finalizar
                    Loader.showLoad();
                } else {
                    return false
                }

            })         

        })

    },

    watchInformarSemContainer: function () {

        $('.informar_sem_container').click( async function () {

            var oGlobalSemContainer = $(this).closest('.global_sem_container')
            var iContainerID        = oGlobalSemContainer.find('select.container_id_sem_container').val()
            var iResvID             = oGlobalSemContainer.find('.resv_id_sem_container').val()

            var oReturn = await OperacaoDescargaContainer.ajaxSaveContainer(iContainerID, iResvID)

            if (oReturn.status == 200) {
                
                Swal.fire({
                    title: oReturn.message,
                    type: 'success',
                    showConfirmButton: false,
                    timer: 3000 
                }).then(function () {
                    location.reload()
                })
                
            } else {
    
                Swal.fire({
                    title: oReturn.message,
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000 
                }).then(function () {
                    location.reload()
                })
    
            }

        })

    },

    ajaxSaveContainer: async function(iContainerID, iResvID) {
        
        var oReturn = await $.fn.doAjax({
            url: 'ordens-servico-pendentes/save-container-from-carga',
            type: 'POST',
            data: {
                iContainerID: iContainerID,
                iResvID: iResvID
            }
        })

        return oReturn

    },

    watchClickBtnVistoria: function () {

        $('.button_vistoria').click( function () {

            var oDivDescarga = $(this).closest('.div_carga')
            var oAllImg      = oDivDescarga.find('.img_clicked')
            var aContainerId = []
            oAllImg.each( function () {
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

            var bVistoriaFinalizada = oDivDescarga.find('.vistoria_finalizada').val()
            if (bVistoriaFinalizada) {
                return Swal.fire({
                    title: 'Atenção!',
                    text: 'A vistoria para essa Resv já foi finalizada!',
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000 
                })
            }

            var iResvId      = oDivDescarga.find('.resv_id').val()
            var iContainerId = aContainerId[0]
            var sContainerSearch = $('#search-container').val() ? '?search=' + $('#search-container').val() : ''

            window.open(webroot + 'vistorias/iniciar-vistoria/0/' + iResvId + '/' + iContainerId + '/0/0/1' + sContainerSearch, '_blank');

        })

    }

}


$(document).ready(function() {

    OperacaoDescargaContainer.init()
    
    EnderecoUtil.watchChanges('local')
    EnderecoUtil.watchChanges('area')

})