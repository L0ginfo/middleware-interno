
// Is Online
window.addEventListener('online', function(){
    oColetorApp.bOnline = true;
    $('.offline').addClass('hide');

    if($('.lf-footer').length) {
        $('.lf-footer').css({ bottom: '0px' });
    }
});

// Is Offline
window.addEventListener('offline', function(){
    oColetorApp.bOnline = false;
    $('.offline').removeClass('hide');

    if($('.lf-footer').length) {
        $('.lf-footer').css({ bottom: '33px' });
    }
});
