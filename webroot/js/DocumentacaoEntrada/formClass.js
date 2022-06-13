var classMaster = '.master'
var classHouse = '.house'
var isCopyOfMaster = false
var setTimerReflesh; 
var setTimerUpdateHeigth; 
var setManageWatchSelectPickersAjax;
var setInitNumericDoubles;
var setManageWatchSelectPickers ;
var setRefreshPaginator;
var setWatchShowBsSelect;
var setSaveControleEspecificosInDocMercadoria;
var setManageWatchCopyMaster;
var setManageWatchTipoMercadoria;
var setManageMercAssoc;
var setFindUnidadeMedidaByProduto;
var setManageMercRemove;

var updateHeigth = () => {
    //clearTimeout(setTimerUpdateHeigth);
    setTimerUpdateHeigth = setTimeout(function () {
        $('.owl-carousel').each(function () {
            var $this = $(this)
            $this.on('changed.owl.carousel', function () {
                $this.find('.owl-stage-outer').height( $this.find('.owl-stage').first().height() )
            })
        })
    }, 600)
}

var Form = {
    init: function(tipo) {
        tipo = '.'+tipo

        var $conhecimento = $('form .conhecimento'+tipo)

        $conhecimento.find('.owl-carousel').owlCarousel({
            loop:false,
            nav:false,
            autoHeight:true,
            singleItem:true,
            items:1,
            autoplay:false,
            dots:false,
            autoHeight:true,
            stagePadding:0,
            //autoWidth
            touchDrag:false,
            mouseDrag:false,
            pullDrag:false,
            freeDrag:false
        })

        $conhecimento.find('.copy-inputs').on('changed.owl.carousel', function () {
            $(this).owlCarousel('update')
        })
        
        //Watchers
        Form.onAddData(tipo)
        Form.onTogglePages(tipo)
        Form.onRemovePages(tipo)
        Form.manageMercAssoc()
        Form.manageWatchCopyMaster()
        Form.manageWatchTipoMercadoria()
        Form.manageShowMercDescrition()
        Form.initNumericDoubles()
        Form.manageWatchSelectPickersAjax()
        Form.functionNull()
        Form.manageInitOthers();

    },

    manageWatchSelectPickersAjax: function() {
        //clearTimeout(setManageWatchSelectPickersAjax);
        //setManageWatchSelectPickersAjax =  setTimeout(() => {
            $('.owl-item .selectpickerAjaxClientes:not(.included-trigger-selectpicker)').each(function() {
                $(this).addClass('included-trigger-selectpicker');
                Utils.doSelectpickerAjax($(this), url + '/empresas/filterQuerySelectpicker', {}, {"busca":"{{{q}}}", "limit": 3});
            })
            Utils.fixSelectPicker()
        //}, 1000);
    },

    initNumericDoubles: function() {
        //clearTimeout(setInitNumericDoubles);
        //setInitNumericDoubles =  setTimeout(() => {

            $('.conhecimento .copy-inputs .put-numeric-double').each(function() {
            Form.manageNumericDouble($(this))
            })
            
            $('.conhecimento .copy-inputs .mercadoria-itens .copy-mercadorias').each(function() {
                Form.manageNumericDouble($(this))
            })

        //}, 1000);
    },

    manageWatchSelectPickers: function (classCustom) {
        $('.copy-inputs .full-item-owl '+classCustom+':not(.watched)').each(function () {
            $(this).addClass('watched')
            $(this).removeClass('no-watched')
            $(this).selectpicker({
                dropupAuto: false
            })
        })
        
    },

    manageWatchCopyMaster: function () {
        //clearTimeout(setManageWatchCopyMaster);
        //setManageWatchCopyMaster =  setTimeout(() => {
        $('.master .copy-master-to-house:not(.watched)').each(function () {
            $(this).addClass('watched')
            $(this).removeClass('no-watched')
            
            $(this).click(function () {
                
                    if (isCopyOfMaster) {
                        var tipo_doc = $('.conhecimento.master .copy-inputs .owl-item.active .tipo_documento_master').val()
                        var numero_doc = $('.conhecimento.master .copy-inputs .owl-item.active .numero_documento').val()
                        var emissao_doc = $('.conhecimento.master .copy-inputs .owl-item.active .emissao_documento').val()
                        var $oHouseActive = $('.conhecimento.house .copy-inputs .owl-item.active')

                        var numero_doc_house = $oHouseActive.find('.numero_documento').val()
                        var emissao_doc_house  = $oHouseActive.find('.emissao_documento').val()
                        
                        if (numero_doc_house == "" || emissao_doc_house == ""){
                            $oHouseActive.find('.tipo_documento_house').val(tipo_doc)
                            $oHouseActive.find('.numero_documento').val(numero_doc)
                            $oHouseActive.find('.emissao_documento').val(emissao_doc)
                        }else {                    
                            $('.conhecimento.house .add-data.house').click();
                            setTimeout(function () {        
                                $oHouseActive = $('.conhecimento.house .copy-inputs .owl-item.active')
                                $oHouseActive.find('.tipo_documento_house').val(tipo_doc)
                                $oHouseActive.find('.numero_documento').val(numero_doc)
                                $oHouseActive.find('.emissao_documento').val(emissao_doc)
                            }, 600)
                        }

                        setTimeout(function () {        
                            Form.refreshAll()
                        }, 680)
                        
                    }
            })
        })
        //}, 1000)
    },

    manageWatchTipoMercadoria: function () {
        //clearTimeout(setManageWatchTipoMercadoria);
        //setManageWatchTipoMercadoria =  setTimeout(() => {
        $('.copy-inputs .tipo_mercadoria_id:not(.watched)').each(function () {
            $(this).addClass('watched')
            $(this).removeClass('no-watched')
            var aGetTiposMasterToHouse = ['1', '2', '5', '6', '9', '10', '13', '14', '19', '20']
            
            $(this).change( function () {
                isCopyOfMaster = false

                if ($(this).val() == '1'){
                    isCopyOfMaster = true
                    $('.copy-master-to-house').addClass('active-normal')
                    $('.copy-master-to-house').removeClass('active-skel')
                }else if ( aGetTiposMasterToHouse.includes($(this).val())){ //tipo_mercadoria_id master to house
                    isCopyOfMaster = true
                    $('.copy-master-to-house').removeClass('active-normal')
                    $('.copy-master-to-house').addClass('active-skel')
                }else {
                    isCopyOfMaster = false
                    $('.copy-master-to-house').removeClass('active-normal')
                    $('.copy-master-to-house').removeClass('active-skel')
                }
            })

            if ($(this).val() == '1'){
                isCopyOfMaster = true
                $('.copy-master-to-house').addClass('active-normal')
                $('.copy-master-to-house').removeClass('active-skel')
            }else if ( aGetTiposMasterToHouse.includes($(this).val()) ){ //tipo_mercadoria_id master to house
                isCopyOfMaster = true
                $('.copy-master-to-house').removeClass('active-normal')
                $('.copy-master-to-house').addClass('active-skel')
            }else {
                isCopyOfMaster = false
                $('.copy-master-to-house').removeClass('active-normal')
                $('.copy-master-to-house').removeClass('active-skel')
            }

        })
        //}, 1000);
    },

    onAddData: function (tipo) {

        var $conhecimento = $('form .conhecimento'+tipo)
        
        $conhecimento.find('.add-data').click(function () {
            var $copy_data = $conhecimento.find('.copy'+tipo)
            $conhecimento.find('.owl-carousel'+tipo).owlCarousel('add', $copy_data.html()).owlCarousel('update')

            Form.refreshAll()

            Form.manageAssoc(tipo)
            
            var $carousel = $conhecimento.find('.copy-inputs')
            var $active = $carousel.find('.owl-item.active')
            
            setTimeout(() => {
                Form.manageNumericDouble($(this).closest('.conhecimento').find('.copy-inputs .put-numeric-double'))
                Form.goToLastPage(tipo)
                Form.manageWatchTipoMercadoria()
                Form.manageWatchSelectPickersAjax()
            }, 200)
        })
    },

    refreshAll: function (ms = 300) {
        clearTimeout(setTimerReflesh);
        setTimerReflesh = setTimeout(function () {
            $('.owl-carousel').each(function () {
                $(this).trigger('refresh.owl.carousel')
            })
            
            $(this).trigger('refreshed.owl.carousel', Form.refreshPaginator())
            
        }, ms ? ms :300);
    },

    refreshPaginator: function (){
        clearTimeout(setRefreshPaginator);
        setRefreshPaginator =  setTimeout(() => {

            var $oFieldsets = $('fieldset')

            $oFieldsets.each(function () {
                var $oOwlCarousel  = $(this).find('.owl-carousel')
                var $oPaginator    = $(this).find('.paginator-slider')

                if ($oPaginator.length) {
                    var $oItens        = $oOwlCarousel.find('.owl-item')
                    var iItens         = $oItens.size()
                    var $oItemActive   = $oOwlCarousel.find('.owl-item.active')
                    var iItemActive    = $oItens.index( $oItemActive ) + 1

                    $oPaginator.find('.to').html(iItens)
                    $oPaginator.find('.from').html(iItemActive)
                }
            })

        }, 1000);
    },

    goToLastPage: function (tipo) {
        
        var $conhecimento = $('form .conhecimento'+tipo)
        var $carousel = $conhecimento.find('.copy-inputs')
        var $itens = $carousel.find('.owl-item')
        var $lastItem = $itens.last()
        var indexLastItem = $itens.index( $lastItem )

        if (tipo == classMaster)
            Form.manageToggleMaster(tipo, 'next', indexLastItem)
        else
            Form.manageToggleHouse(tipo, 'next', indexLastItem)
    },

    manageAssoc: function (tipo) {            
        
        if (tipo == classMaster){
            Form.manageAssocMaster(tipo)
        }else {
            Form.manageAssocHouse(tipo)
        }

    },

    manageAssocMaster: function (tipo) {
        var $conhecimento = $('form .conhecimento'+tipo)
        var $carousel = $conhecimento.find('.copy-inputs')

        $carousel.find('.item[data-assoc="[$]"]').each(function () {
            var $item = $(this)
            var lastAssoc
            
            //faz a verificacao e gravacao das associacoes de masters para o house ser vinculado corretamente
            if (aAssoc.length){
                lastAssoc = aAssoc[ aAssoc.length - 1 ] + 1
            }else {
                lastAssoc = 1
            }
            
            aAssoc.push(lastAssoc)

            $item.attr('data-assoc', lastAssoc)

            $item.find('.form-control').each(function () {
                var $input = $(this)
                var newNameInput = $input.attr('name')
                newNameInput = newNameInput.replace('[$]', '[' + lastAssoc + ']')
                $input.attr('name', newNameInput)
            })

        })
    },

    manageAssocHouse: function (tipo) {
        var $conhecimento = $('form .conhecimento'+tipo)
        var $carousel = $conhecimento.find('.copy-inputs')
        var $activeMaster = $('form .conhecimento'+classMaster+' .copy-inputs .owl-item.active')
        var numAssoc = $activeMaster.find('.item').attr('data-assoc')

        $carousel.find('.item[data-master="[$]"]').each(function () {
            var $item = $(this)
            var lastAssocMerc
            
            //faz a verificacao e gravacao das associacoes de houses para a mercadoria ser vinculada corretamente
            if (aAssocMerc.length){
                lastAssocMerc = aAssocMerc[ aAssocMerc.length - 1 ] + 1
            }else {
                lastAssocMerc = 1
            }
            
            aAssocMerc.push(lastAssocMerc)

            $item.attr('data-master', numAssoc)
            $item.attr('data-merc', lastAssocMerc)

            $item.find('.form-control').each(function () {
                var $input = $(this)
                var newNameInput = $input.attr('name')
                newNameInput = newNameInput.replace('[$]', '[' + numAssoc + ']')
                newNameInput = newNameInput.replace('[$$]', '[' + lastAssocMerc + ']')
                $input.attr('name', newNameInput)
            })

            $carousel.removeClass('disable-edit')

            Form.manageMercAssoc()
        })
    },

    manageMercAssoc: function () {
        //clearTimeout(setManageMercAssoc);
        //setManageMercAssoc =  setTimeout(() => {
            $('.copy-inputs .full-item-owl .add-data-mercadoria:not(.included-trigger)').each(function () {
                $(this).addClass('included-trigger')
                $(this).click(function () {
                    var $itemHouse = $(this).closest('.item'+classHouse)
                    var $mercadorias = $itemHouse.find('.mercadoria-itens')
                    var numAssoc = $itemHouse.attr('data-master')
                    var numAssocMerc = $itemHouse.attr('data-merc')
                    var $copy = $mercadorias.find('.copy.mercadorias')
                    var html_mercadorias = $copy.html() 
                    var lastMerc
                    $mercadorias.find('.copy-mercadorias').append( html_mercadorias )
                    
                    $itemHouse.closest('.owl-carousel').trigger('refresh.owl.carousel')

                    //faz a verificacao e gravacao das associacoes de mercadoria ser vinculada corretamente
                    if (aMercs.length){
                        lastMerc = aMercs[ aMercs.length - 1 ] + 1
                    }else {
                        lastMerc = 1
                    }

                    aMercs.push(lastMerc)

                    $('html').trigger('mercadoria-item-add', { merc_assoc: lastMerc, merc_btn_containers: $mercadorias.find('.copy-mercadorias .btn-modal-containers').last()})

                    $mercadorias.find('.copy-mercadorias .form-control').each(function () {
                        var $input = $(this)
                        if ($input.attr('name') == undefined)
                            return;

                        var newNameInput = $input.attr('name')
                        newNameInput = newNameInput.replace('[$]', '[' + numAssoc + ']')
                        newNameInput = newNameInput.replace('[$$]', '[' + numAssocMerc + ']')
                        newNameInput = newNameInput.replace('[$$$]', '[' + lastMerc + ']')
                        $input.attr('name', newNameInput)
                    })
                    
                    Utils.scrollBindTogetherLeft()
                    Form.refreshAll()
                    Form.manageShowMercDescrition()
                    Form.manageNumericDouble($(this).closest('.mercadoria-itens').find('.copy-mercadorias'))

                    Form.findUnidadeMedidaByProduto();
                    Form.manageInitOthers();

                })

            })
            Form.manageMercRemove()
        //}, 1000);
    },

    manageNumericDouble: async function($oScope) {
        await Utils.waitMoment(150)

        $oScope.find('.numeric-double:not(.included-trigger-double)').each(function () {
            $(this).addClass('included-trigger-double')
            $.fn.numericDoubleAction($(this))
        })
    },

    manageShowMercDescrition: function() {
        var oMercadoriaFirst = $('.copy-inputs.house .owl-item.active .copy-mercadorias .item-mercadoria:first')

        if (!oMercadoriaFirst.size())
            return

        oMercadoriaFirst.find('.select-all-child').css('margin-top', '43px')
        oMercadoriaFirst.find('label').css({
            display: 'block'
        })
    },

    manageMercRemove: function () {

        clearTimeout(setManageMercRemove);
        setManageMercRemove =  setTimeout(() => {
            $('.copy-inputs .full-item-owl .remove-data-mercadoria:not(.included-trigger)').each(function () {
                $(this).addClass('included-trigger')

                $(this).click(async function () {                    
                    var $mercadorias = $(this).closest('.mercadoria-itens')
                    var $lastChild = $mercadorias.find('.copy-mercadorias .item-mercadoria:last')
                    var lastChildHaveID = $lastChild.find('.form-control.id.documento_mercadoria_item_id')[0];
                    var retorno = null
                    
                    if (Form.isEdit() && typeof lastChildHaveID !== 'undefined' && $(lastChildHaveID).val()) {
                        retorno = await Form.manageAjaxDelete('', $lastChild)
                    }

                    if ( (retorno !== null && retorno && Form.isEdit()) || 
                        ( Form.isEdit() && (!lastChildHaveID || !$(lastChildHaveID).val() ) ) || 
                        !Form.isEdit() ) 
                    {
                        $lastChild.slideUp().remove()
                        $mercadorias.closest('.owl-carousel').trigger('refresh.owl.carousel')
                    }

                    Form.manageShowMercDescrition()
                })
            })
        }, 1000);

    },

    isEdit: function () {          
        var isEdit = $('.edit').size();

        if (!isEdit) 
            return false  

        return true
    },

    manageAjaxDelete: async function (tipo = null, $obj) {

        var $conhecimento = $('form .conhecimento'+tipo)
        var $carousel = $conhecimento.find('.copy-inputs')
        var $active = $carousel.find('.owl-item.active')
        var childHaveID = $active.find('.id').size();
        var iDocTransporteID = $('.transporte').find('.id').val();

        if (!childHaveID)
            return true;
            
        return await Swal.fire({
            title: 'Você tem certeza?',
            text: "O registro será apagado assim que confirmar",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#41B314',
            cancelButtonColor: '#ac2925',
            confirmButtonText: 'Sim, deletar',
            cancelButtonText: 'Não',
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                var retorno

                if (tipo == classMaster) 
                    retorno = await Form.manageAjaxDeleteMaster($obj, iDocTransporteID)
                else if (tipo == classHouse) 
                    retorno = await Form.manageAjaxDeleteHouse($obj, iDocTransporteID)
                else 
                    retorno = await Form.manageAjaxDeleteMercItem($obj, iDocTransporteID)
                
                if (retorno.status === 200){
                    return true
                }else{
                    Swal.showValidationMessage('A requisição falhou retornando: ' + retorno.message)
                    return false
                } 

            },
            allowOutsideClick: () => !Swal.isLoading()

        }).then (async result => {

            if (result.value) {

                await Swal.fire({
                    title: 'Registro deletado!',
                    text: "",
                    type: 'success',
                    timer: 1500,
                    showConfirmButton: false
                })

                return true

            }else {
                return false
            }

        })

    },

    manageAjaxDeleteMaster: async function ($obj, iDocTransporteID) {
        
        var data = { id: $obj.find('.form-control.id').val(), doc_transporte_id: iDocTransporteID }
        var action = 'MercadoriaMaster'

        return await Form.doAjax(data, action)
    },

    manageAjaxDeleteHouse: async function ($obj, iDocTransporteID) {

        var data = { id: $obj.find('.form-control.id').val(), doc_transporte_id: iDocTransporteID }
        var action = 'MercadoriaHouse'

        return await Form.doAjax(data, action)
    },

    manageAjaxDeleteMercItem: async function ($obj, iDocTransporteID) {
        var data = { id: $obj.find('.form-control.id.documento_mercadoria_item_id').val(), doc_transporte_id: iDocTransporteID }
        var action = 'MercadoriaItem'

        return await Form.doAjax(data, action)
    },

    doAjax: async function (data, action) {
        return await $.ajax({
            type: 'POST',
            data: data,
            url: url + '/documentacao-entrada/remove-data-ajax/' + action
        })
    },

    next: function ($conhecimento) {
        $conhecimento.find('.owl-carousel').trigger('next.owl') 
    },
    
    prev: function ($conhecimento) {
        $conhecimento.find('.owl-carousel').trigger('prev.owl') 
    },

    nextPage: function ( tipo ) {
        Form.manageToggle(tipo, 'next')
    },

    prevPage: function ( tipo ) {          
        Form.manageToggle(tipo, 'prev')
    },
    
    onTogglePages: function ( tipo ) {
        var $conhecimento = $('form .conhecimento'+tipo)

        $conhecimento.find('.next-data').click(function () {
            Form.nextPage( tipo )
        })

        $conhecimento.find('.prev-data').click(function () {
            Form.prevPage( tipo )
        })

              
    },

    manageToggle: function (tipo, dir) {

        setTimeout(function () {

            if (tipo == classMaster)
                Form.manageToggleMaster(tipo, dir)
            else if (tipo == classHouse)
                Form.manageToggleHouse(tipo, dir) 

            updateHeigth()

        }, 100)

        Form.refreshAll()
    },

    manageToggleMaster: function (tipo, dir, indexLastItem = null) {
        var $conhecimento      = $('form .conhecimento'+tipo)
        var $carousel          = $conhecimento.find('.copy-inputs')
        var totalItems         = $carousel.find('.owl-item').size() - 1
        var $conhecimentoHouse = $('form .conhecimento'+classHouse)
        var $carouselHouse     = $conhecimentoHouse.find('.copy-inputs')
        var $itemActiveHouse   = $carouselHouse.find('.owl-item.active')
        var indexHouseActive   = $carouselHouse.find('.owl-item').index( $itemActiveHouse ) 
        var $active            = $carousel.find('.owl-item.active')
        var goToIndex = null
        var step = null;
        var needMoveMaster = false

        
        if (!$active.size())
        return console.log('nenhum ativo')
        
        var activeIndex        = $carousel.find('.owl-item').index($active)
        
        if (!$active.size())
        return console.log('nenhum index ativo')
        
        var numAssoc           = $active.find('.item'+classMaster).attr('data-assoc')
        
        if (indexLastItem !== null) {                
            $carouselHouse.addClass('disable-edit')
            $carousel.trigger('to.owl', indexLastItem);
            return true;
        }
            
        if (dir == 'next'){
            needMoveMaster = (activeIndex == totalItems) ? false : true
            if (needMoveMaster)
                Form.next( $conhecimento )
        }else {
            needMoveMaster = (activeIndex == 0) ? false : true
            if (needMoveMaster)
                Form.prev( $conhecimento )
        }

        $active = $carousel.find('.owl-item.active')
        if (!$active.size()) return console.log('nenhum ativo')
        
        activeIndex = $carousel.find('.owl-item').index($active)        
        if (!$active.size()) return console.log('nenhum index ativo')
            
        var numAssoc = $active.find('.item'+classMaster).attr('data-assoc')

        if (needMoveMaster) { 
            $itemActiveHouse.nextAll().each(function () {
                var $item = $(this)
                
                if ($item.find('.item').attr('data-master') == numAssoc && !goToIndex) {
                    var goToIndexCheck = $carouselHouse.find('.owl-item').index( $item ) 
                
                    if (goToIndexCheck > indexHouseActive)
                        goToIndex = $item                        
                }
            })

            if (goToIndex) {
                
                goToIndex = $carouselHouse.find('.owl-item').index( goToIndex ) 
                step = goToIndex - indexHouseActive 
                $carouselHouse.removeClass('disable-edit')
                $carouselHouse.trigger('to.owl', goToIndex)

            }else {
                $itemActiveHouse.prevAll().each(function () {
                    var $item = $(this)
                    
                    if ($item.find('.item').attr('data-master') == numAssoc && !goToIndex) {
                        var goToIndexCheck = $carouselHouse.find('.owl-item').index( $item ) 
                    
                        if (goToIndexCheck < indexHouseActive)
                            goToIndex = $item                        
                    }
                })
                
                if (goToIndex) {
                    goToIndex = $carouselHouse.find('.owl-item').index( goToIndex ) 
                    step = indexHouseActive - goToIndex
                    $carouselHouse.trigger('to.owl', goToIndex)
                    $carouselHouse.removeClass('disable-edit')

                }else {                    
                    
                    goToIndex = null
                    
                    if ($itemActiveHouse.find('.item' + classHouse).attr('data-master') == numAssoc) {
                        $carouselHouse.removeClass('disable-edit')
                    }else {
                        $carouselHouse.addClass('disable-edit')
                    }
                }
            }

            Form.callTriggerHouse(goToIndex, dir, step)
        }
    },

    manageToggleHouse: function (tipo, dir, indexLastItem = null, triggerIndex = false) {
        var $conhecimento      = $('form .conhecimento'+classMaster)
        var $carousel          = $conhecimento.find('.copy-inputs')
        var $active            = $carousel.find('.owl-item.active')
        var totalItems         = $carousel.find('.owl-item').size() - 1
        var numAssoc           = $active.find('.item'+classMaster).attr('data-assoc')
        var $conhecimentoHouse = $('form .conhecimento'+classHouse)
        var $carouselHouse     = $conhecimentoHouse.find('.copy-inputs')
        var $itemActiveHouse   = $carouselHouse.find('.owl-item.active')

        var goToIndex = null
        var indexHouseActive = $carouselHouse.find('.owl-item').index( $itemActiveHouse ) 

        console.log('atual:', indexHouseActive);
        console.log('action', dir);
         
        if (indexLastItem !== null) {
            $carouselHouse.removeClass('disable-edit')
            $carouselHouse.trigger('to.owl', indexLastItem)
            if(triggerIndex) Form.callTriggerHouse(true, 'current', indexLastItem);
            return true;
        }

        if (dir == 'next'){
            $itemActiveHouse.nextAll().each(function () {
                var $item = $(this)
                
                if ($item.find('.item').attr('data-master') == numAssoc && !goToIndex) {
                    var goToIndexCheck = $carouselHouse.find('.owl-item').index( $item ) 
                
                    if (goToIndexCheck > indexHouseActive)
                        goToIndex = $item                        
                }
            })
            
            if (goToIndex) {
                goToIndex = $carouselHouse.find('.owl-item').index( goToIndex ) 
                $carouselHouse.removeClass('disable-edit')
                $carouselHouse.trigger('to.owl', goToIndex)
            }else {
                goToIndex = null;
            }
        }else {
            $itemActiveHouse.prevAll().each(function () {
                var $item = $(this)
                
                if ($item.find('.item').attr('data-master') == numAssoc && !goToIndex) {
                    var goToIndexCheck = $carouselHouse.find('.owl-item').index( $item ) 
                
                    if (goToIndexCheck < indexHouseActive)
                        goToIndex = $item                        
                }
            })
            
            if (goToIndex) {
                goToIndex = $carouselHouse.find('.owl-item').index( goToIndex ) 
                $carouselHouse.removeClass('disable-edit')
                $carouselHouse.trigger('to.owl', goToIndex)
            }else {
                goToIndex = null;
            }
        }
        
        Form.callTriggerHouse(goToIndex, dir, 1)
        
    },

    callTriggerHouse: function ( goToIndex, dir, step) {

        if (goToIndex != null) {
            setTimeout(() => {
                $('body').trigger('toggledPageHouse', { dir: dir, step: step })
            }, 150);
        }  

    },

    onRemovePages: function (tipo) {
        var $form = $('form')
        var $conhecimentos = $form.find('.conhecimento'+tipo)
        
        $conhecimentos.on('click', '.remove-data', async function () {
            var $conhecimento = $(this).closest('.conhecimento'+tipo)
            var $carousel = $conhecimento.find('.owl-carousel'+tipo)
            var $pageToRemove = $carousel.find('.owl-item.active')
            var $pageToActive = $pageToRemove.prev()

            var childHaveID = $pageToRemove.find('.form-control.id')[0];
            var childValue = $(childHaveID).val()
            var retorno = null

            if (Form.isEdit() && typeof childHaveID !== 'undefined' && childValue) {
                retorno = await Form.manageAjaxDelete(tipo, $pageToRemove)
            }
            
            if ( (retorno !== null && retorno && Form.isEdit()) || ( Form.isEdit() && (!childHaveID || !childValue) ) || !Form.isEdit() ) {
                Form.manageOnRemovePages(tipo, $pageToRemove, $pageToActive)
                $carousel.trigger('refresh.owl.carousel')
            }

            Form.refreshAll()
        })
    },

    manageOnRemovePages: function (tipo, $pageToRemove, $pageToActive) {
        if (tipo == classMaster){
            var needMove = Form.manageRemoveMaster(tipo, $pageToRemove)
            
            if (needMove)
                if ($pageToActive.size())
                    Form.prevPage(tipo)
                else 
                    Form.nextPage(tipo)

        }else {
            Form.manageRemoveHouse(tipo, $pageToRemove)
            
            if ($pageToActive.size())
                Form.prevPage(tipo)
            else 
                Form.nextPage(tipo)
        }
    },

    manageRemoveHouse: function (tipo, $pageToRemove) {
        var $conhecimento = $('.conhecimento'+tipo)
        var $carousel = $conhecimento.find('.owl-carousel'+tipo)
        var indexToRemove = $carousel.find('.owl-item').index( $pageToRemove )
        
        setTimeout(() => {
            $carousel.trigger('remove.owl.carousel', [indexToRemove]).trigger('refresh.owl.carousel')
        }, 200)
    },

    manageRemoveMaster: function (tipo, $pageToRemove) {            
        var $conhecimentoMaster = $('form .conhecimento'+classMaster)
        var $carouselMaster     = $conhecimentoMaster.find('.copy-inputs')
        var $conhecimentoHouse  = $('form .conhecimento'+classHouse)
        var $carouselHouse      = $conhecimentoHouse.find('.copy-inputs')
        var numAssoc            = $pageToRemove.find('.item'+classMaster).attr('data-assoc')
        var $itemToRemoveHouse  = $carouselHouse.find('.owl-item .item'+classHouse+'[data-master="'+numAssoc+'"]')
        
        
        //remove cada elemento da lista de houses e atualiza a informacao da nova
        //lista no owlCarousel, quando nao tiver mais nenhum associado ao master, cai do while
        while ($itemToRemoveHouse.size() > 0) {
            var i = 0
            var $itemsHouse = $carouselHouse.find('.owl-item')

            $itemToRemoveHouse.each(function () {
                i++
                //acao para remover um por vez
                if (i == 1) {
                    var $item = $(this).parent()
                    var indexToRemove = $itemsHouse.index( $item )
                    $carouselHouse.trigger('remove.owl.carousel', indexToRemove).trigger('refresh.owl.carousel')
                }
            })

            $itemToRemoveHouse = $carouselHouse.find('.owl-item .item'+classHouse+'[data-master="'+numAssoc+'"]')
        }

        var $conhecimento = $('.conhecimento'+tipo)
        var $carousel = $conhecimento.find('.owl-carousel'+tipo)
        var indexToRemove = $carousel.find('.owl-item').index( $pageToRemove )
        
        setTimeout(() => {
            $carousel.trigger('remove.owl.carousel', [indexToRemove]).trigger('refresh.owl.carousel')

            var $itemActiveMaster = $carouselMaster.find('.owl-item.active .item')
            var $itemActiveHouse  = $carouselHouse.find('.owl-item.active .item')
            var numAssocMaster    = $itemActiveMaster.attr('data-assoc')
            var numAssocHouse     = $itemActiveHouse.attr('data-master')

            if (numAssocHouse == numAssocMaster) {
                $carouselHouse.removeClass('disable-edit')
            }

        }, 200)

        return true
    },

    functionNull: function () {

        return ''

    },

    validaQtdeMinimaItem: function () {
        if (!bParamQtdeMinimaItem)
            return null;

        var sTextItem = bParamQtdeMinimaItem > 1
            ? 'itens'
            : 'item';

        $('form.add, form.edit').submit(function (e) {
            var iCountItens = 0

            $('.copy-mercadorias .item-mercadoria').each(function() {
                iCountItens++
            })

            if (iCountItens >= bParamQtdeMinimaItem) {
                return true;
            }

            e.preventDefault()

            var aCampos = [
                '<br><b>Da capa:</b>',
                'Documento',
                'Emissão',
                'Cliente',
                'Peso',
                'Volume',
                '',
                '<b>Dos itens:</b>',
                'Quantidade',
                'Peso Líquido',
                'Peso Bruto',
                'Produto',
                'Valor Total',
            ];

            Utils.swalUtil({
                title: 'Espere!',
                html: 'Você <b style="color:red">NÃO ADICIONOU</b> a quantidade mínima de <b>' + bParamQtdeMinimaItem + ' ' + sTextItem + '</b>! Para prosseguir, você deverá <b>OBRIGATÓRIAMENTE</b> preencher os campos:' + aCampos.join('<br>') + ' <br> Caso houver Container(s) neste Documento, favor <b style="color:green">ADICIONAR</b> também!',
                allowOutsideClick: false,
                showConfirmButton: true,
                confirmButtonText: 'Eu entendi!',
                timer: 17000
            })

            return false;
        })
    },

    validaProdutoIdOnNf: function () {
        if ($('select.tipo_documento_change').find('option:selected').text() != 'NF')
            return null;

        $('form.add, form.edit').submit(function (e) {
            if ($('select.tipo_documento_change')
                .find('option:selected').text() != 'NF')
                    return null;

            var iCountItens = 0
            var iCountProdutos = 0
            $('.copy-mercadorias .item-mercadoria').each(function() {
                if ($(this).find('select.select_produto_id').val())
                    iCountProdutos++

                iCountItens++
            })

            if (iCountItens == iCountProdutos) {
                return true;
            }

            e.preventDefault()

            Utils.swalUtil({
                title: 'Espere!',
                html: 'Você esqueceu de preencher o Produto de algum Item!',
                allowOutsideClick: false,
                showConfirmButton: true,
                confirmButtonText: 'Eu entendi!',
                timer: 17000
            })

            return false;
        })
    },

    findUnidadeMedidaByProduto: function() {
        clearTimeout(setFindUnidadeMedidaByProduto);
        setFindUnidadeMedidaByProduto =  setTimeout(() => {
        $('.copy-mercadorias .item-mercadoria select.select_produto_id:not(.watched-und)').each(function() {
            $(this).addClass('watched-und')

            $(this).change(async function() {
                var oResponse = await $.fn.doAjax({
                    url: 'unidade-medidas/getUnidadeMedidaByProduto',
                    type: 'GET',
                    data: {
                        produto_id: $(this).val()
                    }
                })

                if (oResponse.status == 200) {
                    $(this).closest('.item-mercadoria').find('select.select_unidade_medida_id').val(oResponse.dataExtra.unidade_medida_id)
                }
            })
        })}, 1000)
    },

    saveControleEspecificosInDocMercadoria: function() {
        //clearTimeout(setSaveControleEspecificosInDocMercadoria);
        //setSaveControleEspecificosInDocMercadoria =  setTimeout(() => {
        $('.copy-mercadorias .item-mercadoria select.select_produto_id').each( async function() {

            await Utils.waitMoment(1000)
            
            var iMercadoriaID = $(this).closest('.item-mercadoria').find('.container-checkbox').val()
            var oSelect       = $(this).closest('.item-mercadoria').find('select.select_controle_especificos')

            var oResponse = await $.fn.doAjax({
                url: 'controle-especificos/services/saveInDocMercadoria',
                type: 'POST',
                data: {aData: {produto_id: $(this).val(), mercadoria_id: iMercadoriaID}}
            })

            if (oResponse.status == 200 && oResponse.dataExtra) {

                $(this).closest('.item-mercadoria').find('.hiddem_controle_especifico').removeClass('hidden')
                
                oSelect.selectpicker({
                    style: 'btn-default',
                    size: 16,
                    container: 'body'
                });
                
                oSelect.find('option').remove()

                $.each(oResponse.dataExtra, function(iID, oValues) {

                    oSelect.append($('<option>', { 
                        value: parseInt(iID),
                        text : oValues.descricao,
                        selected: oValues.selected
                    }))

                })

                oSelect.selectpicker('refresh')

            } else {

                $(this).closest('.item-mercadoria').find('.hiddem_controle_especifico').addClass('hidden')

            }
        
        })
        //}, 1000);

    },

    watchShowBsSelect: function () {
        //clearTimeout(setWatchShowBsSelect);
        //setWatchShowBsSelect =  setTimeout(() => {
            $(".copy-mercadorias .item-mercadoria .bootstrap-select.select_controle_especificos").each( function () {

            Form.fActionAdjustHeightMercItemBySelectpicker($(this))

            // $(this).on('show.bs.select', function() {

            //     $(this).closest('.col-lg-3').css('margin-bottom', '200px');

            //     $('.owl-carousel').each(function () {
            //         $(this).trigger('refresh.owl.carousel')
            //     })
    
            // });

            // $(this).on('hide.bs.select', function() {

            //     $(this).closest('.col-lg-3').css('margin-bottom', '0px');
                
            //     $('.owl-carousel').each(function () {
            //         $(this).trigger('refresh.owl.carousel')
            //     })
    
            // });

            })
        //}, 1000);
    },

    manageInitOthers:function(){
        console.log('entro 3');

        try {
            ConhecimentoMaritimoManager.initNcm();
        } catch (error) {
            console.log(error);
        }

        try {
            Form.manageWatchProdutoSelectPickersAjax();
        } catch (error) {
            console.log(error);
        }
    },

    fActionAdjustHeightMercItemBySelectpicker: function(element) {
        var iHeightSum = 400

        element.on('shown.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            const height = $('.house .owl-stage-outer.owl-height').height();
            $('.house .owl-stage-outer.owl-height').height(height+iHeightSum)
            const heightItem = $(this).closest('.item-mercadoria').height();
            $(this).closest('.item-mercadoria').height(heightItem+iHeightSum)
        });

        element.on('hidden.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            const height = $('.house .owl-stage-outer.owl-height').height();
            $('.house .owl-stage-outer.owl-height').height(height-iHeightSum);
            const heightItem = $(this).closest('.item-mercadoria').height();
            $(this).closest('.item-mercadoria').height(heightItem-iHeightSum);
        });
    },

    manageWatchProdutoSelectPickersAjax:function(){

        setTimeout(() => {

            var $aItens = $('.copy-inputs .owl-item .copy-mercadorias .selectpickerAjaxProdutos:not(.included-trigger-selectpicker)');
            console.log('os itens 1:', $aItens);

            $aItens.each(function() {

                $(this).addClass('included-trigger-selectpicker');
                
                Utils.doSelectpickerAjax(
                    $(this), url + '/produtos/filterQuerySelectpicker', {}, {"busca":"{{{q}}}", "limit": 3}
                );
                    
                setTimeout(function(element){
                    Form.fActionAdjustHeightMercItemBySelectpicker(element)
                }($(this)), 1000);
            })

            $aItens = $('.copy-inputs .owl-item .copy-mercadorias .selectpicker:not(.included-trigger-selectpicker)');
            console.log('os itens 2:', $aItens);
            $aItens.each(function() {

                $(this).addClass('included-trigger-selectpicker');
                    
                setTimeout(function(element){
                    Form.fActionAdjustHeightMercItemBySelectpicker(element)
                }($(this)), 1000);
            })

            Utils.fixSelectPicker();
              
        }, 1000);
    }

}