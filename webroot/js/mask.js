//mask

$(document).ready(function () {
//    $('#peso-liquido').mask('###############', {reverse: true});
    //$('#peso-bruto').maskMoney({ decimal: '', thousands: ',', precision: 3 });  
    //   $('#quantidade').mask('###############', {reverse: true});   

    $("#peso-bruto").keyup(function () {
        var valor = $("#peso-bruto").val().replace(/[^0-9,]+/g, '');
        $("#peso-bruto").val(valor);
    });

    $("#peso-liquido").keyup(function () {
        var valor = $("#peso-liquido").val().replace(/[^0-9,]+/g, '');
        $("#peso-liquido").val(valor);
    });

    $("#quantidade").keyup(function () {
        var valor = $("#quantidade").val().replace(/[^0-9,]+/g, '');
        $("#quantidade").val(valor);
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
})
