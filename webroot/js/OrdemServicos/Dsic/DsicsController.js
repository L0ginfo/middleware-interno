var DsicsController = {
    init:function(){
        this.events();
    },
    events:function(){
        $('.lf-search-data-dsic:not(:disabled)').click(function(){
            const iDocumento = $('[name="dsic_id"]').val();
            $('[name="documento_mercadoria_dsic_id"]').val(iDocumento);
            DiscsManager.buscaDocumentoDsic(iDocumento);
        });

        $('.lf-search-data-hawb:not(:disabled)').click(function(){
            const iDocumento = $('[name="hawb_id"]').val();
            $('[name="documento_mercadoria_hawb_id"]').val(iDocumento);
            DiscsManager.buscaDocumentoHwab(iDocumento);
        });
    }
};


$(function(){
    DsicsController.init();
});