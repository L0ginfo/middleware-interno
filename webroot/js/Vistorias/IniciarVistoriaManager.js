var IniciarVistoriaManager = {

    init: function () {

        IniciarVistoriaManager.verifyInputPlaca()
        IniciarVistoriaManager.verifyInputCpf()
        IniciarVistoriaManager.watchClickBtnProsseguir()

    },

    verifyInputPlaca: function () {

        $('.find_placa').focusout( async function () {

            if ($(this).val()) {
                $this = $(this)

                var iRegistroID = $(this).closest('.iniciar_vistoria').find('.registro_id')
                var sTipoRegistro = $(this).closest('.iniciar_vistoria').find('.tipo_registro')
                var oReturn = await IniciarVistoriaServices.getIdFromValue('placa', $(this).val(), iRegistroID.val(), sTipoRegistro.val())

                IniciarVistoriaManager.setValueFromInputHidden($this, 'veiculo_id', oReturn)
            }

        })

    },

    verifyInputCpf: function () {

        $('.find_motorista').focusout( async function () {

            if ($(this).val()) {
                $this = $(this)

                var iRegistroID = $(this).closest('.iniciar_vistoria').find('.registro_id')
                var sTipoRegistro = $(this).closest('.iniciar_vistoria').find('.tipo_registro')
                var oReturn = await IniciarVistoriaServices.getIdFromValue('cpf', $(this).val(), iRegistroID.val(), sTipoRegistro.val())

                IniciarVistoriaManager.setValueFromInputHidden($this, 'pessoa_id', oReturn)
            }

        })

    },

    setValueFromInputHidden: function ($that, sClassFromInputHidden, oReturn) {

        if (oReturn.status == 200) {
            $that.closest('.iniciar_vistoria').find('.'+sClassFromInputHidden).val(oReturn.dataExtra)
            $that.removeClass('input-color-vistoria-errado')
            $that.addClass('input-color-vistoria-correto')
        } else {
            $that.closest('.iniciar_vistoria').find('.'+sClassFromInputHidden).val('')
            $that.removeClass('input-color-vistoria-correto')
            $that.addClass('input-color-vistoria-errado')
        }

    },

    watchClickBtnProsseguir: function () {

        $('.prosseguir_vistoria').click( async function () {

            if ($('.vistoria_id').val() && parseInt($('.is_carga_geral').val())) {
                var oResponseLacre = await Lacres.consisteLacre($('.vistoria_id').val());
    
                if (!oResponseLacre)
                    return;
            }

            var oVeiculoId = $(this).closest('.footer').siblings('.iniciar_vistoria').find('.veiculo_id')
            if (!oVeiculoId.val())
                return Swal.fire({
                    title: 'Atenção!',
                    text: 'A placa não está de acordo com a programação!',
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 5000 
                })

            var oPessoaId = $(this).closest('.footer').siblings('.iniciar_vistoria').find('.pessoa_id')
            if (!oPessoaId.val())
                return Swal.fire({
                    title: 'Atenção!',
                    text: 'O motorista não está de acordo com a programação!',
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 5000 
                })

            var sOperacaoDescricao = $(this).closest('.footer').siblings('.iniciar_vistoria').find('.operacao_descricao').val()
            var sTipoRegistro      = $(this).closest('.footer').siblings('.iniciar_vistoria').find('.tipo_registro').val()

            if (sOperacaoDescricao == 'Carga' && sTipoRegistro == 'Resv') {

                var iVistoriaID = $(this).closest('.footer').siblings('.iniciar_vistoria').find('.vistoria_id').val()
                var sTipoCarga = $(this).closest('.footer').siblings('.iniciar_vistoria').find('.tipo_carga').val()

                var sPlaca = $(this).closest('.footer').siblings('.iniciar_vistoria').find('.find_placa').val()
                var sCpfMotorista = $(this).closest('.footer').siblings('.iniciar_vistoria').find('.find_motorista').val()

                var oReturn = await IniciarVistoriaServices.finalizaVistoriaCarga(iVistoriaID, sTipoCarga, oVeiculoId.val(), oPessoaId.val(), sPlaca, sCpfMotorista)

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

            var oForm = $(this).closest('.form_iniciar_vistoria')
            oForm.submit()

        })

    }

}

$(document).ready(function() {

    IniciarVistoriaManager.init()

})