var EnderecoUtil = {
    getTemplate: function(sType) {
        if (sType == 'single')
            return $('.lf-busca-endereco.copy.hidden .lf-option-single')[0].outerHTML
        else if (sType == 'option-group')
            return $('.lf-busca-endereco.copy.hidden .lf-option-group')[0].outerHTML
    },
    getAreaEscope: function(oLocalEscope) {
        return $(oLocalEscope).closest('.lf-busca-endereco').find('select.busca-endereco.area')
    },
    getEnderecoEscope: function(oAreaEscope) {
        return $(oAreaEscope).closest('.lf-busca-endereco').find('select.busca-endereco.endereco')
    },
    getInputsLocal: function() {
        return $('select.busca-endereco.local:not(.watched-to-change)')
    },
    getInputsAreas: function() {
        return $('select.busca-endereco.area:not(.watched-to-change)')
    },
    setAreas: async function(oResponse, oLocalEscope, sModo = '') {
        var aAreas          = ObjectUtil.getDepth(oResponse, 'dataExtra.areas'),
            sTemplate       = this.getTemplate('single'),
            oResponse       = new window.ResponseUtil(),
            oAreaEscope     = this.getAreaEscope(oLocalEscope),
            oEnderecoEscope = this.getEnderecoEscope(oLocalEscope)

        oAreaEscope.find('option').remove()
        oEnderecoEscope.find('option, optgroup').remove()

        oAreaEscope.selectpicker('refresh')
        oEnderecoEscope.selectpicker('refresh')

        aAreas.forEach(function(oValue, sKey) {
            oResponse = RenderCopy.render({
                object: oValue,
                template: sTemplate,
                nested_tree: aNestedTreeBuscaEndereco,
                data_to_render: 'options_translate',
            })

            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage(), ' Falha ao renderizar item ', oValue)
            
            //Renderiza
            oAreaEscope.append(oResponse.getDataExtra())
        })
        
        oAreaEscope.selectpicker('refresh')

    },
    setEnderecosByLocal: async function(oResponse, oLocalEscope, sModo = '') {
        var aEnderecos      = ObjectUtil.getDepth(oResponse, 'dataExtra.enderecos'),
            sTemplateGroup  = this.getTemplate('option-group'),
            sTemplateSingle = this.getTemplate('single'),
            oResponse       = new window.ResponseUtil(),
            oEnderecoEscope = this.getEnderecoEscope(oLocalEscope),
            $oOptgroup      = null

        this.nomalizeBeforeSetValue(oEnderecoEscope, 0)

        oEnderecoEscope.find('option, optgroup').remove()
        
        var aEnderecosKeys = Object.keys(aEnderecos)

        aEnderecosKeys.forEach(function(sIndexEndereco, sKey) {
            oEnderecoAgroup = aEnderecos[ sIndexEndereco ]

            oResponse = RenderCopy.render({
                object: {
                    label: sIndexEndereco,
                    key: sIndexEndereco
                },
                template: sTemplateGroup,
                nested_tree: aNestedTreeBuscaEndereco,
                data_to_render: 'options_translate',
            })

            //Renderiza optgroup
            oEnderecoEscope.append(oResponse.getDataExtra())
            //captura
            $oOptgroup = oEnderecoEscope.find('optgroup[key="' + sIndexEndereco + '"]')
            
            oEnderecoAgroup.forEach(function(oEndereco, sEnderecoKey) {
                oResponse = RenderCopy.render({
                    object: oEndereco,
                    template: sTemplateSingle,
                    nested_tree: aNestedTreeBuscaEndereco,
                    data_to_render: 'options_translate',
                })
    
                if (oResponse.getStatus() !== 200)
                    return console.log(oResponse.getMessage(), ' Falha ao renderizar item ', oValue)
                
                //Renderiza dentro do optgroup
                $oOptgroup.append(oResponse.getDataExtra())
            })
        })
        
        oEnderecoEscope.selectpicker('refresh')

    },
    setEnderecos: async function(oResponse, oAreaEscope, sModo = '') {
        var aEnderecos      = ObjectUtil.getDepth(oResponse, 'dataExtra.enderecos'),
            sTemplateGroup  = this.getTemplate('option-group'),
            sTemplateSingle = this.getTemplate('single'),
            oResponse       = new window.ResponseUtil(),
            oEnderecoEscope = this.getEnderecoEscope(oAreaEscope),
            $oOptgroup      = null

        this.nomalizeBeforeSetValue(oEnderecoEscope)

        oEnderecoEscope.find('option, optgroup').remove()
        
        var aEnderecosKeys = Object.keys(aEnderecos)

        aEnderecosKeys.forEach(function(sIndexEndereco, sKey) {
            oEnderecoAgroup = aEnderecos[ sIndexEndereco ]

            oResponse = RenderCopy.render({
                object: {
                    label: sIndexEndereco,
                    key: sIndexEndereco
                },
                template: sTemplateGroup,
                nested_tree: aNestedTreeBuscaEndereco,
                data_to_render: 'options_translate',
            })

            //Renderiza optgroup
            oEnderecoEscope.append(oResponse.getDataExtra())
            //captura
            $oOptgroup = oEnderecoEscope.find('optgroup[key="' + sIndexEndereco + '"]')
            
            oEnderecoAgroup.forEach(function(oEndereco, sEnderecoKey) {
                oResponse = RenderCopy.render({
                    object: oEndereco,
                    template: sTemplateSingle,
                    nested_tree: aNestedTreeBuscaEndereco,
                    data_to_render: 'options_translate',
                })
    
                if (oResponse.getStatus() !== 200)
                    return console.log(oResponse.getMessage(), ' Falha ao renderizar item ', oValue)
                
                //Renderiza dentro do optgroup
                $oOptgroup.append(oResponse.getDataExtra())
            })
        })
        
        oEnderecoEscope.selectpicker('refresh')

    },
    nomalizeBeforeSetValue: function(oEscope, iTimer = 1000) {
        if (!iTimer)
            return;

        oEscope.change(async function() {
            Loader.showLoad()
            
            await Utils.waitMoment(iTimer)
            
            Loader.hideLoad(true)
        })
    },

    /**
     * Retorna a composicao de um endereco
     * 
     * @param {*} iEnderecoID = ID da tabela enderecos
     * @param {*} sFormato = null
     */
    getComposicao: async function(iEnderecoID, sFormato = null, bWithObj = true) {
        return await $.fn.doAjax({
            url: 'enderecos/get-composicao',
            type: 'POST',
            data: {
                endereco_id: iEnderecoID,
                formato: sFormato,
                with_obj: bWithObj
            }
        })
    },

    watchChanges: async function(sComboName, aEnderecosPossiveis = null) {
        var aUrls = {
            local: {
                url: 'enderecos/getAreasByLocal',
                classWatched: 'watched-to-change',
                setMethod: 'setAreas',
                getInputMethod: 'getInputsLocal',
                enderecos_possiveis: aEnderecosPossiveis
            },
            area: {
                url: 'enderecos/getEnderecosByArea',
                classWatched: 'watched-to-change',
                setMethod: 'setEnderecos',
                getInputMethod: 'getInputsAreas'
            },
        }

        await this.watchCombo(aUrls[sComboName])
    },
   
    watchCombo: async function(oDataCombo) {
        this[oDataCombo.getInputMethod]().each(function() {
            $(this).addClass(oDataCombo.classWatched)

            var sModo = $(this).closest('.lf-busca-endereco').attr('data-modo')

            $(this).change(async function() {
                if (!$(this).val())
                    return

                if (!Loader.isShowing) {
                    Loader.showLoad()
                    await Utils.waitMoment(300)
                }

                if (sModo == 'local-endereco' && oDataCombo.setMethod == 'setAreas' && typeof oDataCombo.enderecos_possiveis != 'undefined' && oDataCombo.enderecos_possiveis) {
                    oDataCombo.url = 'enderecos/getEnderecosByLocal'
                    oDataCombo.setMethod = 'setEnderecosByLocal'
                }

                var oResponse = await $.fn.doAjax({
                    url: oDataCombo.url,
                    type: 'POST',
                    data: { 
                        referer_id: $(this).val(), 
                        modo: sModo, 
                        enderecos_possiveis: oDataCombo.enderecos_possiveis 
                    }
                })

                if (oResponse.status !== 200){
                    Loader.close(true)
                    await Utils.swalResponseUtil(oResponse)
                    return
                }

                await EnderecoUtil[oDataCombo.setMethod](oResponse, $(this), sModo)

                await Utils.waitMoment(400)

                Loader.close()
            })
        })
    }
} 