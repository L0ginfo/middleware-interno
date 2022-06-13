var VistoriaCargaGeralManager = {

    init: function() {

        VistoriaCargaGeralManager.watchClickBtnVistoriar()
        VistoriaCargaGeralManager.watchBtnFinalizarVistoria()
        VistoriaCargaGeralManager.functionNull()

    },

    watchClickBtnVistoriar: function() {

        $('.button_avaria_carga_solta').click( function() {

            var oVistoriaItemID = $(this).closest('.div_lotes').find('.vistoria_item_id')
            var oDivAvaria      = $(this).closest('.div_global').find('.carga_geral_avarias'+oVistoriaItemID.val())
            var oDivsAvarias    = $(this).closest('.div_global').find('.div_carga_geral_avarias')

            oDivsAvarias.each( function() {
                $(this).hide()
            })

            oDivAvaria.show()

            if(oDivAvaria.length) {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(oDivAvaria).offset().top - 200
                }, 400);
            }

        })

    },

    watchBtnFinalizarVistoria: function () {

        $('.button_finalizar_vistoria_carga_geral').click( function () {

            return Swal.fire({
                title: 'Atenção',
                text: 'Tem certeza que deseja finalizar a vistoria?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#41B314',
                cancelButtonColor: '#ac2925',
                confirmButtonText: 'Sim, continuar',
                cancelButtonText: 'Não',
                showLoaderOnConfirm: true
            }).then (async result => {
                if (result.dismiss != 'cancel') {

                    var iTipoRegistro = $(this).closest('.finalizar_vistoria_carga_geral').find('.tipo_registro').val()

                    if (iTipoRegistro != 'Programacao') {
                        var iVistoriaID = $(this).closest('.finalizar_vistoria_carga_geral').find('.vistoria_id').val()
                        var oReturn = await VistoriaContainersServices.finalizaVistoria(iVistoriaID)

                        if (oReturn.status == 200) {

                            await Swal.fire({
                                title: 'Sucesso!',
                                text: 'Vistoria finalizada com sucesso!',
                                type: 'success',
                                showConfirmButton: false,
                                timer: 3000 
                            })

                            window.close()
                            return 

                        } else {

                            return Swal.fire({
                                title: 'Atenção!',
                                text: 'Ocorreu um erro ao finalizar a vistoria!',
                                type: 'warning',
                                showConfirmButton: false,
                                timer: 3000 
                            })

                        }
                    }

                    var oForm = $(this).closest('.finalizar_vistoria_container')
                    oForm.submit()
                    Loader.showLoad();

                } else {
                    return false
                }
            })

        })

    },

    functionNull: function () {

        return ''

    },

}

$(document).ready(function() {

    VistoriaCargaGeralManager.init()

})
