$("#botao").click(function() { 
    /* 
     * desabilita o botao para nao poder pesquisar novamente sem limpar
     * Se houver pesquisa sem limpar a antiga os data-index vao se repetir 
     * e vai adicionar itens a mais ao clicar no botao 
     */
    $(this).attr({
        disabled: true,
        title: "Limpe a Pesquisa",
    });
    var agendamento_id  = $("#agendamento_id").val();
    var nota_fiscal     = $("#nota_fiscal").val();
    var nome_emitente   = $("#nome_emitente").val();   
    var adicionar_itens = $("#adicionar_itens").val(); 
    var dataArray = { 
        agendamento_id: agendamento_id, 
        nota_fiscal   : nota_fiscal, 
        nome_emitente : nome_emitente 
    };
    $('.ajaxloader').fadeIn(); 
    $.ajax 
    ({
        url     : webroot + 'NotaFiscal/getNotas', 
        data    : dataArray,
        type    : "POST",
        dataType: 'json',
        success: function (result) {
            var b = 0; // Contador dos itens das notas (assim se houver mais notas o data-index dos itens nao vao se repetir)
                var cabecalho =
                '<table class="table table-bordered table-hover table-condensed" style="margin-bottom: 0px;">'
                    +'<thead>'
                        +'<tr>'
                            +'<th style="width:8%;">Nº Nota</th>'
                            +'<th style="width:8%;">Nº Item</th>'
                            +'<th style="width:31%;">Nome Emitente</th>'
                            +'<th style="width:10%;">Cod. Produto</th>'
                            +'<th style="width:20%;">Desc. Produto</th>'
                            +'<th style="width:5%;">CFOP</th>'
                            +'<th style="width:10%;">Qtd. Unitária</th>'
                            +'<th style="width:5%;">NCM</th>';
                            if (result['adicionar'] == true) {
                                cabecalho += '<th style="width:5%; text-align: center;">AÇÃO</th>';
                            }
                        cabecalho += '</tr>'
                    +'</thead>'
                    +'<tbody id="pesquisa_tabela">';
            $('#tabela').append(
                cabecalho
            );
            // varre as notas fiscais
            for (var i = 0; result['result'].length > i; i++) { 
                // varre os itens das notas fiscais
                for (var c = 0; result['result'][i].nota_fiscal_item.length > c; c++) {
                    if (result['result'][i].nota_fiscal_item[c].quantidade_unitaria > 0 /*& result['result'][i].nota_fiscal_item[c].agendado != 1*/) {
                        var tabela =
                            '<tr class="bast'+b+'">'
                                +'<td id="nota_id'+i+'">'+result['result'][i].numero_documento+'</td>'
                                +'<td id="numero_item'+b+'">'+result['result'][i].nota_fiscal_item[c].numero_item+'</td>'
                                +'<td id="nome'+i+'">'+result['result'][i].empresa.nome+'</td>'
                                +'<td id="codigo_produto'+b+'">'+result['result'][i].nota_fiscal_item[c].codigo_produto+'</td>'
                                +'<td id="descricao_produto'+b+'">'+result['result'][i].nota_fiscal_item[c].descricao_produto+'</td>'
                                +'<td id="cfop'+b+'">'+result['result'][i].nota_fiscal_item[c].cfop+'</td>';
                                if (result['adicionar'] == true) {
                                    tabela += '<td><input id="quantidade_unitaria'+b+'" class="form-control" type="number" value="'+result['result'][i].nota_fiscal_item[c].quantidade_unitaria+'"></td>';
                                } else {
                                    tabela += '<input id="quantidade_unitaria'+b+'" class="form-control" type="hidden" value="'+result['result'][i].nota_fiscal_item[c].quantidade_unitaria+'">';
                                    tabela += '<td id="quantidade_unitaria'+b+'">'+result['result'][i].nota_fiscal_item[c].quantidade_unitaria+'</td>';
                                }
                                tabela += '<td id="ncm'+b+'">'+result['result'][i].nota_fiscal_item[c].ncm+'</td>'
                                +'<input id="quantidade_unitaria_disponivel'+b+'" type="hidden" value="'+result['result'][i].nota_fiscal_item[c].quantidade_unitaria+'">'
                                +'<td style="display:none;" id="item_id'+b+'">'+result['result'][i].nota_fiscal_item[c].id+'</td>';
                                if (result['adicionar'] == true) {
                                    tabela += '<td style="text-align: center; vertical-align: middle !important"><button type="submit" class="meubotao btn btn-success btn-xs" data-index="'+b+'">Adicionar</button></td>';
                                } else {
                                    tabela += '<td style="display:none;"><button type="submit" class="meubotao btn btn-success btn-xs" data-index="'+b+'">Adicionar</button></td>';
                                }
                            tabela += '</tr>';
                        $('#pesquisa_tabela').append(  
                            tabela
                        );
                        b++
                    }
                } 
            }
            rodape = '</tbody>';
            if (result['adicionarTodos'] == true) {
                rodape += '<button class="btn btn-success btn-block" id="adicionar-tudo" style="border-radius: 0px;">Adicionar Tudo</button>';
            }
            rodape += '</table>';
            $('#tabela').append(
                rodape 
            );
            $(".meubotao").click(function() { 
                $('.ajaxloader').fadeIn();  
                var i                              = $(this).data('index');
                var id_agendamento                 = agendamento_id;
                var quantidade_unitaria            = parseInt($("#quantidade_unitaria"+i).val()); 
                var quantidade_unitaria_disponivel = parseInt($("#quantidade_unitaria_disponivel"+i).val()); 
                var item_id                        = $("#item_id"+i).html();
                if (quantidade_unitaria > quantidade_unitaria_disponivel) {
                    alert("Quantidade inválida, O máximo para esse item é de: " + quantidade_unitaria_disponivel);
                    $('.ajaxloader').fadeOut();
                    return
                }
                var dataArray = {
                    id_agendamento     : id_agendamento,
                    quantidade_unitaria: quantidade_unitaria,
                    item_id            : item_id,
                };
                $.ajax 
                ({ 
                    url     : webroot + 'Agendamentos/addItemNotaFiscal/', 
                    data    : dataArray,
                    type    : "POST",
                    dataType: 'json',
                    success: function (result) {
                        $('.ajaxloader').fadeOut();
                        window.location.reload();
                    },
                    error  : function () {
                        $('.ajaxloader').fadeOut();
                        window.location.reload();
                    }
                });
            });
            // Se for Adicionar Tudo, ele adiciona todos os itens automaticamente
            $("#adicionar-tudo").click(function() { 
                $(".meubotao").trigger('click');
            });
            $('.ajaxloader').fadeOut();
        },
        error: function () {
            alert("Nenhum item encontrado");
            $('.ajaxloader').fadeOut();
            window.location.reload();
        }
    });
});

