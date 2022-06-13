var fManageLoadInitLogboxAssocs = function () {
    setTimeout( function () { 
        LogboxAssocButtons.watchLogBoxEdit() 
    }, 700)
}

var LogboxAssocButtons = {

    init: function() {
        this.watchLogboxButtons()
        this.watchLogBoxInputsSelectsChange()

        $(window).load(fManageLoadInitLogboxAssocs)

    },

    watchLogBoxEdit: function () {

        $('.copy-mercadorias .item-mercadoria').each( function () {
            var oObject = {
                merc_assoc: $(this).attr('data-item-count'),
                merc_btn_containers: $(this).find('.btn-modal-containers')
            }
            LogboxAssocButtons.watchClickBtn(oObject)
        });

    },

    watchLogboxButtons: function () {

        $('html').on('mercadoria-item-add', function (event, object) {

            LogboxAssocButtons.setDataTargetButtonContainers(object)
            LogboxAssocButtons.watchClickBtn(object)

        })

    },

    setDataTargetButtonContainers: function (object) {

        var newDataTarget = $(object.merc_btn_containers).attr('data-merc-assoc')
        newDataTarget = newDataTarget.replace('[$$$]', '[' + object.merc_assoc + ']')
        $(object.merc_btn_containers).attr('data-merc-assoc', newDataTarget)

    },

    watchClickBtn: function (object) {

        $(object.merc_btn_containers).click( function () {

            var sContentModal = $(this).closest('.item-mercadoria').find('.content-containers-lacres')
            var aaa = $('#modal-logbox .modal-body').html($(sContentModal).html())
            $('#modal-logbox .button-salvar-containers').attr('data-assoc-containers-mercadorias', $(this).attr('data-merc-assoc'))

            LogboxAssocButtons.watchLogboxContainerAdd()
            LogboxAssocButtons.watchLogboxContainersSave()

            var oContentModalContainerAppend = aaa.find('.item-mercadoria-container-add-append')
            LogboxAssocButtons.watchLogboxContainerFind(oContentModalContainerAppend)
            LogboxAssocButtons.watchLogboxContainerLacre(oContentModalContainerAppend)
            LogboxAssocButtons.watchLogboxContainerNovo(oContentModalContainerAppend)
            LogboxAssocButtons.watchLogboxContainerExcluir(oContentModalContainerAppend)
            LogboxAssocButtons.watchLogboxContainerLacreExcluir(oContentModalContainerAppend)
            ContainersUtil.maskContainer()
            ContainersUtil.upperCaseContainer()

        })

    },

    watchLogBoxInputsSelectsChange: function () {

        var fAction = function () {
            var oInputs = $("#modal-logbox .modal-body :input:not(.watched-trigger)")

            oInputs.each(function(){
                if ($(this).closest('.hidden').size()) {
                    return;
                }

                $(this).addClass('watched-trigger')
                $(this).attr('value', $(this).val())
                $(this).on('keydown, keyup, change', function () {
                    $(this).attr('value', $(this).val())
                })
            });
        }

        $('html').on('keydown, keyup, change, click', function () {
            setTimeout( function () { fAction() }, 500)
        })
        $(window).on('load', function () { 
            setTimeout( function () { fAction() }, 500)
        })
    },

    watchLogboxContainersSave: function () {

        $('.button-salvar-containers, #modal-logbox .close, .button-cancelar-containers, .modal.fade.class-replace.in').click( async function () {
            if ($(this).hasClass('closing')) {
                return;
            }

            if ($(this).hasClass('button-salvar-containers')) {

                var bReturn = false;
                var oLinhaContainerAdd = $(this).closest('.modal-content').find('.linha-container-add')
                var oInputsContainers  = oLinhaContainerAdd.find('.input-find-container')

                oInputsContainers.each( async function () {
                    if ($(this).val()) {
                        var oLacreAdicionado = $(this).closest('.linha-container-add').find('.linha-container-lacre-adicionado')
                        
                        if (oLacreAdicionado.length == 1)
                            bReturn = true
                    }
                })

                if (bReturn) {
                    Swal.fire({
                        title: 'Ops! Faltou informar os lacres deste item dentro deste container!',
                        type: 'warning'
                    })
                    return await Utils.waitMoment(100)
                }

            }
            
            var oContentModal = $('#modal-logbox .modal-body')
            var sAssocModal = $(this).attr('data-assoc-containers-mercadorias')
            var oContentItemMercadoria = $("[data-merc-assoc='"+sAssocModal+"']").closest('.item-mercadoria').find('.hidden.content-containers-lacres')
            var oCheckboxes = oContentItemMercadoria.closest('.copy-mercadorias').find('.container-checkbox')
                       
            var aCheckeds = []
            oCheckboxes.each( function () {
                if ($(this).is(':checked')) {
                    aCheckeds.push($(this).val())
                }
            })

            if (aCheckeds.length < 1 && $(this).hasClass('button-salvar-containers')) {

                var bReturn = false;
                var oLinhaContainerAdd = $(this).closest('.modal-content').find('.linha-container-add')
                var oInputsContainers  = oLinhaContainerAdd.find('.input-find-container')

                oInputsContainers.each( async function () {
                    if ($(this).val()) {
                        var oQuantidade = $(this).closest('.linha-container-add').find('.input-check-quantidade')
                        
                        if (!oQuantidade.val())
                            bReturn = true
                    }
                })

                if (bReturn) {
                    Swal.fire({
                        title: 'Ops! Faltou informar a quantidade deste item dentro deste container!',
                        type: 'warning'
                    })
                    return await Utils.waitMoment(100)
                }

            }

            if (aCheckeds.length >= 1) {
                oItensIds = oContentModal.find('.documento_mercadoria_itens_ids')
                oItensIds.each( function () {
                    $(this).val(aCheckeds)
                })
                oCheckboxes.each( function () {
                    if (oCheckboxes.is(':checked')) {
                        oCheckboxes.closest('.item-mercadoria').find('.documento_mercadoria_itens_ids').val(aCheckeds)
                    }
                })
            }

            oContentItemMercadoria.html(oContentModal.html()) 
            
            LogboxAssocButtons.removeClassTrigger(oContentItemMercadoria)
    
            await Utils.waitMoment(500)
            oContentModal.html('')

            oContentModal.closest('#modal-logbox').find('.close').addClass('closing')
            oContentModal.closest('#modal-logbox').find('.close').click()
            
            await Utils.waitMoment(500)
            oContentModal.closest('#modal-logbox').find('.close').removeClass('closing')

            if (aCheckeds.length > 1) 
                $('.save_containers_checkbox').submit()

        })

    },

    removeClassTrigger: function (oContentItemMercadoria) {

        oContentItemMercadoria.find('.watched-trigger').removeClass('watched-trigger')
        oContentItemMercadoria.find('.included-trigger').removeClass('included-trigger')

    },

    watchLogboxContainerAdd: function () {

        $('.button-container-add').click( function () {
            
            var oContentModalContainer = $(this).closest('.modal-body').find('.item-mercadoria-container-add')
            var oContentModalContainerAppend = $(this).closest('.modal-body').find('.item-mercadoria-container-add-append')

            oContentModalContainerAppend.append($(oContentModalContainer).html())            
            LogboxAssocButtons.setAssocInputsContainers(oContentModalContainerAppend)
            
        })

    },

    setAssocInputsContainers: function (oContentModalContainerAppend) {

        if (aAssocContainer.length){
            lastAssocContainer = aAssocContainer[ aAssocContainer.length - 1 ] + 1
        }else {
            lastAssocContainer = 1
        }

        aAssocContainer.push(lastAssocContainer)

        oContentModalContainerAppend.find('.form-control').each(function () {
            
            var $input = $(this)
            var newNameInput = $input.attr('name')
            newNameInput = newNameInput.replace('[$$$$]', '[' + lastAssocContainer + ']')
            $input.attr('name', newNameInput)

        })

        LogboxAssocButtons.watchLogboxContainerFind(oContentModalContainerAppend)
        LogboxAssocButtons.watchLogboxContainerLacre(oContentModalContainerAppend)
        LogboxAssocButtons.watchLogboxContainerNovo(oContentModalContainerAppend)
        LogboxAssocButtons.watchLogboxContainerExcluir(oContentModalContainerAppend)
        LogboxAssocButtons.watchLogBoxContainerQuantidade(oContentModalContainerAppend)

    },

    watchLogBoxContainerQuantidade: function (oContentModalContainerAppend) {

        oContentModalContainerAppend.find('.input-check-quantidade').each( function () {

            $(this).focusout( async function () {

                var iItemMercadoriaAssoc = $('#modal-logbox .button-salvar-containers').attr('data-assoc-containers-mercadorias')
                var oContentItemMercadoria = $("[data-merc-assoc='"+iItemMercadoriaAssoc+"']").closest('.item-mercadoria').find('.quantidade-merc-item').val()

                var iSomaQuantidadeContainers = 0
                $(this).closest('.modal-body').find('.input-check-quantidade').each( async function () {
                    if (parseInt($(this).val())) {
                        iSomaQuantidadeContainers += parseInt($(this).val())
                    }
                })

                if (!oContentItemMercadoria) {
                    Swal.fire({
                        title: 'Favor digitar primeiro a quantidade da Mercadoria Item',
                        type: 'warning'
                    })
                    $('#modal-logbox').find('.close').click()
                }

                if (iSomaQuantidadeContainers > oContentItemMercadoria) {
                    Swal.fire({
                        title: 'A quantidade digitada é maior que a da Mercadoria Item',
                        type: 'warning'
                    })
                    $(this).val('')
                }

            })

        })

    },

    watchLogboxContainerFind: function (oContentModalContainerAppend) {

        oContentModalContainerAppend.find('.input-find-container').each( function () {
            var $this = $(this)

            $(this).focusout( async function () {
                
                if (!$(this).val())
                    return

                var oResponseDigitoVerificador = await ContainersUtil.validaDigitoVerificador($(this));
                if (oResponseDigitoVerificador.status != 200) {
                    $(this).val('');
                    return Utils.swalResponseUtil(oResponseDigitoVerificador);
                }
                
                $(this).closest('.linha-container-add').find('.button-container-novo').removeClass('hidden')

                var oResponseBloqueio = await BloqueioContainer.validaBloqueioContainer($(this).val());
                console.log(oResponseBloqueio);
                if (oResponseBloqueio.status != 200) {
                    $(this).val('');
                    return Utils.swalResponseUtil(oResponseBloqueio);
                }

                var oReturn = await LogBoxServices.findContainer($(this).val(), 'check')

                if (oReturn.status == 200) {
                    Swal.fire({
                        title: oReturn.message,
                        type: 'success',
                        showConfirmButton: false,
                        timer: 3000 
                    }).then(function () {
                        LogboxAssocButtons.setInputsContainerExist($this.closest('.linha-container-add'), oReturn)
                    })
                } else {
                    Swal.fire({
                        type: 'warning',
                        title: oReturn.message
                    }).then(function () {
                        LogboxAssocButtons.setInputsContainerNew($this, oReturn)
                        ContainersUtil.digitoVerificador()
                    })
                }

            })
        
        })

    },

    setInputsContainerNew: function ($that, oReturn) {

        $that.closest('.linha-container-add').find('.button-container-novo-add').addClass('new-container')
        $that.closest('.linha-container-add').find('.button-container-novo').trigger('click')
        $that.closest('.linha-container-add').find('.numero_container_edit').val($that.val())

    },

    setInputsContainerExist: function ($that, oReturn) {

        $that.find('.button-container-novo-add').removeClass('new-container')
        var buttonContainerEditar = $that.find('.button-container-novo')
        var inputsContainerEditar = $that
        var aSetInputs = ['container_id_edit', 'numero_container_edit', 'tara_container_edit']
        var aSetSelects = ['tipo_iso_container_edit', 'armador_container_edit']

        var iIdContainerAnterior = inputsContainerEditar.find('.container_id_edit').val()
        
        aSetInputs.forEach(element => {
            inputsContainerEditar.find('.'+element).val(oReturn.dataExtra[element])
            inputsContainerEditar.find('.'+element).attr('readonly', true)
        });

        aSetSelects.forEach(element => {
            inputsContainerEditar.find('.'+element).val(oReturn.dataExtra[element])
            inputsContainerEditar.find('.'+element).attr('readonly', true)

            inputsContainerEditar.find('.'+element+' option').each(function() {
                if ($(this).val() == oReturn.dataExtra[element]) {
                    $(this).attr('selected', 'selected')
                } else {
                    $(this).attr('selected', false)
                }
            })
        })


        var oButtonSalvar = $that.closest('.modal-content').find('.button-salvar-containers')
        var sAssocModal = oButtonSalvar.attr('data-assoc-containers-mercadorias')
        var oContentItemMercadoria = $("[data-merc-assoc='"+sAssocModal+"']").closest('.item-mercadoria').find('.hidden.content-containers-lacres')
        var oCheckboxes = oContentItemMercadoria.closest('.copy-mercadorias').find('.container-checkbox')

        if (oCheckboxes) {
            oCheckboxes.each( function () {
                if ($(this).is(':checked')) {
                    var oIdContainersEditar = oCheckboxes.closest('.item-mercadoria').find('.container_id_edit')
                    
                    oIdContainersEditar.each( function () {
                        if ($(this).val() == iIdContainerAnterior) {
                            $(this).val(oReturn.dataExtra['container_id_edit'])
                        }
                    })
    
                }
            })
        }

        buttonContainerEditar.html('<i class="glyphicon glyphicon-th" aria-hidden="true"></i> Editar')
        buttonContainerEditar.trigger('click')

    },

    watchLogboxContainerLacre: function (oContentModalContainerAppend) {

        oContentModalContainerAppend.find('.button-container-lacre:not(.included-trigger)').each( function () {
            
            $(this).addClass('included-trigger')
            $(this).click( function () {

                $(this).closest('.linha-container-add').find('.linha-container-lacre-add').toggleClass("hidden")
                $(this).closest('.linha-container-add').find('.linha-container-novo-add').addClass("hidden")
            })
            
        })

        LogboxAssocButtons.watchLogboxContainerLacreAdd(oContentModalContainerAppend)

    },

    watchLogboxContainerNovo: function (oContentModalContainerAppend) {

        oContentModalContainerAppend.find('.button-container-novo:not(.included-trigger)').each( function () {

            var iContainerId = $(this).closest('.linha-container-add').find('.container_id_edit').val()
            if (iContainerId) {
                $(this).html('<i class="glyphicon glyphicon-th" aria-hidden="true"></i> Editar')
            }
            
            $(this).addClass('included-trigger')
            $(this).click( function () {

                $(this).closest('.linha-container-add').find('.linha-container-novo-add').toggleClass("hidden")
                $(this).closest('.linha-container-add').find('.linha-container-lacre-add').addClass("hidden")

            })
            
        })

        LogboxAssocButtons.watchLogboxContainerNovoSalvar(oContentModalContainerAppend)

    },

    watchLogboxContainerNovoSalvar: function (oContentModalContainerAppend) {

        oContentModalContainerAppend.find('.button-container-novo-add:not(.included-trigger)').each( function () {

            $(this).addClass('included-trigger')
            $(this).click( function () {

                if ($(this).hasClass('new-container')) {
                    LogboxAssocButtons.setNewContainer($(this).closest('.linha-container-add'))
                }

                aSetSelects = ['tipo_iso_container_edit', 'armador_container_edit']
                aSetSelects.forEach(element => {
                    var iOption = oContentModalContainerAppend.find('.'+element).val()
        
                    oContentModalContainerAppend.find('.'+element+' option').each(function() {
                        if ($(this).val() == iOption) {
                            $(this).attr('selected', 'selected')
                        } else {
                            $(this).attr('selected', false)
                        }
                    })
                })

                $(this).closest('.linha-container-add').find('.linha-container-novo-add').toggleClass("hidden")
                $(this).closest('.linha-container-add').find('.linha-container-lacre-add').addClass("hidden")

            })
            
        })

        oContentModalContainerAppend.find('.button-container-novo-add').click( function () {

            var iEntradaID = $(this).closest('.container-novo').find('.id').val()
            var iFreeTime  = $(this).closest('.container-novo').find('.free_time_edit').val()

            var oButtonSalvar = $(this).closest('.modal-content').find('.button-salvar-containers')
            var sAssocModal = oButtonSalvar.attr('data-assoc-containers-mercadorias')
            var oContentItemMercadoria = $("[data-merc-assoc='"+sAssocModal+"']").closest('.item-mercadoria').find('.hidden.content-containers-lacres')
            var oEntradas = oContentItemMercadoria.closest('.copy-mercadorias').find('.container-novo').find('.id')

            oEntradas.each( function() {
                if ($(this).val() == iEntradaID) {
                    $(this).closest('.container-novo').find('.free_time_edit').val(iFreeTime)
                }
            })

        })

    },

    setNewContainer: async function (oContentModalContainerAppend) {

        var aInputs = ['tipo_iso_container_edit', 'numero_container_edit', 'armador_container_edit', 'tara_container_edit']
        var oDataInputs = new Object()
        aInputs.forEach(element => {
            oDataInputs[element] = oContentModalContainerAppend.find('.'+element).val()
        });

        var oReturn = await LogBoxServices.findContainer(oDataInputs, 'set')
        if (oReturn.status == 200) {
            Swal.fire({
                title: oReturn.message,
                type: 'success',
                showConfirmButton: false,
                timer: 3000 
            }).then(function () {
                LogboxAssocButtons.setInputsContainerExist(oContentModalContainerAppend, oReturn)
            })
        } else {
            Swal.fire({
                type: 'warning',
                title: oReturn.message
            })
        }

    },

    watchLogboxContainerExcluir: function (oContentModalContainerAppend) {

        oContentModalContainerAppend.find('.button-container-excluir').each( function () {
                        
            $(this).click( async function () {

                var iItemContainerId = $(this).closest('.linha-container-add').find('.item_container_id').val()

                if (iItemContainerId) {
                    var oCheckboxes = $('.copy-mercadorias').find('.container-checkbox')
                    var aCheckeds   = []

                    oCheckboxes.each( function () {
                        if ($(this).is(':checked')) {
                            aCheckeds.push($(this).val())
                        }
                    })

                    var oResponse = await LogboxAssocButtons.manageAjaxDeleteContainer(iItemContainerId, aCheckeds)
                    if (oResponse.status == 200) {
                        $(this).closest('.linha-container-add').remove()
                    }
                } else {
                    $(this).closest('.linha-container-add').remove()
                }

                setTimeout( function () { 
                    LogboxAssocButtons.rebindModalAfterClose()
                }, 400)

            })
            
        })
    },

    manageAjaxDeleteContainer: async function (iItemContainerId, aCheckeds) {

        oData = {
            title: 'Você tem certeza?',
            text: "O registro será apagado assim que confirmar",
            showCancelButton: true,
            confirmButtonText: 'Sim, deletar',
            showConfirmButton: true
        }
         
        var oResponse = await Utils.swalConfirmOrCancel(oData, () => { return LogBoxServices.deleteContainer(iItemContainerId, aCheckeds) })

        if (oResponse.status == 200) {
            Utils.swalUtil(Object.assign(oResponse, {timer: 3000}))
            if (aCheckeds)
                window.location.reload();
        }

        Swal.fire({
            title: oResponse.title,
            text: oResponse.message,
            type: 'warning'
        })
        return await Utils.waitMoment(100)

    },


    watchLogboxContainerLacreAdd: function (oContentModalContainerAppend) {

        oContentModalContainerAppend.find('.button-container-lacre-add:not(.included-trigger)').each( function () {
            $(this).addClass('included-trigger')

            $(this).click( function () {
            
                var oContentModalContainerLacre = $(this).closest('.linha-container-lacre-add').find('.container-lacre-add')
                var oContentModalContainerLacreAppend = $(this).closest('.linha-container-lacre-add').find('.container-lacre-add-append')
                oContentModalContainerLacreAppend.append($(oContentModalContainerLacre).html())
                LogboxAssocButtons.setAssocInputsContainersLacres(oContentModalContainerLacreAppend)
    
            })

        })

    },

    setAssocInputsContainersLacres: function (oContentModalContainerLacreAppend) {

        if (aAssocLacre.length){
            lastAssocLacre = aAssocLacre[ aAssocLacre.length - 1 ] + 1
        }else {
            lastAssocLacre = 1
        }

        aAssocLacre.push(lastAssocLacre)

        oContentModalContainerLacreAppend.find('.form-control').each(function () {
            
            var $input = $(this)
            var newNameInput = $input.attr('name')
            newNameInput = newNameInput.replace('[$$$$$]', '[' + lastAssocLacre + ']')
            $input.attr('name', newNameInput)

        })

        LogboxAssocButtons.setSequenciaLacresAdicionados(oContentModalContainerLacreAppend, lastAssocLacre)
        LogboxAssocButtons.watchLogboxContainerLacreExcluir(oContentModalContainerLacreAppend)

    },

    setSequenciaLacresAdicionados: function (oContentModalContainerLacreAppend, lastAssocLacre) {

        oContentModalContainerLacreAppend.find('.linha-container-lacre-adicionado').each(function () {
            var $input = $(this)
            var newNameInput = $input.attr('data-lacre-sequencia')
            newNameInput = newNameInput.replace('[$$$$$]', lastAssocLacre)
            $input.attr('data-lacre-sequencia', newNameInput)

            var oContentModalContainerLacreLacreId = $(this).closest('.linha-container-lacre-add').find('.lacre_id').val()
            var oContentModalContainerLacreLacreTipoId = $(this).closest('.linha-container-lacre-add').find('.lacre_tipo_id').val()

            var $dataSequencia = $('*[data-lacre-sequencia="' + lastAssocLacre + '"]')
            
            $dataSequencia.find('.lacre_id_adicionado').val(oContentModalContainerLacreLacreId)
            $dataSequencia.find('.lacre_tipo_id_adicionado').val(oContentModalContainerLacreLacreTipoId)

            $dataSequencia.find('.lacre_id_adicionado').attr('value', oContentModalContainerLacreLacreId)
            $dataSequencia.find('.lacre_tipo_id_adicionado').attr('value', oContentModalContainerLacreLacreTipoId)

            $dataSequencia.find('.lacre_tipo_id_adicionado option').each(function() {
                if ($(this).val() == oContentModalContainerLacreLacreTipoId) {
                    $(this).attr('selected', 'selected')
                }
            })

            $dataSequencia.find('.lacre_id_adicionado').attr('readonly', 'readonly')
            $dataSequencia.find('.lacre_tipo_id_adicionado').attr('readonly', 'readonly')

        })

    },

    watchLogboxContainerLacreExcluir: function (oContentModalContainerLacreAppend) {

        oContentModalContainerLacreAppend.find('.button-container-lacre-excluir').each( function () {
            
            $(this).click( async function () {

                var iLacreId = $(this).closest('.linha-container-lacre-adicionado').find('.container_lacre_id_edit').val()
                if (iLacreId) {
                    var oResponse = await LogboxAssocButtons.manageAjaxDeleteLacre(iLacreId)
                    if (oResponse.status == 200) {
                        $(this).closest('.linha-container-lacre-adicionado').remove();
                    }
                } else {
                    $(this).closest('.linha-container-lacre-adicionado').remove();
                }

                setTimeout( function () { 
                    LogboxAssocButtons.rebindModalAfterClose()
                }, 400)

                // window.location.reload();

            })

        })
    },

    rebindModalAfterClose: function () {

        var oContentModal = $('#modal-logbox .modal-body')
        var sAssocModal = oContentModal.closest('.modal-content').find('.button-salvar-containers').attr('data-assoc-containers-mercadorias')
        var oContentItemMercadoria = $("[data-merc-assoc='"+sAssocModal+"']").closest('.item-mercadoria').find('.hidden.content-containers-lacres')

        oContentItemMercadoria.html(oContentModal.html()) 
        
        LogboxAssocButtons.removeClassTrigger(oContentItemMercadoria)

    },

    manageAjaxDeleteLacre: async function (iLacreId) {

        oData = {
            title: 'Você tem certeza?',
            text: "O registro será apagado assim que confirmar",
            showCancelButton: true,
            confirmButtonText: 'Sim, deletar',
            showConfirmButton: true
        }
         
        var oResponse = await Utils.swalConfirmOrCancel(oData, () => { return LogBoxServices.deleteLacre(iLacreId) })

        if (oResponse.status == 200) {
            Utils.swalUtil(Object.assign(oResponse, {timer: 3000}))
        }
        return oResponse
    },

}

var fManageInitLogboxAssocButtons = function() {

    Utils.MultipleChecksAction.init({
        sBtnAction  : 'select-all-action-btn',
        sCheckAll   : 'select-all-inputs',
        sCheckChild : 'select-all-child',
        sClassToHide: 'lf-opacity-medium',
        sClassToShow: 'lf-opacity-full',
        iQtdToShow  : 1,
        processNow  : true,
        oClassClosest : 'copy-mercadorias'
    })

    LogboxAssocButtons.init()

}

$(document).ready(fManageInitLogboxAssocButtons)
