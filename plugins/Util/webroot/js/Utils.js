var Utils = {

    /**
     * Usage:
     *
     * Utils.MultipleChecksAction.init({
            sBtnAction  : 'select-all-action-btn', -> element class
            sCheckAll   : 'select-all-inputs',     -> element class
            sCheckChild : 'select-all-child',      -> element class
            sClassToHide: 'lf-opacity-none',       -> element class
            sClassToShow: 'lf-opacity-full',       -> element class
            iQtdToShow  : 1,
            processNow  : true
        })
     */
    MultipleChecksAction: {

        sBtnAction: '',
        sCheckAll: '',
        sCheckChild: '',
        sClassToHide: '',
        sClassToShow: '',
        iQtdToShow: 1,

        oBtnAction: '',
        oCheckAll: '',
        oCheckChild: '',

        init: function ($obj) {

            Utils.MultipleChecksAction.iQtdToShow = $obj.iQtdToShow

            Utils.MultipleChecksAction.sClassToHide = $obj.sClassToHide
            Utils.MultipleChecksAction.sClassToShow = $obj.sClassToShow

            Utils.MultipleChecksAction.oBtnAction = $('.' + $obj.sBtnAction)
            Utils.MultipleChecksAction.sBtnAction = '.' + $obj.sBtnAction

            Utils.MultipleChecksAction.oCheckAll = $('.' + $obj.sCheckAll)
            Utils.MultipleChecksAction.sCheckAll = '.' + $obj.sCheckAll

            Utils.MultipleChecksAction.oCheckChild = $('.' + $obj.sCheckChild)
            Utils.MultipleChecksAction.sCheckChild = '.' + $obj.sCheckChild

            Utils.MultipleChecksAction.selectAllCheckboxes()
            Utils.MultipleChecksAction.watchCheckboxes()

            if ($obj.processNow) {
                Utils.MultipleChecksAction.oCheckChild.change()
            }
        },

        selectAllCheckboxes: function () {
            Utils.MultipleChecksAction.oCheckAll.click(function () {

                var $pai = $(this)
                var $filhos = $(this).closest('table').find(Utils.MultipleChecksAction.sCheckChild)

                $filhos.each(function () {
                    if ($pai.is(':checked'))
                        $(this).prop('checked', 'checked')
                    else
                        $(this).prop('checked', '')
                })
            })
        },

        watchCheckboxes: function () {
            Utils.MultipleChecksAction.oCheckChild.change(function () {
                Utils.MultipleChecksAction.decider($(Utils.MultipleChecksAction.sCheckChild + ':checked'))
            })

            Utils.MultipleChecksAction.oCheckAll.change(function () {
                Utils.MultipleChecksAction.decider($(Utils.MultipleChecksAction.sCheckChild + ':checked'))
            })
        },

        decider: function ($checkeds) {
            if ($checkeds.size() >= Utils.MultipleChecksAction.iQtdToShow)
                Utils.MultipleChecksAction.showButton()
            else
                Utils.MultipleChecksAction.hideButton()
        },

        showButton: function () {
            var $btn = Utils.MultipleChecksAction.oBtnAction
            $btn.removeClass(Utils.MultipleChecksAction.sClassToHide)
            $btn.addClass(Utils.MultipleChecksAction.sClassToShow)
        },

        hideButton: function () {
            var $btn = Utils.MultipleChecksAction.oBtnAction
            $btn.removeClass(Utils.MultipleChecksAction.sClassToShow)
            $btn.addClass(Utils.MultipleChecksAction.sClassToHide)
        }
    },

    parseFloat: function(num) {

        num = (typeof num == 'undefined') ? 0 : num

        try {
            if (num.indexOf(',') == -1)
                num = parseFloat(num)
            else
                num = parseFloat(num.split('.').join('').replace(',', '.'))
        } catch (error) {
            return 0
        }

        return num
    },

    copyToClipboard: function() {
        $('.lf-copy-to-clipboard:not(.watched-copy)').each(function() {
            $(this).addClass('watched-copy')

            const copyToClipboard = str => {
                const el = document.createElement('textarea');
                el.value = str;
                el.setAttribute('readonly', '');
                el.style.position = 'absolute';
                el.style.left = '-9999px';
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
              };

            $(this).click(async function(e) {
                e.preventDefault()
                var content = $(this).find('.lf-copy-to-clipboard-content').html()

                copyToClipboard(content)

                alert('Copiado!')
            })
        })
    },

    showFormatFloat: function(uNumber, minimumFractionDigits = 2) {
        uNumber = uNumber.toFixed(minimumFractionDigits)
        return new Intl.NumberFormat('pt-BR', { minimumFractionDigits: minimumFractionDigits }).format(uNumber)
    },

    toUppercase: function(customPrevClass) {
        $( customPrevClass + ' .to-uppercase:not(.watched)').each(function() {
            $(this).on('keyup', function() {
                $(this).addClass('watched')

                $(this).val( $(this).val().toUpperCase() )
            })
        })
    },

    confirmBeforeUnload: function() {
        var $oBtnsPreConfirm = $('.preconfirm')

        $oBtnsPreConfirm.each(function() {
            var $oBtnPreConfirm = $(this)

            $oBtnPreConfirm.click( async function(e) {
                e.preventDefault()

                var $oBtn = $(this)

                return await Swal.fire({
                    title: $oBtn.attr('title'),
                    text: $oBtn.attr('text'),
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#41B314',
                    cancelButtonColor: '#ac2925',
                    confirmButtonText: 'Sim, continuar',
                    cancelButtonText: 'Não',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false
                }).then (async result => {

                    if (result.dismiss != 'cancel')
                        window.location = $oBtn.attr('href')
                })
            })
        })
    },

    scrollBindTogetherLeft: function() {
        var $targets = $(".scroll-together-left"),
            i = 0

        $targets.each(function() {
            $(this).attr('data-scroll-id', i)
            i++

            $(this).scroll(function() {
                var scroll_id = $(this).attr('data-scroll-id'),
                    scroll_width = this.scrollLeft

                $(".scroll-together-left").each(function() {
                    if ($(this).attr('data-scroll-id') != scroll_id)
                        $(this).prop("scrollLeft", scroll_width)

                })
            })
        })
    },

    updateHeightBasedElement: function($element, $target, plus = 120, min = 0, aCaseWhen = []) {
        var heightElement = $element.height() + plus,
            bCaseUsed = false

        if (aCaseWhen.length) {

            for (var i in aCaseWhen){
                var oCase = aCaseWhen[i]

                if ($(window).width() <= oCase.width) {
                    bCaseUsed = true
                    heightElement = oCase.value_to_use
                    break
                }
            }
        }

        if (!bCaseUsed && heightElement < min) {
            heightElement = min
        }

        $target.height(heightElement)

        // console.log('heightElement = ' + heightElement)
        // console.log('heightTarget = ' + $target.height())
    },

    /**
     * Retorna bHaveError que diz se existe algum required nao preenchido
     * @param {*} oElem
     */
    manageRequiredCustom: function(oElem = null) {
        var $oContext = oElem ? oElem : $('html'),
            bHaveError = false

        $oContext.find('.required-custom').each(function() {
            if (!($(this).is('select') || $(this).is('input') || $(this).is('textarea')))
                return

            var $oInput = $(this).is('.form-control') ? $(this) : $(this).find('.form-control'),
                isVisible = $oInput.is(':visible'),
                $oElemVisible = $oInput.is('[class*="selectpicker"]') ? $oInput.closest('.input.select') : $oInput

            if (bHaveError)
                return bHaveError

            if (isVisible && !$oInput.val()) {

                Swal.fire({
                    title: $oInput.attr('data-title-error'),
                    text: $oInput.attr('data-text-error'),
                    type: 'warning',
                    timer: 2000,
                    showConfirmButton: false
                })

                bHaveError = true

                $oElemVisible.addClass('lf-input-required')

                $oInput.change(function() {
                    if ($(this).val())
                        $oElemVisible.removeClass('lf-input-required')
                    else
                        $oElemVisible.addClass('lf-input-required')
                })

            }else if (!isVisible) {
                $oElemVisible.removeClass('lf-input-required')
            }
        })

        //Se tem erro, retorna false para nao prosseguir
        //a execucao de quem chamou a manageRequiredCustom
        return bHaveError
    },

    /**
     * Faz refresh da page quando clicado nessa classe. Pode-se passar também uma URL
     */
    refreshPage: function() {
        $('.lf-log-refresh-page').each(function() {
            $(this).click(function() {
                var url = $(this).attr('data-url')
                if (url){
                    window.location = url
                }
                else{
                    location.reload()
                }
            })
        })
    },

    /**
     * Faz um accordion com base num botao (lf-log-accordion-pull) e um content (lf-log-accordion)
     */
    manageAcordion: function() {
        $('.lf-log-accordion-pull').each(function() {
            $(this).click(function() {
                var $oAcordionSection = $('body').find('.lf-log-accordion')

                if ($oAcordionSection.hasClass('active')) {
                    $oAcordionSection.removeClass('active')

                    $(this).find('.glyphicon').addClass('glyphicon-eye-close')
                    $(this).find('.glyphicon').removeClass('glyphicon-eye-open')
                }
                else {
                    $oAcordionSection.addClass('active')

                    $(this).find('.glyphicon').removeClass('glyphicon-eye-close')
                    $(this).find('.glyphicon').addClass('glyphicon-eye-open')
                }
            })
        })
    },

    fixDropdownClipped: function(sEscope = '', sClassToWatch = ''){
        var sSelecteds = '.lf-dropdown-fix-overflow',
            sClassToWatchDefault = 'watch-fix-dropdown-clipped'

        if (sClassToWatch){
            sSelecteds += ':not(.'+sClassToWatch+')'
        }else {
            sSelecteds += ':not(.'+sClassToWatchDefault+')'
            sClassToWatch = sClassToWatchDefault
        }

        sSelecteds = sEscope + sSelecteds

        $(sSelecteds).each(function() {
            $(this).addClass(sClassToWatch)
            var $oThat = $(this)
            var $oDropdown = $('.dropdown')

            if ($(this).is('select[class*="selectpicker"]') || $(this).find('select[class*="selectpicker"]').size()){
                eventShow = 'show.bs.select'
                eventHide = 'hide.bs.select'
                $oDropdown = $oThat.find('.dropdown-menu.open')
            }else {
                eventShow = 'show.bs.dropdown'
                eventHide = 'hidden.bs.dropdown'
                $oDropdown = $oThat.find('.dropdown')
            }

            $oDropdown.on(eventShow, function () {
                console.log('abriu')
                $('body').append(
                    $oDropdown.css({
                        position:'absolute',
                        left: $oDropdown.offset().left,
                        top:  $oDropdown.offset().top
                    }).detach()
                )
            })

            $oDropdown.on(eventHide, function () {
                console.log('fechou')
                $oThat.append(
                    $oDropdown.css({
                        position: 'initial',
                        left:false,
                        top:false
                    }).detach()
                )
            })
        })
    },

    /**
     * Conserta o tamanho do selectpicker que explode a div quando a
     * string é muito grande
     */
    fixSelectPicker: function() {
        $('select.selectpicker').each(function() {
            var $that = $(this)

            if ($(this).hasClass('not-fix-width'))
                return

            var fixWidth = function () {
                var maxWidth = $that.closest('.input').width()

                $that.closest('.input').find('.bootstrap-select').css({
                    width: maxWidth
                })
            }

            fixWidth($(this))

            $(this).change(function() {
                fixWidth($(this))
            })
        })
    },

    /**
     * Faz um POST sem ajax, trocando de página, para a próxima página
     * com os parametros passados
     * @param aParams == array de objetos e.g. [ 0 => {posicao: valor}, 1 => {posicao: valor} ]
     */
    doPost: function(sFullUrl, aParams) {
        var sInputs = '',
            sFormID = 'form-auto-submit' + parseInt((Math.random() * 100 ) / 5)

        for (name in aParams) {
            objKey = Object.keys(aParams[name])
            sInputs += '<input type="hidden" name="'+objKey+'" value="' + aParams[name][objKey] + '">'
        }

        $('body').append('<form id="'+sFormID+'" action="'+sFullUrl+'" method="POST">' + sInputs + '</form>')

        $('#' + sFormID).submit()
    },

    /**
     * Faz o gerenciamento de data retroativa, utilizado nas telas de iniciar operacao de OS
     */
    ManageRetroativo: {
        minValue: {},
        init: function () {
            Utils.ManageRetroativo.minValue = $('.sync-retroativo').attr('min');

            $('.is-retroativo').change(function () {
                var value = parseInt( $(this).val() );

                if (value){
                    $('.sync-retroativo').removeAttr('min');
                }else{
                    $('.sync-retroativo').attr('min', Utils.ManageRetroativo.minValue);
                }

            });
        }
    },

    focusOnElem: function(sElemTarget) {
        if ($(sElemTarget).size()) {
            $(sElemTarget).focus()
        }

        return true
    },

    waitMoment: async function(iTiming) {
        return await $.fn.executeFirst(function(resolve) {setTimeout(resolve, iTiming)})
    },

    focusInShadow: function(sElementsToFocusIn) {
        $(sElementsToFocusIn).each(function() {
            $(this).attr('old-position-css', $(this).css('position'))

            var newPosition = 'relative'

            if ($(this).css('position') != 'static')
                newPosition = $(this).css('position')

            $(this).css({zIndex: 1058, position: newPosition})
        })

        $('.wms-loader-overlay').addClass('active putUpper')
    },

    focusOutShadow: function(sElementsToFocusOut) {

        $(sElementsToFocusOut).each(function() {
            var oldPosition = $(this).attr('old-position-css')

            $(this).css({zIndex: 1, position: oldPosition})
        })

        $('.wms-loader-overlay').removeClass('active').removeClass('putUpper')
    },

    swalConfirmOrCancel: async function(oData, fAction = null) {
        var bRetorno = false

        await Swal.fire({
            title:               oData.title,
            text:                oData.text,
            type:                'warning',
            showCancelButton:    oData.showCancelButton,
            showConfirmButton:   oData.showConfirmButton,
            confirmButtonColor:  oData.defaultConfirmColor ? '' : '#41B314',
            cancelButtonColor:   '#ac2925',
            confirmButtonText:   oData.confirmButtonText,
            cancelButtonText:    'Não',
            time:                oData.time,
            showLoaderOnConfirm: true,
            allowOutsideClick:   false,
            preConfirm: async (confirm) => {
                if (!confirm)
                    return

                if (fAction)
                    return await fAction()

                return bRetorno = true
            },
        })

        return bRetorno
    },

    swalUtil: async function(oData, fFunction = null) {

        var oRetorno = await Swal.fire({
            title:              oData.title,
            text:               oData.text,
            type:               oData.type ?  oData.type : 'warning',
            showConfirmButton:  oData.showConfirmButton,
            confirmButtonText:  oData.confirmButtonText,
            confirmButtonColor: oData.defaultConfirmColor ? '' : '#41B314',
            allowOutsideClick:  false,
            timer:              oData.timer ? oData.timer : null
        })

        await fFunction ? fFunction() : null

        return oRetorno
    },

    swalResponseUtil: async function(oResponse, oParamsExtra = {}) {
        var html = oResponse.message,
            timer = ObjectUtil.issetProperty(oParamsExtra, 'timer')
                ? oParamsExtra.timer
                : 2000

        if (oResponse.status !== 200) {
            html += '<br>' + (oResponse.error ? oResponse.error : '')
        }

        setTimeout(function() {
            oResponse.status !== 200 ?
                Utils.copyToClipboard()
            : null
        }, 1000)

        var oRetorno = await Swal.fire({
            title: oResponse.title,
            html: html,
            type: oResponse.type,
            showConfirmButton: oResponse.status !== 200 ? true : false,
            confirmButtonText: 'OK',
            confirmButtonColor: '#41B314',
            allowOutsideClick: false,
            timer: oResponse.status !== 200 ? null : timer,
        })

        return oRetorno
    },

    isMobile: function() {
        var check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    }
}

//Funcoes para ativar assim que window carregar
$(window).load(function() {
    // setTimeout(() => {
    //     Utils.confirmBeforeUnload()
    // }, 300);


    // Utils.fixDropdownClipped()
    // Utils.fixSelectPicker()
    Utils.manageAcordion()
    Utils.refreshPage()
    // Utils.scrollBindTogetherLeft()
    // Utils.copyToClipboard()
})