$(document).ready(function() {
    $('#veiculo').keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });
    $('#reboque1').keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });
    $('#reboque2').keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });

    $('#veiculo').mask('XXXXXXX', {
        'translation': {
            X: {pattern: /[A-Za-z0-9]/}
        }
    });
    $('#reboque1').mask('XXXXXXX', {
        'translation': {
            X: {pattern: /[A-Za-z0-9]/}
        }
    });
    $('#reboque2').mask('XXXXXXX', {
        'translation': {
            X: {pattern: /[A-Za-z0-9]/}
        }
    });
});

// const validaPlacaVeicule = (placa) => {
//     var padrao = /^[a-zA-Z]{3}\d{4}$/;
//     var OK = padrao.exec(placa);
//     if (placa != '') {
//         if (!OK) {
//             window.alert("Placa do veiculo esta no formato incorreto!");
//             document.getElementById("veiculo").value = "";
//             return false;
//         }
//     }
// };

// const validaPlacaReboque1 = (placa) => {
//     var padrao = /^[a-zA-Z]{3}\d{4}$/;
//     var OK = padrao.exec(placa);
//     if (placa != '') {
//         if (!OK) {
//             window.alert("Placa do reboque 1 esta no formato incorreto!");
//             document.getElementById("reboque1").value = "";
//             return false;
//         }
//     }
// };

// const validaPlacaReboque2 = (placa) => {
//     var padrao = /^[a-zA-Z]{3}\d{4}$/;
//     var OK = padrao.exec(placa);
//     if (placa != '') {
//         if (!OK) {
//             window.alert("Placa do reboque 2 esta no formato incorreto!");
//             document.getElementById("reboque2").value = "";
//             return false;
//         }
//     }
// };
