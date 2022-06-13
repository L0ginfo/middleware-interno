var ContainersUtil = {

    init: function() {

        ContainersUtil.maskContainer()
        ContainersUtil.upperCaseContainer()
        ContainersUtil.digitoVerificador()
        ContainersUtil.searchContainer()

    },

    maskContainer: function() {

        if (!$('.mask-container').size())
            return;

        var fAction = function () {

            $(document).ready(function(){
                $('.mask-container').mask('SSSS000000-0')
            });
            
        }

        $('html').on('keydown, keyup, change, click', function () {
            setTimeout( function () { fAction() }, 200)
        })

        $(window).on('load', function () { 
            setTimeout( function () { fAction() }, 200)
        })

    },

    upperCaseContainer: function() {

        if (!$('.upper-case-container').size())
            return;
            
        var fAction = function () {

            $(".upper-case-container").each(function(){

                $(this).val (function () {
                    return this.value.toUpperCase();
                })

            });

        }

        $('html').on('keydown, keyup, change, click', function () {
            setTimeout( function () { fAction() }, 200)
        })

        $(window).on('load', function () { 
            setTimeout( function () { fAction() }, 200)
        })
    },

    digitoVerificador: function() {

        $('.digito_verificador').focusout( async function () {

            if (!$(this).val())
                return

            var sContainerNumero = $(this).val().toUpperCase()

            if (sContainerNumero.length != 12) {

                $(this).removeClass('input-color-vistoria-correto')
                $(this).addClass('input-color-vistoria-errado')
                $(this).val('')

                return Utils.swalUtil({
                    title: 'Ops!',
                    type: 'warning',
                    timer: 5000,
                    html: 'Parece que o numero digito não está de acordo com a mascara (XXXX000000-0)'
                })

            }

            var oResponse = await $.fn.doAjax({
                url: 'containers/digito-verificador/' + sContainerNumero + '/true',
                type: 'GET'
            });

            if (oResponse.status != 200) {
                $(this).removeClass('input-color-vistoria-correto')
                $(this).addClass('input-color-vistoria-errado')
                $(this).val('')
                return Utils.swalResponseUtil(oResponse);
            }
    
            $(this).removeClass('input-color-vistoria-errado')
            $(this).addClass('input-color-vistoria-correto')

        })

    },

    validaDigitoVerificador: async function ($this) {

        var sContainerNumero = $this.val().toUpperCase()

        if (sContainerNumero.length != 12) {

            $this.removeClass('input-color-vistoria-correto')
            $this.addClass('input-color-vistoria-errado')
            $this.val('')

            oResponse = new window.ResponseUtil()
            oResponse.setMessage('Parece que o numero digito não está de acordo com a mascara (XXXX000000-0)')
            
            return oResponse

        }

        var oResponse = await $.fn.doAjax({
            url: 'containers/digito-verificador/' + sContainerNumero + '/0',
            type: 'GET'
        });

        if (oResponse.status != 200) {
            $this.removeClass('input-color-vistoria-correto')
            $this.addClass('input-color-vistoria-errado')
            $this.val('')
            return oResponse
        }

        $this.removeClass('input-color-vistoria-errado')
        $this.addClass('input-color-vistoria-correto')
        return oResponse;

    },

    searchContainer: function() {
        $(document).ready(function() {

            var fAction = function($input) {
                $aContainers = $('.container-name');
                var sTextDigitado = $input.val();
                $aContainers.each(function() {
                    if ($(this).text().toUpperCase().indexOf(sTextDigitado.toUpperCase()) !== -1)
                        $(this).closest('.container-class-search').removeClass('hide');
                    else
                        $(this).closest('.container-class-search').addClass('hide');
                })
            }

            setTimeout(() => {
                fAction($('input[name="search-container"]'));
            }, 200);
            $('input[name="search-container"]').on('keydown, keyup', function() {
                setTimeout(() => {
                    fAction($(this));
                }, 200);
            });
        });
    }
}

ContainersUtil.init()
