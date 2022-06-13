var BloqueioContainer = {

    init: function($containerInput) {

        BloqueioContainer.watchInputContainer($containerInput);
    },

    watchInputContainer: function($containerInput) {

        $containerInput.focusout(async function() {

            if (!$(this).val())
                return

            var oResponse = await BloqueioContainer.validaBloqueioContainer($(this).val());
            if (oResponse.status != 200) {
                $(this).val('')
                return Utils.swalResponseUtil(oResponse);
            }
        });
    },

    validaBloqueioContainer: async function(sContainer) {
        
        var oReturn = await $.fn.doAjax({
            url: 'bloqueio-containers/validaBloqueioContainer/' + sContainer,
            type: 'GET'
        });

        return oReturn;

    }
}