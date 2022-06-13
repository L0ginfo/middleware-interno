var MenuItensManager = {
    button: 'button',
    action: 'action',
    anterior: 'anterior',

    init:function(){
        MenuItensManager.onInit();
        MenuItensManager.next();
        MenuItensManager.back();
    },
    onInit:function(){
        MenuItensManager.start();
    },
    start:function(){
        setTimeout(() => {
            oState.setState(MenuItensManager.action, 'start');
            oState.setState(MenuItensManager.anterior, 0);
            oState.setState(MenuItensManager.button, null);
            $('.lf-item-main .lf-item-body').each(function(){
                $(this).find('.lf-body-data-item:first').addClass('active');
            });
        }, 1000);
    },
    restart:function(sIdentificador){
        const sAction = oState.getState(MenuItensManager.action);
        const iPrevisto = oState.getState(MenuItensManager.anterior);
        oState.setState(MenuItensManager.action, 'restart');
        oState.setState(MenuItensManager.anterior, 0);
        oState.setState(MenuItensManager.button, null);
        
        if(sAction == 'add'){
            return MenuItensManager.last(sIdentificador);
        }
        
        if(sAction == 'remove' && iPrevisto){
            const eElement = $(sIdentificador +' .lf-item-main .lf-item-body');
            const eItem = eElement.find('.lf-body-data-item.lf-item-'+iPrevisto);

            if(eItem && eItem.length > 0 ){
                eElement.find('.lf-body-data-item').removeClass('active');
                eItem.addClass('active');
                return true;
            }
        }

        MenuItensManager.first(sIdentificador);
    },
    first:function(sIdentificador){
        const eElement = $(sIdentificador +' .lf-item-main .lf-item-body');
        eElement.find('.lf-body-data-item').removeClass('active');
        eElement.find('.lf-body-data-item:first').addClass('active');
    },
    last:function(sIdentificador){
        const eElement = $(sIdentificador +' .lf-item-main .lf-item-body');
        eElement.find('.lf-body-data-item').removeClass('active');
        eElement.find('.lf-body-data-item:last').addClass('active');
    },
    events:function(sIdentificador, eClassController){
        MenuItensManager.add(sIdentificador, eClassController.add);
        MenuItensManager.remove(sIdentificador, eClassController.remove);
    },
    add:function(sIdentificador, callback){
        $(sIdentificador+' .lf-item-header .add-data:not(.watched)').click(function(e){
            const eAtual = $(this).closest('.lf-item-main').find('.lf-item-body .lf-body-data-item.active');
            const iPrevisto = eAtual.prev() ? eAtual.prev().data('id'): null;
            oState.setState(MenuItensManager.anterior, iPrevisto);
            oState.setState(MenuItensManager.button, this);
            oState.setState(MenuItensManager.action, 'add');
            callback(this, e);
        });
        $(sIdentificador+' .lf-item-header .add-data:not(.watched)').addClass('watched');
    },
    remove:function(sIdentificador, callback){
        $(sIdentificador+' .lf-item-header .remove-data:not(.watched)').click(function(e){
            const eAtual = $(this).closest('.lf-item-main').find('.lf-item-body .lf-body-data-item.active');
            const iPrevisto = eAtual.prev() ? eAtual.prev().data('id'): null;
            oState.setState(MenuItensManager.anterior, iPrevisto);
            oState.setState(MenuItensManager.button, this);
            oState.setState(MenuItensManager.action, 'remove');
            callback(this, e);
        });
        $(sIdentificador+' .lf-item-header .add-data:not(.watched)').addClass('watched');
    },
    back:function(){
        $('.lf-item-header .prev-data:not(.watched)').each(function(){
            $(this).addClass('watched');
            $(this).click(function(){

                const eAtual =  $(this).closest('.lf-item-main').find('.lf-item-body .lf-body-data-item.active');
                const ePre = eAtual.prev();

                if(ePre && ePre.length > 0) {
                    eAtual.removeClass('active');
                    ePre.addClass('active');
                    oState.setState(MenuItensManager.anterior, ePre.prev().data('id'));
                    oState.setState(MenuItensManager.button, this);
                    oState.setState(MenuItensManager.action, 'back');
                }
            });
        })
    },
    next:function(){
        $('.lf-item-header .next-data:not(.watched)').each(function(){
            $(this).addClass('watched');
            $(this).click(function(){
                oState.setState(MenuItensManager.anterior, null);
                const eAtual =  $(this).closest('.lf-item-main').find('.lf-item-body .lf-body-data-item.active');
                const eNext = eAtual.next();
                if(eNext && eNext.length > 0) {
                    eAtual.removeClass('active');
                    eNext.addClass('active');
                    oState.setState(MenuItensManager.anterior, eAtual.data('id'));
                    oState.setState(MenuItensManager.button, this);
                    oState.setState(MenuItensManager.action, 'next');
                }
            });            
        });
    }
};

$(function(){
    MenuItensManager.init();
});