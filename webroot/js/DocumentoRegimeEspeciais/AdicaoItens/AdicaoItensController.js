AdicaoItensController = {
    init:function(){
        this.events();
    },
    events:function(){
        $('[name="documento_regime_especial_adicao_id"]').change(function(){
            AdicaoItensManager.setSequencia({
                documento_regime_especial_adicao_id:this.value
            });
        });
    }
    
};

$(function(){
    AdicaoItensController.init();
});