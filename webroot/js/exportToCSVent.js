
$(document).ready(function () {
    $('#selecione_entrada').click(function () {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + 'lotes/adiciona_entradas/' + $('#selecione_entrada').attr('entrada_id') + '/' + $('#selecione_entrada').attr('tipo'), // our php file
            type: 'post',
            success: function (data) {
                $('.ajaxloader').fadeOut()
                $.fancybox({
                    content: data,
                    autoSize: false,
                    width: '800px',
                    height: 'auto',
                    afterClose: function () { // USE THIS IT IS YOUR ANSWER THE KEY WORD IS "afterClose"
                        parent.location.reload(true);
                    }
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro! ' + errorThrown)
            }
        });

    })
})


$('#resultados').DataTable({
    lengthMenu: [[10, 30, 50, -1], [10, 30, 50, "Todos"]],
    "scrollY": "330px",
    "scrollX": true,
    "scrollCollapse": true,
    "paging": false,
    //   dom: 'Bfrtipl', l->resuultado por paginda   t->tabela  B->botao f->pesquisa  i->Mostrando de 1 até 10 de 49 registro r-> ???  p-> paginacao
    dom: 'f<"clear">t<"col-sm-4"i>p',
    stateSave: false,
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


function adicionarContainer (id, entrada, container) {
   input = $('#incluir'+id)

    $('.ajaxloader').fadeIn()
    $.ajax({
        url: webroot + 'lotes/adiciona_entradas' + '/' + entrada + '/' +'container' + '/' + container,
        type: "post",
        //data: $('form').serialize(),
        success: function (data) {
            $('.ajaxloader').fadeOut()
            input.removeClass("glyphicon-plus");
            input.addClass("glyphicon-ok");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.ajaxloader').fadeOut()
            alert('Erro! ')

        }
    })
}




