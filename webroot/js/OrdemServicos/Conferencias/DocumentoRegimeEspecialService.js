var DocumentoRegimeEspecialService = {
    ordemServico:async function(id){
        const oRespose = await $.fn.doAjax({
            url : window.url+'OrdemServicoDocumentoRegimeEspeciais/get/'+id,
            type: 'GET',
        });

        DocumentoRegimeEspecialService.doRespose(oRespose, true);
    },

    conforme:async function(id, data){
        
        const oRespose = await $.fn.doAjax({
            url : window.url+'OrdemServicoDocumentoRegimeEspeciais/conforme/'+id,
            type: 'POST',
            data:data
        });

        DocumentoRegimeEspecialService.doRespose(oRespose);
    },

    naoConforme:async function(id, data){
        const iNaoConform =  $('[name="nao_conforme"]').val();

        const oRespose = await $.fn.doAjax({
            url : window.url+'OrdemServicoDocumentoRegimeEspeciais/naoConforme/'+id,
            type: 'POST',
            data:data
        });

        DocumentoRegimeEspecialService.doRespose(oRespose);

        if(!iNaoConform && !oRespose) {
            setTimeout(function(){
                document.location.reload();
            }, 2000);
        }

        if(!iNaoConform && oRespose.status == 200) {
            setTimeout(function(){
                document.location.reload();
            }, 2000);
        }
    },
    remove:async function(iOSd, id){        
        const oRespose = await $.fn.doAjax({
            url : window.url+'OrdemServicoDocumentoRegimeEspeciais/remove/'+iOSd+'/'+id,
            type: 'POST'
        });

        DocumentoRegimeEspecialService.doRespose(oRespose);
    },

    doRespose: function(oRespose, bNotShow){

        if(!oRespose) {
            Swal.fire({
                title: 'Ops..',
                text: 'Falha na requisição.',
                type: 'error',
                timer: 2000,
                showConfirmButton: false
            });

            return false;
        }

        if(!bNotShow){

            Swal.fire({
                title: oRespose.status ? 'Sucesso': 'Ops...',
                text: oRespose.message,
                type: oRespose.type,
                timer: 2000,
                showConfirmButton: false
            });

        }

        if(oRespose.hasOwnProperty('dataExtra')){

            if(oRespose.dataExtra.hasOwnProperty('adicoes')){
                oState.setState(DocumentoRegimeEspecialController.sAdicoes, oRespose.dataExtra.adicoes); 
            }

            if(oRespose.dataExtra.hasOwnProperty('adicao_itens')){
                oState.setState(DocumentoRegimeEspecialController.sAdicaoItens, oRespose.dataExtra.adicao_itens); 
            }

            if(oRespose.dataExtra.hasOwnProperty('locais')){
                oState.setState(DocumentoRegimeEspecialController.sLocais, oRespose.dataExtra.locais); 
            }

            if(oRespose.dataExtra.hasOwnProperty('areas')){
                oState.setState(DocumentoRegimeEspecialController.sAreas, oRespose.dataExtra.areas); 
            }

            if(oRespose.dataExtra.hasOwnProperty('enderecos')){
                oState.setState(DocumentoRegimeEspecialController.sEnderecos, oRespose.dataExtra.enderecos); 
            }

            if(oRespose.dataExtra.hasOwnProperty('os_doc_itens')){
                oState.setState(DocumentoRegimeEspecialController.sItens, oRespose.dataExtra.os_doc_itens); 
            }

            if(oRespose.dataExtra.hasOwnProperty('desconsolidar')){
                oState.setState(DocumentoRegimeEspecialController.sDesconsolidar, oRespose.dataExtra.desconsolidar); 
            }

        }
    }
};