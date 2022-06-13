$('.fancybox').click(function (e) {
    e.preventDefault();
    $('.ajaxloader').fadeIn();
    $.ajax({
        url: $(this).attr('href'),
        type: "post",
        success: function (data) {
            $('.ajaxloader').fadeOut();
            $.fancybox({
                content: data,
                autoSize: false,
                width: '800px',
                height: 'auto'
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown);
            location.reload();
        }
    });
});