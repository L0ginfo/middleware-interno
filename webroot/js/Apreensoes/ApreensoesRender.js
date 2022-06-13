var ApreensoesRender = {
    renderHtml:function(oData){
        const oRespose = ApreensoesRender.renderData(oData);
        if(oRespose.status == 200) $(oData.identify).html(oRespose.dataExtra);
    },
    renderData:function(oData){
        let oResponse = new window.ResponseUtil();
        let sListTemplate = '';

        if(ApreensoesRender.hasInvalidData(oData)) {
            console.log('os dados da "data" são invalidos.');
            return oResponse.setMessage('os dados da "data" são invalidos.');
        }

        if(ApreensoesRender.hasInvalidNestedTree(oData)) {
            console.log('os dados do "nested_tree" são invalidos.');
            return oResponse.setMessage('os dados do "nested_tree" são invalidos.');
        }

        if(ApreensoesRender.hasInvalidTemplate(oData)) {
            console.log('os dados do "template" são invalidos.');
            return oResponse.setMessage('os dados do "template" são invalidos.');
        }

        oData.data.forEach(function(oDataComposicao, sKeyComposicao) {
            oResponse = RenderCopy.render({
                object: oDataComposicao,
                template: oData.template,
                data_to_render: oData.data_to_render,
                nested_tree: oData.nested_tree,
            });

            if (oResponse.getStatus() !== 200){
                console.log(oResponse.getMessage() + ' Falha ao renderizar item ' + sKeyComposicao);
                return oResponse;
            }

            sListTemplate += oResponse.getDataExtra();
        });

        return oResponse.setStatus(200).setDataExtra(sListTemplate);
    },

    renderEmpty:function(sIdentify){
        $(sIdentify).html(
            `<tr> 
                <td colspan="6" class="text-center">Vazio</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>`
        );
    },

    hasInvalidData:function (oData){
        return !oData.hasOwnProperty('data') || 
        !Array.isArray(oData.data);
    },

    hasInvalidNestedTree(oData){
        return !oData.hasOwnProperty('nested_tree') || 
        typeof oData.nested_tree !== 'object'|| 
        oData.nested_tree === null;
    },

    hasInvalidTemplate(oData){
        return !oData.hasOwnProperty('template') || 
        !(typeof oData.template === 'string' || oData.template instanceof String);
    }
};