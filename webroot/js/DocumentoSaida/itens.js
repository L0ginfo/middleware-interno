$(".fonte-menor").css("font-size", "12px");
/*
 * JS para listar os itens da pesquisa
 * e adicionar ao documento
 *
 * verifica o tipo de pesquisa, manda para o metodo getContainers()
 * que devolve a lista, o JS monta a tabela e cria o botao para adicionar
 * Ao adicionar o JS chama o metodo addItem() e adiciona na tabela
 */
$( "#botao" ).click(function() { 
    var tipo_pesquisa = $("#tipo_pesquisa").val();
    var pesquisa      = $("#pesquisa").val(); 
    var idSaida       = $("#documentoSaida_id").val();
    var liberacao     = $("#liberacao").val();
    var dataArray     = { tipo_pesquisa: tipo_pesquisa, pesquisa: pesquisa };
    $('.ajaxloader').fadeIn(); 
    $.ajax 
    ({ 
        url: webroot + 'DocumentoSaida/getContainers', 
        data: dataArray,
        type: "POST",
        dataType: 'json',
        success: function (result) {
            var tabela = 
                '<table class="table table-bordered table-hover table-condensed fonte-menor" style="margin-bottom: 0px;">'
                    +'<thead>'
                        +'<tr>'
                            +'<th colspan="1">Protocolo / Lote</th>'
                            +'<th colspan="1">Conhecimento / NF</th>'
                            +'<th colspan="1">Item</th>'
                            +'<th colspan="1">CC / CG</th>'
                            +'<th colspan="1">Descrição</th>'
                            +'<th colspan="1">Vistoriado / Fiscal</th>'
                            +'<th colspan="1">Saldo</th>'
                            +'<th colspan="1">Espécie</th>'
                            +'<th colspan="1">Liberar</th>'
                            +'<th colspan="1">Apreendida</th>'
                            +'<th colspan="1" style="text-align: center;">AÇÃO</th>'
                        +'</tr>'
                    +'</thead>'
                    +'<tbody>';

            for (var i = 0; result.length > i; i++) { 
                var cor = '';
                if (result[i].madeira == 2 || result[i].madeira == 3) {
                    cor = '#FFFD80'; /* amarelo */
                }
                if (result[i].necessita_vistoria == 2 || result[i].necessita_vistoria == 3) {
                    cor = '#FF5454'; /* vermelho */
                }
                if (result[i].liberado_por_nome) {
                    cor = '#4CE32D'; /* verde */
                } else {
                    result[i].liberado_por_nome = "";
                    cor = '#FFFFFF'; /* branco */
                }

                var cg = "CARGA GERAL";
                if (result[i].apr_qtde > 0) {
                    tabela += '<tr class="bast'+i+'" style="background-color: red;">';
                } else {
                    result[i].apr_qtde = 0;
                    tabela += '<tr class="bast'+i+'">';
                }
                tabela +=
                    '<td><span id="latu_lote'+i+'">'+result[i].latu_lote+'</span></td>'
                    +'<td id="lote_conhec'+i+'">'+result[i].lote_conhec+'</td>'
                    +'<td id="latu_item'+i+'">'+result[i].latu_item+'</td>';
                    if (result[i].cnt_id) {
                        tabela += '<td id="cnt_id'+i+'">'+result[i].cnt_id+'</td>'; /* recebe cnt_id */
                    } else {
                        tabela += '<td id="cnt_id'+i+'">'+cg+'</td>'; /* recebe carga geral */
                    }
                    tabela += '<td id="litem_descricao'+i+'">'+result[i].litem_descricao+'</td>'
                    +'<td style="background-color:'+cor+'" id="liberado_por_nome'+i+'">'+result[i].liberado_por_nome+'</td>'
                    +'<td id="latu_qt_saldo'+i+'">'+result[i].latu_qt_saldo+'</td>'
                    +'<td style="display:none" id="dent_id'+i+'">'+result[i].dent_id+'</td>'
                    +'<td id="esp_id'+i+'">'+result[i].esp_id+'</td>';
                    if (result[i].latu_qt_saldo > 0) {
                        if (result[i].cnt_id) {
                            tabela += '<td id="liberar'+i+'">'+1+'</td>';
                        } else {
                            tabela += '<td><input id="liberar'+i+'" class="form-control" type="number" value="'+result[i].latu_qt_saldo+'"></td>'; 
                        }
                    } else {
                        if (result[i].cnt_id) {
                            tabela += '<td id="liberar'+i+'">'+1+'</td>';
                        } else {
                            tabela += '<td><input id="liberar'+i+'" class="form-control" disabled type="number" value="'+result[i].latu_qt_saldo+'"></td>'; 
                        }
                    }
                    // if (result[i].apr_qtde > 0) {
                    //     tabela += '<td id="apr_qtde'+i+'" style="background-color: red;">'+result[i].apr_qtde+'</td>';
                    // } else {
                    //     result[i].apr_qtde = 0;
                        tabela += '<td id="apr_qtde'+i+'">'+result[i].apr_qtde+'</td>';
                    // }
                    if (result[i].latu_qt_saldo > 0) {
                        tabela += '<td style="text-align: center;"><button type="submit" class="meubotao btn btn-success btn-xs" data-index="'+i+'">Adicionar</button></td>';
                    } else {
                        tabela += '<td style="text-align: center;"><button type="submit" disabled class="meubotao btn btn-success btn-xs" data-index="'+i+'">Adicionar</button></td>';
                    }
                tabela += '</tr>';
            } 
            tabela += '</tbody>'
                +'</table>';  
            $('#tabela').append(
                tabela
            ); 

            $(".meubotao").click(function() {  
                var i                 = $(this).data('index');
                var id                = idSaida;
                var latu_lote         = $("#latu_lote"+i).html();
                var lote_conhec       = $("#lote_conhec"+i).html();
                var latu_item         = $("#latu_item"+i).html();
                var cnt_id            = $("#cnt_id"+i).html();
                var litem_descricao   = $("#litem_descricao"+i).html();
                var liberado_por_nome = $("#liberado_por_nome"+i).html();
                var latu_qt_saldo     = $("#latu_qt_saldo"+i).html();
                var apr_qtde          = $("#apr_qtde"+i).html();
                var esp_id            = $("#esp_id"+i).html();
                var dent_id           = $("#dent_id"+i).html();
                var cores             = cor;

                if ($("#liberar"+i).html()) { 
                    var liberar = $("#liberar"+i).html(); /* se for container recebe 1 */
                } else { 
                    var liberar = $("#liberar"+i).val(); /* se for carga geral recebe quantidade digitada */
                }
                if (liberar > latu_qt_saldo) {
                    alert("A quantidade digitada é maior que o saldo");
                    return;
                }

                var dataArray = {
                    id               : id,
                    latu_lote        : latu_lote,
                    lote_conhec      : lote_conhec,
                    latu_item        : latu_item,
                    cnt_id           : cnt_id,
                    litem_descricao  : litem_descricao,
                    liberado_por_nome: liberado_por_nome,
                    latu_qt_saldo    : latu_qt_saldo,
                    apr_qtde         : apr_qtde,
                    esp_id           : esp_id,
                    liberar          : liberar,
                    cores            : cores,
                    dent_id          : dent_id,
                }

                $.ajax 
                ({ 
                    url: webroot + 'DocumentoSaida/addItem/' + id, 
                    data: dataArray,
                    type: "POST",
                    dataType: 'json',
                    success: function (result) {
                        window.location.reload();
                    },
                    error: function () {
                        window.location.reload();
                    }
                });
            });
            /* se for liberação total, ele adiciona os itens automaticamente */
            if (liberacao == 'Total') { 
                $(".meubotao").trigger('click'); 
            }
            $('.ajaxloader').fadeOut(); 
        },
        error: function () {
            alert("Nenhum item encontrado");
            $('.ajaxloader').fadeOut();
        }
    });
});
