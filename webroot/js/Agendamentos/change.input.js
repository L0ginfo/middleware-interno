$('form input[type="select"], form select').change(function () {
    if ($(this).attr('notchange') !== 'true') {
       $( "form:first" ).submit();
    }
});