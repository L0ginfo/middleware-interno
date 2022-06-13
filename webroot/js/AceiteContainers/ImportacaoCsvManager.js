var ImportacaoCsvClass = {

    init: async function (Dropzone) {

        var oResponseDropzone = JSON.parse(Dropzone.xhr.response)

        oResponse = await $.fn.doAjax({
            url: 'aceite-containers/generateByCsv',
            data: oResponseDropzone,
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
                location.href = url + 'aceite-containers/index'
            }, 2000)

        } else {

            Utils.swalResponseUtil(oResponse)

        }

    }

}
