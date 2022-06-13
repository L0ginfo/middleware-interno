DsicsService = {
    documento:async function(id){
        const oRespose = await $.fn.doAjax({
            url : window.url+'OrdemServicoDsics/getDocumento',
            type: 'GET',
            data:{
                'documento_mercadoria_id':id
            }
        });

        if(!oRespose) return {
            status:500,
            message:'falha ao relaizar a requisição.'
        };

        return oRespose;
    },
};