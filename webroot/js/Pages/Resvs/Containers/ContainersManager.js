ParamObrigaDriveEspacoDescargaVazio = null
ParamObrigaDriveEspacoDescargaCheio = null
ParamObrigaDriveEspacoCargaVazio = null
ParamObrigaDriveEspacoCargaCheio = null
ParamObrigaClienteDescargaVazio = null
ParamObrigaBeneficiarioDescargaVazio = null

var ContainersManager = {
    
    globalData: {
        armador_id: null,
        cliente_id: null
    },

    init: async function() {
        aParams = await this.getParamObrigaDriveEspaco()

        if (aParams) {
            ParamObrigaDriveEspacoDescargaVazio = aParams.descarga_vazio
            ParamObrigaDriveEspacoDescargaCheio = aParams.descarga_cheio
            ParamObrigaDriveEspacoCargaVazio = aParams.carga_vazio
            ParamObrigaDriveEspacoCargaCheio = aParams.carga_cheio
            ParamObrigaClienteDescargaVazio = aParams.descarga_vazio_cliente
            ParamObrigaBeneficiarioDescargaVazio = aParams.descarga_vazio_beneficiario
        }

        this.watchButtonSalvarDocumentoCheckDriveEspaco()
        this.watchInputsReadonly()
        this.watchFindContainer()
        this.watchFindDriveEspaco()
        this.watchFindDocumentosTransporte()
        this.watchInputTags()
        this.watchEditResvContainerLacres()
        this.watchAddResvContainerLacres()
        this.watchAddDocumentoEntradaSaida()
        this.watchCheioOuVazio()
        this.watchButtonDocumentoContainers()
        this.watchContainerOperacaoOptions()
        this.watchChangeArmador()
        this.watchChangeCliente()
    },

    getParamObrigaDriveEspaco: async function () {

        return await ContainersServices.getParamObrigaDriveEspaco()

    },

    watchCheioOuVazio: function () {

        $('select.tipo_container_readonly').change( function() {
            ContainersManager.verifyCheioOuVazio($(this), false)

        })

        $('.resv_container_edit').click( function () {

            var dataTarget = $(this).data("target")
            var $this = $(dataTarget).find('.tipo_container_readonly').find('select#tipo-container')
            ContainersManager.verifyCheioOuVazio($this, true)

        })

    },

    verifyCheioOuVazio: function ($this = false, bLimpaSelectpicker) {

        if (!bLimpaSelectpicker) {
            $('.selectpicker.find_container').val(0)
            $('.selectpicker.find_container').selectpicker('refresh')
            $('.selectpicker.find_drive_espaco').val(0)
            $('.selectpicker.find_drive_espaco').selectpicker('refresh')
            $('.selectpicker.documento_containers').val(0)
            $('.selectpicker.documento_containers').selectpicker('refresh')
        }

        $this.closest('.container-fluid').find('.add_container_disabled').addClass('lf-opacity-medium')

        if ($this.val() == 'CHEIO') {

            $(".campos_vazio").hide()
            $(".campos_cheio").show()
            $(".campos_forma_uso_testado").show()
            $('.campos_descarga_vazio').hide()
            $('.selectpicker.find_container').attr("required", "required")
            $(".campo_cliente").hide()
            // $('.quantidade_vazios_display').hide()

        } else if ($this.val() == 'VAZIO') {

            $(".campos_cheio").hide()
            $(".campos_forma_uso_testado").hide()
            $(".campos_vazio").show()
            $(".campo_cliente").show()
            $('.campos_descarga_vazio').hide()

            var iOperacaoID = $this.closest('.modal-body').find('select.container_operacao_options').val()
            if (iOperacaoID == 2) {
                $('.selectpicker.find_drive_espaco').closest('.lf-selectpicker-ajax').find('.lf-opacity-medium').removeClass('lf-opacity-medium')
                $('.selectpicker.find_container').removeAttr("required")
                // $('.quantidade_vazios_display').show()
            } else {
                $('.selectpicker.find_drive_espaco').closest('.lf-selectpicker-ajax').find('.lf-opacity-medium').removeClass('lf-opacity-medium')
                $('.selectpicker.find_container').closest('.lf-selectpicker-ajax').find('.lf-opacity-medium').removeClass('lf-opacity-medium')
                $('.selectpicker.find_container').attr("required", "required")
                $('.quantidade_vazios_display').hide()
                $this.closest('.container-fluid').find('.add_container_disabled').removeClass('lf-opacity-medium')
                $('.campos_descarga_vazio').show()
            }

        } else {

            $(".campos_cheio").hide()
            $(".campos_forma_uso_testado").hide()
            $(".campos_vazio").hide()
            $('.selectpicker.find_container').attr("required", "required")
            // $('.quantidade_vazios_display').hide()
            $('.selectpicker.find_drive_espaco').addClass('lf-opacity-medium')

        }

    },

    watchAddDocumentoEntradaSaida: function () {

        $('.find_containers_doc_entrada_saida').each(function () {
            $(this).click( async function (e) {
                e.preventDefault()
    
                await Utils.waitMoment(180)
    
                var iDocEntradaSaida         = $(this).closest('form').find('select.numero_doc_entrada_saida').val()
                var iOperacaoDocEntradaSaida = $(this).closest('form').find('.operacao_id_doc_entrada_saida').val()
                var iTipoDocEntradaSaida     = $(this).closest('form').find('select.tipo_doc_entrada_saida').val()
                
                iDocEntradaSaida         = !iDocEntradaSaida
                    ? $('select.numero_doc_entrada_saida').val()
                    : iDocEntradaSaida;
                
                iOperacaoDocEntradaSaida = !iOperacaoDocEntradaSaida
                    ? $('.operacao_id_doc_entrada_saida').val()
                    : iOperacaoDocEntradaSaida;
                
                iTipoDocEntradaSaida     = !iTipoDocEntradaSaida
                    ? $('select.tipo_doc_entrada_saida').val()
                    : iTipoDocEntradaSaida;

                console.log(iDocEntradaSaida, iOperacaoDocEntradaSaida);

                if ($(this).hasClass('submit-documento-saida')) {
                    iDocEntradaSaida = $('select.numero_doc_entrada_saida').eq(1).val();
                    iOperacaoDocEntradaSaida = 2;
                } else if ($(this).hasClass('submit-documento-entrada')) {
                    iDocEntradaSaida = $('select.numero_doc_entrada_saida').eq(0).val();
                    iOperacaoDocEntradaSaida = 1;
                }
    
                $('.operacao_id_doc_entrada_saida').val(iOperacaoDocEntradaSaida);
                console.log(iDocEntradaSaida, iOperacaoDocEntradaSaida);
                var oReturn = await ContainersServices.getContainersDocumento(iDocEntradaSaida, iOperacaoDocEntradaSaida)
    
                if (oReturn.status == 200) {
    
                    $('.documento_containers').find('option').remove()
    
                    $.each(oReturn.dataExtra, function(iID, sNumero) {
                        $('select.documento_containers').append($('<option>', { 
                            value: parseInt(iID),
                            text : sNumero 
                        }))
                    })
    
                    $('.documento_containers').selectpicker('refresh')
    
                    $('.numero_doc_entrada_saida_hidden').val(iDocEntradaSaida)
                    $('.tipo_doc_entrada_saida_hidden').val(iTipoDocEntradaSaida)
    
                    $('.tipo_container_readonly').val('CHEIO')
                    $('.tipo_container_readonly').selectpicker('refresh')
    
                    var oCliente = await ContainersServices.getClienteDocumento(null, iOperacaoDocEntradaSaida, iDocEntradaSaida)
                    if (!oCliente)
                        return null
                    else
                        ContainersManager.globalData.cliente_id = oCliente.id

        
                    $('.selectpicker.selectpicker_cliente').append('<option value="'+ oCliente.id +'" title="'+ oCliente.descricao +'">'+ oCliente.descricao +'</option>')
                    $('.selectpicker.selectpicker_cliente').val(oCliente.id)
                    $('.selectpicker.selectpicker_cliente').selectpicker('refresh')
                    $('.selectpicker.selectpicker_cliente').change()
    
                    $('#modal-documento-containers').modal('toggle')
                    
                } else {
                    var $fieldNum = $('select.numero_doc_entrada_saida');
                    var $form = $('#documento-form');
                    if ($(this).hasClass('submit-doc-saida')) {
                        $fieldNum = $('select.numero_doc_entrada_saida').eq(1);
                        $form = $('select.numero_doc_entrada_saida').eq(1).closest('form#documento-form');
                    } else if ($(this).hasClass('submit-doc-entrada')) {
                        $fieldNum = $('select.numero_doc_entrada_saida').eq(0);
                        $form = $('select.numero_doc_entrada_saida').eq(0).closest('form#documento-form');
                    }
                    
                    //se não for na tela de viagens, faz submit
                    if ($fieldNum.val() && !$('body.main-class.viagens').size()) {
                        $form.submit()
                    }
                }
    
            })
        })

    },

    watchEditResvContainerLacres: function () {

        $('.resv_container_edit').click( function () {

            var $modal = $($(this).data("target")).hide()

            var oTagsLacres = $modal.find('.tags_lacres')
            oTagsLacres.tagsinput('removeAll')

            if (!oTagsLacres.hasClass('watched-trigger')) {
                oTagsLacres.tagsinput({
                    itemValue       : 'lacre_tipo_id',
                    itemText        : 'lacre_descricao',
                    allowDuplicates : true
                })
                oTagsLacres.addClass('watched-trigger')
            }
            
            var oLacreJson  = $modal.find('.lacres_json')
            if (!oLacreJson.val())
                return;
            var oJsonLacres = JSON.parse(oLacreJson.val())

            var iCount = 0
            oJsonLacres.forEach( function (oLacre) {
                oTagsLacres.tagsinput('add', {
                    "lacre_tipo_id"   : parseInt(oLacre.lacre_tipo_id),
                    "lacre_descricao" : oLacre.lacre_numero,
                    "id"              : oLacre.id
                })

                setTimeout(function() {
                    var $tag = oTagsLacres.closest('div').find('.bootstrap-tagsinput').find('span.tag').eq(iCount)
                    iCount++
                    $tag.attr('class', '');
                    switch (parseInt(oLacre.lacre_tipo_id)) {
                        case 1 : return $tag.addClass('tag label label-primary')
                        case 2 : return $tag.addClass('tag label label-danger label-important')
                        case 3 : return $tag.addClass('tag label label-success')
                        case 4 : return $tag.addClass('tag label label-default')
                        case 5 : return $tag.addClass('tag label label-warning')
                        case 6 : return $tag.addClass('tag label label-info')
                    }
                }, 200)

            })

        })

    },

    validaDriveBeforeSaveModalContainer: async function($oScope) {
        var oResponse = new ResponseUtil();
        var bTemDivergencia = false;
        var iDriveEspacoID = $oScope.find('.selectpicker.drive_espaco_id_find').val();
        var sTipoContainer = $oScope.find('select.tipo_container').val();
        var iOperacaoID = $oScope.find('select.container_operacao_options').val() 
            ? $oScope.find('select.container_operacao_options').val() 
            : $oScope.find('.operacao_id_doc_entrada_saida').val();

        if (!ParamObrigaDriveEspacoDescargaVazio && !ParamObrigaDriveEspacoDescargaCheio && !ParamObrigaDriveEspacoCargaVazio && !ParamObrigaDriveEspacoCargaCheio)
            return oResponse.setStatus(200)
        
        if (iDriveEspacoID)
            return oResponse.setStatus(200)
        
        if (sTipoContainer == 'CHEIO' && iOperacaoID == 2 && ParamObrigaDriveEspacoCargaCheio) {
            oResponse.setMessage('Você deve informar um Drive de Espaço!')
            bTemDivergencia = true
        }else if (sTipoContainer == 'CHEIO' && iOperacaoID == 1 && ParamObrigaDriveEspacoDescargaCheio) {
            oResponse.setMessage('Você deve informar um Drive de Espaço!')
            bTemDivergencia = true
        }else if (sTipoContainer == 'VAZIO' && iOperacaoID == 2 && ParamObrigaDriveEspacoCargaVazio) {
            oResponse.setMessage('Você deve informar um Drive de Espaço!')
            bTemDivergencia = true
        }else if (sTipoContainer == 'VAZIO' && iOperacaoID == 1 && ParamObrigaDriveEspacoDescargaVazio) {
            oResponse.setMessage('Você deve informar um Drive de Espaço!')
            bTemDivergencia = true
        }

        if (!bTemDivergencia)
            return oResponse.setStatus(200)

        await Utils.swalResponseUtil(oResponse)

        return oResponse
    },

    watchAddResvContainerLacres: function () {

        $('.button-salvar-containers:not(.watched)').each(function() {
            $(this).addClass('watched')
            $(this).addClass('watched-check-drive-espaco')

            $(this).click( async function (e) {
                var iDriveEspacoID = $(this).closest('form').find('.selectpicker.drive_espaco_id_find').val();
                var sTipoContainer = $(this).closest('form').find('select.tipo_container').val();
                var iClienteID = $(this).closest('form').find('select.selectpicker_cliente').val();
                var iBeneficiarioID = $(this).closest('form').find('select.selectpicker_beneficiario').val();
    
                var iOperacaoID = $(this).closest('form').find('select.container_operacao_options').val() 
                        ? $(this).closest('form').find('select.container_operacao_options').val() 
                        : $(this).closest('form').find('.operacao_id_doc_entrada_saida').val();
    
                var iContainerID = $(this).closest('form').find('.selectpicker.find_container').val();
    
                var oResponseValidacaoDrive = await ContainersManager.validaDriveBeforeSaveModalContainer($(this).closest('form'));
    
                if (oResponseValidacaoDrive.getStatus() != 200) {
                    return false;
                }
    
                if (!iContainerID && sTipoContainer == 'CHEIO') {
                    Utils.swalUtil({
                        title: 'Ops!',
                        text: 'Para prosseguir é necessário selecionar um Container!',
                        type: 'warning',
                        timer: 5000
                    })
    
                    e.preventDefault()
    
                    return false;
                }
    
                if (!iContainerID && sTipoContainer == 'VAZIO' && iOperacaoID == 1) {
                    Utils.swalUtil({
                        title: 'Ops!',
                        text: 'Para prosseguir é necessário selecionar um Container!',
                        type: 'warning',
                        timer: 5000
                    })
    
                    e.preventDefault()
    
                    return false;
                }
    
                if (sTipoContainer == 'VAZIO' && ParamObrigaDriveEspacoDescargaVazio == 1 && !iDriveEspacoID && iOperacaoID == 1) {
                    Utils.swalUtil({
                        title: 'Ops!',
                        text: 'Falta vincular um Drive de Espaço corretamente!',
                        type: 'warning',
                        timer: 5000
                    })
    
                    e.preventDefault()
    
                    return false;
                }

                if (sTipoContainer == 'VAZIO' && ParamObrigaClienteDescargaVazio == 1 && !iClienteID && iOperacaoID == 1) {
                    Utils.swalUtil({
                        title: 'Ops!',
                        text: 'Falta vincular um Cliente!',
                        type: 'warning',
                        timer: 5000
                    })
    
                    e.preventDefault()
    
                    return false;
                }

                if (sTipoContainer == 'VAZIO' && ParamObrigaBeneficiarioDescargaVazio == 1 && !iBeneficiarioID && iOperacaoID == 1) {
                    Utils.swalUtil({
                        title: 'Ops!',
                        text: 'Falta vincular um Beneficiario!',
                        type: 'warning',
                        timer: 5000
                    })
    
                    e.preventDefault()
    
                    return false;
                }
    
                var $modal      = $($(this).closest('.modal-content'))
                var oTagsLacres = $modal.find('.tags_lacres')
                var oLacreJson  = $modal.find('.lacres_json')
                oLacreJson.val(JSON.stringify(oTagsLacres.tagsinput('items')))
    
                var sTipoContainer = $(this).closest('form').find('.tipo_container_readonly').find("option:selected").text()
                if (sTipoContainer == 'CHEIO' && iOperacaoID == 1 && !oTagsLacres.val()) {
                    e.preventDefault()
                    
                    Utils.swalUtil({
                        title: 'Ops!',
                        text: 'Para Descarga de Container Cheio é necessário informar os Lacres (Digite os Lacres e precione a tecla ENTER)!',
                        type: 'warning',
                        timer: 5000
                    })
    
                    return false;
                }
                
                $(this).closest('form').submit()
            })
        })

        

    },

    watchInputTags: function (sButtons = '.tags_lacres') {

        var oTagsLacres = $(sButtons)

        oTagsLacres.each( function () {

            $(this).tagsinput({
                itemValue       : 'lacre_tipo_id',
                itemText        : 'lacre_descricao',
                allowDuplicates : true
            })
           
            var $this = $(this)

            $this.closest('div').find('.bootstrap-tagsinput input').keydown( function (e) {
                
                if (e.keyCode == 13) {
                    e.preventDefault()

                    var oLacreTipo = $this.closest('.modal-body').find('.lacre_tipo_options')

                    $this.tagsinput('add', { 
                        "lacre_tipo_id"   : parseInt(oLacreTipo.val()),
                        "lacre_descricao" : $(this).val(),
                        "id"              : ''
                    })
                    
                    $(this).val('')

                    setTimeout(function() {
                        var $tag = $this.closest('div').find('.bootstrap-tagsinput').find('span.tag').last()
                        
                        $tag.attr('class', '');

                        switch (parseInt(oLacreTipo.val())) {
                            case 1 : return $tag.addClass('tag label label-primary')
                            case 2 : return $tag.addClass('tag label label-danger label-important')
                            case 3 : return $tag.addClass('tag label label-success')
                            case 4 : return $tag.addClass('tag label label-default')
                            case 5 : return $tag.addClass('tag label label-warning')
                            case 6 : return $tag.addClass('tag label label-info')
                        }
                    }, 200)
                }
            })

        })

    },

    watchInputsReadonly: function () {

        $('select.tipo_container_readonly').change( function() {
            if ($(this).val()) {
                $('.selectpicker.find_container').closest('.lf-selectpicker-ajax').find('.lf-opacity-medium').removeClass('lf-opacity-medium')
            } else {
                $('.selectpicker.find_container').addClass('lf-opacity-medium')
            }
        })

    },

    watchContainerOperacaoOptions: function() {
        $('select.container_operacao_options').change(function() {
            var iOperacaoID = $(this).val() 
                    ? $(this).val() 
                    : $(this).closest('form').find('.operacao_id_doc_entrada_saida').val();

            if (iOperacaoID == 2) {
                $('.selectpicker.find_drive_espaco').removeAttr('required')
            }else if (iOperacaoID == 1) {
                $('.selectpicker.find_drive_espaco').attr('required', 'required')
            }
        })
    },

    watchFindContainer: function() {

        $(".selectpicker.find_container, .selectpicker.documento_containers").on("changed.bs.select", async function(e, iClickedIndex, bNewValue, oldValue) {
            $('.selectpicker.drive_espaco_id_find').val(0)
            $('.selectpicker.drive_espaco_id_find').selectpicker('refresh')
            if ((!iClickedIndex && !bNewValue))
                return;

            var aContainersSelected = $('.selectpicker.find_container option:selected, .selectpicker.documento_containers option:selected');
            var $this = $(this)
            var iOperacaoID = $(this).closest('form').find('select.container_operacao_options').val() 
                ? $(this).closest('form').find('select.container_operacao_options').val() 
                : $(this).closest('form').find('.operacao_id_doc_entrada_saida').val()

            if (!iOperacaoID)
                iOperacaoID = $(this).closest('.modal-body').find('.operacao_id_doc_entrada_saida').val();

            if (iOperacaoID == 2)
                $('.selectpicker.find_drive_espaco').removeAttr('required')
            else if (iOperacaoID == 1 && ParamObrigaDriveEspacoDescargaVazio == 1)
                $('.selectpicker.find_drive_espaco').attr('required', 'required')

            aContainersSelected.each(async function() {
                if (!$(this).closest('select').is(":visible"))
                    return;
                var oResponseBloqueio = await BloqueioContainer.validaBloqueioContainer($(this).text())
                if (oResponseBloqueio.status != 200) {
                    $('.selectpicker.find_container, .selectpicker.documento_containers').val(0)
                    $('.selectpicker.find_container, .selectpicker.documento_containers').selectpicker('refresh')
                    return Utils.swalResponseUtil(oResponseBloqueio)
                }
    
                var oReturn = await ContainersServices.getIdFromValue('Containers', 'numero', $(this).text())
                if (oReturn.status == 200 && oReturn.dataExtra) {
                    var sTipoContainer = $this.closest('.container-fluid').find('.tipo_container_readonly').find("option:selected").text()
                    
                    if (iOperacaoID == 2) {
                        var oResponseValidacao = await ContainersServices.validaEstoqueContainer(oReturn.dataExtra, sTipoContainer)
                        if (oResponseValidacao.status != 200) {
                            $('.selectpicker.find_container, .selectpicker.documento_containers').val(0)
                            $('.selectpicker.find_container, .selectpicker.documento_containers').selectpicker('refresh')
                            return Utils.swalResponseUtil(oResponseValidacao)
                        }
                    } else {
                        $('.selectpicker.find_drive_espaco').closest('.lf-selectpicker-ajax').find('.lf-opacity-medium').removeClass('lf-opacity-medium')
                    }
                }
            });

            $('.container_novo').hide()
            ContainersManager.setDriveByContainer($(this))
            ContainersManager.setArmadorByContainer($(this))
            ContainersManager.setClienteByContainer($(this), iOperacaoID)
                
        })

    },

    watchChangeArmador: function() {
        $('.selectpicker_armador').on('changed.bs.select', function (e) {
            ContainersManager.globalData.armador_id = e.target.value;
        });
    },

    watchChangeCliente: function() {
        // $('.selectpicker_cliente').on('changed.bs.select', function (e) {
        //     ContainersManager.globalData.cliente_id = e.target.value;
        // });
    },

    setArmadorByContainer: async function ($that) {

        $('.selectpicker.selectpicker_armador').val(0)

        var iContainerID = $that.closest('.container-fluid').find('.selectpicker.find_container').val()
        if (!iContainerID)
            return null;

        var oArmador = await ContainersServices.getArmadorByContainerID(iContainerID)

        if (!oArmador)
            return null

        $that.closest('form').find('.selectpicker.selectpicker_armador').append('<option value="'+ oArmador.id +'" title="'+ oArmador.descricao +'">'+ oArmador.descricao +'</option>')
        $that.closest('form').find('.selectpicker.selectpicker_armador').val(oArmador.id)
        $('.selectpicker.selectpicker_armador').selectpicker('refresh')
        $('.selectpicker.selectpicker_armador').change()

    },

    setClienteByContainer: async function ($that, iOperacaoID) {

        $('.selectpicker.selectpicker_cliente').val(0)

        var iContainerID = $that.closest('.container-fluid').find('.selectpicker.find_container').val()
        if (!iContainerID)
            return null;

        var oCliente = await ContainersServices.getClienteDocumento(iContainerID, iOperacaoID, null)
        if (!oCliente)
            return null
        else
            ContainersManager.globalData.cliente_id = oCliente.id

        $('.class-replace.in .selectpicker.selectpicker_cliente').append('<option value="'+ oCliente.id +'" title="'+ oCliente.descricao +'">'+ oCliente.descricao +'</option>')
        $('.class-replace.in .selectpicker.selectpicker_cliente').val(oCliente.id)
        $('.class-replace.in .selectpicker.selectpicker_cliente').selectpicker('refresh')
        $('.class-replace.in .selectpicker.selectpicker_cliente').change()

    },

    setDriveByContainer: async function($that) {
        var iOperacaoID = $('.class-replace.in select.container_operacao_options').val() 
            ? $('.class-replace.in select.container_operacao_options').val() 
            : $('.class-replace.in .operacao_id_doc_entrada_saida').val();

        var sTipoContainer = $('.class-replace.in select.tipo_container_readonly').val();

        if (iOperacaoID != 2)
            return null

        var iContainerID = $that.closest('.container-fluid').find('.selectpicker.find_container').val()
            ? $that.closest('.container-fluid').find('.selectpicker.find_container').val()
            : $that.closest('.container-fluid').find('select.selectpicker.documento_containers').val()
        var oDriveEspaco = await ContainersServices.getDriveEspacoByContainerID(iContainerID, 2)

        $('.class-replace.in .selectpicker.find_drive_espaco').closest('.lf-selectpicker-ajax').find('.lf-opacity-medium').removeClass('lf-opacity-medium')

        if (!oDriveEspaco)
            return null

        if (sTipoContainer == 'VAZIO') {
            $('.class-replace.in .selectpicker.selectpicker_cliente').append('<option value="'+ oDriveEspaco.cliente.id +'" title="'+ oDriveEspaco.cliente.descricao +'">'+ oDriveEspaco.cliente.descricao +'</option>')
            $('.class-replace.in .selectpicker.selectpicker_cliente').val(oDriveEspaco.cliente.id)
            $('.class-replace.in .selectpicker.selectpicker_cliente').selectpicker('refresh')
            $('.class-replace.in .selectpicker.selectpicker_cliente').change()
        }

        $('.class-replace.in .selectpicker.drive_espaco_id_find').append('<option value="'+ oDriveEspaco.id +'" title="'+ oDriveEspaco.descricao +'">'+ oDriveEspaco.descricao +'</option>')
        $('.class-replace.in .selectpicker.drive_espaco_id_find').val(oDriveEspaco.id)
        $('.class-replace.in .selectpicker.find_drive_espaco').selectpicker('refresh')
        $('.class-replace.in .selectpicker.find_drive_espaco').change()
    },

    watchFindDriveEspaco: function() {

        $(".selectpicker.find_drive_espaco").on("changed.bs.select", async function(e, iClickedIndex, bNewValue, oldValue) {

            if ((!iClickedIndex && !bNewValue) || iClickedIndex == 1)
                return;

            $this = $(this).closest('.container-fluid')

            var oData = {
                operacao_id: $('.class-replace.in select.container_operacao_options').val() 
                    ? $('.class-replace.in select.container_operacao_options').val() 
                    : $('.class-replace.in .operacao_id_doc_entrada_saida').val(),

                tipo_container: $('.class-replace.in .tipo_container_readonly').find("option:selected").text(),

                container_id: $('.class-replace.in .selectpicker.find_container option:selected').val()
                    ? $('.class-replace.in .selectpicker.find_container option:selected').val()
                    : $('.class-replace.in select.documento_containers').val(),

                container_numero: $('.class-replace.in .selectpicker.find_container option:selected').text(),

                drive_espaco_descricao: $('.class-replace.in .selectpicker.find_drive_espaco option:selected').text(),

                armador_id: ContainersManager.globalData.armador_id 
                    ? ContainersManager.globalData.armador_id
                    : $('.class-replace.in .selectpicker.selectpicker_armador').val(),
                    
                cliente_id: ContainersManager.globalData.cliente_id 
                    ? ContainersManager.globalData.cliente_id
                    : $('.class-replace.in .selectpicker.selectpicker_cliente').val(),
                    
            }

            console.log(oData);

            if (!oData.operacao_id 
                || !oData.tipo_container 
                || (!oData.container_id && !oData.container_numero && oData.operacao_id != 2 && oData.tipo_container != 'VAZIO') 
                || !oData.drive_espaco_descricao
                /*|| !oData.armador_id*/) {

                Utils.swalUtil({
                    title: 'Ops!',
                    type: 'warning',
                    timer: 4000,
                    html: 'Parece que faltou digitar alguma informação para pesquisar o Drive de Espaço! <br><br> Campos necessários: Operação, Tipo Container, Container, Armador, Cliente.'
                })
                return;
            }

            var oReturn = await ContainersServices.checkDriveEspaco(oData)
            if (oReturn.status != 200) {
                Swal.fire({
                    title: oReturn.title,
                    text: oReturn.message,
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 5000 
                }).then(function () {
                    $('.class-replace.in .selectpicker.find_drive_espaco').val(0)
                    $('.class-replace.in .selectpicker.find_drive_espaco').selectpicker('refresh')
                })
            }

        })

    },

    watchFindDocumentosTransporte: function() {

        $('.find_documentos_transporte').focusout( async function () {
            if ($(this).val()) {
                $this = $(this)
                var oReturn = await ContainersServices.getIdFromValue('DocumentosTransportes', 'numero', $(this).val())

                ContainersManager.setValueFromInputHidden($this, 'documentos_transporte_id_find', oReturn)
            }
        })

    },

    setValueFromInputHidden: function ($that, sClassFromInputHidden, oReturn) {

        if (!ObjectUtil.issetProperty(oReturn, 'status'))
            return false;

        if (oReturn.status == 200) {
            $that.closest('.container-fluid').find('.'+sClassFromInputHidden).val(oReturn.dataExtra)
            if (sClassFromInputHidden == 'container_id_find') {
                $('.find_drive_espaco').prop("readonly", false)
            }
        } else if (oReturn.status == 403) {
            
            Swal.fire({
                title: oReturn.message,
                type: 'warning',
                showConfirmButton: false,
                timer: 5000 
            }).then(function () {
                $that.val('')
            })
            
        } else {

            var oTipoContainer = $that.closest('.container-fluid').find('.tipo_container_readonly').find("option:selected").text()
            var iOperacaoID = $('select.container_operacao_options').val()
            if (sClassFromInputHidden == 'container_id_find' && oTipoContainer == 'VAZIO' && iOperacaoID == 1) {
                $('.find_drive_espaco').prop("readonly", false)
                return ContainersManager.setContainerNovo()
            }

            Swal.fire({
                title: oReturn.title,
                text: oReturn.message,
                type: 'warning',
                showConfirmButton: false,
                timer: 3000 
            }).then(function () {
                $that.val('')
            })

        }

    },

    setContainerNovo: function () {
        $('.container_novo').show()
    },

    watchButtonSalvarDocumentoCheckDriveEspaco: async function () {
        $('.button-salvar-containers:not(.watched-check-drive-espaco)').each(function() {
            $(this).addClass('watched-check-drive-espaco')

            //somente para viagens
            $('.button-salvar-container-programacao, .button_salvar_documento_generic').click(async function(e) {
                
                var oResponseValidacaoDrive = await ContainersManager.validaDriveBeforeSaveModalContainer($('.class-replace.in'));
                
                if (oResponseValidacaoDrive.getStatus() != 200) {
                    e.preventDefault();
                    return false;
                }
    
                return true;
            })
        })
        


    },

    watchButtonDocumentoContainers: function () {

        $('.button_salvar_documento_containers').click( async function (e) {

            ContainersManager.consistQtdeContainers();
            var oDivGlobal  = $(this).closest('.container-fluid')
            var iOperacaoID = oDivGlobal.find('.operacao_id_doc_entrada_saida').val()
            var oForm       = $(this).closest('#documento-form')

            if (iOperacaoID != 1) {
                oForm.submit()
                return false;
            }

            var iNumeroDocEntrada    = oDivGlobal.find('.numero_doc_entrada_saida_hidden').val()
            var oDocumentoContainers = oDivGlobal.find('.selectpicker.documento_containers').val()
            var oDriveEspacos        = oDivGlobal.find('.selectpicker.find_drive_espaco').val()
            var iProgramacaoID       = oDivGlobal.find('.programacao_id_documento_containers').val()
            var sTipoContainer       = oDivGlobal.find('select.tipo_container').val();

            var oResponseValidacaoDrive = await ContainersManager.validaDriveBeforeSaveModalContainer($('.class-replace.in'));
                
            if (oResponseValidacaoDrive.getStatus() != 200) {
                e.preventDefault();
                return false;
            }

            var oResponseExistsAgendamento = await ContainersServices.verifyExistsAgendamentoDocumento(iNumeroDocEntrada, oDocumentoContainers, iProgramacaoID, oDriveEspacos)
            
            if (oResponseExistsAgendamento.status != 200)
                return Utils.swalResponseUtil(oResponseExistsAgendamento)
            
            oForm.submit()
        })

    },

    consistQtdeContainers: function () {

        if (!$('#qtde-container').length)
            return;

        var iQtdeContainers = $('#qtde-container').val();

        if (!iQtdeContainers)
            return Utils.swalUtil({
                title: 'Ops!',
                text: 'Para prosseguir é necessário digitar a quantidade de containers!',
                type: 'warning',
                timer: 5000
            });

        var $aOptionsSelectContainers = $('.selectpicker.documento_containers option');

        var aValues = [];
        $aOptionsSelectContainers.each(function(index) {
            if (!iQtdeContainers)
                return;

            aValues.push($aOptionsSelectContainers.eq(index).val());
            iQtdeContainers--;
        })

        $('.selectpicker.documento_containers').selectpicker('val', aValues);
        $('.selectpicker.documento_containers').trigger('changed.bs.select', [this, 1, 1]);
    }

}

$(document).ready(function() {
    ContainersManager.init()
})
