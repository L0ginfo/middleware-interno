DiscsManager = {
    buscaDocumentoDsic: async function(id){

        const oResult = await DsicsService.documento(id);

        if(oResult.status == 200){
            return DsicsRender.dsic(oResult.dataExtra);
        }

        Utils.swalUtil({
            title:'Ops..',
            message:oResult.message,
            type:'error',
            timer:3000
        });
    },

    buscaDocumentoHwab: async function(id){
        
        const oResult = await DsicsService.documento(id);

        if(oResult.status == 200){
            return DsicsRender.hwab(oResult.dataExtra);
        }

        Utils.swalUtil({
            title:'Ops..',
            message:oResult.message,
            type:'error',
            timer:3000
        });
    }

};