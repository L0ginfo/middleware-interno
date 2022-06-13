var DriveEspacoAtualManager = {

    init: function () {

        this.watchButtonDriveEspacoAtual()

    },

    watchButtonDriveEspacoAtual: function () {

        $('.button_drive_espaco_atual').click( function () {

            DriveEspacoAtualManager.setDriveEspacoAtual($(this))

        })

    },

    setDriveEspacoAtual: async function ($this) {

        var oDriveEspacoID = $this.closest('.div_global_drive_espaco_atual').find('.selectpicker.drive_espaco_atual')
        var oContainerID   = $this.closest('.div_global_drive_espaco_atual').find('.drive_espaco_atual_container_id')

        if (!oDriveEspacoID.val() || oDriveEspacoID.val() == 0)
            return Utils.swalUtil({
                title: 'Ops!',
                type: 'warning',
                timer: 3000,
                html: 'É necessário selecionar um Drive de Espaço!'
            })
            
        var oReturn = await DriveEspacoAtualManager.setDriveEspacoAtualAjax(oContainerID.val(), oDriveEspacoID.val())
        if (oReturn.status != 200)
            return Swal.fire({
                title: oReturn.title,
                text: oReturn.message,
                type: 'error',
                showConfirmButton: false,
                timer: 3000 
            })
        else 
            return Swal.fire({
                title: oReturn.title,
                text: oReturn.message,
                type: 'success',
                showConfirmButton: false,
                timer: 3000 
            })

    },

    setDriveEspacoAtualAjax: async function (iContainerID, iDriveEspacoID) {

        var oResponse = await $.fn.doAjax({
            url: 'EntradaSaidaContainers/setDriveEspacoAtual/' + iContainerID + '/' + iDriveEspacoID,
            type: 'GET'
        });

        return oResponse;

    }

}

$(document).ready( function () {

    DriveEspacoAtualManager.init()

})