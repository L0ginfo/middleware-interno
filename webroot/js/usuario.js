//$(document).on('change', 'form input[type="text"], form input[type="select"], form select', function(){
$('form input[type="text"], form input[type="select"],form input[type="email"], form select').change(function () {
   this.form.submit();
})
