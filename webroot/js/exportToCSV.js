$(document).ready(function () {
    $('#resultados').DataTable({
        lengthMenu: [[10, 30, 50, -1], [10, 30, 50, "Todos"]],
        "scrollY": "330px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging": false,
        //   dom: 'Bfrtipl', l->resuultado por paginda   t->tabela  B->botao f->pesquisa  i->Mostrando de 1 até 10 de 49 registro r-> ???  p-> paginacao
        dom: '<"col-sm-5"B>f<"clear">t<"col-sm-4"i>p',
        "columnDefs": [
            {
                "targets": [0],
                "visible": true,
                "searchable": false
            },
            {
                "targets": [1, 2],
                "visible": true,
                "searchable": true
            },
            {
                "targets": [3],
                "visible": false,
                "searchable": true
            }
        ],
        stateSave: true,
        buttons: [
            {
                extend: 'colvis',
                text: 'Colunas',
            },
            {
                extend: 'copyHtml5',
                text: '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i>',
                titleAttr: 'Imprimir',
                exportOptions: {
                    columns: ':visible'
                }
            },
        ],
        "paging": true,
        language: {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            colvis: 'Visualizar',
            "sEmptyTable": "Vazio",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        }
    });

    /*- -*/
    $('#resultados_pack').DataTable({
        lengthMenu: [[20, 30, 50, -1], [20, 30, 50, "Todos"]],
        //   dom: 'Bfrtip', t->tabela  B->botao f->pesquisa  i->Mostrando de 1 até 10 de 49 registro r-> ???  p-> paginacao
        dom: '<"col-sm-2 left"f><"col-sm-10 left"><"clear">t<"col-sm-4"i>p',
        "columnDefs": [
            {
                "targets": [0],
                "visible": true,
                "searchable": true
            },
            {
                "targets": [1],
                "visible": true,
                "searchable": true
            },
        ],
        stateSave: true,
        buttons: [
            {
                extend: 'colvis',
                text: 'Colunas',
            },
            {
                extend: 'copyHtml5',
                text: '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i>',
                titleAttr: 'Imprimir'
            },
        ],
        "paging": true,
        language: {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            colvis: 'Visualizar',
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        }
    });
    $('#resultados_pack tbody').on('change', '#qt_carregada', function () {
        selecionarPack($(this));
    });

    /*- -*/
    $('#selecionadosItens').DataTable({
        destroy: true,
        searching: false,
        dom: '',
        "ajax": webroot + 'agendamentos/jsonListacarregados/' + $('#agendamento_id').val(),
        "columns": [
            {"data": "lote"},
            {"data": "pack_bobina"},
            {"data": "peso"},
        ],
        language: {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            colvis: 'Visualizar',
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        }
    });

    /*- -*/
    $('#resultados_movimentacao').DataTable({
        lengthMenu: [[20, 30, 50, -1], [20, 30, 50, "Todos"]],
        "scrollY": "225px",
        "scrollX": true,
        "scrollCollapse": true,
        columnDefs: [
            {type: 'de_datetime', targets: 7},
        ],
        // dom: 'Bfrtip', t->tabela  B->botao f->pesquisa  i->Mostrando de 1 até 10 de 49 registro r-> ???  p-> paginacao
        dom: '<"col-sm-2"l>f<"clear"><"col-sm-4"B>t<"col-sm-3"i><"col-sm-5"p>',
        stateSave: true,
        buttons: [
            {
                extend: 'colvis',
                text: 'Colunas',
            },
            {
                extend: 'copyHtml5',
                text: '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i>',
                titleAttr: 'Imprimir',
                exportOptions: {
                    columns: ':visible'
                },
                title: function () {
                    return 'Agendamentos <span style="font-size: 14px">' + $('#atual').val() + '</span>'
                }
            },
        ],
        "paging": true,
        language: {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            colvis: 'Visualizar',
            "sEmptyTable": "Vazio",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        }
    });
    $('#atualizar_movimentacao').click(function (e) {
        var table = $('#resultados_movimentacao').DataTable();
        table.search('').columns().search('').draw();
        window.location = webroot + 'agendamentos/movimentacao/' + $('#operacao').val() + '/' + $('#situacao').val();
    });

    /*- -*/
    $('#resultados_triagem').DataTable({
        lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
        "scrollY": "330px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging": false,
        // dom: 'Bfrtipl', l->resuultado por paginda   t->tabela  B->botao f->pesquisa  i->Mostrando de 1 até 10 de 49 registro r-> ???  p-> paginacao
        dom: '<"col-sm-5"B>f<"clear">t<"col-sm-4"i>p',
        "order": [[1, "desc"]],
        stateSave: true,
        buttons: [
            {
                extend: 'colvis',
                text: 'Colunas',
            },
            {
                extend: 'copyHtml5',
                text: '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i>',
                titleAttr: 'Imprimir'
            },
        ],
        "paging": true,
        language: {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            colvis: 'Visualizar',
            "sEmptyTable": "Vazio",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        }
    });

    /*- -*/
    $('#resultados_lotesolicitacoes').DataTable({
        lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
        "scrollY": "330px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging": false,
        // dom: 'Bfrtipl', l->resuultado por paginda   t->tabela  B->botao f->pesquisa  i->Mostrando de 1 até 10 de 49 registro r-> ???  p-> paginacao
        dom: '<"col-sm-5"B>f<"clear">t<"col-sm-4"i>p',
        "order": [[1, "desc"]],
        stateSave: true,
        buttons: [
            {
                extend: 'colvis',
                text: 'Colunas',
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i>',
                titleAttr: 'Imprimir'
            },
        ],
        "paging": true,
        language: {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            colvis: 'Visualizar',
            "sEmptyTable": "Vazio",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        }
    });
});

