$(function() {

    $('#collapse-title-button').click(function(){

        if($('#collapse').css('display') == 'block'){
            $("#icon-title-collapse")
                .addClass("fa-chevron-up");
            $("#icon-title-collapse")
                .removeClass("fa-chevron-down");
        }else{
            $("#icon-title-collapse")
                .removeClass("fa-chevron-up");
            $("#icon-title-collapse")
                .addClass("fa-chevron-down");
        }
    
    });
    
});