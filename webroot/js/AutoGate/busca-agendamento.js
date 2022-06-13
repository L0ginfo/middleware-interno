$( "#busca-agendamento" ).click(function() { 
    var numeroAgendamento = $("#agendamento-id").val();
    if (!numeroAgendamento) {
        alert("Favor digitar o numero do agendamento");
        return;
    }
    $('.ajaxloader').fadeIn(); 
    $.ajax 
    ({ 
        url: webroot + 'AutoGate/buscaAgendamento/' + numeroAgendamento, 
        type: "POST",
        dataType: 'json',
        success: function (result) {
            console.log(result.comentario);
            document.getElementById('id-agendamento').value = result.id;
            document.getElementById('data-agendamento').value = result.data;
            document.getElementById('hora-agendamento').value = result.hora;
            document.getElementById('cesv-agendamento').value = result.cesv_codigo_sara;
            document.getElementById('CPF-motorista').value = result.CPF_Motorista;
            document.getElementById('nome-motorista').value = result.nome_motorista;
            document.getElementById("comentario-agendamento").value = result.comentario;

            $('.ajaxloader').fadeOut();
        },
        error: function () {
            alert("Nenhum agendamento encontrado");
            $('.ajaxloader').fadeOut();
            window.location.reload();
        }
    });
});