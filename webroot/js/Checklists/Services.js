var Services = {

    updateChecklistResvPerguntasOrRespostas: async function (aData) {

        var oReturn = await $.fn.doAjax({
            showLoad: false,
            url: 'checklists/services',
            type: 'POST',
            data: {aData}
        })

        return oReturn
    
    }

}