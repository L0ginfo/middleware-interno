var ImportarCsvManager = {

    init: async function (Dropzone) {

        var oResponseDropzone = JSON.parse(Dropzone.xhr.response)

        var oDivGlobal    = $('.div_global')
        var oDataMedicao = oDivGlobal.find('.data_medicao')

        if (!oDataMedicao.val()) {
            Swal.fire({
                title: 'Selecione a Data da Medição!',
                type: 'warning',
                timer: 2500,
                showConfirmButton: false,
                allowOutsideClick: false
            })

            return window.location.reload()
        }

        oResponse = await $.fn.doAjax({
            url: 'endereco-medicoes/importar',
            data: {'oResponse' : oResponseDropzone, 'sData' : oDataMedicao.val()},
            type: 'POST'
        })

        if (typeof oResponse != 'undefined' && oResponse.status == 200)  {

            Swal.fire({
                title: 'CSV importado com sucesso!',
                type: 'success',
                timer: 2500,
                showConfirmButton: false,
                allowOutsideClick: false
            })

            setTimeout(function () {
                location.href = url + 'endereco-medicoes/dashboard'
            }, 2000)

        } else {

            Utils.swalResponseUtil(oResponse)

        }

    }

}
