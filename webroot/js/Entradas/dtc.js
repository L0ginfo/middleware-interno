//mask
$(document).ready(function () {
    //    listaFaixa()
    $('.numerodocumento').mask('00/0000000-0', {reverse: true});
})


$('#codigo-viagem-sara').change(function (e) {
    input = $('#codigo-viagem-sara')
    window.location = webroot + 'entradas/dtc/' + input.val();
})

$(function () {

    $('#todos_trans').on('change', function () {
        var selected = $(this).find("option:selected").val();
        //   alert(selected);
        $('.selectpicker').each(function () {
          
               //alert($(this).val());
            if ($(this).val() === '' || $(this).val() === undefined || $(this).val() === null) {
                  //alert(selected)
                  $(this).val(selected)
                  $(this).selectpicker('refresh');
            }
        });
    });



});

