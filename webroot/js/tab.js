// vai pra hash certa e faz o tab funcionar
$(function () {
    var hash = window.location.hash;
    hash && $('ul.nav a[href="' + hash + '"]').tab('show');
    $('.nav-tabs a').click(function (e) {
        $(this).tab('show');
        window.location.hash = this.hash;
        $('.alert').remove(); // removendo alertas
    });
});