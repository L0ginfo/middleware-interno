var FormNotaFiscalManualManager = {

    init: function() {

        FormNotaFiscalManualManager.tipoDocumento()
        FormNotaFiscalManualManager.watchTipoDocumento()
        FormNotaFiscalManualManager.watchNumeroDocTransporte()
        FormNotaFiscalManualManager.watchDataEmissaoHouse()
        FormNotaFiscalManualManager.watchBtnExibeMaster()
        FormNotaFiscalManualManager.watchBtnExibeResumida()

    },

    tipoDocumento: async function() {

        var sTipoDocumento       = $('select.tipo_documento_change').find('option:selected').text()
        var iNumeroDocTransporte = $('.numero_documento_transporte').val()

        var bIsAdd = $('.main-class').hasClass('add')
        var oResponse = await FormNotaFiscalManualManager.checkNecessitaMaster($('select.tipo_documento_change').find('option:selected').val())
        
        if (bIsAdd) {
            if (oResponse.status == 200)
                var iNecessitaMaster = oResponse.dataExtra
            else 
                var iNecessitaMaster = null
        } else {
            var iNecessitaMaster = $('.resumida').eq(1).val()
        }
        
        
        if (sTipoDocumento === 'NF' || iNecessitaMaster == 1) {

            if (iNumeroDocTransporte != "") {
                FormNotaFiscalManualManager.setInputsHide(false)
            } else {
                await FormNotaFiscalManualManager.setInputsHide(true)
                await FormNotaFiscalManualManager.setValueNfInputs(true)
            }

            $('.label_conhecimento_house').html('Dados NF')
            if (iNecessitaMaster == 1) {
                $('.btn_exibe_master').show()
                $('.btn_exibe_resumida').hide()
                $('.resumida').val(1)
            } else {
                $('.btn_exibe_master').hide()
                $('.btn_exibe_resumida').hide()
                $('.resumida').val(0)
            }

        } else {

            if (oResponse.status == 200) {
                $('.label_conhecimento_house').html('Conhecimento House')
                $('.btn_exibe_master').hide()
                $('.btn_exibe_resumida').show()
            } else { 
                $('.label_conhecimento_house').html('Conhecimento House')
                $('.btn_exibe_master').hide()
                $('.btn_exibe_resumida').hide()
            }

        }
    
    },

    watchTipoDocumento: async function() {

        $('select.tipo_documento_change').change( async function () {

            var oResponse = await FormNotaFiscalManualManager.checkNecessitaMaster($(this).find('option:selected').val())

            if (oResponse.status == 200)
                var iNecessitaMaster = oResponse.dataExtra
            else 
                var iNecessitaMaster = null

            var bIsAdd = $('.main-class').hasClass('add')

            FormNotaFiscalManualManager.doTipoDocumento($(this), bIsAdd, iNecessitaMaster)

        })

    },

    doTipoDocumento: async function($this, bIsAdd = null, iNecessitaMaster = null) {

        var sTipoDocumento = $this.find('option:selected').text()
          
        if (sTipoDocumento === 'NF' || iNecessitaMaster == 1) {

            await FormNotaFiscalManualManager.setInputsHide(bIsAdd)
            await FormNotaFiscalManualManager.setValueNfInputs(bIsAdd)
            $('.label_conhecimento_house').html('Dados NF')

            if (iNecessitaMaster == 1) {
                $('.btn_exibe_master').show()
                $('.btn_exibe_resumida').hide()
                $('.resumida').val(1)
            } else {
                $('.btn_exibe_master').hide()
                $('.btn_exibe_resumida').hide()
                $('.resumida').val(0)
            }

        } else {

            await FormNotaFiscalManualManager.setInputsShow(bIsAdd)
            $('.label_conhecimento_house').html('Conhecimento House')
            $('.btn_exibe_master').hide()
            $('.btn_exibe_resumida').hide()

        }

        Form.refreshAll(500)

    },

    watchNumeroDocTransporte: function() {

        $('.numero_documento_transporte').focusout( function () {
            
            var sTipoDocumento = $('select.tipo_documento_change').find('option:selected').text()
            if (sTipoDocumento === 'NF' && $(this).val()) {

                var oItemMaster = $('.item.master').eq(1)
                oItemMaster.find('.numero_documento').val($(this).val())

                var oItemHouse = $('.item.house').eq(1)
                oItemHouse.find('.numero_documento').val($(this).val())

            }

        })

    },

    watchDataEmissaoHouse: function() {

        $("html").focusout( function () {
            
            var dDataEmissaoHouse = $(this).find('.data_emissao_house').eq(1).val()

            if (dDataEmissaoHouse)
                $(this).find('.data_emissao_master').eq(1).val(dDataEmissaoHouse)

        });

    },

    setValueNfInputs: async function(bClickAddMaster) {

        if (bClickAddMaster)
            $('.add-data.master').click()

        var oItemMaster = $('.add-data.master').closest('.conhecimento.master').find('.item.master').eq(1)

        oItemMaster.find('.tipo_documento_master').val(6)
        oItemMaster.find('.tipo_mercadoria_id').val(1)

        await Utils.waitMoment(300)

        var oButtonCopiaMasterParaHouse = oItemMaster.closest('.conhecimento.master').find('.copy-master-to-house')
        if (bClickAddMaster)
            oButtonCopiaMasterParaHouse.click()

    },

    setInputsHide: async function(bRemoveMasterHouseItens) {

        if (bRemoveMasterHouseItens)
            await FormNotaFiscalManualManager.removeMasterHouseItens()

        await Utils.waitMoment(200)

        var aInputsHide = [
            '.conhecimento.master', 
            '.add-data.house', 
            '.remove-data.house', 
            '.prev-data.house', 
            '.next-data.house', 
            '.hidden_natureza_nf',
            '.hidden_regime_nf',
            '.hidden_tratamento_nf',
            '.hidden_bto_nf',
        ]

        for (let index = 0; index < aInputsHide.length; ++index) {
            $(aInputsHide[index]).hide()
        }

        $('.valores_nota_fiscal').show()
        $('.change_chave_nf').show()
        $('.change_serie_nf').show()

    },

    setInputsShow: async function(bRemoveMasterHouseItens) {

        if (bRemoveMasterHouseItens)
            await FormNotaFiscalManualManager.removeMasterHouseItens()

        await Utils.waitMoment(200)

        var aInputsShow = [
            '.conhecimento.master', 
            '.add-data.house', 
            '.remove-data.house', 
            '.prev-data.house', 
            '.next-data.house', 
            '.hidden_natureza_nf',
            '.hidden_regime_nf',
            '.hidden_tratamento_nf',
            '.hidden_bto_nf',
        ]

        for (let index = 0; index < aInputsShow.length; ++index) {
            $(aInputsShow[index]).show()
        }

        $('.valores_nota_fiscal').hide()
        $('.change_chave_nf').hide()
        $('.change_serie_nf').hide()

    },

    removeMasterHouseItens: async function() {

        var iItensMaster = $('.item.master').length
        var iItensHouse  = $('.item.house').length
        var iItens       = $('.copy-mercadorias').length

        for (let index = 0; index < iItens; ++index) {
            $('.remove-data-mercadoria').click()
        }

        for (let index = 0; index < iItensHouse; ++index) {
            $('.remove-data.house').click()
        }

        for (let index = 0; index < iItensMaster; ++index) {
            $('.remove-data.master').click()
        }

    },

    checkNecessitaMaster: async function(iTipoDocumentoID) {

        var oReturn = await $.fn.doAjax({
            url: 'tipo-documentos/checkNecessitaMaster/' + iTipoDocumentoID,
            type: 'GET'
        })

        return oReturn

    },

    watchBtnExibeMaster: function() {

        $('.btn_exibe_master').click(async function() {
            await FormNotaFiscalManualManager.setInputsShow()
            $('.label_conhecimento_house').html('Conhecimento House')
            $('.btn_exibe_master').hide()
            $('.btn_exibe_resumida').show()
            $('.resumida').val(0)
        })

    },

    watchBtnExibeResumida: function() {

        $('.btn_exibe_resumida').click(async function() {
            await FormNotaFiscalManualManager.setInputsHide()
            $('.label_conhecimento_house').html('Dados NF')
            $('.btn_exibe_master').show()
            $('.btn_exibe_resumida').hide()
            $('.resumida').val(1)
        })

    }

}

$(document).ready(function() {

    FormNotaFiscalManualManager.init()

})
