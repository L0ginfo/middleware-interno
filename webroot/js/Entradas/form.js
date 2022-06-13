//mask
$(document).ready(function () {
 //    listaFaixa()
    $('.numerodocumento').mask('00/0000000-0', {reverse: true});
    
    $('#numero-documento').mask('00/0000000-0', {reverse: true});
    $('#hora-agendamento').mask('00:00', {reverse: true});
})


$('input,select').each(function () {
    if (this.type != "hidden") {

        var $input = $(this);
        $input.attr("tabindex", this.offsetTop);

    }
});


$('#data-agendamento').change(function (e) {
  //  listaFaixa()

})
$('#hora-agendamento').change(function (e) {
   //  $('#hora-banco').val($('#hora-agendamento').val())

})

function listaFaixa() {

    input = $('#data-agendamento')
    horapadrao = $('#hora-banco').val()
     $('.ajaxloader').fadeIn()
    $.ajax({
        url: webroot + 'horarios/getfaixahorario/' + escapeHtml(input.val()) + '/2',
        type: "post",
        //data: $('form').serialize(),
        success: function (data) {
            var $select = $('#hora-agendamento');
            $select.find('option').remove();
            $.each(JSON.parse(data), function (key, value)
            {
                if (key == horapadrao)
                    $select.append('<option value=' + key + ' selected >' + value + '</option>');
                else
                    $select.append('<option value=' + key + '>' + value + '</option>');
            });

            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown)
            location.reload()
        }
    })
}

$('#operacao-id').on('change', function () {
    if (this.value != '1') {
        $('#entrada-id').val('')
        $('#entrada-id').hide()
        $("label[for=entrada-id]").hide()
    } else
    {
        $('#entrada-id').show(5)
        $("label[for=entrada-id]").show(5)
    }
});
function escapeHtml(unsafe) {
    return unsafe
            .replace(/\//g, "-")
}
 