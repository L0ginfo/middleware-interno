var VistoriaContainersManager = {

    init: function () {

        VistoriaContainersManager.watchInputTipoIso()
        VistoriaContainersManager.watchInputTara()
        VistoriaContainersManager.watchInputMgw()
        VistoriaContainersManager.watchBtnVistoriar()
        VistoriaContainersManager.watchBtnInformarAvaria()
        VistoriaContainersManager.watchBtnSalvarAvarias()
        VistoriaContainersManager.functionNull()
        VistoriaContainersManager.watchBtnFinalizarVistoria()
        VistoriaContainersManager.watchCheckboxsAvarias()
        VistoriaContainersManager.watchInputAnoFabricacao()
        
    },

    watchInputTipoIso: function () {

        $('.find_tipo_iso').focusout( async function () {

            if ($(this).val()) {
                $this = $(this)

                var iContainerId = $(this).closest('.dados_container').find('.container_id')
                var oReturn = await VistoriaContainersServices.getIdFromValue('tipo_iso', $(this).val(), iContainerId.val())
                VistoriaContainersManager.setValueFromInputHidden($this, 'tipo_iso_id', oReturn)
            }

        })

    },

    watchInputTara: function () {

        $('.find_tara').focusout( async function () {

            if ($(this).val()) {
                $this = $(this)

                var iContainerId = $(this).closest('.dados_container').find('.container_id')
                var oReturn = await VistoriaContainersServices.getIdFromValue('tara', $(this).val(), iContainerId.val())
                VistoriaContainersManager.setColorFromInput($this, oReturn)
            }

        })

    },

    watchInputMgw: function () {

        $('.find_mgw').focusout( async function () {

            if ($(this).val()) {
                $this = $(this)

                var iContainerId = $(this).closest('.dados_container').find('.container_id')
                var oReturn = await VistoriaContainersServices.getIdFromValue('mgw', $(this).val(), iContainerId.val())
                VistoriaContainersManager.setColorFromInput($this, oReturn)
            }

        })

    },

    watchInputAnoFabricacao: function () {

        $('.find_ano_fabricacao').focusout( async function () {

            if ($(this).val()) {
                $this = $(this)

                var iContainerId = $(this).closest('.dados_container').find('.container_id')
                var oReturn = await VistoriaContainersServices.getIdFromValue('ano_fabricacao', $(this).val(), iContainerId.val())
                VistoriaContainersManager.setColorFromInput($this, oReturn)
            }

        })

    },

    setValueFromInputHidden: function ($that, sClassFromInputHidden, oReturn) {

        if (oReturn.status == 200) {
            $that.closest('.dados_container').find('.'+sClassFromInputHidden).val(oReturn.dataExtra)
            $that.removeClass('input-color-vistoria-errado')
            $that.addClass('input-color-vistoria-correto')
        } else {
            $that.closest('.dados_container').find('.'+sClassFromInputHidden).val('')
            $that.removeClass('input-color-vistoria-correto')
            $that.addClass('input-color-vistoria-errado')
        }

    },

    setColorFromInput: function ($that, oReturn) {

        if (oReturn.status == 200) {
            $that.removeClass('input-color-vistoria-diferente')
            $that.addClass('input-color-vistoria-correto')
        } else {
            $that.removeClass('input-color-vistoria-correto')
            $that.addClass('input-color-vistoria-diferente')
        }

    },

    watchBtnVistoriar: function () {

        $('.button_vistoria_container').click( function () {

            var oTipoIsoId = $(this).closest('.dados_container').find('.tipo_iso_id')
            if (!oTipoIsoId.val())
                return Swal.fire({
                    title: 'Atenção!',
                    text: 'O Tipo Iso não está de acordo com a programação!',
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 5000 
                })

            return Swal.fire({
                title: 'Atenção',
                text: 'Tem certeza que deseja realizar a vistoria do container?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#41B314',
                cancelButtonColor: '#ac2925',
                confirmButtonText: 'Sim, continuar',
                cancelButtonText: 'Não',
                showLoaderOnConfirm: true
            }).then (result => {
                if (result.dismiss != 'cancel'){
                    var oForm = $(this).closest('.execute_vistoria_container')
                    oForm.submit()
                    Loader.showLoad();
                } else {
                    return false
                }
            })

        })

    },

    watchBtnInformarAvaria: function () {

        $('.button_informar_avaria').click( function () {

            var iContainerIdVistoria    = $(this).closest('.dados_container').find('.container_id')
            var oContainerAvarias       = $(this).closest('.div_global').find('.dados_avaria_container .container_avarias[data-container-id="'+ iContainerIdVistoria.val() +'"]')
            var iContainerIdAvaria      = oContainerAvarias.find('.container_id')
            var iVistoriaItemIdVistoria = $(this).closest('.dados_container').find('.vistoria_item_id')
            var iVistoriaItemIdAvaria   = oContainerAvarias.find('.vistoria_item_id')

            iContainerIdAvaria.val('')
            iVistoriaItemIdAvaria.val('')

            iContainerIdAvaria.val(iContainerIdVistoria.val())
            iVistoriaItemIdAvaria.val(iVistoriaItemIdVistoria.val())

            $('.dados_avaria_container .container_avarias').hide("")

            var oDivAvaria = $('.dados_avaria_container .container_avarias[data-container-id="'+ iContainerIdVistoria.val() +'"]')
            
            oDivAvaria.show("")

            if(oDivAvaria.length) {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(oDivAvaria).offset().top - 200
                }, 400);
            }

        })

    },

    watchBtnSalvarAvarias: function () {

        $('.button_salvar_avarias').click( function () {

            return Swal.fire({
                title: 'Atenção',
                text: 'Tem certeza que deseja salvar as avarias do container?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#41B314',
                cancelButtonColor: '#ac2925',
                confirmButtonText: 'Sim, continuar',
                cancelButtonText: 'Não',
                showLoaderOnConfirm: true
            }).then (result => {
                if (result.dismiss != 'cancel'){
                    var oForm = $(this).closest('.execute_avaria_container')
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

    watchBtnFinalizarVistoria: function () {

        $('.button_finalizar_vistoria').click( async function () {

            if ($('.vistoria_id').val()) {
                var oResponseLacre = await Lacres.consisteLacre($('.vistoria_id').val());
    
                if (!oResponseLacre)
                    return;
            }

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

                    var iTipoRegistro = $(this).closest('.finalizar_vistoria_container').find('.tipo_registro').val()

                    if (iTipoRegistro != 'Programacao') {
                        var iVistoriaID = $(this).closest('.finalizar_vistoria_container').find('.vistoria_id').val()
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

    watchCheckboxsAvarias: function () {

        $('.checkboxs_avarias').change( function () {

            var oDivGlobalAvarias = $(this).closest('.div_global_avarias')
            var oCheckboxsAvarias = oDivGlobalAvarias.find('.checkboxs_avarias')

            var oInputCheckd = false
            oCheckboxsAvarias.each(function () {
                if ($(this).is(':checked'))
                    oInputCheckd = true
            })
            
            if (oInputCheckd)
                return $('.div_necessita_reparo').removeClass('hidden')

            return $('.div_necessita_reparo').addClass('hidden')

        })

    }
    

}

$(document).ready(function() {

    VistoriaContainersManager.init()

})