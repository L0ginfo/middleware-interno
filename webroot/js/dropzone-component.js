var DropzoneElement = {

    init: function() {
        setTimeout(function () {
            $('.dz-preview.dz-image-preview .dz-image').css({
                display: 'inline-flex'
            })
        }, 1500)
    
        $(document).on('click', '.dz-preview div',function() {
            if ($(this).closest('.dz-preview').attr('data-show-image-by-php')) 
                window.open(url + 'anexos/get-content-file/' + $(this).closest('.dz-preview').attr('data-id'));
            else
                window.open($(this).closest('.dz-preview').attr('data-link'));
        })
    
        $('.dropzone.component:not(.watched, .anexo_tabelas)').each(function() {
    
            var show_image_by_php  = $(this).attr('data-show-image-by-php') ? $(this).attr('data-show-image-by-php') : false
            var maxFiles           = $(this).attr('data-max-files') ? $(this).attr('data-max-files') : 10
            var callbackOnComplete = $(this).attr('callback-on-complete') ? $(this).attr('callback-on-complete') : '() => {}'
            var showGetFiles       = $(this).attr('data-show-get-files') ? $(this).attr('data-show-get-files') : 1
            var caminho            = $(this).attr('data-caminho')
            var id                 = $(this).attr('data-id')
            var tipo               = $(this).attr('data-tipo') ? $(this).attr('data-tipo') : ''
            var tabela             = $(this).attr('data-tabela') ? $(this).attr('data-tabela') : ''
            var coluna             = $(this).attr('data-coluna') ? $(this).attr('data-coluna') : ''
            var idAuxiliar         = $(this).attr('data-id-auxiliar') ? $(this).attr('data-id-auxiliar') : ''
            var tabelaAuxiliar     = $(this).attr('data-tabela-auxiliar') ? $(this).attr('data-tabela-auxiliar') : ''
            var colunaAuxiliar     = $(this).attr('data-coluna-auxiliar') ? $(this).attr('data-coluna-auxiliar') : ''
            var initOnReady         = $(this).attr('data-initOnReady') ? $(this).attr('data-initOnReady') : 0
            var acceptedFiles      = tipo.split(',')

            if (!parseInt(initOnReady))
                return;

            $(this).addClass('watched')
    
            for (let index = 0; index < acceptedFiles.length; index++) {
                acceptedFiles[index] = '.' + acceptedFiles[index];
            }
    
            if ($(this).hasClass('required')) {
                $(this).closest('form').submit(function(e) {
                    if (!$(this).find('.dz-preview').length) {
                        e.preventDefault()
                        Swal.fire({
                            title: 'Obrigatório envio de fotos!',
                            type: 'error'
                        })
                    }
                })
            }
    
            acceptedFiles = acceptedFiles.join(',')
    
            Dropzone.autoDiscover = false;
            dropzone = new Dropzone(this, {
                url: url + 'anexos/addWithComponent',
                addRemoveLinks: true,
                autoProcessQueue: true,
                parallelUploads: 1,
                maxFiles: maxFiles,
                maxFilesize: 5, // MB
                acceptedFiles: acceptedFiles,
                // addRemoveLinks: true,
                params: {
                    'diretorio': caminho + '-' + id,
                    'tabela': tabela,
                    'coluna': coluna,
                    'id' : id,
                    'tabela_auxiliar': tabelaAuxiliar,
                    'coluna_auxiliar': colunaAuxiliar,
                    'id_auxiliar' : idAuxiliar
                },
                resizeWidth: 1920,
                dictDefaultMessage: "Solte os arquivos aqui para enviar",
                dictFallbackMessage: "Seu navegador não suporta uploads de arquivos com arrastar e soltar.",
                dictFallbackText: "Por favor, use o campo abaixo para enviar seus arquivos.",
                dictFileTooBig: "Arquivo é muito grande ({{filesize}}MiB). Tamanho máximo do arquivo: {{maxFilesize}}MiB.",
                dictInvalidFileType: "Você não pode fazer upload de arquivos desse tipo.",
                dictResponseError: "Ops! Ocorreu o erro {{statusCode}}",
                dictCancelUpload: "<i class='glyphicon glyphicon-trash' aria-hidden='true'></i>",
                dictCancelUploadConfirmation: "Tem certeza de que deseja cancelar este upload?",
                // dictRemoveFileConfirmation: "Tem certeza de que deseja excluir este arquivo?",
                dictRemoveFile: "<i class='glyphicon glyphicon-trash' aria-hidden='true'></i>",
                dictMaxFilesExceeded: "Você não pode carregar mais arquivos.",
                sending: function (file) {
                },
                complete: function (files) {
                    eval(callbackOnComplete)(files)
                },
                queuecomplete: function () {
                    
                },
                success: function(file, data) {
                    if (data.isReturnForCallback)
                        return false
    
                    if (data.saveEntity.status == 400) {
                        Swal.fire({
                            html: data.saveEntity.message,
                            type: 'error'
                        }).then(() => {
                            $(file.previewElement).fadeOut("slow", function() {
                                file.previewElement.remove();
    
                                if (!$('.dz-preview').length) {
                                    $('.dz-message').fadeIn();
                                }
                            });
                        })
                    } else {
                        setTimeout(() => {
                            $(dropzone.element).find('.dz-preview').remove()
                            
                            if (showGetFiles == '1')
                                getFiles(this, id, caminho, tipo, tabela, coluna, show_image_by_php)
                            
                            $('.dropzone .dz-preview .dz-image img').css('width', '100%');
                        }, 100);
                    }
    
                },
                removedfile: function(file) {
                    $('.dz-message').hide();
    
                    Swal.fire({
                        title: 'Tem certeza de que deseja excluir este arquivo?',
                        text: 'Você não poderá reverter isto depois!',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim, confirmar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.value) {
                            $(file.previewElement).fadeOut("slow", function() {
                                file.previewElement.remove();
    
                                if (!$('.dz-preview').length) {
                                    $('.dz-message').fadeIn();
                                }
                            });
                            var data = {
                                path: file.path,
                                id: id,
                                caminho: caminho,
                                tipo: tipo,
                                tabela: tabela,
                                anexo_id: $(file.previewElement).attr('data-id')
    
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
    
                                    $('.dz-preview.dz-image-preview .dz-image').css({
                                        display: 'inline-flex'
                                    })
                                },
                                error: function() {
                                    Swal.fire({
                                        title: 'Falha ao buscar arquivos.',
                                        type: 'error'
                                    })
                                }
                            })
                        }
                    })
                },
    
                error: function(file, erro) {
                    Swal.fire({
                        title: erro.message,
                        type: 'error'
                    }).then((result) => {
                        $(file.previewElement).fadeOut("slow", function() {
                            file.previewElement.remove();
    
                            if (!$('.dz-preview').length) {
                                $('.dz-message').fadeIn();
                            }
                        });
                    })
                }
            });
            
            if (showGetFiles == '1')
                getFiles(dropzone, id, caminho, tipo, tabela, coluna, show_image_by_php)
    
            dropzone.autoDiscover = false;
        })
    
        function getFiles(dropzone, id, caminho, tipo, tabela, coluna, show_image_by_php = false) {
            $.ajax({
                url: url + '/anexos/getFiles',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    caminho: caminho,
                    tipo: tipo,
                    tabela: tabela,
                    coluna: coluna
                },
                async: false,
                success: function(data) {
                    var existingFiles = data

                    $(dropzone.element).find('.dz-preview').remove();
                    
                    for (i = 0; i < existingFiles.length; i++) {
                        var sCaminho = url + existingFiles[i].path;
                        var sThumb = existingFiles[i].thumb;
    
                        if (show_image_by_php) {
                            $(dropzone.element).find('.dz-preview').eq(i).attr('data-show-image-by-php', '1')
                            sCaminho = url + 'anexos/get-content-file/' + existingFiles[i].id + '/1.' + existingFiles[i].mime
                            if (['jpeg', 'png'].indexOf(existingFiles[i].mime.toLowerCase()) > -1)
                                sThumb = sCaminho
                        }
    
                        dropzone.emit("addedfile", existingFiles[i]);
                        dropzone.emit("thumbnail", existingFiles[i], sThumb);
                        dropzone.emit("complete", existingFiles[i]);
    
                        $(dropzone.element).find('.dz-preview').eq(i).attr('data-id', existingFiles[i].id)
    
                        //$('#' + $(dropzone.element).attr('id') + ' .dz-preview').eq(i).attr('data-link', url + existingFiles[i].path)
    
                        $(dropzone.element).find('.dz-preview').eq(i).attr('data-link', sCaminho)

                        $(dropzone.element).find('.dz-preview').eq(i).find('.dz-image img').css({
                            'width': '100%',
                            'height': '100%',
                        });
                    }
    
                    $('.dz-preview.dz-image-preview .dz-image').css({
                        display: 'inline-flex'
                    })
                },
                error: function() {
                    alert('error2')
    
                    Swal.fire({
                        title: 'Falha ao buscar arquivos.',
                        type: 'error'
                    })
                }
            })
        }
    },
}

$(document).ready(function() {

    DropzoneElement.init();
    
});