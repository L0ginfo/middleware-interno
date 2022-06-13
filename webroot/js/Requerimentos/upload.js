/**
 * Faz upload das fotos
 */
$('#enviaXml').submit(function (e) {
    e.preventDefault()
    dados = new FormData()
    dados.append("arquivo", document.getElementById('arquivo').files[0])
    //send formdata to server-side
    $.ajax({
        url: webroot + 'requerimentos/importarXml', // our php file
        type: 'post',
        data: dados,
        async: true,
        processData: false, // tell jQuery not to process the data
        contentType: false, // tell jQuery not to set contentType
        success: function (data) {
            if (data) {
                dados = JSON.parse(data)
                $('#numero-documento').val(dados.numero_documento)
                $('#data-emissao').val(dados.data_emissao)
                $('#cnpj-cliente').val(dados.cnpj_cliente)
                $('#cnpj-representante').val(dados.cnpj_representante)
                $('#valor-cif').val(dados.valor_cif)
                $.fancybox.close()
            } else {
                alert('ERRO: Arquivo não enviado!')
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown)
        }
    });
});