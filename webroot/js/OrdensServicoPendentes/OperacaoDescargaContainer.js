var OperacaoDescargaContainer = {

    init: function () {

        OperacaoDescargaContainer.watchClickImgDescarregar()
        OperacaoDescargaContainer.watchClickTextDescarregar()
        OperacaoDescargaContainer.watchClickBtnExecuteOs()
        OperacaoDescargaContainer.watchClickImgEstornar()
        OperacaoDescargaContainer.watchClickTextEstorno()
        OperacaoDescargaContainer.watchClickBtnEstornarContainer()
        OperacaoDescargaContainer.watchClickBtnAtualizarDestinoContainer()
        OperacaoDescargaContainer.watchFinalizarDescargaContainer()
        OperacaoDescargaContainer.watchClickBtnVistoria()

    },

    watchClickImgDescarregar: function () {

        $('.click_image').click( function () {

            var oAllImg   = $(this).closest('.div_descarga').find('.img_clicked')
            var aClickeds = []
            oAllImg.each( function () {
                if ($(this).hasClass('clicked')) 
                    aClickeds.push($(this).prop('id'))
            })

            if (aClickeds > 0) {
                if (!$(this).hasClass('clicked'))
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Só é permitido descarregar um container por vez!',
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

    watchClickTextDescarregar: function () {

        $('.click_text').click( function () {
    
            $(this).closest('.container').find('.click_image').click()
   
        })

    },

    watchClickBtnExecuteOs: function () {

        $('.button_execute_os').click( function () {

            var oDivDescarga = $(this).closest('.div_descarga')
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
            
            var oContainerId = oDivDescarga.find('.container_id')
            oContainerId.prop('value', aContainerId[0])

            var oForm = oDivDescarga.find('.form_os_descarga')
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

            var oDivDescarga = $(this).closest('.div_estornar')
            var oAllImg      = oDivDescarga.find('.img_clicked_estornar')
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
            
            var oContainerId = oDivDescarga.find('.container_id')
            oContainerId.prop('value', aContainerId[0])

            var oForm = oDivDescarga.find('.form_estornar_container')
            oForm.submit()
        })

    },

    watchClickBtnAtualizarDestinoContainer: function () {

        $('.button_atualizar_destino').click( async function () {

            var oDivDescarga = $(this).closest('.div_estornar')
            var oAllImg      = oDivDescarga.find('.img_clicked_estornar')
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

            var iDestinoID = $('.input_container_destino').val()
            if (!iDestinoID) {
                return Swal.fire({
                    title: 'Atenção!',
                    text: 'Favor selecionar um destino!',
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000 
                })
            }
            
            var oContainerId = oDivDescarga.find('.container_id')
            oContainerId.prop('value', aContainerId[0])

            var oDestinoID = oDivDescarga.find('.destino_id')
            oDestinoID.prop('value', iDestinoID)

            var oResponse = await OperacaoDescargaContainer.setDestinoByContainerId(aContainerId[0], iDestinoID)
            Swal.fire({
                title: oResponse.title,
                text: oResponse.message,
                type: 'warning',
                showConfirmButton: false,
                timer: 3000 
            })
            
        })

    },

    setDestinoByContainerId: async function (iContainerID, iDestinoID) {
        var oResponse = await $.fn.doAjax({
            url: 'entrada-saida-containers/setDestinoByContainerId/' + iContainerID + '/' + iDestinoID,
            type: 'GET'
        });

        return oResponse;
    },

    watchFinalizarDescargaContainer: function () {

        $('.finalizar-recebimento').click( async function () {

            var oDivContainer        = $('.div_descarga')
            var oContainersPendentes = oDivContainer.find('.click_image')

            if (oDivContainer.find('.os_id').val()) {
                var oResponseLacre = await Lacres.consisteLacre(oDivContainer.find('.os_id').val());
    
                if (!oResponseLacre)
                    return;
            }

            if (oContainersPendentes.length > 0){
                title = 'Você tem certeza?'
                text  = 'Há containers pendentes de descarga'
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
                    var iTransporteID = oDivContainer.find('.documento_transporte_id').val()

                    var url_finalizar = url + '/ordens-servico-pendentes/finalizar-descarga-container/' + iOSID + '/' + iTransporteID 
                    
                    window.location.href = url_finalizar
                    Loader.showLoad();
                } else {
                    return false
                }

            })         

        })

    },

    watchClickBtnVistoria: function () {

        $('.button_vistoria').click( function () {

            var oDivDescarga = $(this).closest('.div_descarga')
            var oAllImg      = oDivDescarga.find('.img_clicked')
            var aContainerId = []
            oAllImg.each( function () {
                // if ($(this).hasClass('clicked')) 
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