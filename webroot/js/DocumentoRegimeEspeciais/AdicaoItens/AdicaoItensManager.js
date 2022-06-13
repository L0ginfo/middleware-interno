AdicaoItensManager = {
    setSequencia:async function(oData){

        oResult = await AdicaoItensService.findSequencia(oData);

        if(oResult.status == 200){
            AdicaoItensRender.sequencia(oResult.dataExtra);
        }

    }
    
};