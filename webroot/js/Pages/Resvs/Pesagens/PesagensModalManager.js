const PesagensModalManager = {
    init: function() {

    },
    showModal: async function(oPesagemRESV) {
        // localStorage.setItem('pesagem_id', oPesagemRESV.pesagem_id)
        oState.setState('pesagem_id', oPesagemRESV.pesagem_id)
        PagePesagem.displayVeiculoPesagens()

        $('.imprimir-ticket').attr('href', 
            $('.imprimir-ticket').attr('href').replace('__RESV_ID__', oPesagemRESV.resv.id) 
        )

        //fix para poder clicar no input do swal
        $('#modal-pesagens').on('shown.bs.modal', function() {
            $(document).off('focusin.modal');
        });

        await Utils.waitMoment(350)

        $('#modal-pesagens .modal-dialog').css({
            width: 1075
        })
        $('#modal-pesagens').modal('toggle')

        if (screen.width < 1000)
            $('#modal-pesagens .modal-dialog').css({
                width: '100%'
            });
        
    }
}

$(document).ready(function() {
    PesagensModalManager.init()
})