//mask
$(document).ready(function () {
    /*  $('#valor-seguro').mask('###.###.###.###.###.##0,00', {reverse: true});
     $('#valor-frete').mask('###.###.###.###.###.##0,00', {reverse: true});
     $('#valor-fob').mask('###.###.###.###.###.##0,00', {reverse: true});
     $('#valor-cif').mask('###.###.###.###.###.##0,00', {reverse: true});*/

    ocultarCampos();

})

$(document).on('change blur', '#codigo-viagem-sara', function () {
    if ($(this).val() == '0') {
        $('#procedencia-id').prop("disabled", false);
        $('#recinto-id').prop("disabled", false);
    } else {
        $('#procedencia-id').prop("disabled", true);
        $('#recinto-id').prop("disabled", true);
    }

})

$(document).on('change blur', '#valor-seguro , #valor-frete, #valor-fob', function () {
    var seguro = $('#valor-seguro').val().replace(".", "").replace(".", "").replace(".", "").replace(".", "")
    seguro = parseFloat(seguro.replace(",", "."))
    var frete = $('#valor-frete').val().replace(".", "").replace(".", "").replace(".", "").replace(".", "")
    frete = parseFloat(frete.replace(",", "."))
    var fob = $('#valor-fob').val().replace(".", "").replace(".", "").replace(".", "").replace(".", "")
    fob = parseFloat(fob.replace(",", "."))


    var cif = 0;
    if (!Number.isNaN(seguro)) {
        cif = cif + seguro
    }
    if (!Number.isNaN(frete)) {
        cif = cif + frete
    }
    if (!Number.isNaN(fob)) {
        cif = cif + fob
    }

    cif = numeroParaMoeda(cif);

    $('#valor-cif').val(cif)
    $('#valor-cif-label').val(cif)

});

function numeroParaMoeda(n, c, d, t)
{
    c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

$('input,select').each(function () {
    if (this.type != "hidden") {

        var $input = $(this);
        $input.attr("tabindex", this.offsetTop);

    }
});

$(document).on('change blur', '#tipo-conhecimento-id', function () {
    ocultarCampos()

}
);

$(document).on('change blur', '#lcl', function () {
    if ($(this).val() == 1) {
        $("#div_ag_master").show("");
    } else {
        $("#div_ag_master").hide("");
    }

}
);
function ocultarCampos() {
    if ($("#tipo-conhecimento-id").val() == '3')
    {
        $("#dmbl").show("");
    } else {
        $("#dmbl").hide("");
        $("#div_ag_master").hide("");
        $('#lcl option')
                .removeAttr('selected')
                .filter('[value=0]')
                .attr('selected', true)
    }

    if ($("#tipo-conhecimento-id").val() == '4')
        $("#camposNF").show("");
    else
        $("#camposNF").hide("")
        $("#campoAdquirente").hide("") // AQUI

}

$('#cnpj_cliente').selectpicker({
    noneResultsText: 'Enviar dados ao COMEX para cadastrar.'
});

$('#cnpj_despachante').selectpicker({
    noneResultsText: 'Enviar dados ao COMEX para cadastrar.'
});

$('#cnpj_representante').selectpicker({
    noneResultsText: 'Enviar dados ao COMEX para cadastrar.'
});

jQuery(function ($) {
    $('form').bind('submit', function () {
        $(this).find(':input').prop('disabled', false);
    });
});