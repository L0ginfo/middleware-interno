//mask
$(document).ready(function () {
    $('#numero-documento').mask('00/0000000-0', {reverse: true});
    $('#hora-agendamento').mask('00:00', {reverse: true});
})


$('input,select').each(function () {
    if (this.type != "hidden") {

        var $input = $(this);
        $input.attr("tabindex",  this.offsetTop);

    }
});