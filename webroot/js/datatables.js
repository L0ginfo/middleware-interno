jQuery(function ($) {
    $(document).ready(function () {
        var colPreenchida = false;
        var withColumm = $('#resultados').data('col');
        var table = $('#resultados').DataTable({
            responsive: $('#resultados').hasClass('lf-table-responsive') ? true : false,
            paging: false,
            select: true,
            dom: withColumm == false ? '' : 'Bfrtip',
            ordering: false,
            bFilter: false,
            bInfo : false,
            buttons: [
                {
                    extend: 'colvis',
                    text: 'Colunas',
                },
                {
                    extend: 'copyHtml5',
                    text: '<i class="glyphicon glyphicon-file"></i>',
                    titleAttr: 'Copy'
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="glyphicon glyphicon-list-alt"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="fas fa-file-alt"></i>',
                    titleAttr: 'CSV'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="glyphicon glyphicon-book"></i>',
                    titleAttr: 'PDF'
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'Imprimir'
                },
            ],
            language: {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de START até END de TOTAL registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de MAX registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "MENU resultados por página",
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
        
        //Fix button Colunas
        $('.btn.btn-default.buttons-collection.buttons-colvis').click(function () {
            
            if (!colPreenchida) {
                var i = 0;
                colPreenchida = true;

                $('#resultados thead tr:first th').each(function () {
                    
                    i++;
                    var text = $(this).find('a').html() || $(this).html();
                    $('.dt-button-collection.dropdown-menu li:nth-child('+i+') a').html( text );

                });

            }
            
        });
        
            
    });
});