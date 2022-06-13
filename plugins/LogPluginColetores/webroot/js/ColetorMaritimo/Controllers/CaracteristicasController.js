var CaracteristicasController = {
    tipo_caracterisca:'caracterisca_tipo',
    caracterisca:'plano_carga_caracterisca',
    
    observers: function() {
        oSubject.setObserverOnEvent(function () {
            CaracteristicasService.hide();
        }, ['on_plano_carga_change']);
    },

    init: function() {
        CaracteristicasController.observers();
    },

    index:function(){  
        $('.select-produto').change(function(){
            CaracteristicasService.display({
                produto_id: this.value
            });
        });
    }
};

