var OsMedicaoTemperatura = {

    init: function () {

        OsMedicaoTemperatura.watchClickBtnFinalizarOS()

    },

    watchClickBtnFinalizarOS: function () {

        $('.button_finalizar_os').click( function () {

            OsMedicaoTemperatura.finalizarOs($(this))

        })

    },

    finalizarOs: function ($this) {

        var iOSID = $this.attr('data-os-id')
        
        return Swal.fire({

            title: 'Deseja prosseguir?',
            text: 'A Ordem de Serviço será finalizada ao prosseguir',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#41B314',
            cancelButtonColor: '#ac2925',
            confirmButtonText: 'Sim, continuar',
            cancelButtonText: 'Não',
            showLoaderOnConfirm: true

        }).then (result => {

            if (result.dismiss != 'cancel') {
                var url_finalizar = url + 'ordem-servicos/finalizar/' + iOSID 
                window.location.href = url_finalizar
                Loader.showLoad();
            } else {
                return false
            }

        })

    },

}

$(document).ready(function () {

    OsMedicaoTemperatura.init()

})