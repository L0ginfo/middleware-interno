var ApreensoesManager = {
    search: async function(oData){
        oResult = await ApreensoesService.getHouseData(oData);

        if(oResult.status != 200 || oResult.dataExtra.length == 0) {
            return ApreensoesRender.renderEmpty('table tbody');
        } 

        if(oResult.status == 200){

            const aData = oResult.dataExtra.map((value) =>{

                value.peso_bruto = Utils.showFormatFloat(
                    value.peso_bruto, 3
                );

                value.volume = Utils.showFormatFloat(
                    value.volume, 3
                );

                value.data_emissao = ApreensoesManager.dateToView(
                    value.data_emissao, 'T');

                return value;
            });

            return ApreensoesRender.renderHtml({
                template:window.templates.documento_mercadorias,
                data_to_render:'documento_mercadorias',
                nested_tree:window.nested_tree,
                data:aData,
                identify:'.houses table tbody'
            });
        }
    },

    dateToView:function(string, divisor){
        if(!string) return '';
        if(!divisor) divisor = ' ';
        var dateAndTime = string.split(divisor);
        var slicesDate = dateAndTime[0].split('-');
        return slicesDate[2]+'/'+slicesDate[1]+'/'+slicesDate[0];
    },
};