//JS para alterar pendencia 
$("#alterar").click(function() { //Jquery faz ação do botao
    var id = $("#id").val();
    var idSaida = $("#id-saida").val();
    var tipoPendencia = $("#tipo").val(); //pega os valores e coloca nas variaveis
    var informacao = $("#info").val();
    
    var dataArray = {
        id: id,
        idSaida: idSaida,
        tipoPendencia: tipoPendencia,
        informacao: informacao,
    };
    $('.ajaxloader').fadeIn(); // icone de loading INICIO

    $.ajax //Ajax busca metodo e passa as variaveis
    ({ 
        url: webroot + 'NotaFiscal/editPendencias/', //link do metodo
        data: dataArray,
        type: "POST",
        success: function (result) {
            $('.ajaxloader').fadeOut(); // icone de loading FIM 
            window.location.reload()
        },
        error: function () {
            $('.ajaxloader').fadeOut(); // icone de loading FIM 
            window.location.reload()
        }
    });
});


//JS popula modal para editar 
$('#myModal3').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var id = button.data('whatever') 
    var recipienttipo = button.data('whatevertipo')
    var recipientinfo = button.data('whateverinfo')  

    var modal = $(this)
    modal.find('.modal-title').text('Editar ' + id)
    modal.find('#id').val(id)
    modal.find('#tipo').val(recipienttipo)
    modal.find('#info').val(recipientinfo)
})

//JS para adicionar pendencia 
$("#salvar").click(function() { //Jquery faz ação do botao
    var id = $("#id-saida").val();
    var tipoPendencia = $("#tipo-pendencia").val(); //pega os valores e coloca nas variaveis
    var informacao = $("#informacao").val();
    
    var dataArray = {
        id: id,
        tipoPendencia: tipoPendencia,
        informacao: informacao,
    };
    $('.ajaxloader').fadeIn(); // icone de loading INICIO

    $.ajax //Ajax busca metodo e passa as variaveis
    ({ 
        url: webroot + 'NotaFiscal/setPendencias/', //link do metodo
        data: dataArray,
        type: "POST",
        success: function (result) {
            $('.ajaxloader').fadeOut(); // icone de loading FIM 
            window.location.reload();
        },
        error: function () {
            $('.ajaxloader').fadeOut(); // icone de loading FIM 
            window.location.reload();
        }
    });
});
