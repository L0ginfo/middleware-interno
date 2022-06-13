$(document).ready(function () {
    $('#resultados').DataTable({
        lengthMenu: [[10, 30, 50, -1], [10, 30, 50, "Todos"]],
        "scrollY": "330px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging": false,
        //   dom: 'Bfrtipl', l->resuultado por paginda   t->tabela  B->botao f->pesquisa  i->Mostrando de 1 até 10 de 49 registro r-> ???  p-> paginacao
        dom: '<"col-sm-5"B>f<"clear">t<"col-sm-4"i>p',  
        stateSave: false,
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
        }, 
        initComplete: function () {
            this.api().columns('.filter').every( function () {
            var column = this;
            var select = $('<select class="form-control" placeholder="Escolha" empty="Escolha"><option value="">Escolha</option></select>')
                .appendTo( $('#sel_'+column[0]).empty() )
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );
                    column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                });
                column.data().unique().sort().each( function ( d, j ,i) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                });
            });
        }
    });
});

$(document).ready(function() {
    $('#resultados3').DataTable( {
       lengthMenu: [[10, 30, 50, -1], [10, 30, 50, "Todos"]],
        "scrollY": "330px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging": false,
        dom: '<"col-sm-5"B>f<"clear">t<"col-sm-4"i>p',
      
        stateSave: true,
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    });
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                });
            });
        }
    });
});

$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#resultados_dtc thead  tr:eq(1)  th').each( function (i) {
        var title = $('#resultados_dtc thead  tr:eq(1) th').eq( $(this).index() ).text();
            $(this).html( '<input  style="width : 80px" type="text" placeholder="" data-index="' + i + '" />');
    });

    // DataTable
    var table = $('#resultados_dtc').DataTable( {
        scrollY:        "330px",
        scrollX:        "100%",
        lengthMenu: [[100, 25, 50, -1], [100, 25, 50, "All"]],
        scrollCollapse: true,
        fixedColumns:   true,
         orderCellsTop: true
    });
 
    // Filter event handler
    $( table.table().container() ).on( 'keyup', 'thead input', function () {
        table
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    });
});