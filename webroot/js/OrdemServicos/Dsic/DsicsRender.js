DsicsRender = {
    dsic:function(oData){
        $('.lf-documento-dsic .lf-conhecimento')
            .html(oData.conhecimento);
        $('.lf-documento-dsic .lf-termo')
            .html(oData.termo);
        $('.lf-documento-dsic .lf-quantidade-house')
            .html(Utils.showFormatFloat(parseFloat(oData.volume)), 3);
        $('.lf-documento-dsic .lf-peso-house')
            .html(Utils.showFormatFloat(parseFloat(oData.peso), 3));
        $('.lf-documento-dsic .lf-quantidade')
            .html(Utils.showFormatFloat(parseFloat(oData.estoque_quantidade)), 3);
        $('.lf-documento-dsic .lf-peso')
            .html(Utils.showFormatFloat(parseFloat(oData.estoque_peso), 3));
        $('.lf-documento-dsic .lf-data')
            .html(DsicsRender.dateToView(oData.data, 'T'));
    },
    hwab:function(oData){
        console.log(oData);
        $('.lf-documento-hawb .lf-conhecimento')
            .html(oData.conhecimento);
        $('.lf-documento-hawb .lf-termo')
            .html(oData.termo);
        $('.lf-documento-hawb .lf-quantidade-house')
            .html(Utils.showFormatFloat(parseFloat(oData.volume)), 3);
        $('.lf-documento-hawb .lf-peso-house')
            .html(Utils.showFormatFloat(parseFloat(oData.peso), 3));
        $('.lf-documento-hawb .lf-quantidade')
            .html(Utils.showFormatFloat(parseFloat(oData.estoque_quantidade)), 3);
        $('.lf-documento-hawb .lf-peso')
            .html(Utils.showFormatFloat(parseFloat(oData.estoque_peso), 3));
        $('.lf-documento-hawb .lf-data')
            .html(DsicsRender.dateToView(oData.data, 'T'));
    },

    dateToView:function(string, divisor){
        if(!string) return '';
        if(!divisor) divisor = ' ';
        var dateAndTime = string.split(divisor);
        var slicesDate = dateAndTime[0].split('-');
        return slicesDate[2]+'/'+slicesDate[1]+'/'+slicesDate[0];
    },
}