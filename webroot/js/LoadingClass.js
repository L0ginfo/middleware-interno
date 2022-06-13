var $outside = $(this)
var alreadyExecutedOutside = false
var bSetLoaderAnimateIn = true
var calledClose = false
var iCountCalls = 0
var sOrigin = ''
var timerToFallback = null

var Loader = {
    isShowing: false,

    fire: async function (iTimeToClose) {
        if (Loader.isShowing)
            Loader.clearTimeoutToClose()

        this.setPositions($(window))
        this.setActive()
        Loader.isShowing = true

        $.fn.trigger('wms-loader-open');

        timerToFallback = setTimeout(function() {
            if (Loader.isShowing) Loader.hideLoad()
        }, iTimeToClose);
    },

    setPositions: function ($window){
        var window = $window

        $('.wms-loader-overlay').css({
            width: window.width(),
            height: window.height()
        })

        $('.wms-loader-container').css({
            top: window.height() / 2,
            left: window.width() / 2,
            marginLeft: ($('.wms-loader-container').width() / 2) * -1,
            marginTop: ($('.wms-loader-container').height() / 2) * -1
        })

        $('html').css({
            overflowX: 'none'
        })

    },

    setActive: function () {
        $('.wms-loader-container').addClass('animated duration-1s')
        $('.wms-loader-overlay').addClass('putUpper')

        if (bSetLoaderAnimateIn)
            $('.wms-loader-container').addClass('rubberBand')

        setTimeout(() => {
            $('.wms-loader-overlay, .wms-loader-container').addClass('active putUpper')
            bSetLoaderAnimateIn = true
        }, 200)
    },

    clearTimeoutToClose: function() {
        if (timerToFallback){
            clearTimeout(timerToFallback)
            timerToFallback = null
        }
    },

    swalIsVisible: function () {
        if (typeof Swal != 'undefined' && Swal.isVisible()) {
            return true;
        }

        return false;
    },

    close: function (closeNow = false) {
        if (!closeNow) {
            if (!Loader.isShowing || Loader.swalIsVisible()){
                calledClose = true

                $.fn.on('wms-loader-open', function () {
                    if (calledClose)
                        Loader.hideLoad()
                });

                setTimeout(() => {
                    calledClose = false
                }, 1000);

                if (!Loader.swalIsVisible()) {
                    return false
                }
            }
        }
        Loader.isShowing = false

        $('.wms-loader-container').addClass('bounceOut')

        timeOutClose = 800
        timeOutAnimate = 250

        if (closeNow) {
            timeOutClose = timeOutAnimate = 0
        }

        setTimeout(() => {

            Loader.clearTimeoutToClose()

            iCountCalls = 0

            $('.wms-loader-overlay, .wms-loader-container').removeClass('active')
            $('.wms-loader-container').removeClass('animated rubberBand duration-1s bounceOut')

            //fix z-index de elementos atras que apareciam antes que outros elem
            setTimeout(() => {
                $('.wms-loader-overlay, .wms-loader-container').removeClass('putUpper')
            }, timeOutAnimate);
        }, timeOutClose)
    },

    showLoad: function (bSetAnimate = true, sInitiateOrigin = 'external', iTimeToClose = 10000) {
        bSetLoaderAnimateIn = bSetAnimate
        iCountCalls++
        sOrigin = sInitiateOrigin

        if (typeof haveAnotherSwal == 'undefined' || (typeof haveAnotherSwal != 'undefined' && alreadyExecutedOutside) ){
            this.fire(iTimeToClose)
        }else {
            $.fn.on('swal-flash-closed', function () {
                alreadyExecutedOutside = true
                this.fire(iTimeToClose)
            })
        }
    },

    hideLoad: async function (timeout = 200, closeNow = false) {
        that = this

        if (sOrigin == 'internal' && iCountCalls > 1)
            return false

        if (typeof haveAnotherSwal == 'undefined' || alreadyExecutedOutside || Loader.swalIsVisible() )    {
            return await new Promise( (resolve, reject) => {
                setTimeout(() => {
                    that.close(closeNow)
                    resolve()
                }, timeout)
            })
        }else {
            return await $.fn.on('swal-flash-closed', async function () {
                alreadyExecutedOutside = true

                return await new Promise( (resolve, reject) => {
                    setTimeout(() => {
                        that.close(closeNow)
                        resolve()
                    }, timeout)
                })
            })
        }

    }
}

$(document).ready(async function () {
    Loader.setPositions($(window))

    if (typeof showSwalOnReady == 'undefined' || (typeof showSwalOnReady != 'undefined' && showSwalOnReady)) 
        Loader.showLoad(false, 'internal')

    function removeIfHaveSwal () {
        if (Loader.swalIsVisible())
            Loader.close(true)

        requestAnimationFrame(removeIfHaveSwal)
    }

    removeIfHaveSwal()
})


$(window).on('load', async function(){ 
    Loader.setPositions($(window))
});


// $(window).load(async function () {
//     Loader.setPositions($(window))
// })

$(window).on('resize scroll', async function () {
    Loader.setPositions($(this))
})

$(window).bind('beforeunload', function(e) {
    Loader.showLoad()
});
