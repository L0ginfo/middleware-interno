$(document).ready(function () {

    $("#peso-bruto").keyup(function () {
        var valor = $("#peso-bruto").val().replace(/[^0-9,]+/g, '');
        $("#peso-bruto").val(valor);
    });

    $("#peso-liq").keyup(function () {
        var valor = $("#peso-liq").val().replace(/[^0-9,]+/g, '');
        $("#peso-liq").val(valor);
    });

    $("#quantidade").keyup(function () {
        var valor = $("#quantidade").val().replace(/[^0-9,]+/g, '');
        $("#quantidade").val(valor);
    });

    $("#adicao").keyup(function () {
        var valor = $("#adicao").val().replace(/[^0-9,]+/g, '');
        $("#adicao").val(valor);
    });
    
    $("#valor-seguro").keyup(function () {
        var valor = $("#valor-seguro").val().replace(/[^0-9,]+/g, '');
        $("#valor-seguro").val(valor);
    });
    
    $("#valor-frete").keyup(function () {
        var valor = $("#valor-frete").val().replace(/[^0-9,]+/g, '');
        $("#valor-frete").val(valor);
    });
    
    $("#valor-fob").keyup(function () {
        var valor = $("#valor-fob").val().replace(/[^0-9,]+/g, '');
        $("#valor-fob").val(valor);
    });

    $("#valor-cif").keyup(function () {
        var valor = $("#valor-cif").val().replace(/[^0-9,]+/g, '');
        $("#valor-cif").val(valor);
    });

})

/*
 * Mascaras para numero do documento
 * e se tiver entreposto ou parte tambem 
 */
$(document).ready(function () {
    $('.daentreposto').mask('00/0000000-0', {reverse: true});
    $('#da-entreposto').mask('00/0000000-0', {reverse: true});
})
// $(document).ready(function () {
//     $('.numeroblparte').mask('00/0000000-0', {reverse: true});
//     $('#numero-bl-parte').mask('00/0000000-0', {reverse: true});
// })
$(document).ready(function () {
    $('.numerodiparte').mask('00/0000000-0', {reverse: true});
    $('#numero-di-parte').mask('00/0000000-0', {reverse: true});
})
$(document).ready(function () {
    $('.docsaida').mask('00/0000000-0', {reverse: true});
    $('#doc-saida').mask('00/0000000-0', {reverse: true});
})
$(document).ready(function () {
    $('.dataregistro').mask('00/00/0000 00:00', {reverse: true});
    $('#data-registro').mask('00/00/0000 00:00', {reverse: true});
})
$(document).ready(function () {
    $('.datadesembaraco').mask('00/00/0000 00:00', {reverse: true});
    $('#data-desembaraco').mask('00/00/0000 00:00', {reverse: true});
})

/* Mascara para campos Valor */ 
// $(document).on('change blur', '#valor-seguro , #valor-frete, #valor-fob', function () {
//     $('#valor-seguro').val().replace(".", "").replace(".", "").replace(".", "").replace(".", "")
//     $('#valor-frete').val().replace(".", "").replace(".", "").replace(".", "").replace(".", "")
//     $('#valor-fob').val().replace(".", "").replace(".", "").replace(".", "").replace(".", "")
// });
