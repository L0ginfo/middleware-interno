$('#caracteristica-id').change(function () {
    $('.ajaxloader').fadeIn()
    $.ajax({
        url: webroot + 'caracteristicas/getValoresCaracteristicas/' + $(this).val(),
        type: "post",
        data: $(this).serialize(),
        success: function (data) {
            $('#valor-caracteristica').html(data)
            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown)
            location.reload()
        }
    })

})