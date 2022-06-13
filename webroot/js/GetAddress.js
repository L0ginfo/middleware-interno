var GetAddress = {

    init: function ($cepField, $logradouroField, $estadoField, $cidadeField, $bairroField) {
        this.manageFields($cepField, $logradouroField, $estadoField, $cidadeField, $bairroField);
    },

    findAddress: async function(cep) {

        oResponse = new window.ResponseUtil()

        if (!cep)
            return oResponse
                .setStatus(400)
                .setMessage('Necessário informar o CEP!');

        cep = cep.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');

        var oReturn = await $.fn.doAjax({
            url: 'https://ws.apicep.com/cep.json?code=' + cep,
            type: 'GET',
            loadInfinity: true
        });

        oResponse.setStatus(oReturn.status);

        if (oReturn.status == 400)
            oResponse.setMessage(oReturn.message);
        else
            oResponse.setDataExtra(oReturn);

        return oResponse;

    },

    manageFields: function($cepField, $logradouroField, $estadoField, $cidadeField, $bairroField) {

        $cepField.change(async function() {

            var oReturn = await GetAddress.findAddress($(this).val());

            if (oReturn.getStatus() == 400)
                return await Utils.swalResponseUtil(oReturn, {
                    timer: 2500
                });
                
            var oData = oReturn.getDataExtra();

            if ($logradouroField)
                $logradouroField.val(oData.address);

            if ($estadoField)
                $estadoField.val(oData.state)

            if ($cidadeField)
                $cidadeField.val(oData.city);

            if ($bairroField)
                $bairroField.val(oData.district);

        })
        
    }

}