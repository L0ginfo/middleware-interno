$("#capturar-pesagem").click(function() { 
    $('.ajaxloader').fadeIn(); 
    $.ajax 
    ({ 
        url: webroot + 'AutoGate/buscaPesagemBalanca', 
        // data: dataArray,
        type: "POST",
        dataType: 'json',
        success: function (result) {
            document.getElementById('auto-pesagem').value = result;
        },
        error: function () {
            alert("Não foi possivel capturar a pesagem.");
        }
    })
    $('.ajaxloader').fadeOut();
});