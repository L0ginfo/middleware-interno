var ApreensoesService = {

    getTermoData:async function(oData){

        const oResult =  await $.fn.doAjax({
            url :'Apreensoes/findTermo',
            type:'GET',
            data:oData
        });

        if(!oResult) return {
            status:500,
            message:'Falha ao na requisição',
            dataExtra:{}
        };

        return oResult;

    },

    getHouseData:async function(oData){

        const oResult =  await $.fn.doAjax({
            url :'Apreensoes/findHouse',
            type:'GET',
            data:oData
        });

        if(!oResult) return {
            status:500,
            message:'Falha ao na requisição',
            dataExtra:{}
        };

        return oResult;

    }
};