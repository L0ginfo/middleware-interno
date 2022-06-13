//$(document).on('change', 'form input[type="text"], form input[type="select"], form select', function(){
$('form input[type="text"], form input[type="select"], form select').change(function () {
    if ($(this).attr('notchange') !== 'true') {
       //$( "form:first" ).submit();
    }
})


