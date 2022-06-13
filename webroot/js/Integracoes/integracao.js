$(document).ready(function(){
    async function iniciarIntegracao(sUrl, oBody = {}, sHash) {

        var oReturn = await $.fn.doAjax({
            url: sUrl,
            headers: {
                'private-key': sHash,
            },
            type: 'POST',
            data: oBody,
            loadInfinity: true
        });

        Loader.hideLoad();

        if(JSON.parse(oReturn).status == 200) {
            Swal.fire({
                type: 'success',
                title: 'Integração Finalizada com Sucesso!',
                confirmButtonText: 'Recarregar Página'
            }).then((result) => {
                document.location.reload(true);
            })
        }
        else {
            Swal.fire({
                type: 'error',
                title: 'Ocorreu um Erro!',
                confirmButtonText: 'Recarregar Página'
            }).then((result) => {
                document.location.reload(true);
            })
        }
    }

    $(".btn-integracao-estoque").click(function(e){
        e.preventDefault();
        var sUrl = $(this).attr('href');
        iniciarIntegracao(sUrl);
    })

    $(".btn-integracao-pedidos").submit(function(e){
        e.preventDefault();
        var sUrl = $(this).attr('action');
        sUrl =  sUrl.indexOf('/') == 0 ? sUrl.replace('/', '') : sUrl;
        console.log(sUrl);
        var oBody = {
            data_integracao: $(this).find('input[name="data_integracao"]').val()
        };
        var sHash = $(this).attr('data-hash')
        iniciarIntegracao(sUrl, oBody, sHash);
    })
})
