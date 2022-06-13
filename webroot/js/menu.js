$(document).ready(function(){

    // Active Third Level
    var url = window.location;
    $('ul.nav a').filter(function () {

        if (this.href == url || url.href.indexOf(this.href) == 0) 
            //console.log($(this).parents('#side-menu ul').parents('.active-ancestor'))

        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active')
      .closest('.nav.dropdown.mm-collapse.in')
      .click()
      .closest('.active-ancestor')
      .prev('a')
      .click()
      .parents('#side-menu ul')
      .addClass('in')
      ; 
    
    var activeItem = $('.navigation.active li a.active .icon > .active-arrow');

    if(activeItem.length) {
        var activeOffsetTop = $(activeItem).offset().top;
        $('#sidebar-nav').scrollTop(activeOffsetTop - 200);
    }

    function beInactive() {
        $('.vertical-nav .slide.two').removeClass('active').addClass('inactive');
        $('.vertical-nav .slide.one').addClass('active').removeClass('inactive');
    }
    $(".navigation").hover(beInactive); 
    
    $(".vertical-nav.hover").hoverIntent({
        over: beWide, 
        out: beNarrow,
        timeout: 300
    });
    
    function beWide() {
        $(this).addClass("wide").removeClass("narrow");
        var nav = $(this).find('.navigation.active #sidebar-nav');

        

        setTimeout(function() {
            nav.css({'overflow-y': 'auto', 'overflow-x': 'auto'});
            nav.find('li a.active .icon > .active-arrow').fadeOut();
        }, 300);
    }
    
    function beNarrow() {
        $(this).removeClass("wide").addClass("narrow");
        var nav = $(this).find('.navigation.active #sidebar-nav');
        nav.css({'overflow-y': 'hidden', 'overflow-x': 'hidden'});
        nav.find('li a.active .icon > .active-arrow').css('display', 'none');

        setTimeout(function() {
            nav.find('li a.active .icon > .active-arrow').fadeIn();
        }, 100);

        beInactive();
    }
    
    $.fn.extend({
        toggleText: function(a, b){
            return this.text(this.text() == b ? a : b);
        }
    });

    $('#apps-switch .button').click(function(){
        $('#apps-switch .material-icons').toggleText('menu', 'sort');
        $('.slide.two').toggleClass('active').toggleClass('inactive');
        $('.slide.one').toggleClass('active').toggleClass('inactive');
    });

    $('.vertical-nav.hover .hamburger').click(function() {

        if ($('.vertical-nav.hover').hasClass('wide')) {
            $('.vertical-nav.hover.wide').removeClass('wide')
            $('.vertical-nav.hover').addClass('narrow')
        }else {
            $('.vertical-nav.hover.narrow').addClass('wide')
            $('.vertical-nav.hover').removeClass('narrow')
        }
    })
})

