var ValidateToken = {
 
    init: async function() {
        var bRetorno = await this.getPermission()
        if (!bRetorno)
            return await this.manageSwal();

        return {
            status: 200
        }
    },

    manageSwal: async function() {
        var oRetorno = await Swal.fire({
            title: 'Solicite o Token e insira no campo abaixo:',
            input: 'text',
            inputAttributes: {
              autocapitalize: 'characters'
            },
            inputValidator: (value) => {
                if (!value) {
                  return 'Campo obrigatório!'
                }
            },
            showCancelButton: true,
            confirmButtonText: 'Validar',
            showLoaderOnConfirm: true,
            preConfirm: async (sToken) => {
                var iResvId = $('#resvid').data('resv_id') 
                var oResponse = await this.manageValidate(sToken, iResvId);
                return oResponse;
            }
        })

        if (oRetorno.dismiss)
            return {
                status: 400, 
                title: 'Necessário validar token para remover pesagem!',
                message: '',
                type: "error"
            }
        
        return oRetorno.value;
    },

    getPermission: async function() {
        var oResponse = await $.fn.doAjax({
            url: 'pesagens/verificaPermissaoRemoverPesagem',
            type: 'GET'
        });

        if (oResponse.status == 400)
            return false;

        return true;

    },

    manageValidate: async function(sToken, iResvId) {

        var oResponse = await $.fn.doAjax({
            url: 'pesagens/validaTokenPesagem' + '/' + sToken + '/' + iResvId,
            type: 'GET'
        });

        return oResponse;
    }


}