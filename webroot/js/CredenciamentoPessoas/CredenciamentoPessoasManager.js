var CredenciamentoPessoasManager = {

    init: function () {

        CredenciamentoPessoasManager.watchBtnIsTemporario()

    },

    watchBtnIsTemporario: function () {

        $('.is_temporario').change(function () {

            var oDataInicio = $('.data_inicio_acesso')
            var oDatafim    = $('.data_fim_acesso')

            if ($(this).val() == 0) {

                oDataInicio.attr('readonly', true)
                oDatafim.attr('readonly', true)

                var oDate    = new Date()
                
                var sDay   = ("0" + oDate.getDate()).slice(-2);
                var sMonth = ("0" + (oDate.getMonth() + 1)).slice(-2);

                $('.data_fim_acesso').val((oDate.getFullYear()+1)+"-"+sMonth+"-"+sDay+"T00:00");
                $('.data_inicio_acesso').val(oDate.getFullYear()+"-"+sMonth+"-"+sDay+"T00:00");

            } else {

                oDataInicio.attr('readonly', false)
                oDatafim.attr('readonly', false)

            }

        })

    },
    
    functionNull: function () {

        return ''

    }

}

$(document).ready( function() {

    CredenciamentoPessoasManager.init()

})
