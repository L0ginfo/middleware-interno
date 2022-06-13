$(document).ready(function () {
    $("#barcode").focus();
    
    $(".transito").click(function () {
        $('.ajaxloader').fadeIn()

        var campo_texto;
        var input = $(this);
        campo_texto = $(this).text();
        var id_ag = $(this).attr('id_ag');
        var data_atual;
        var hora_atual;
        var url;
        var hora_atual_string;
        $('#hora_inicio_' + id_ag).text(data_atual)

        if ($(this).text() != 'Sim') {
            if (confirm("Deseja mesmo cancelar este inicio de transito")) {
                campo_texto = 'Sim'
                $('#hora_' + id_ag).show()
                $('#data_' + id_ag).show()
                $('#bt_cancela_' + id_ag).hide()
                $('#bt_inicia_' + id_ag).show()
                id = "bt_cancela_' . $agendamento->id . '"
                hora_atual_string = ''
                $('#data_inicio_' + id_ag).text('')
                $('#status_' + id_ag).text('Aguardando inicio transito')
                url = webroot + 'agendamentos/transito/' + id_ag + "/0"
            }
        } else {
            campo_texto = 'Cancelar'
            data_atual = $('#data_' + id_ag).val()
            hora_atual = $('#hora_' + id_ag).val()
            $('#hora_' + id_ag).hide()
            $('#data_' + id_ag).hide()
            hora_atual_string = $('#data_' + id_ag).val() + ' ' + $('#hora_' + id_ag).val()
            $('#data_inicio_' + id_ag).text(hora_atual_string)
            $('#status_' + id_ag).text('Aguardando confirmação de entrada')
            $('#bt_cancela_' + id_ag).show()

            $('#bt_inicia_' + id_ag).hide()

            data_atual = data_atual.replace('/', '-')
            data_atual = data_atual.replace('/', '-')
            hora_atual = hora_atual.replace(':', '-')

            url = webroot + 'agendamentos/transito/' + id_ag + "/1/" + data_atual + "/" + hora_atual
        }
        
        if (campo_texto !== input.text()) {
            $.ajax({
                url: url,
                type: "post",
                //data: $('form').serialize(),
                success: function (data) {
                    $('.ajaxloader').fadeOut()



                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('.ajaxloader').fadeOut()
                    alert("Erro ao gravar a alteração.")
                }
            })
        } else {
            $('.ajaxloader').fadeOut()
        }

    });
});
var myVar;
$('#barcode').keydown(function () {
    myVar = setTimeout(ir_agendamento, 2000);
});

function ir_agendamento() {
    if ($('#barcode').val().length > 3) {
        // window.location.href = $('#url_view').val() + "agendamentos/view/" + $('#barcode').val(),
        $.ajax({
            url: webroot + "agendamentos/view/" + $('#barcode').val(),
            type: "post",
            data: $('form').serialize(),
            success: function (data) {
                clearInterval(myVar);
                $('#wrapper').html(data)
                $('.ajaxloader').fadeOut()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                
            }
        });
    }

    clearInterval(myVar);
}

$('.pesquisar').change(function () {
    var tela = 'transito';

    if ($('#tela').val() == 'triagem') {
        tela = 'triagem';
    }

    var previsao = $('#previsao').val()
    var operacao = $('#operacao').val()
    var documento = $('#documento').val()
    var barcode = $('#barcode').val()
    var codigo_viagem_sara = $('#codigo_viagem_sara').val()
    documento = documento.replace('/', '-')

    var cnt = $('#cnt').val()
    cnt = cnt.replace('/', '-')

    var placa = $('#placa').val()
    var situacao = $('#situacao').val()

    if ($(this).attr('id') == 'codigo_viagem_sara' && codigo_viagem_sara == 'todos') {
        var url_transito = webroot + 'agendamentos/' + tela
    } else {
        if (codigo_viagem_sara == 'todos') {
            codigo_viagem_sara = ''
        }
        var url_transito = webroot + 'agendamentos/' + tela + '/0/0/0/0/' +
                previsao + '|' + operacao + '|' + documento + '|' + cnt + '|' + placa + '|' + situacao + '|' + codigo_viagem_sara + '|' + barcode
    }

    $('.ajaxloader').fadeIn();
    $.ajax({
        url: url_transito,
        type: "post",
        data: $('form').serialize(),
        success: function (data) {
            $('#wrapper').html(data)
            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown)
            location.reload()
        }
    });
});