AdicaoItensService = {
    findSequencia:async function(oData){
        const oResult =  await $.fn.doAjax({
            url :'DocumentoRegimeEspecialAdicaoItens/findSequencia',
            type:'GET',
            data:oData
        });

        if(!oResult) return {
            status:500,
            message:'Falha na requisição.',
            dataExtra:{}
        };
        
        return oResult;
    }
};