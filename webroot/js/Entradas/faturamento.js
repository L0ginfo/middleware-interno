

$('.calcular_faturamento').change(function (e) {
    var input = $(this);
    taxa = input.attr("taxa");
    linha = input.attr("linha");
    valor = parseFloat(input.val());
    calulo = (valor * (taxa / 100)) + valor;

    $('#faturado_' + linha).val(calulo)



})


$('.salvar_faturamento').click(function (e) {
    var input = $(this);
    linha = input.attr("linha");
    gerarfatura = input.attr("gerarfatura");

    s = "#entrada_" + linha



    id = $("#fatura_repasse_id_" + linha).val();
    entrada_id = $("#entrada_" + linha).val()
    lote_id = $("#lote_" + linha).val()
    valor_area_primaria = $("#valor_" + linha).val()
    valor_final = $("#faturado_" + linha).val()
    parceiro_id = $("#parceiro_id_" + linha).val()
    taxa_administrativa = $("#taxa_" + linha).val()
    codviagem = $("#codviagem_" + linha).val()
    recinto = $("#recinto").val()
    //console.log('faturamentoDtcRepasse/edit/' + id + '/' + gerarfatura + '/' + entrada_id + '/' + lote_id + '/' + valor_area_primaria + '/' + valor_final + '/' + parceiro_id + '/' + taxa_administrativa + '/' + codviagem + '/' + recinto);

    $('.ajaxloader').fadeIn()
    $.ajax({
        url: webroot + 'faturamentoDtcRepasse/edit/' + id + '/' + gerarfatura + '/' + entrada_id + '/' + lote_id + '/' + valor_area_primaria + '/' + valor_final + '/' + parceiro_id + '/' + taxa_administrativa + '/' + codviagem + '/' + recinto,
        type: "post",
        data: $('form').serialize(),
        success: function (data) {
            window.location = webroot + 'entradas/faturamento-editar/' + codviagem
            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    })
})


$('.alterar_faturamentoMoeda').change(function (e) {
    var input = $(this);
    linha = input.attr("linha");
    cotacao = $("#cotacao-" + linha).val(0)
    altera(input, 'moeda');
})

$('.alterar_faturamentoCotacao').click(function (e) {
    var input = $(this);
    linha = input.attr("linha");
    altera(input, 'cotacao');
})
$('.alterar_faturamentoValor').click(function (e) {
    var input = $(this);
    linha = input.attr("linha");
    altera(input, 'valor');
})

function altera(input, tipo) {

    linha = input.attr("linha");

    s = "#entrada_" + linha

    valorcif = $("#valorcif-" + linha).val();
    moedaid = $("#moeda-id-" + linha).val();
    lote_id = $("#lote_" + linha).val()
    codviagem = $("#codviagem_" + linha).val()
    quantidadeCNT = $("#quantidadecnt-" + linha).val()
    cotacao = $("#cotacao-" + linha).val()
    $('.ajaxloader').fadeIn()
    $.ajax({
        url: webroot + 'entradas/faturamentoAlterarcif/' + tipo + '/' + lote_id + '/' + moedaid + '/' + cotacao + '/' + valorcif + '/' + quantidadeCNT+'/'+linha,
        type: "post",
        data: $('form').serialize(),
        success: function (data) {
            console.log( JSON.parse(data))
            linharet = data
            window.location = webroot + 'entradas/faturamento-editar/' + codviagem+ '/0/0/'+linharet
            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    })

}
