$(document).ready(function () {
    $("input[type='submit']").on("click", function (e) {
        $(this).hide();
        var athis = this;
        setTimeout(function () {
            $(athis).show();
        }, 10000);
        return true;
    });
});
