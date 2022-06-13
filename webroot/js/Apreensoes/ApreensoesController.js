var ApreensoesController = {
    init:function(){
        ApreensoesController.events();
    },

    events:function(){
        $('.lf-search-data').click(function(){
            ApreensoesManager.search({
                documento_mercadoria_id : 
                    $('[name="documento_mercadoria_id"]').val()
            });
        });
    }

    
};

$(function(){
    ApreensoesController.init();
});