class Hooks {

    init() {
        var that = this

        oSubject.setObserverOnEvent(function () {

            that.watchChangesAndCopyChanges()

        }, ['onDocumentReady', 'onDocumentChange'])
    }

    /**
     * Observa modificações de algum elemento e manda pegar o val()
     * dele e setar em outro elemento
     */
    watchChangesAndCopyChanges () {
        $('.hook-watch-changes:not(.watched).can-execute').each(function () {
            var $caller = $(this)
            $caller.addClass('watched')

            var $closest = $caller.closest( $caller.attr('data-closest') )
            var $from = $closest.find( $caller.attr('data-from') )
            var $to = $closest.find( 'input'+$caller.attr('data-to') + ', select'+$caller.attr('data-to') )
            var triggerToDispatch = $to.attr('data-trigger-to-dispatch')


            var doAction = function($to, uValue) {
                $to.val( uValue )

                if (triggerToDispatch) {
                    $to[triggerToDispatch]()
                }
    
                if ($to.is('select[class*="selectpicker"]'))
                    $to.selectpicker('refresh')
    
                $('html').trigger('hook-watch-changes', $to)
            }

            $from.on('change', function () {
                var $toNew = $closest.find( 'input'+$caller.attr('data-to') + ', select'+$caller.attr('data-to') )

                doAction($toNew, $(this).val())
            })

            doAction($to, $from.val())
            
        })
    }

    watchDoubleClick(sTarget, fAnonymous) {
        var fAction = fAnonymous
        var setTouchtime = function(obj, val) {
            $(obj).attr('touchtime', val)
        }

        var getTouchtime = function(obj) {
            return $(obj).attr('touchtime')
        }

        $(sTarget).each(function() {
            setTouchtime(this, 0)

            $(this).on("click", function() {
                if (getTouchtime(this) == 0) {
                    setTouchtime(this, new Date().getTime())
                } else {
                    if (((new Date().getTime()) - getTouchtime(this)) < 800) {
                        fAction(this)
                        setTouchtime(this, 0)
                    } else {
                        setTouchtime(this, new Date().getTime())
                    }
                }
            })
        })
    }
}

var oHooks = new Hooks()
oHooks.init()