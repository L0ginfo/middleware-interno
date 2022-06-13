const PesagensManager = {
    init: function () {

        this.watchPesagensBtn()
    },
    watchPesagensBtn: function() {
        $('.btn-pesagens').click(async function(e) {
            e.preventDefault()
            var sLink = url + 'pesagens/iniciar-pesagem?resv_id=' + $(this).attr('data-resv-id')
            
            var oResponse = await $.fn.doAjax({
                url: sLink,
                type: 'POST',
                data: {
                    return_in_json: true
                }
            })

            if (oResponse.status == 200)
                PesagensModalManager.showModal(oResponse.dataExtra)

            return false
        })
    }
    
}

$(document).ready(function() {
    PesagensManager.init()
})