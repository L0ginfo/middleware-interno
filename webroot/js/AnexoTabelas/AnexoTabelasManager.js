var AnexoTabelasManager = {

    parametrosGlobais: {
        dropzoneAtual: {}
    },

    init: async function() {

        AnexoTabelasManager.functionNull()
        AnexoTabelasManager.watchDropzone()

        setTimeout(function() {
            AnexoTabelasManager.watchAnexoSituacaoRender()
        }, 500)

    },
    
    watchDropzone: async function() {

        const dropzones = []

        $('.dropzone.component.anexo_tabelas').each( async function() {

            var iID                = $(this).attr('data-dropzone-id')
            var maxFiles           = $(this).attr('data-max-files') ? $(this).attr('data-max-files') : 10
            var caminho            = $(this).attr('data-caminho')
            var id                 = $(this).attr('data-id')
            var tipo               = $(this).attr('data-tipo') ? $(this).attr('data-tipo') : ''
            var tabela             = $(this).attr('data-tabela') ? $(this).attr('data-tabela') : ''
            var table              = $(this).attr('data-table') ? $(this).attr('data-table') : ''
            var coluna             = $(this).attr('data-coluna') ? $(this).attr('data-coluna') : ''
            var idAuxiliar         = $(this).attr('data-id-auxiliar') ? $(this).attr('data-id-auxiliar') : ''
            var tabelaAuxiliar     = $(this).attr('data-tabela-auxiliar') ? $(this).attr('data-tabela-auxiliar') : ''
            var colunaAuxiliar     = $(this).attr('data-coluna-auxiliar') ? $(this).attr('data-coluna-auxiliar') : ''
            var initOnReady        = $(this).attr('data-initOnReady') ? $(this).attr('data-initOnReady') : 0
            var anexoTipo          = $(this).attr('data-anexo-tipo') ? $(this).attr('data-anexo-tipo') : ''
            var anexoSituacao      = $(this).attr('data-anexo-situacao') ? $(this).attr('data-anexo-situacao') : ''
            var acceptedFiles      = tipo.split(',')

            if (!parseInt(initOnReady))
                return;
    
            for (let index = 0; index < acceptedFiles.length; index++) {
                acceptedFiles[index] = '.' + acceptedFiles[index];
            }
    
            acceptedFiles = acceptedFiles.join(',')

            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone(this, {
                url: url + 'anexos/addWithComponent',
                addRemoveLinks: true,
                autoProcessQueue: false,
                parallelUploads: 10,
                maxFiles: maxFiles,
                maxFilesize: 5, // MB
                acceptedFiles: acceptedFiles,
                params: {
                    'diretorio': caminho + '-' + id,
                    'tabela': tabela,
                    'table': table,
                    'coluna': coluna,
                    'id' : id,
                    'tabela_auxiliar': tabelaAuxiliar,
                    'coluna_auxiliar': colunaAuxiliar,
                    'id_auxiliar' : idAuxiliar,
                    'anexo_tipo_id' : anexoTipo,
                    'anexo_situacao_id' : anexoSituacao,
                    'data_dropzone_id': iID
                },
                success: async function(file, data) {
                    if (data.isReturnForCallback)
                        return false

                    if (data.saveEntity.status == 400) {
                        Swal.fire({
                            html: data.saveEntity.message,
                            type: 'error'
                        }).then(() => {
                            window.location.reaload()
                        })
                    } else {
                        var oData = {'tabela' : table, 'id' : id}
                        var oResponse = await AnexoTabelasServices.getAnexoTabelas(oData)

                        AnexoTabelasRender.renderAnexos(oResponse, AnexoTabelasManager.parametrosGlobais.dropzoneAtual)
                        AnexoTabelasManager.parametrosGlobais.dropzoneAtual = {}
                        Swal.fire({
                            title: 'Sucesso!',
                            html: 'O anexo foi salvo com sucesso',
                            type: 'success',
                        })

                        $('.dz-preview').remove()
                        $('.dz-message').show()
                    }
                }
            })

            dropzones.push(myDropzone)
        })

        $('.salvar_anexos').click(function() {

            $thisButton = $(this)
        
            dropzones.forEach(dropzone => {

                var iDropzoneID = dropzone.options.params.data_dropzone_id
                var iButtonID   = $thisButton.attr('data-dropzone-id')
                if (iDropzoneID == iButtonID) {

                    oModalContent = $thisButton.closest('.modal-content')

                    if (oModalContent.find('.selectpicker.anexo_tipo option:selected').val())
                        dropzone.options.params.anexo_tipo_id = oModalContent.find('.selectpicker.anexo_tipo option:selected').val()

                    if (oModalContent.find('.selectpicker.anexo_situacao option:selected').val())
                        dropzone.options.params.anexo_situacao_id = oModalContent.find('.selectpicker.anexo_situacao option:selected').val()

                    AnexoTabelasManager.parametrosGlobais.dropzoneAtual = $thisButton
                    dropzone.processQueue()

                }

            })

        });

        AnexoTabelasManager.watchBtnOpenModal()

    },

    functionNull: function() {

        return ''

    },

    watchAnexoSituacaoRender: function() {
        
        $('select.anexo_situacao_render:not(.watched)').each(function() {

            $(this).addClass('watched')

            $(this).change(async function() {

                var iSituacaoID    = $(this).val()
                var iAnexoTabelaID = $(this).closest('.tr_anexo_situacao').find('.anexo_tabela_id_hidden').val()

                var oData = {
                    'iSituacaoID'    : iSituacaoID,
                    'iAnexoTabelaID' : iAnexoTabelaID
                }
                var oResponse = await AnexoTabelasServices.setAnexoSituacao(oData)
                if (oResponse.status == 400)
                    sType = 'error'
                else
                    sType = 'success'

                Swal.fire({
                    title: oResponse.title,
                    html: oResponse.message,
                    type: sType,
                })

                var id     = $(this).closest('.modal-body').find('.dropzone.component').attr('data-id')
                var tabela = $(this).closest('.modal-body').find('.dropzone.component').attr('data-table') ? $('.dropzone.component').attr('data-table') : ''
                var oData = {
                    'tabela' : tabela,
                    'id'     : id
                }
                var oResponse = await AnexoTabelasServices.getAnexoTabelas(oData)
                AnexoTabelasRender.renderAnexos(oResponse, $(this))

            })

        })

    },

    watchBtnOpenModal: function() {

        $('.btn_open_modal').click(async function() {

            var sBtnDataTarget = $(this).attr('data-target')
            var oModalDropzone = $(sBtnDataTarget)

            var oDropzone = oModalDropzone.find('.dropzone.component')

            var id    = oDropzone.attr('data-id')
            var table = oDropzone.attr('data-table')

            if (table && id) {
                var oData = {'tabela' : table, 'id' : id}
                var oResponse = await AnexoTabelasServices.getAnexoTabelas(oData)
                AnexoTabelasRender.renderAnexos(oResponse, oDropzone)
            }

        })

    },

    watchBtnDeleteAnexo: function() {

        $('.btn_delete_anexo').click(async function() {

            Swal.fire({
                title: 'Tem certeza de que deseja excluir este arquivo?',
                text: 'Você não poderá reverter isto depois!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, confirmar!',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.value) {

                    var iDataID   = $(this).attr('data-id')
                    var oDropzone = $(this).closest('.modal-body').find('.dropzone')

                    var oResponse = await AnexoTabelasServices.getInfoRemove(iDataID)

                    var data = {
                        path: oResponse.dataExtra.path,
                        id: oResponse.dataExtra.id,
                        caminho: oResponse.dataExtra.caminho,
                        tipo: oResponse.dataExtra.tipo,
                        tabela: oResponse.dataExtra.tabela,
                        anexo_id: oResponse.dataExtra.anexo_id

                    }
                    $.ajax({
                        url: url + '/anexos/removerArquivo',
                        type: 'POST',
                        dataType: 'json',
                        data: data,
                        async: false,
                        success: function(data) {
                            if (data.status == 400)
                                Swal.fire({
                                    title: data.message,
                                    type: 'error'
                                })
                            
                            Swal.fire({
                                title: data.message,
                                type: 'success'
                            })

                        },
                        error: function() {
                            Swal.fire({
                                title: 'Falha ao buscar arquivos.',
                                type: 'error'
                            })
                        }
                    })

                    var id    = oDropzone.attr('data-id')
                    var table = oDropzone.attr('data-table')

                    if (table && id) {
                        var oData = {'tabela' : table, 'id' : id}
                        var oResponse = await AnexoTabelasServices.getAnexoTabelas(oData)
                        AnexoTabelasRender.renderAnexos(oResponse, oDropzone)
                    }

                }
            })

        })

    }
    
}