// $agendamento_id, $empresa_id, $lote, $doc_saida, $item,$doc_id=null, $pack = null

function selecionarPack(input) {
    var qt_carregada = input.val();
    var pack = input.attr('pack');
    var cnt_id = input.attr('cnt_id');
    var peso = input.attr('peso');
    var cod_cliente = $('#cod_cliente').val();
    var empresa_id = $('#empresa_id').val();
    var lote = input.attr('lote');
    var doc_saida = input.attr('doc_saida');
    var doc_sara = $('#doc_sara').val();
    var num = input.attr('num');
    var doc_id = $('#doc_id').val();
    var agendamento_id = $('#agendamento_id').val();
    var maximo_liberado = $('#maximo_liberado').val();
    var data_agendamento = $('#data_agendamento').val();
    var peso_penhor = $('#peso_penhor').val();
    var saldo = $('#saldo').val();
    // alert(doc_sara)
    if (input.val() > 0) {
        $('#linha_situacao_' + input.attr('linha')).html('Agendado');
    } else {
        $('#linha_situacao_' + input.attr('linha')).html('');
    }
    
    var dataArray = {
        data_agendamento: data_agendamento,
        peso_penhor: peso_penhor,
        saldo: saldo,
        cnt_id: {1: cnt_id},
        item_cod_cliente: {1: cod_cliente},
        item_doc_saida: {1: doc_saida},
        item_doc_sara: {1: doc_sara},
        item_num: {1: num},
        item_lote: {1: lote},
        item_doc_id: {1: doc_id},
        item_pack: {1: pack},
        item_portal_agendamento_id: {1: agendamento_id},
        item_qt_carregada: {1: qt_carregada},
        item_maximo_liberado: {1: maximo_liberado},
        item_peso_pack: {1: peso}
    };

    $.ajax({
        url: webroot + 'agendamentos/selecionar_pack/' + agendamento_id + '/' + empresa_id + '/' + lote + '/' + doc_saida + '/' + num + "/",
        data: dataArray,
        dataType: "json",
        type: "POST",
        error: function () {
            alert("An error ocurred.");
        },
        success: function (resp) {
            saldo_item = 0;
            if (resp['saldo'])
            {
                saldo_item = resp['saldo'];
                $('#saldo_pack').html(parseFloat(saldo_item).toFixed(4));
            }
            if (resp['total_carregado'])
            {
                total_carregado = resp['total_carregado'];
                $('#total_carregado').html(parseFloat(total_carregado).toFixed(4));
            }
            $('#saldo').val(saldo_item);

            if (parseInt(total_carregado) == 0) {
                clear('#selecionadosItens');
            } else {
                reload('#selecionadosItens');
            }
            if (resp['msg']) {
                alert(resp['msg'])
            }
        }
    });
}
   
function reload(id_table) {
    $(id_table).DataTable().ajax.reload();
}

function clear(id_table) {
    $(id_table).DataTable().clear().draw();
}





