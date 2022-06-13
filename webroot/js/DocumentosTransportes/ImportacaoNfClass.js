
var ImportacaoNfClass = {
    init: async function (Dropzone) {
        var oResponseDropzone = JSON.parse(Dropzone.xhr.response)

        oResponse = await $.fn.doAjax({
            url: 'documentos-transportes/generateByXmlNf',
            data: oResponseDropzone,
            type: 'POST'
        })

        if (typeof oResponse != 'undefined' && oResponse.status == 200)  {
            Swal.fire({
                title: 'Nota importada com sucesso!',
                type: 'success',
                timer: 2500,
                showConfirmButton: false,
                allowOutsideClick: false
            })

            setTimeout(function () {
                location.href = url + 'documentacao-entrada/edit/' + oResponse.dataExtra.documento_transporte_id 
            }, 2000);
        }else {
            Utils.swalResponseUtil(oResponse)
        }

    }
} 