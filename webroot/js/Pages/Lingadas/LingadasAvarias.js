/*jshint esversion: 6 */

var oLingadasAvarias  = {

    init:function(){
        this.events();
    },

    events:function(){

        $('.save-lingada').blur((event)=>{
           this.save(event);
        });

        $('.mostra-avarias').click((event)=>{
            this.showAvarias(event.target.dataset.id);
        });
    },

    save:function(event){

        const qtdeValue = $(`#qtde-${event.target.dataset.id}`);
        const pesoValue = $(`#peso-${event.target.dataset.id}`);

        if(qtdeValue.val() == qtdeValue.data('value') && pesoValue.val() == pesoValue.data('value')){
            return;
        }

        let form = document.createElement("form");
        form.setAttribute('method', 'POST');
        form.setAttribute('action', event.target.dataset.url);

        let id = document.createElement("input"); 
        id.setAttribute("type", "hidden"); 
        id.setAttribute("name", "id"); 
        id.setAttribute("value", event.target.dataset.id); 

        let qtde = document.createElement("input"); 
        qtde.setAttribute("type", "hidden"); 
        qtde.setAttribute("name", "qtde"); 
        qtde.setAttribute("value", qtdeValue.val()); 
        
        let peso = document.createElement("input"); 
        peso.setAttribute("type", "hidden"); 
        peso.setAttribute("name", "peso"); 
        peso.setAttribute("value", pesoValue.val()); 

        form.appendChild(id);
        form.appendChild(qtde);
        form.appendChild(peso);

        document.querySelector('body').appendChild(form);

        form.submit();
    },

    showAvarias:async function(id){

        oResponse = await $.fn.doAjax({
            'url':`/plano-cargas/avarias/${id}`,
            'type':'get'
        });

        this.renderRespose(oResponse);
    },

    renderRespose:function(oResponse){
        if(oResponse && oResponse.status != 200 && oResponse.dataExtra){
            return;
        }
        const aData = oResponse.dataExtra;
        const sAvariasTemaplate = window.aTemplates.avarias_template;
        const sAvariaFotosTemplate = window.aTemplates.avaria_fotos_template;
        let sResult = this.renderElements(sAvariasTemaplate, 'lista_avarias', aData);

        for (const key in aData) {
            const sResultFotos = this.renderElements(sAvariaFotosTemplate, 'lista_avaria_fotos', aData[key].lingada_avaria_fotos);
            sResult = sResult.replace(`fotos-${aData[key].id}`, sResultFotos);
        }

        $('#report-modal .modal-body').html(sResult);
        $('#report-modal').modal();
    },

    renderElements(sTemplate, sLista, aData){

        let oResponse = new window.ResponseUtil();
        let sListTemplate = '';

        aData.forEach(function(oDataComposicao, sKeyComposicao) {
            oResponse = RenderCopy.render({
                object: oDataComposicao,
                template: sTemplate,
                data_to_render: sLista,
                nested_tree: window.oNestedTree
            });

            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item ' + sKeyComposicao);

            sListTemplate += oResponse.getDataExtra();
        });

        return sListTemplate;
    }

}