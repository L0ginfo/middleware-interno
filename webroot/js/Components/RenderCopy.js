var RenderCopy = {

    data: {
        tree: {
            nested: null,
            object: null,
            template: null,
            replace_first: false
        },
        template_replaced: ''
    },
    render: function(oData) {
        this.setData(oData)

        var oResponseValidate = this.validate(),
            oResponse = new window.ResponseUtil()

        if (oResponseValidate.getStatus() !== 200)
            return oResponseValidate

        this.replaceNested()

        return oResponse.setStatus(200).setDataExtra(this.data.template_replaced)
    },
    setData: function(oData) {
        this.data.tree.nested         = oData.nested_tree ? oData.nested_tree : aNestedTree
        this.data.tree.object         = oData.object
        this.data.tree.template       = oData.template
        this.data.tree.data_to_render = oData.data_to_render
        this.data.tree.replace_first  = ObjectUtil.isset(oData.replace_first) ? oData.replace_first : false 
    },
    validate: function() {
        var oResponse = new window.ResponseUtil()
 
        if (!ObjectUtil.isset( ObjectUtil.getDepth(this, 'data.tree.nested') )) 
            return oResponse.setMessage('Não foi possível obter a Árvore associativa para renderizar!')
        else if (!ObjectUtil.isset( ObjectUtil.getDepth(this, 'data.tree.object') ))
            return oResponse.setMessage('Não foi possível obter o Objeto associativo para renderizar!')
        else if (!ObjectUtil.isset( ObjectUtil.getDepth(this, 'data.tree.template') ))
            return oResponse.setMessage('Não foi possível obter o template para renderizar!')
        else if (!ObjectUtil.isset( ObjectUtil.getDepth(this, 'data.tree.data_to_render') ))
            return oResponse.setMessage('Não foi possível obter a chave para renderizar os dados!')

        return oResponse.setStatus(200)
    },
    replaceNested: function() {
        var aNested       = ObjectUtil.getDepth(this, 'data.tree.nested'),
            oObject       = ObjectUtil.getDepth(this, 'data.tree.object'),
            sTemplate     = ObjectUtil.getDepth(this, 'data.tree.template'),
            sDataToRender = ObjectUtil.getDepth(this, 'data.tree.data_to_render'),
            bReplaceFirst = ObjectUtil.getDepth(this, 'data.tree.replace_first'),
            uData         = null,
            oInfoReplace  = null,
            sToReplace    = ''
    
        Object.keys( aNested[sDataToRender] ).forEach(function(sKeyName, idx) {
            oInfoReplace = aNested[sDataToRender][sKeyName]
            sToReplace = sKeyName

            uData = RenderCopy.getValue(oInfoReplace, oObject)

            if (!ObjectUtil.isset( uData ))
                uData = null

            uData = RenderCopy.manageCaseWhenValues(uData, oInfoReplace, oObject)

            if (!bReplaceFirst) 
                sTemplate = sTemplate.replace(new RegExp(sToReplace, 'g'), uData)
            else 
                sTemplate = sTemplate.replace(sToReplace, uData)
        });
        
        this.data.template_replaced = sTemplate 
    },
    manageCaseWhenValues: function(uData, oInfoReplace, oObject) {
        if (!ObjectUtil.isset(oInfoReplace.when)) 
            return uData
        
        Object.keys( oInfoReplace.when ).forEach(function(sKeyName, idx) {
            var oCase = oInfoReplace.when[sKeyName],
                uValueReferer = RenderCopy.getValue(oCase.value_referer, oObject),
                uValueReplace = RenderCopy.getValue(oCase.value_replace, oObject)

            if (uValueReferer === uData){
                uData = uValueReplace
                return uData
            }
        })

        return uData
    },
    getValue: function(oInfoReplace, oObject) {
        if (oInfoReplace.type === 'static')
            return oInfoReplace.referer
        else if (oInfoReplace.type === 'depth')
            return ObjectUtil.getDepth(oObject, oInfoReplace.referer)

        return undefined
    }
}