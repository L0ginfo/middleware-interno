var DesovarContainersManager = {

    init: function () {

        DesovarContainersManager.watchClickBtnFinalizarOS()
        DesovarContainersManager.watchClickBtnVistoria()
        DesovarContainersManager.watchClickBtnVistoriaCargaSolta()

    },

    watchClickBtnFinalizarOS: function () {

        $('.button_finalizar_os').click( async function () {

            var iOSID   = $(this).attr('data-os-id')
            var oReturn = await DesovarContainersManager.checkExistsItensPendentes(iOSID)
            
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
            url: 'ordem-servicos/check-exists-itens-pendentes-desova/' + iOSID,
            type: 'POST'
        })

        return oReturn

    },

    watchClickBtnVistoria: function () {

        $('.button_vistoria').click( function () {

            var oDivDesovar     = $(this).closest('.div_desovar')
            var iOrdemServicoId = oDivDesovar.find('.ordem_servico_id').val()
            var iContainerId    = oDivDesovar.find('.container_id').val()
            var sContainerSearch = $('#search-container').val() ? '?search=' + $('#search-container').val() : ''

            window.open(webroot + 'vistorias/iniciar-vistoria/0/0/' + iContainerId + '/' + iOrdemServicoId + sContainerSearch, '_blank');

        })

    },

    watchClickBtnVistoriaCargaSolta: function () {

        $('.button_vistoria_carga_solta').click( function () {

            var oFormEstornar   = $(this).closest('.div_desovados')
            var iOrdemServicoId = oFormEstornar.find('.ordem_servico_id_vistoria').val()

            window.open(webroot + 'vistorias/iniciar-vistoria/0/0/0/' + iOrdemServicoId + '/1', '_blank');

        })

    }

}

$(document).ready(function() {

    DesovarContainersManager.init()
    $.fn.numericDouble()

    EnderecoUtil.watchChanges('local')
    EnderecoUtil.watchChanges('area')

})