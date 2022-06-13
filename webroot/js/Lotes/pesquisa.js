//$(document).on('change', 'form input[type="text"], form input[type="select"], form select', function(){
$('.pesquisa').change(function () {
    if ($(this).attr('notchange') !== 'true') {
        $('.ajaxloader').fadeIn();
        $.ajax({
            url: $('form').attr('action'), // empresas/index
            type: "post",
            data: $('form').serialize(),
            success: function (data) {
                // console.log(data);
                $('#content').html(data);
                $('.ajaxloader').fadeOut();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // window.location = webroot + 'lotes/index/0/1';
                alert('Sem registro.');
                $('.ajaxloader').fadeOut();
            }
        })
    }
})

//$(document).on('click', 'ul.pagination li:not(.disabled) a', function (e) {
$('ul.pagination li:not(.disabled) a').click(function (e) {
    e.preventDefault()
    if (!$(this).parent('li').hasClass('active')) {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: $(this).attr('href'),
            type: "post",
            data: $('form').serialize(),
            success: function (data) {
                $('#content').html(data)
                $('.ajaxloader').fadeOut()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                location.reload()
            }
        })
    }
})
