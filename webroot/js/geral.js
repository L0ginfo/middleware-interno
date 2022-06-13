$(document).ready(function () {
    $('.duploclick').click(function (e) {
        e.preventDefault ? e.preventDefault() : e.returnValue = false;
    })
});

$(window).load(function () {
    var checkComprimeMenu = $('.comprime-menu').size()

    if (checkComprimeMenu)
        $('.container-fluid .navbar-btn .btn-toggle-fullwidth').click()

    $('.click-label').closest('label').click()

    $('.numeric-double:not(.watched)').each(function () {
        $(this).addClass('watched')

        var precision = $(this).attr('data-precision');
        var allowZero = $(this).attr('data-disable-zero') && $(this).attr('data-disable-zero') == '1' ? false : true;
        var reverse = $(this).attr('data-reverse') == 1 || $(this).attr('data-reverse') == 'true'
            ? true
            : false;

        if (typeof precision == 'undefined' || !precision)
            precision = 2

        $(this).maskMoney({
            prefix: "",
            decimal: ",",
            thousands: ".",
            precision: precision,
            reverse: reverse,
            allowZero: allowZero
        });

        if (Utils.isMobile()) {
            $(this).on('keydown keyup change blur', function() {
                $(this).trigger('mask.maskMoney')
            })
        }
    })

})


$.fn.numericDoubleAction = function($oThat) {
    var precision = $oThat.attr('data-precision');
    var reverse = $oThat.attr('data-reverse') == 1 || $oThat.attr('data-reverse') == 'true'
        ? true
        : false; 

    if (typeof precision == 'undefined' || !precision)
        precision = 2

    $oThat.maskMoney({
        prefix: "",
        decimal: ",",
        thousands: ".",
        precision: precision,
        reverse: reverse,
        allowZero: true
    });
}

$.fn.numericDouble = function () {
    $('.numeric-double').each(function () {
        $.fn.numericDoubleAction($(this))
    })
}

$.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
        if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
            this.value = "";
        }
    });
};

$.fn.doAjaxLogError = async function (oResponse) {

    var oReturn = await $.ajax({
        url: url + '/app/saveLogError',
        data: { ajax_log_error: (oResponse) },
        type: 'POST'
    })

    return await oReturn
}

var $oResponseText = null

$.fn.doAjax = async function (oData) {

    if (oData.showLoad === undefined || oData.showLoad)
        if (oData.loadInfinity === true)
            Loader.showLoad(true, 'external', 1000*60*60)
        else
            Loader.showLoad()

    var oReturn = null,
        full_url_ajax = ((oData.url.indexOf('http') > -1) 
            ? oData.url 
            : url + '/' + oData.url)
        oErrorData = null

    try {
        oReturn = await $.ajax({
            url: full_url_ajax,
            data: oData.data,
            type: oData.type,
            headers: oData.headers
        }).error(function (x,e) {
            oErrorData = {
                full_url_ajax: full_url_ajax,
                data_ajax: oData,
                object_return: {
                    x
                },
                error_type: e
            }
        }).fail(function (x,e) {
            oErrorData = {
                full_url_ajax: full_url_ajax,
                data_ajax: oData,
                object_return: {
                    x
                },
                error_type: e
            }
        })

    } catch (error) {
        var sResposeText = error.responseText,
            sResponseTitle = ''
      
        try {
            sResponseTitle = $($(sResposeText)[5]).html()   
        } catch (error) {}

        if (sResposeText.indexOf('error-contents') > -1) {
            $oResponseText = $($(sResposeText)[14])
            sResposeText = $oResponseText.find('.error-subheading').html()    
        }

        oErrorData = {
            actual_url: window.location.href ? window.location.href : document.URL,
            full_url_ajax: full_url_ajax,
            data_ajax: oData,
            object_return: oReturn,
            error_catched: {
                response_title: sResponseTitle,
                response_text: sResposeText,
                response_status: error.status,
                response_status_text: error.statusText,
            }
        }
    }

    Loader.hideLoad()

    if (oErrorData){
        oReturn = await $.fn.doAjaxLogError(oErrorData)

        if (Swal.isVisible()) {
            Swal.close()
            await Utils.waitMoment(500)
        }

        Swal.fire({
            'title': 'Houve algum problema ao fazer essa requisição!',
            'html': 'Log de erro de network gerado <br><br> Para solicitar suporte, favor enviar no chamado o código de erro: <b>'+oReturn+'</b>',
            'type': 'error'
        })

        oReturn = null
    }

    return await oReturn
}

$.fn.executeFirst = async function (func) {
    return new Promise(async function(resolve) {
        return await func(resolve)
    })
}

