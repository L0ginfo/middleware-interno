jQuery( function ($) {

    var SyncModal = {

        //guarda o json recebido via ajax
        jsonRelation: {},

        sync: function (modal_id) {

            //pega as relacoes de modais
            var relacao_veiculos_modais = SyncModal.getJsonRelation();
            var esconde_nao_relacionados = new Array();

            //verifica os options que nao tem relacao com o modal_id selecionado
            for (var relacao in relacao_veiculos_modais) {
                if (relacao_veiculos_modais[relacao].modal != modal_id) {
                    esconde_nao_relacionados.push(relacao_veiculos_modais[relacao].id);
                }
            }

            //remove todos os options:selected
            $('.sync-modal select option').each(function () {
                $(this).removeAttr('selected');                
            });

            //quando clicar num botao de adicionar veiculo, vai importar o id do modal 
            //selecionado atualmente na tela anterior
            $('.sync-modal .btn-save-back').each(function () {
                var link = $(this).attr('href');
                link = link.split('&');
                link[ link.length - 1 ] = 'data-modal=' + modal_id;
                link = link.join('&');
                $(this).attr('href', link);
            });

            //remove o atributo disabled de todos
            $('.sync-modal select option').each(function () {
                $(this).removeAttr('disabled');
            });

            //coloca disabled nos que nao tem relacao com o modal_id selecionado
            $('.sync-modal select option').each(function () {
                var value = $(this).attr('value');

                if (esconde_nao_relacionados.indexOf(parseInt(value)) > -1 && value != '') {
                    $(this).attr('disabled', 'disabled')
                }
            });

            //atualiza o selectpicker
            $('.sync-modal select.selectpicker').each(function() {
                $(this).selectpicker('refresh')
                $(this).selectpicker('render');
            })
            
        },

        //traz a relacao de modais e veiculos para disponibilizar a visualizacao em tela
        //de somente os veiculos que forem do modal selecionado
        getJsonRelation: function () {
            return SyncModal.jsonRelation;
        },

        getRelationAjax: async function () {

            await $.ajax({
                url: url + '/documentacao-entrada/get-veiculos-modais',
                type: 'GET'
            }).success(async function (retorno){
                SyncModal.jsonRelation = retorno;
            });

            return true;
        }
    };

    var ManageRetroativo = {
        minValue: {},
        init: function () {
            ManageRetroativo.minValue = $('.sync-retroativo').attr('min');
            
            $('.is-retroativo').change(function () {
                var value = parseInt( $(this).val() );

                if (value){
                    $('.sync-retroativo').removeAttr('min');
                }else{
                    $('.sync-retroativo').attr('min', ManageRetroativo.minValue);
                }

            });
        }
    };
    
    $(document).ready(function () {
        ManageRetroativo.init();

        Loader.showLoad();
    });

    $(window).load( async function () {

        SyncModal.getRelationAjax();

        await Loader.hideLoad(750);

        //init
        var modal_id = $('select.modal-control').val();  
        var isEdit = $('.edit').size();
        
        if (!isEdit) 
            SyncModal.sync(modal_id);
        
        $('select.modal-control').change(function () {
            modal_id = $(this).val();
            SyncModal.sync(modal_id);
        });
        
    });





});