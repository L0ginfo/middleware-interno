$('form').submit(function (e) {
    e.preventDefault()
    $('.ajaxloader').fadeIn()
    $.ajax({
        url: $(this).attr('action'),
        type: "post",
        data: $(this).serialize(),
        success: function (data) {
            if (data == 1) {
                location.reload()
            } else {
                $('.fancybox-inner').html(data)
            }
            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown)
            location.reload()
        }
    })
})