const ContainerLotesManager = {

    init: function () {

        this.watchPesagensBtn()

    },

    watchPesagensBtn: function() {

        $('.btn_container_lotes').click(async function(e) {
            
            var oResponse = await $.fn.doAjax({
                showLoad: false,
                url: 'lotes/loteServices/ContainerLotes/' + $(this).attr('data-container'),
                type: 'GET'
            }); 

            await ManageFrontend.render('ContainerLotes', oResponse);

            return oResponse;
        })

    }
    
}

$(document).ready(function() {
    ContainerLotesManager.init()
})
