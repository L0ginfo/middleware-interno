DocumentoEntradaService = {

    init:function(){
        this.eventos();
    },

    eventos:function(){

        $('[name="pesquisa[master]"]').change(function(){
            DocumentoEntradaService.master(this.value);
        });
    
        $('[name="pesquisa[house]"]').change(function(){
            DocumentoEntradaService.house(this.value);
        });

    },

    master: function(sId){

        if(oDataMasters) this.renderDataHouse(sId);
        
        const oConhecimento = $('.conhecimento.master');
        const oCarousel = oConhecimento.find('.copy-inputs');
        const aItens = oCarousel.find('.owl-item');
        const oActiveItem = oCarousel.find('.owl-item.active');
        const oToItem = aItens.find(`.id[value="${sId}"]`).closest('.owl-item');
        const indexActive = aItens.index(oActiveItem) ;
        const indexTo = aItens.index(oToItem);

        if(indexActive == indexTo) return false;

        console.log('UPDATE MASTER', indexTo);

        setTimeout(function () {
            if(indexTo < 0|| indexActive == indexTo){
                Form.manageToggleMaster('.master', 'next', indexTo);
            }else{
                Form.manageToggleMaster('.master', 'back', indexTo);
            }

            updateHeigth();

        }, 100);

        Form.refreshAll();
    },

    renderDataFromMaster: function(){
        const sId = $('[name="pesquisa[master]"]').val();
        if(oDataMasters) this.renderDataHouse(sId);
    },

    house:function(sId){
        
        const oConhecimento = $('.conhecimento.house');
        const oCarousel = oConhecimento.find('.copy-inputs');
        const aItens = oCarousel.find('.owl-item');
        const oActiveItem = oCarousel.find('.owl-item.active');
        const oToItem = aItens.find(`.id[value="${sId}"]`).closest('.owl-item');
        const indexActive = aItens.index(oActiveItem) ;
        const indexTo = aItens.index(oToItem);
        
        if(indexTo < 0|| indexActive == indexTo ) return false;

        console.log('UPDATE HOUSE', indexTo);

        setTimeout(function () {
            if(indexTo > indexActive){
                Form.manageToggleHouse('.house', 'next', indexTo, true);
            }else{
                Form.manageToggleHouse('.house', 'back', indexTo, true);
            } 

            updateHeigth();

        }, 100);
        Form.refreshAll();
    },

    renderDataHouse:function(sId){

        $('[name="pesquisa[house]"]').html(`<option val=""></option>`);

        let oItens = ObjectUtil.getDepth(
            oDataMasters, `${sId}.conhecimento_house`
        );
        
        oItens = oItens ? oItens :{};

        for (const key in oItens) {
            $('[name="pesquisa[house]"]').append(
                `<option value="${oItens[key].id}">
                    ${oItens[key].numero_documento}
                </option>`
            );
        }
        
        $('[name="pesquisa[house]"]').selectpicker('refresh');
    }
}


$(function(){
    DocumentoEntradaService.init();
})

