const PorProdutos = {
    init: function() {

        this.watchPesquisa()
        this.watchDeleteItem()
    },

    /**
     * Watchers
     */
    watchDeleteItem: function() {
        $('.delete-item').each(function() {
            $(this).click(function() {
                $(this).closest('tr').find('.quantidade-input').val(0)
                $(this).closest('tr').find('.atualiza-item').click()
            })
        })
    },

    watchPesquisa: function() {
        
        $('.filtro-por-produtos').keydown((e) => {
           
            if (e.keyCode == 13) {
                this.doPesquisa()
            }
        })

        $('.pesquisa-por-produtos').click((e) => {
            e.preventDefault()
            this.doPesquisa()
        })
    },


    /**
     * Actions
     */
    doPesquisa: function() {
        $('form').submit()
    }
}

$(document).ready(function() {
    PorProdutos.init()
})