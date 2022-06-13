var ColetorMaritimoService = {
    baseUrl: url+'/coletores/PlanejamentoMaritimo',
    get: function(_callback) {
        simpleRequest.doAjax({
            url:  this.baseUrl+'/get/'+sId,
            type: 'GET',
        }, _callback);
    }
};
