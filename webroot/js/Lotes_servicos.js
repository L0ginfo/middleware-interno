$(document).ready(function () {
 //    listaFaixa()
    $('#dis').mask('00/0000000-0', {reverse: true});
})

$(document).on('change blur', '#servico', function () {
    var lote = $('#lote-id').val()

    switch ($('#servico select').val()) {
        case '1':
            window.location = webroot + 'loteSolicitacoes/edit/' + '0/' + lote + '/1';
            break;

        case '2':
            break;

        case '3':
            break;

        case '4':
            break;

        case '5':
               window.location = webroot + 'loteSolicitacoes/edit/' + '0/' + lote + '/5';
            break;
            break;

        case '6':
            window.location = webroot + 'loteSolicitacoes/edit/' + '0/' + lote + '/6';
            break;
  
        case '7':
            window.location = webroot + 'loteSolicitacoes/edit/' + '0/' + lote + '/7';
            break;

        case '8':
            window.location = webroot + 'loteSolicitacoes/edit/' + '0/' + lote + '/8';
            break;

        case '9':
            window.location = webroot + 'loteSolicitacoes/edit/' + '0/' + lote + '/9';
            break;


        case '10':
            window.location = webroot + 'loteSolicitacoes/edit/' + '0/' + lote + '/10';
            break;
            
        case '11':
            window.location = webroot + 'loteSolicitacoes/edit/' + '0/' + lote + '/11';
            break;

    }



})



$(document).on('change blur', '#pesquisa_cnt', function () {
    var lote = $('#lote').val()
    var servico_id = $('#tipo-servico-id').val()
    var pesquisacnt = $('#pesquisa-cnt').val()
    window.location = webroot + 'loteSolicitacoes/edit/' + servico_id + '/' + lote + '/10' + '/' + pesquisacnt;
})



$(document).ready(function() {    
    $('#demurge').click(function() {
        if($(this).is(":checked"))
        {
            $('#dv_data_vencimento').show();
        } else {
            $('#dv_data_vencimento').hide();
        }
    });
});


$(document).ready(function() {    
    $('#canal-vermelho').click(function() {
        if($(this).is(":checked"))
        {
            $('#dv_dis').show();
        } else {
            $('#dv_dis').hide();
        }
    });
});

