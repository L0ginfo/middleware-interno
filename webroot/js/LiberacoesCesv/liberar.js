$("#nova-liberacao").click(function(e) {
    e.preventDefault();
    var numeroCesv = $("#numero-cesv").val();
    var observacao = $("#observacao").val();
    if (!observacao) {
        alert("Favor preencher a Observação");
        return;
    }
    if (!numeroCesv) {
        alert("Favor preencher o Numero da CESV");
        return;
    }
    var dataArray = {
        numeroCesv: numeroCesv,
        observacao: observacao,
    };
    $('.ajaxloader').fadeIn();
    $.ajax
    ({ 
        url: webroot + 'LiberacoesCesv/liberarCesv/',
        data: dataArray,
        type: "POST",
        success: function (result) {
            switch(result) {
                case "existe":
                    alert("Erro: Já existe liberação para essa CESV")
                    break;
                case "nao salvou":
                    alert("Erro: Nao salvou")
                    break;
                case "nao salvou":
                    alert("Erro: Nao integrou")
                    break;
                case "nao existe sara":
                    alert("Erro: Essa CESV não existe")
                    break;
            }
            window.location.href = webroot + "liberacoes-cesv/index";
        },
        error: function () {
            window.location.href = webroot + "liberacoes-cesv/index";
        }
    });
    $('.ajaxloader').fadeOut();
});

$('#myModal3').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var id     = button.data('id') 
    var cesv   = button.data('cesv')
    var obs    = button.data('obs')  

    var modal = $(this)
    modal.find('.modal-title').text('Editar ' + id)
    modal.find('#id-editar').val(id)
    modal.find('#numero-cesv-editar').val(cesv)
    modal.find('#observacao-editar').val(obs)
});

$("#alterar-liberacao").click(function() {
    var id         = $("#id-editar").val();
    var numeroCesv = $("#numero-cesv-editar").val();
    var observacao = $("#observacao-editar").val();

    var dataArray = {
        id        : id,
        numeroCesv: numeroCesv,
        observacao: observacao,
    };
    console.log(dataArray);
    
    $('.ajaxloader').fadeIn();
    $.ajax
    ({ 
        url: webroot + 'LiberacoesCesv/alterarLiberacaoCesv/',
        data: dataArray,
        type: "POST",
        success: function (result) {
            switch(result) {
                case "existe":
                    alert("Erro: A CESV ja tem duas pesagem.")
                    break;
            }
            window.location.href = webroot + "liberacoes-cesv/index";
        },
        error: function () {
            window.location.href = webroot + "liberacoes-cesv/index";
        }
    });
    $('.ajaxloader').fadeOut();
});