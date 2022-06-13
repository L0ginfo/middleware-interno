
var SaveMapaAnexos = {
    init: async function (Dropzone) {
        var oResponseDropzone = JSON.parse(Dropzone.xhr.response)
        var iMapaAnexoTipo = $('select[name="mapa_anexo_tipo_id"]').val()
        oResponseDropzone.mapa_anexo_tipo_id = iMapaAnexoTipo;

        oResponse = await $.fn.doAjax({
            url: 'mapa-anexos/saveMapaAnexos',
            data: oResponseDropzone,
            type: 'POST'
        })

        if (typeof oResponse != 'undefined' && (oResponse.status == 200 || oResponse.status == 201))  {
            Swal.fire({
                title: 'Documento salvo com sucesso!',
                type: 'success',
                timer: 2500,
                showConfirmButton: false,
                allowOutsideClick: false
            })

            SaveMapaAnexos.renderTable(oResponse.dataExtra);
            SaveMapaAnexos.deleteAnexo();

            if (oResponse.status == 201) {
                setTimeout(function () {
                    document.location.reload(true);
                }, 100);
            }
        }else {
            Utils.swalResponseUtil(oResponse)
        }

    },

    renderTable: function(aMapaAnexos) {

        $('.table-anexos tbody tr').remove();

        aMapaAnexos.forEach(oMapaAnexo => {

            $('.table-anexos tbody').append(
                '<tr>' + 
                    '<td><a href="/anexos/get-content-file/'+oMapaAnexo.anexo.id +'" target="__BLANK">'+oMapaAnexo.anexo.nome+'</a></td>' +
                    '<td>'+oMapaAnexo.mapa_anexo_tipo.descricao+'</td>' +
                    '<td>'+ (oMapaAnexo.usuario ? oMapaAnexo.usuario.nome : ' ') 
                          + ' - ' 
                          + new Date(oMapaAnexo.created_at).toLocaleDateString() 
                          + ' ' 
                          + new Date(oMapaAnexo.created_at).toLocaleTimeString() +
                    '</td>' +
                    '<td>'+ '<button class="btn btn-danger excluir-anexo" data-id="'
                          + oMapaAnexo.id
                          + '" type="submit"><span class="glyphicon glyphicon-remove-circle"></span></button>'+
                    '</td>' +
                '</tr>'
            );
        });

        SaveMapaAnexos.deleteAnexo();
    },

    deleteAnexo: function() {

        $('.excluir-anexo:not(.watched)').each(function() {

            $(this).click(async function(e) {
                e.preventDefault();

                $(this).addClass('watched');

                var bResponse = await Utils.swalConfirmOrCancel({
                    title: 'Tem certeza disso?',
                    text: 'Deseja realmente excluir o anexo selecionado?',
                    showConfirmButton: true,
                    showCancelButton: true
                })

                if (!bResponse)
                    return;

                oResponse = await $.fn.doAjax({
                    url: 'mapa-anexos/deleteAnexo/' +  $(this).attr('data-id'),
                    type: 'GET'
                });
    
                if (oResponse.status == 200)
                    SaveMapaAnexos.renderTable(oResponse.dataExtra);
                else
                    Utils.swalResponseUtil(oResponse);

            })
        });

        
    }
} 