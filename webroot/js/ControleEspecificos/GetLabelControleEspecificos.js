var GetLabelControleEspecificos = {

    init: function() {

        setTimeout(function () {
            GetLabelControleEspecificos.watchClass()
        }, 600)

    },

    watchClass: async function() {

        var oInput = $('.param_label_controle_especificos')

        if (!oInput)
            return

        var oResponse = await GetLabelControleEspecificos.getParamLabelControleEspecificos();

        if (oResponse.status != 200)
            return Utils.swalResponseUtil(oResponse);

        oInput.parent().find('label').text(oResponse.dataExtra.valor)

    },

    getParamLabelControleEspecificos: async function(sContainer) {
        
        var oReturn = await $.fn.doAjax({
            url: 'controle-especificos/getParamLabelControleEspecificos/',
            type: 'GET'
        });

        return oReturn;

    }

}

$(document).ready( function () {

    GetLabelControleEspecificos.init()

})
