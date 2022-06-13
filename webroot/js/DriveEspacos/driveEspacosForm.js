var DriveEspacosForm = {

    init: function () {

        this.watchChangeDriveEspacoTipo()
        this.watchDriveEspacoTipo()
        // this.watchQuantidadeContainer()
        this.watchQtdeCntCargaVazio()
        this.watchQtdeCntCargaCheio()
        // this.watchInputsValidaQuantidade()
        this.watchDriveEspacoClassificacao()
        this.watchDriveEspacoTipoCarga()

    },

    watchDriveEspacoTipo: function () {

        var sTextSelected = $('.drive_espaco_tipo_id').find('option').filter(':selected').text()
        if (sTextSelected)
            DriveEspacosForm.checkDriveEspacoTipoValue(sTextSelected)

    },

    watchChangeDriveEspacoTipo: function () {

        $('.drive_espaco_tipo_id').change( function () {

            var sTextSelected = $(this).find('option').filter(':selected').text()
            DriveEspacosForm.checkDriveEspacoTipoValue(sTextSelected)

        })

    },

    watchDriveEspacoClassificacao: function () {

        $('.drive_espaco_classificacao_id').change( function () {

            var sTextSelected = $(this).find('option').filter(':selected').text()
            DriveEspacosForm.checkDriveEspacoClassificacao(sTextSelected)
            
        })

    },

    watchDriveEspacoTipoCarga: function () {

        $('.drive_espaco_tipo_carga_id').change( function () {

            var sTextSelected = $(this).find('option').filter(':selected').text()
            DriveEspacosForm.checkDriveEspacoTipoCarga(sTextSelected)
            
        })

    },

    checkDriveEspacoTipoCarga: function (sTextSelected) {

        switch (sTextSelected) {
            case 'CABOTAGEM - EXPORTAÇÃO' || 'Cabotagem - Exportação' || 'EXPORTAÇÃO' || 'Exportação':

                $('input[name="data_hora_ddl"]').prop('required', true)
                break;

            default:

                $('input[name="data_hora_ddl"]').prop('required', false)
                break;
        }

    },

    checkDriveEspacoClassificacao: function (sTextSelected) {

        switch (sTextSelected) {
            case 'Cheio' || 'CHEIO':

                $('select[name="drive_espaco_tipo_carga_id"]').prop('required', true)
                break;

            case 'Vazio' || 'VAZIO':

                $('select[name="drive_espaco_tipo_carga_id"]').prop('required', false)
                break;
        
            default:
                break;
        }

    },

    checkDriveEspacoTipoValue: function (sTextSelected) {

        switch (sTextSelected) {
            case 'Container' || 'CONTAINER':

                DriveEspacosForm.removeHideInputsContainers()
                DriveEspacosForm.addHideInputsCargaGeral()
                DriveEspacosForm.toggleInputsRequired(true)
                break;

            case 'Carga Geral' || 'CARGA GERAL':

                DriveEspacosForm.removeHideInputsCargaGeral()
                DriveEspacosForm.addHideInputsContainers()
                DriveEspacosForm.toggleInputsRequired(false)
                break;
        
            default:

                DriveEspacosForm.addHideInputsCargaGeral()
                DriveEspacosForm.addHideInputsContainers()
                break;
        }

    },

    toggleInputsRequired: function (bRequired) {

        var aInputsRequired = ['qtde_cnt_possivel']
        aInputsRequired.forEach(element => {
            $('input[name="'+ element +'"]').prop('required', bRequired)
        });

        var aSelectsRequired = ['armador_id', 'conteiner_tamanho_id', 'tipo_iso_id']
        aSelectsRequired.forEach(element => {
            $('select[name="'+ element +'"]').prop('required', bRequired)
        });
    
    },

    removeHideInputsContainers: function () {

        var oInputsContainers = $('.inputs_container')

        oInputsContainers.each( function (index) {
            $(this).removeClass('hide')
        })

        Utils.fixSelectPicker();

    },

    removeHideInputsCargaGeral: function () {

        var oInputsCargaGeral = $('.inputs_carga_geral')
        oInputsCargaGeral.each( function (index) {
            $(this).removeClass('hide')
        })

        Utils.fixSelectPicker();

    },

    addHideInputsContainers: function () {

        var oInputsContainers = $('.inputs_container')

        oInputsContainers.each( function (index) {
            $(this).addClass('hide')
        })

    },

    addHideInputsCargaGeral: function () {

        var oInputsCargaGeral = $('.inputs_carga_geral')
        oInputsCargaGeral.each( function (index) {
            $(this).addClass('hide')
        })

    },

    watchQtdeCntCargaVazio: function () {

        $('.qtde_container_vazio_carga').focusout( async function () {

            var oDivGlobal = $(this).closest('.div_global')

            // var iOperacaoID                 = oDivGlobal.find('.selectpicker.operacao_id').val()
            var iArmadorID                  = oDivGlobal.find('.selectpicker.selectpicker_armador').val()
            var iDriveEspacoClassificacaoID = 2
            var iContainerTamanhoID         = oDivGlobal.find('.selectpicker.container_tamanho_id').val()
            var iTipoIsoID                  = oDivGlobal.find('.selectpicker.tipo_iso_id').val()
            var iContainerFormaUsoID        = oDivGlobal.find('select.container_forma_uso_id').val() ? oDivGlobal.find('select.container_forma_uso_id').val() : null
            var iSuperTestado               = oDivGlobal.find('select.super_testado').val() ? oDivGlobal.find('select.super_testado').val() : null

            var oResponseVerify = await DriveEspacosForm.verifyValidaQuantidade(iArmadorID, iContainerTamanhoID, iTipoIsoID, iContainerFormaUsoID, iSuperTestado, $(this))
            if (oResponseVerify.status == 400)
                return Utils.swalResponseUtil(oResponseVerify)
            if (oResponseVerify.status == 204)
                return

            var oResponseValida = await DriveEspacosForm.validaCapacidadeEstoque($(this).val(), iDriveEspacoClassificacaoID, iArmadorID, iContainerTamanhoID, iTipoIsoID, iContainerFormaUsoID, iSuperTestado)
            if (oResponseValida.status != 200) {
                $(this).val('')
                return Utils.swalResponseUtil(oResponseValida)
            }

            return
        })

    },

    watchQtdeCntCargaCheio: function () {

        $('.qtde_container_cheio_carga').focusout( async function () {

            var oDivGlobal = $(this).closest('.div_global')

            // var iOperacaoID                 = oDivGlobal.find('.selectpicker.operacao_id').val()
            var iArmadorID                  = oDivGlobal.find('.selectpicker.selectpicker_armador').val()
            var iDriveEspacoClassificacaoID = 1
            var iContainerTamanhoID         = oDivGlobal.find('.selectpicker.container_tamanho_id').val()
            var iTipoIsoID                  = oDivGlobal.find('.selectpicker.tipo_iso_id').val()
            var iContainerFormaUsoID        = oDivGlobal.find('select.container_forma_uso_id').val() ? oDivGlobal.find('select.container_forma_uso_id').val() : null
            var iSuperTestado               = oDivGlobal.find('select.super_testado').val() ? oDivGlobal.find('select.super_testado').val() : null

            var oResponseVerify = await DriveEspacosForm.verifyValidaQuantidade(iArmadorID, iContainerTamanhoID, iTipoIsoID, iContainerFormaUsoID, iSuperTestado, $(this))
            if (oResponseVerify.status == 400)
                return Utils.swalResponseUtil(oResponseVerify)
            if (oResponseVerify.status == 204)
                return

            var oResponseValida = await DriveEspacosForm.validaCapacidadeEstoque($(this).val(), iDriveEspacoClassificacaoID, iArmadorID, iContainerTamanhoID, iTipoIsoID, iContainerFormaUsoID, iSuperTestado)
            if (oResponseValida.status != 200) {
                $(this).val('')
                return Utils.swalResponseUtil(oResponseValida)
            }

            return
        })

    },

    // watchQuantidadeContainer: function () {

    //     $('.quantidade_container').focusout( async function () {

    //         var oDivGlobal = $(this).closest('.div_global')

    //         var iOperacaoID                 = oDivGlobal.find('.selectpicker.operacao_id').val()
    //         var iArmadorID                  = oDivGlobal.find('.selectpicker.selectpicker_armador').val()
    //         var iDriveEspacoClassificacaoID = oDivGlobal.find('.selectpicker.drive_espaco_classificacao_id').val()
    //         var iContainerTamanhoID         = oDivGlobal.find('.selectpicker.container_tamanho_id').val()
    //         var iTipoIsoID                  = oDivGlobal.find('.selectpicker.tipo_iso_id').val()
    //         var iContainerFormaUsoID        = oDivGlobal.find('select.container_forma_uso_id').val() ? oDivGlobal.find('select.container_forma_uso_id').val() : null
    //         var iSuperTestado               = oDivGlobal.find('select.super_testado').val() ? oDivGlobal.find('select.super_testado').val() : null

    //         var oResponseVerify = await DriveEspacosForm.verifyValidaQuantidade(iArmadorID, iOperacaoID, iDriveEspacoClassificacaoID, iContainerTamanhoID, iTipoIsoID, iContainerFormaUsoID, iSuperTestado, $(this))
    //         if (oResponseVerify.status == 400)
    //             return Utils.swalResponseUtil(oResponseVerify)
    //         if (oResponseVerify.status == 204)
    //             return

    //         var oResponseValida = await DriveEspacosForm.validaCapacidadeEstoque($(this).val(), iDriveEspacoClassificacaoID, iArmadorID, iContainerTamanhoID, iTipoIsoID, iContainerFormaUsoID, iSuperTestado)
    //         if (oResponseValida.status != 200) {
    //             $(this).val('')
    //             return Utils.swalResponseUtil(oResponseValida)
    //         }

    //         return
    //     })

    // },

    verifyValidaQuantidade: async function (iArmadorID, iContainerTamanhoID, iTipoIsoID, iContainerFormaUsoID, iSuperTestado, $this) {

        var oResponse = new window.ResponseUtil()

        // if (!iOperacaoID) {
        //     $this.val('')
        //     return oResponse.setMessage('Selecione uma Operação antes de informar a quantidade!')
        // }

        // if (iOperacaoID != 2)
        //     return oResponse.setStatus(204)

        // if (!iDriveEspacoClassificacaoID) {
        //     $this.val('')
        //     return oResponse.setMessage('Selecione um Drive Espaço Classificação antes de informar a quantidade!')
        // }

        if (!iArmadorID) {
            $this.val('')
            return oResponse.setMessage('Selecione um Armador antes de informar a quantidade!')
        }

        if (!iContainerTamanhoID) {
            $this.val('')
            return oResponse.setMessage('Selecione um Container Tamanho antes de informar a quantidade!')
        }

        if (!iTipoIsoID) {
            $this.val('')
            return oResponse.setMessage('Selecione um Tipo Iso antes de informar a quantidade!')
        }

        // if (!iContainerFormaUsoID) {
        //     $this.val('')
        //     return oResponse.setMessage('Selecione um Container Forma Uso antes de informar a quantidade!')
        // }

        // if (!iSuperTestado) {
        //     $this.val('')
        //     return oResponse.setMessage('Selecione se é ou não Super Testado antes de informar a quantidade!')
        // }
        
        return oResponse.setStatus(200)

    },

    validaCapacidadeEstoque: async function (iQuantidade, iDriveEspacoClassificacaoID, iArmadorID, iContainerTamanhoID, iTipoIsoID, iContainerFormaUsoID, iSuperTestado) {

        var oResponse = await $.fn.doAjax({
            url: 'drive-espacos/validaCapacidadeEstoque/' + iQuantidade + '/' + iDriveEspacoClassificacaoID + '/' + iArmadorID + '/' + iContainerTamanhoID + '/' + iTipoIsoID + '/' + iContainerFormaUsoID + '/' + iSuperTestado,
            type: 'POST'
        });

        return oResponse;

    },

    // watchInputsValidaQuantidade: function () {

    //     $('.selectpicker.drive_espaco_tipo_id, .selectpicker.operacao_id, .selectpicker.drive_espaco_classificacao_id, .selectpicker.selectpicker_armador, .selectpicker.container_tamanho_id, .selectpicker.tipo_iso_id, select.container_forma_uso_id, select.super_testado').change( function () {

    //         $('.quantidade_container').val('')

    //     })

    // }

}

$(document).ready(function() {

    DriveEspacosForm.init()

})