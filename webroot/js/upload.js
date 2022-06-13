/** 
 * Ajax Upload Script
 */
//$(document).on('change', ':file', function(){  
$(':file').change(function () {
    var formData = new FormData();
    formData.append('file', $(this)[0].files[0])
    formData.append('tipo', $('#tipo').val())
    $('.ajaxloader').fadeIn()
    $.ajax({
        url: $(this).parents('form:first').attr('action'),
        type: 'POST',
        data: formData,
        processData: false, // tell jQuery not to process the data
        contentType: false, // tell jQuery not to set contentType
        success: function (data) {
            $('.fancybox-inner').html(data)
            $('.ajaxloader').fadeOut()
        }
    })
})