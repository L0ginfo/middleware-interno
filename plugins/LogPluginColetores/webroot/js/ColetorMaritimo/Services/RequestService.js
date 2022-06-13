var RequestService = {

    ajax:function(oRequest, _callback, _error){
        simpleRequest.doAjax(oRequest, _callback, _error);
    },

    ajaxPost:function (oRequest, _callback) {
        simpleRequest.doAjax(
            {type: 'POST', url: oRequest.url, data: oRequest.data}, 
            _callback, 
            RequestService.doError
        );
    },

    ajaxGet:function (oRequest, _callback) {
        simpleRequest.doAjax(
            {type: 'GET',url: oRequest.url, data: oRequest.data}, 
            _callback, 
            RequestService.doError
        );
    },

    postRespose:function(oRequest){
        Loader.showLoad(true, 'external', 10000000);
        simpleRequest.doAjax({type: 'POST', url: oRequest.url, data: oRequest.data}, 
            RequestService.doRespose, 
            RequestService.doError
        );
    },

    getRespose:function(oRequest){
        Loader.showLoad(true, 'external', 10000000);
        simpleRequest.doAjax(
            {type: 'GET', url: oRequest.url, data: oRequest.data},
            RequestService.doRespose, 
            RequestService.doError
        );
    },


    doRespose:function(oResponse){

        if(!oResponse){
            alert('Falha na requisição.');
            Loader.hideLoad();
            return false;
        }

        if(RequestService.isObject(oResponse)){

            if(oResponse.dataExtra.hasOwnProperty('aPlanoCargas')){
                oState.setState(MenuController.sNavioViagemPLanoCargas, oResponse.dataExtra.aPlanoCargas);
            }

            if(oResponse.dataExtra.hasOwnProperty('oPlanoCarga')){
                oState.setState(PlanoCargasController.sPlanoCarga, oResponse.dataExtra.oPlanoCarga);
            }

            if(oResponse.dataExtra.hasOwnProperty('aLingadaRemocoes')){
                oState.setState(MenuController.sNavioViagemLinagdasRemocoes, oResponse.dataExtra.aLingadaRemocoes);
            }
    
            if(oResponse.dataExtra.hasOwnProperty('iTempoParalisacao')){
                console.log(oResponse.dataExtra.iTempoParalisacao);
                oState.setState(ParalisacoesController.ParalisacaoTimer, oResponse.dataExtra.iTempoParalisacao);
            }

            if(oResponse.dataExtra.hasOwnProperty('aParalisacoes')){
                oState.setState(ParalisacoesController.Paralisacoes, oResponse.dataExtra.aParalisacoes);
            }

            if(oResponse.dataExtra.hasOwnProperty('oResv')){
                oState.setState(LingadaController.sResv, oResponse.dataExtra.oResv);
            }

            if (oResponse.message !== 'Ok, veículo com resv aberta.')
                alert(oResponse.message);
            Loader.hideLoad();
            return false;
        }
    }, 

    doError:function(error){
        console.log(error);
        if(RequestService.isString(error)){
            alert(error);
            Loader.hideLoad();
            return false;
        }

        alert("Ops, ocorreu um erro ao processar requisição.");
        Loader.hideLoad();
        return false;

    },

    isObject:function(obj) {
        return obj === Object(obj);
    },

    isString:function(obj){
        return typeof obj === 'string' || obj instanceof String;
    },

    isFunction:function(obj){
        return typeof obj === "function";
    }

};