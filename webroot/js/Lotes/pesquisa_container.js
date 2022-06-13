
var input = null


$('.rapid-search').change(function () {
    input = $(this)
    if (input.val()) {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + input.attr('url') + '/' + input.val(), // empresas/index
            type: "post",
            //data: $('form').serialize(),
            success: function (data) {
                $('.list-items-box').remove()
                input.after(data)
                $('.ajaxloader').fadeOut()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro! ' + errorThrown)
                location.reload()
            }
        })
    } else {
        $('.list-items-box').remove()
    }
})

/**
 * escolhe na lista e popula o input que será enviado pelo form
 */
$(document).on('click', '.list-items', function () {
    input.val($(this).attr('value'))
    $('.list-items-box').remove()
})

/**
 * mudar iso code
 */
$(document).ready(function () {
    $('#container').mask('SSSS000000-0');
})
