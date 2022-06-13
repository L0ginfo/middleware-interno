/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$(document).on('click', '.delete-file', function () {
$('.delete-file').click(function () {
    if (confirm('Deseja remover?')) {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + 'anexos/delete/' + $(this).attr('anexo_id'),
            type: 'POST',
            success: function (data) {
                $('.fancybox-inner').html(data)
                $('.ajaxloader').fadeOut()
            }
        })
    }
})