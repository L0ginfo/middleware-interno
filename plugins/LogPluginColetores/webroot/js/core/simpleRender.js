var simpleRender = {
    render: function (uView, sTemplate, oNestedTree, aData){

        if(!uView){
            alert('Undefiend View');
            return;
        }

        if(!sTemplate){
            alert('Undefiend Temaplte');
            return;
        }

        if(!oNestedTree){
            alert('Undefiend NestedTree');
            return;
        }

        try {
            var sHtml = '';
            for (var keyData in aData) {
                if(typeof aData[keyData] === 'object' && aData[keyData] !== null){
                    sHtml = sHtml + this._getStringToRender(sTemplate, oNestedTree, aData[keyData]);
                }
            }
            this._renderOnHTML(uView, sHtml);
            return true;
        } catch (error) {
            return false;
        }
    },

    getRender: function (sTemplate, oNestedTree, aData){

        if(!sTemplate){
            alert('Undefiend Temaplte');
            return '';
        }

        if(!oNestedTree){
            alert('Undefiend NestedTree');
            return '';
        }

        try {

            var sHtml = '';

            for (var keyData in aData) {
                if(typeof aData[keyData] === 'object' && aData[keyData] !== null){
                    sHtml = sHtml + this._getStringToRender(sTemplate, oNestedTree, aData[keyData]);
                }
            }

           return sHtml;

        } catch (error) {
            return '';
        }
    },

    _getStringToRender: function (sTemplate, oNestedTree, oObject){
        var sTemplateCopy = sTemplate;
        for (var oTreeKey in oNestedTree) {
            try {
                sValue = this._getValue(oObject, oNestedTree[oTreeKey]);
                sTemplateCopy = sTemplateCopy.split(oTreeKey).join(sValue); 
                sTemplate = sTemplateCopy;
            } catch (error) {
                console.log(error);
            }
        }
        return sTemplate;
    },

    _renderOnHTML: function(uView, sHtml){
        
        if (uView instanceof Array) {
            
            for (var key in uView) {
               $(uView[key]).html(sHtml);
            }

        } else {
            $(uView).html(sHtml);
        }

    },

    _getValue: function(oObject, oInfo) {
        if (oInfo.type === 'static'){
            return oInfo.referer;
        }
        else if (oInfo.type === 'depth'){
            return this._applyRule(this._when(oInfo, this._getDepth(oObject, oInfo.referer), oInfo), oInfo);
        }
    },

    _when: function (oInfo, value){
        if(oInfo.hasOwnProperty('when')){
            for (var whenKey in oInfo.when) {
                if(oInfo.when[whenKey].value_referer && oInfo.when[whenKey].value_referer.referer === value){
                    return oInfo.when[whenKey].value_replace.referer;
                }
            }
        }
        return value;
    },

    _getDepth: function(o, s) {
        var a = s.split('.');
        for (var i = 0, n = a.length; i < n; ++i) {
            var k = a[i];
            if (k in o) {
                o = o[k];
            } else {
                return null;
            }
        }
        return o 
    },


    _applyRule: function (string, oInfo){
        try {
            return simpleRules.init(string, oInfo);

        } catch (error) {
            console.log(error);
            return string;
        }
    }
}