var OvarContainersManager = {

    init: function () {

        OvarContainersManager.watchClickImgPesquisarLotes()
        OvarContainersManager.watchClickTextContainer()
        OvarContainersManager.watchClickBtnEstufar()
        OvarContainersManager.watchClickBtnEstornar()
        OvarContainersManager.watchClickBtnFinalizarOS()
        OvarContainersManager.watchClickBtnVistoria()
        OvarContainersManager.watchClickBtnVistoriaCargaSolta()
        OvarContainersManager.watchInputEtiquta()
    },

    watchClickImgPesquisarLotes: function () {

        $('.click_image').click( function () {

            var oAllImg   = $(this).closest('.div_ovar').find('.img_clicked')
            var aItemID = []
            oAllImg.each( function () {
                if ($(this).hasClass('clicked')) 
                    aItemID.push($(this).attr('data-item-id'))
            })

            if (aItemID.length > 0) {
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

    watchClickTextContainer: function () {

        $('.click_text').click( function () {
    
            $(this).closest('.container').find('.click_image').click()
   
        })

    },

    watchClickBtnEstufar: function () {

        $('.button_estufar_lotes').click( function () {

            var oDivLotesOvar = $(this).closest('.div_lotes_ovar')
            var oDivOvar      = oDivLotesOvar.siblings('.div_ovar')
            var oAllImg       = oDivOvar.find('.img_clicked')
            var aItemID       = []

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

            var oDivLotes = $(this).closest('.div_lotes_ovar')
            var oOSitemID = oDivLotes.find('.ordem_servico_item_id')
            oOSitemID.prop('value', aItemID[0])

            var oForm = oDivLotes.find('.form_ovar_lotes')
            oForm.submit()
        })

    },

    watchClickBtnEstornar: function () {

        $('.button_estornar_item').click( function () {

            var iOSItemID     = $(this).attr('data-item-id')
            var oInputEstorno = $(this).closest('.div_ovar').find('.ordem_servico_item_id_estorno')
            var oForm         = $(this).closest('.div_ovar').find('.form_estornar_item')

            oInputEstorno.val(iOSItemID)
            oForm.submit()

        })

    },

    watchClickBtnFinalizarOS: function () {

        $('.button_finalizar_os').click( async function () {

            var iOSID   = $(this).attr('data-os-id')
            var oReturn = await OvarContainersManager.checkExistsItensPendentes(iOSID)
            
            return Swal.fire({
                title: oReturn.title,
                text: oReturn.text,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#41B314',
                cancelButtonColor: '#ac2925',
                confirmButtonText: 'Sim, continuar',
                cancelButtonText: 'Não',
                showLoaderOnConfirm: true
            }).then (result => {
                if (result.dismiss != 'cancel'){
                    var url_finalizar = url + 'ordem-servicos/finalizar/' + iOSID 
                    window.location.href = url_finalizar
                    Loader.showLoad();
                } else {
                    return false
                }
            })

        })

    },

    checkExistsItensPendentes: async function(iOSID) {
        
        var oReturn = await $.fn.doAjax({
            url: 'ordem-servicos/check-exists-itens-pendentes-ova/' + iOSID,
            type: 'POST'
        })

        return oReturn

    },

    watchClickBtnVistoria: function () {

        $('.button_vistoria').click( function () {

            var oDivFormEstornar = $(this).closest('.form_estornar_item')
            var iOrdemServicoId  = oDivFormEstornar.find('.ordem_servico_id').val()
            var iContainerId     = oDivFormEstornar.find('.container_id').val()
            var sContainerSearch = $('#search-container').val() ? '?search=' + $('#search-container').val() : ''

            window.open(webroot + 'vistorias/iniciar-vistoria/0/0/' + iContainerId + '/' + iOrdemServicoId + sContainerSearch, '_blank');

        })

    },

    watchClickBtnVistoriaCargaSolta: function () {

        $('.button_vistoria_carga_solta').click( function () {

            var oDivFormEstornar = $(this).closest('.form_ovar_lotes')
            var iOrdemServicoId  = oDivFormEstornar.find('.ordem_servico_id').val()

            window.open(webroot + 'vistorias/iniciar-vistoria/0/0/0/' + iOrdemServicoId + '/1', '_blank');

        })

    },

    watchInputEtiquta: function() {

        if ($('[name="etiqueta"]').length)
            $('.form_ovar_lotes').css({
                'margin-top': '80px'
            });

        $('[name="etiqueta"]').keyup(function(e) {

           if (e.key === "Enter" || e.key === "ArrowUp" || e.key === "ArrowDown") {

                if (!$(this).val()) {
                    $('.container-lote').show();
                    return Swal.fire({
                        title: 'Atenção!',
                        text: 'Favor bipar uma etiqueta.',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 3000 
                    });
                }

                var sEtiqueta = $(this).val();
                var aLotes = $('input[name="codigo_barras"]');
                var aIndexLoteEncotrado = [];
                aLotes.each(index => {
                    if (aLotes.eq(index).val() == sEtiqueta)
                        aIndexLoteEncotrado.push(index);
                });

                var aLotesValidos = [];
                aIndexLoteEncotrado.forEach(index => {
                    aLotesValidos.push(aLotes.eq(index));
                    aLotes.splice(index, 1);
                });

                if (!aIndexLoteEncotrado.length) {
                    $('.container-lote').show();
                    $(this).val('');
                    return Swal.fire({
                        title: 'Atenção!',
                        text: 'Não foi encontrado lote com esta etiqueta.',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 3000 
                    });
                }
                
                aLotes.each(index => {
                    aLotes.eq(index).closest('.container-lote').hide();
                })

                aLotesValidos.forEach(element => {
                    var qtde = element.closest('.container-lote').find('.quantidade_lote').text();
                    element.closest('.container-lote').find('input[type="text"]').val(qtde);
                });

                var aContainers = $('.click_image');

                if (aContainers.length == 1)
                    aContainers.click();

                if (aLotesValidos.length)
                    $('.button_estufar_lotes').click();
           }

        });
    },

    functionNull: function () {

        return '';

    }

}

$(document).ready(function() {

    OvarContainersManager.init()
    $.fn.numericDouble()

})