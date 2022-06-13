/* 
 * Isso � p/ os anexos
 */
$('.anexos').click(function (e) {
    e.preventDefault()
    $('.ajaxloader').fadeIn()
    $.ajax({
        url: $(this).attr('href'),
        type: "post",
        success: function (data) {
            $('.ajaxloader').fadeOut()
            $.fancybox({
                content: data,
                autoSize: false,
                width: '800px',
                height: 'auto',
                afterClose: function () {
                    //alert('ssss');
                    $.ajax({
                        url: webroot + 'mapas',
                        type: "post",
                        data: $('form').serialize(),
                        success: function (data) {
                            $('#content').html(data)
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert('Erro! ' + errorThrown)
                            location.reload()
                        }
                    })
                    //location.reload()
                },
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown)
            location.reload()
        }
    })
})

$('#produto, #pais_origem, #vistoriados-nome, #liberados-nome, #cliente,#peso_bruto,#especie,#conteiner,#conhecimento,#ce-mercante, #peso-bruto, #pais-origem').keypress(function (e) {
    if (e.which == 13) {
        e.preventDefault()
        var elementoId = $(e.target).attr("id")
        $('#' + elementoId).change()

    }
});

  