var DocumentoSemNumero = {

    init: function () {

        DocumentoSemNumero.watchBtnSalvar()

    },

    watchBtnSalvar: function () {

        $('.btn_salvar_numero').click(async function () {

            var oGlobal          = $(this).closest('.global_documento_sem_numero')
            var iDocTransporteID = oGlobal.find('.documento_transporte_id').val()
            var sNumero          = oGlobal.find('.numero_documento').val()

            var oResponse = await $.fn.doAjax({
                showLoad: false,
                url: 'documentacao-entrada/setNumeroDocTransporte/',
                type: 'POST',
                data: {
                    'numero_documento': sNumero,
                    'documento_transporte_id': iDocTransporteID
                }
            });

            if (oResponse.status != 200)
                Swal.fire({
                    title: oResponse.title,
                    text: oResponse.message,
                    type: 'error',
                    showConfirmButton: false,
                    timer: 3000 
                })
            else 
                Swal.fire({
                    title: oResponse.title,
                    text: oResponse.message,
                    type: 'success',
                    showConfirmButton: false,
                    timer: 3000 
                })

            window.location.reload()

        })

    }

}

$(document).ready(function() {

    DocumentoSemNumero.init();

});
