jQuery(function ($) {
    
    var Area = {
        carregaComposicoes: function () {
            var area_id = $('#area-id').val();
            
            $('.composicao.linha').addClass('hidden');
            $('.composicao.linha.hidden').find('.form-control').attr('disabled', 'disabled');
            $('.composicao.linha.hidden').find('.form-control.field-composicao').attr('required', 'required');
            $('.composicao.msg.hidden').removeClass('hidden');
            
            $.ajax({
                method: "POST",
                url: url + "/enderecos/buscaComposicoes",
                data: { id: area_id }
            })
            .done(function( response ) {
                
                if (response && response.tipo_estrutura){
                    var tipo_estrutura = response.tipo_estrutura;
                    
                    $('.composicao.msg').addClass('hidden');
                    
                    for (var composicao in tipo_estrutura) {

                        if (tipo_estrutura[composicao] && tipo_estrutura[composicao] != "") {
                            $('#'+composicao+'-text').removeAttr('disabled');
                            $('#'+composicao+'-de').removeAttr('disabled');
                            $('#'+composicao+'-ate').removeAttr('disabled');
                            $('#'+composicao+'-de').attr('required', 'required');
                            $('#'+composicao+'-ate').attr('required', 'required');
                            $('#'+composicao+'-text').val(tipo_estrutura[composicao]);
                            $('#'+composicao+'-text').closest('tr.composicao.linha').removeClass('hidden');
                        }
                    }
                }
            });
        }
    };

    $(window).load(function() {
        Area.carregaComposicoes();

        $(".field-composicao").maskMoney({
            precision: 4,
            decimal: ''
        });
        
    });

    $('#area-id').change(function() {
        Area.carregaComposicoes();
    });
    
    


    

});