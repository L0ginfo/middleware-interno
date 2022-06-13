$(document).ready(function () {
    $('#resultados').DataTable({
        lengthMenu: [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
        // "scrollY": true,
        "scrollX": false,
        "scrollCollapse": true,
        "paging": false,
        //   dom: 'Bfrtipl', l->resuultado por paginda   t->tabela  B->botao f->pesquisa  i->Mostrando de 1 até 10 de 49 registro r-> ???  p-> paginacao
        dom: '<"row"<"col-md-6"B><"col-md-6"<"teste"l>>>t<"row"<"col-md-6"i><"col-md-6"<"teste"p>>>',
        // dom: '<"row"B><"row"f><"clear">t<"row"ip>',
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
                "visible": true,
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
    $(".teste").css("text-align", "right");
});


   
