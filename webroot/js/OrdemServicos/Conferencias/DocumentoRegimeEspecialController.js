var DocumentoRegimeEspecialController = {
    sDesconsolidar:'desconsolidar',
    sOrdemServico:'ordem_servico',
    sAdicoes:'adicoes',
    sAdicaoItens:'adicao_itens',
    sAdicaoItem:'adicao_item',
    sLocais:'locais',
    sAreas:'areas',
    sEnderecos:'enderecos',
    sItens:'os_doc_itens',

    init:function(){
        DocumentoRegimeEspecialController.observers();
        DocumentoRegimeEspecialController.watch();
        DocumentoRegimeEspecialController.onInit();
        MenuItensManager.events('.os-conferencia', DocumentoRegimeEspecialManager);
    },

    onInit:function(){
        const iOrdemServico = $('[name="ordem_servico_id"]').val();
        oState.setState(DocumentoRegimeEspecialController.sOrdemServico, iOrdemServico);
    },

    observers: function() {

        oSubject.setObserverOnEvent(function () {
            const value = oState.getState(DocumentoRegimeEspecialController.sDesconsolidar);
            console.log(value);
            if(value) return $('.desconsolidar').removeAttr('disabled');
            $('.desconsolidar').attr('disabled', true); 
        }, ['on_desconsolidar_change']);

        oSubject.setObserverOnEvent(function () {
            DocumentoRegimeEspecialManager.buttons();
        }, ['on_action_change']);

        oSubject.setObserverOnEvent(function () {
            const aItens = oState.getState(DocumentoRegimeEspecialController.sOrdemServico);
            DocumentoRegimeEspecialService.ordemServico(aItens);
        }, ['on_ordem_servico_change']);

        oSubject.setObserverOnEvent(function () {
            const aItens = oState.getState(DocumentoRegimeEspecialController.sItens);
            DocumentoRegimeEspecialManager.itens(aItens);
            setTimeout(() => {
                MenuItensManager.restart('.os-conferencia');
                DocumentoRegimeEspecialManager.buttons();
            }, 1000);
        }, ['on_os_doc_itens_change']);

        oSubject.setObserverOnEvent(function () {
            const aItens = oState.getState(DocumentoRegimeEspecialController.sAdicaoItens); 
            DocumentoRegimeEspecialManager.adicaoItens(aItens);
        }, ['on_adicao_itens_change']);

        oSubject.setObserverOnEvent(function () {
            const oitem = oState.getState(DocumentoRegimeEspecialController.sAdicaoItem); 
            DocumentoRegimeEspecialManager.adicaoItem(oitem);
        }, ['on_adicao_item_change']);

        oSubject.setObserverOnEvent(function () {
            const aItens = oState.getState(DocumentoRegimeEspecialController.sLocais); 
            DocumentoRegimeEspecialManager.locais(aItens);

            setTimeout(function(){
                DocumentoRegimeEspecialController.watchLocaisChange();
            }, 1000);

        }, ['on_locais_change']);

        oSubject.setObserverOnEvent(function () {
            const aItens = oState.getState(DocumentoRegimeEspecialController.sAreas); 
            DocumentoRegimeEspecialManager.areas(aItens);

            setTimeout(function(){
                DocumentoRegimeEspecialController.watchAreasChange();
            }, 1000);

        }, ['on_areas_change']);

        oSubject.setObserverOnEvent(function () {
            const aItens = oState.getState(DocumentoRegimeEspecialController.sEnderecos); 
            DocumentoRegimeEspecialManager.enderecos(aItens);
        }, ['on_enderecos_change']);
    },

    watch:function(){
        DocumentoRegimeEspecialController.watchAdicaoChange();
        DocumentoRegimeEspecialController.watchItensChange();
        DocumentoRegimeEspecialController.watchConformeClick();
        DocumentoRegimeEspecialController.watchNaoConformeClick();
        DocumentoRegimeEspecialController.watchImprimirClick();
        DocumentoRegimeEspecialController.watchDesconsolidarClick();
    },

    watchAdicaoChange:function(){
        $('select.lf-adicoes').change(function(){
            const aItens = oState.getState(DocumentoRegimeEspecialController.sAdicoes);
            const iValue = this.value;

            if(Array.isArray(aItens)){
                DocumentoRegimeEspecialManager.adicao(aItens.find(function(value){
                    return value.id == iValue;}));
            }
        });
    },

    watchItensChange:function(){
        $('select.lf-adicao-itens').change(function(){
            const aItens = oState.getState(DocumentoRegimeEspecialController.sAdicaoItens);
            const iValue = this.value;

            if(Array.isArray(aItens)){
                DocumentoRegimeEspecialManager.item(aItens.find(function(value){
                    return value.id == iValue;}));
            }
        });
    },

    watchConformeClick:function(){
        $('.conforme').click(function(){
            const iOrdemServico = $('[name="ordem_servico_id"]').val();
            let formData = $(".lf-item-body .lf-item-body-data .active").find("select,textarea,input").serialize();
            DocumentoRegimeEspecialService.conforme(iOrdemServico, formData);
        });
    },

    watchNaoConformeClick:function(){
        $('.nao-conforme').click(function(){
            const iOrdemServico = $('[name="ordem_servico_id"]').val();
            let formData = $(".lf-item-body .lf-item-body-data .active").find("select,textarea,input").serialize();
            DocumentoRegimeEspecialService.naoConforme(iOrdemServico, formData);
        });
    },

    watchImprimirClick:function(){
        $('.etiqueta').click(function(){
            let iOrdemServico = $('[name="ordem_servico_id"]').val();
            let iOrdemServicoItemId = $(".lf-item-body .lf-item-body-data .active").find(".lf-adicao-id").val();
            iOrdemServico = iOrdemServico ?iOrdemServico: 0;
            iOrdemServicoItemId = iOrdemServicoItemId ? iOrdemServicoItemId: 0;
            window.open(window.url+'OrdemServicoDocumentoRegimeEspeciais/etiqueta/'+
                iOrdemServico+'/'+iOrdemServicoItemId, '_blank').focus();
        });
    },
    
    watchDesconsolidarClick:function(){

        $('.desconsolidar').click(function(){

            const iOrdemServico = $('[name="ordem_servico_id"]').val();
        
            return Swal.fire({

                title: 'Deseja prosseguir?',
                text: 'Os Itens do Documento House serão desconsolidados ao prosseguir',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#41B314',
                cancelButtonColor: '#ac2925',
                confirmButtonText: 'Sim, continuar',
                cancelButtonText: 'Não',
                showLoaderOnConfirm: true

            }).then (result => {

                if (result.dismiss != 'cancel') {
                    const sUrlDesconsolidar = url + 'OrdemServicoDocumentoRegimeEspeciais/desconsolidar/' + iOrdemServico 
                    window.location.href = sUrlDesconsolidar
                    Loader.showLoad();
                } else {
                    return false
                }

            })

        });
    }
};

$(function (){
    DocumentoRegimeEspecialController.init();
});