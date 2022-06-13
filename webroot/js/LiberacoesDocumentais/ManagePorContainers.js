const PorContainers = {
    
    init: function() {
        this.watchPesquisa()
        // this.watchButtonAddContainer()
    },

    watchPesquisa: function() {
        
        $('.filtro-por-containers').keydown((e) => {
           
            if (e.keyCode == 13) {
                this.doPesquisa()
            }
        })

        $('.pesquisa-por-containers').click((e) => {
            e.preventDefault()
            this.doPesquisa()
        })
    },

    doPesquisa: function() {
        $('form').submit()
    },

    // watchButtonAddContainer: function () {

    //     $('.adicionar_container').click( function () {

    //         var iContainerID      = $(this).attr("data-container-id")
    //         var oInputContainerID = $(this).closest('#por-containers').find('.container_id')
            
    //         oInputContainerID.val(iContainerID)
    //         $('form').submit()

    //     })

    // }

}

$(document).ready(function() {
    PorContainers.init()
})