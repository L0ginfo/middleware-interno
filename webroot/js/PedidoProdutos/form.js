$('#produto-id').change(function () {
    form = $(this).closest('form')
    if ($(this).val() != '') {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + 'produtos/getTabelaPrecosCaracteristicas/' + $(this).val(),
            type: "post",
            data: {
                pedido_id: $('#pedido-id').val()
            },
            success: function (data) {
                // remove div's depois do 2º div (quantidade)
                form.children('fieldset').children('.form-group:eq(1)').nextAll('.form-group, .form-control').remove()
                // coloca resultado após último div (quantidade)
                form.children('fieldset').children('.form-group:last-of-type').after(data)
                $('.ajaxloader').fadeOut()
                $.fancybox.update()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro! ' + errorThrown)
                location.reload()
            }
        })
    } else {
        form.children('fieldset').children('.form-group:eq(1)').nextAll('.form-group, .form-control').remove()
        $.fancybox.update()
    }
})