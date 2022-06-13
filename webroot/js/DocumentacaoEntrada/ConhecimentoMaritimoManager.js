ConhecimentoMaritimoManager ={

    init:async function(){
        ConhecimentoMaritimoManager.doTipoDocumento();
        ConhecimentoMaritimoManager.manageSelectPickersAjax();
        ConhecimentoMaritimoManager.events();
    },

    events:async function(){
        $('select.tipo_documento_change').change(function(){
            ConhecimentoMaritimoManager.doTipoDocumento();
        });

        $('.add-data.house').click(function(){
            ConhecimentoMaritimoManager.doTipoDocumento();
        });
    },

    showInputs:async function(){
        await Utils.waitMoment(200);
        $('.hidden_ce').show();
        $('.hidden_ncm').show();
        $('.copy-inputs .hidden_ce.required input')
            .attr('required', 'required');
        $('.copy-inputs .hidden_ncm.required select')
            .attr('required', 'required');
    },

    hideInputs:async function(){
        await Utils.waitMoment(200);
        $('.hidden_ce').hide();
        $('.hidden_ncm').hide();
        $('.copy-inputs .hidden_ce.required input')
            .removeAttr('required');
        $('.copy-inputs .hidden_ncm.required select')
            .removeAttr('required');
    },

    doTipoDocumento:async function($this){
        var sTipoDocumento = $('select.tipo_documento_change').find('option:selected').text();
        if (sTipoDocumento === 'BL' || sTipoDocumento === 'MANIFESTO') {
            ConhecimentoMaritimoManager.showInputs();
        }else{
            ConhecimentoMaritimoManager.hideInputs();
        }
    },

    manageSelectPickersAjax: function() {
        $('.owl-item .selectpickerAjaxNcms:not(.included-trigger-selectpicker)').each(function() {
            $(this).addClass('included-trigger-selectpicker');
            Utils.doSelectpickerAjax(
                $(this), url + '/ncms/filterQuerySelectpicker', {}, {"busca":"{{{q}}}", "limit": 3}
            );
        });
        Utils.fixSelectPicker();
    },

    initNcm:function () {
        $('.search-ncm:visible:first').css("margin-top", "25px");
        $('.search-ncm').click(function(){

            const eFather = $(this).closest(".input-group");
            const id =  eFather.find('input[type=hidden]').attr('name');
            const descricao = eFather.find('input[type=text]').attr('name');
            let sTemplate = window.templates.modal_ncm;
            sTemplate = sTemplate.replace('__id__', id);
            sTemplate = sTemplate.replace('__descricao__', descricao);
            console.log(id, descricao);
            ConhecimentoMaritimoManager.__showModalPage(sTemplate);
            ConhecimentoMaritimoManager.close();
        });
    },

    close:function(){
        $('.modal-ncm .modal-ncm-close button').click(function(){
            const id = $(this).data('id');
            const descricao = $(this).data('descricao');
            const sText = $( '[name="modal_ncm_id"] option:selected' ).text();
            const sVal = $('[name="modal_ncm_id"]').val();

            if(!sVal) {
                return Utils.swalUtil({
                    title:'Ops..',
                    text:'Por favor, seleciona um ncm antes de salvar',
                    timer:4000
                });
            }
            $(`[name="${id}"]`).val(sVal);
            $(`[name="${descricao}"]`).val(sText);
            $('#modal-save-back').modal('hide');
        });
    },

    __showModalPage:function(sPageContent){
        if(!sPageContent) return false;
        const sTitle = 'Pesquisar ncm';
        $('#modal-save-back .modal-header .modal-title .modal-title-ajax')
            .remove();
        $('#modal-save-back .modal-header .modal-title')
            .prepend(`<span class="modal-title-ajax" style="font-size:36px"><b>${sTitle}</b></span>`);
        $('#modal-save-back .modal-body')
            .html(sPageContent);
        $('#modal-save-back .selectpicker').selectpicker('refresh');
        $('#modal-save-back').modal();
        return true;
    }
}


$(function() {
    ConhecimentoMaritimoManager.init();
});