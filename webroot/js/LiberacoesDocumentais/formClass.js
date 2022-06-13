aLoteItemIncrement  = (typeof aLoteItemIncrement === "undefined") ? [] : aLoteItemIncrement

var Liberacao = {
    init: function () {
        
        Liberacao.manageWatcherSearch()
        
        Liberacao.manageWatchSelectPickers('.selectpicker-item-liberacao')

        Liberacao.manageWatcherRemove()

        Liberacao.maskTipoDocumento()
    },

    manageWatcherRemove: function () {
        var $oBtnRemove = $('.copy-inputs .remove-item-liberacao.no-watched')
        
        $oBtnRemove.each(function () {
            $(this).removeClass('no-watched')
            $(this).addClass('watched')
            
            var $oBtn = $(this)

            $oBtn.click(function () {
                $oBtn.closest('tr').remove()
            })
        })

    },

    manageWatcherSearch: function () {
        var $oMercadorias = $('.pesquisa-mercadorias')
        var $oBtnSearch = $('.btn-pesquisa')
        var $oInputSearch = $oMercadorias.find('.pesquisa-input')

        $oInputSearch.keydown(function(e){
            //Quando der Enter no campo de pesquisa
            if(e.keyCode == 13){
                $oBtnSearch.click()
            }
        });

        $oBtnSearch.click(async function () {
            var $oMercadorias = $('.pesquisa-mercadorias')
            var $oInputSearch = $oMercadorias.find('.pesquisa-input')
            var $oTypeSearch  = $oMercadorias.find('select.pesquisa-select')
            var valueSearch   = $oInputSearch.val()
            var typeSearch    = $oTypeSearch.val()

            if (valueSearch && typeSearch) {
                Loader.showLoad()

                var oReturn = await Liberacao.doAjax({ search: valueSearch, type: typeSearch }, 'liberacoes-documentais', 'search-conhecimentos')
                
                if (oReturn.status == 200)
                    await Liberacao.drawTable( oReturn.data )
                else 
                    await Swal.fire({
                        title: oReturn.message,
                        type: 'warning',
                        timer: 2000,
                        showConfirmButton: false
                    })

                Loader.hideLoad()
                Liberacao.manageWatcherRemove()
            }
        })
    },

    drawTable: async function (aData) {
        
        if (typeof aData !== 'object')
            return await Swal.fire({
                title: 'Houve algum problema ao formatar os itens, favor contatar os administradores!',
                type: 'warning',
                timer: 2000,
                showConfirmButton: false
            })

        return await new Promise (function (resolve, reject) {
            
            var $oLotesLiberados      = $('.lotes-liberados')
            var $oCopyInputs          = $oLotesLiberados.find('.copy.hidden')
            var $oLotesLiberadosItens = $oLotesLiberados.find('.lotes-liberados-itens')
            var sHtmlBase = $oCopyInputs.html()
            
            aData.forEach(function (elem, index, array) {
                var iEstoqueId = elem.estoque_id;
                var iEstoqueTelaId = $oLotesLiberadosItens
                    .find(`.estoque_id[value="${iEstoqueId}"]`).val();
                if(iEstoqueTelaId != iEstoqueId){
                    sHtmlBase = $oCopyInputs.html()
                    sHtmlBase = Liberacao.formatLine( sHtmlBase ) 
                    var sHtml = Liberacao.injectData( sHtmlBase, elem )
                    $oLotesLiberadosItens.find('.copy-inputs').append( sHtml )
                    Liberacao.addMaskNumericAll()
                    Liberacao.manageWatchSelectPickers('.selectpicker-item-liberacao')
                }
            })
            
            return resolve()
        })
    },

    injectData: function ( sHtml, elem ) {
        var $oHtml = $(sHtml)

        var qtde = elem.qtde_saldo

        if ( qtde.indexOf(',') === -1 ){    
            qtde = parseFloat(elem.qtde_saldo)
            qtde = qtde.toLocaleString('pt-BR')
        }

        $oHtml.find('.conhecimento_transporte').val( elem.transporte_numero );
        $oHtml.find('.conhecimento_master').val( elem.master_numero );
        $oHtml.find('.conhecimento').val( elem.house_numero );
        $oHtml.find('.lote_codigo').val( elem.estoque_lote_codigo );
        $oHtml.find('.lote_item').val( elem.estoque_lote_item );
        $oHtml.find('.estoque_id').val( elem.estoque_id );
        $oHtml.find('.lote_quantidade_estoque').val( qtde );
        $oHtml.find('.liberacao-estoque-ids').val( elem.estoque_id );
        $oHtml.find('.liberacao-estoque-ids').attr('name', 'liberacao_estoque_ids['+elem.estoque_id+']');
        $oHtml.find('.liberacao-estoque-ids').val( qtde );

        if ($('.tipo-liberacao:checked').val() == '0') 
            $oHtml.find('.lote_quantidade_liberar').val( qtde )


        var iRegimePrincipal = $('select.regime-aduaneiro-principal').val()
        
        if (iRegimePrincipal){
            $oHtml.find('select.regime-aduaneiro option').removeAttr('checked')
            $oHtml.find('select.regime-aduaneiro option[value="'+iRegimePrincipal+'"]').attr('checked', 'checked')
            $oHtml.find('select.regime-aduaneiro').val(iRegimePrincipal)
        }

        return $oHtml
    },
    
    manageWatchSelectPickers: function (classCustom) {

        $('.copy-inputs '+classCustom+':not(.watched)').each(function () {
            $(this).addClass('watched')
            $(this).removeClass('no-watched')
            $(this).selectpicker({
                dropupAuto: false
            })
        })

    },

    addMaskNumericAll: function () {
        
        $('.copy-inputs .numeric-double:not([name*="_increment__"])').each(function () {
            $(this).addClass('watched')

            $(this).maskMoney({
                prefix: " ",
                decimal: ",",
                thousands: "."
            });

        })
    },

    formatLine: function ( sHtml ) {
        sHtml = sHtml.replace(new RegExp('tr_item', 'g'), 'tr')
        sHtml = sHtml.replace(new RegExp('td_item', 'g'), 'td')
        
        return Liberacao.manageAssocIncrement(sHtml)
    },

    manageAssocIncrement: function (sHtml) {

        var sToReplace = '__lote_item_increment__'
        var iLastAssoc
        
        //faz a verificacao e gravacao das associacoes de itens para ser vinculado corretamente
        if (aLoteItemIncrement.length){
            iLastAssoc = aLoteItemIncrement[ aLoteItemIncrement.length - 1 ] + 1
        }else {
            iLastAssoc = 1
        }
        
        aLoteItemIncrement.push(iLastAssoc)
        
        return sHtml.replace(new RegExp(sToReplace, 'g'), iLastAssoc)
    },

    doAjax: async function (data, controller, action) {

        var awaitAjax = async function () {
            var oRetorno = null;
            
            await $.ajax({
                url: url + '/' + controller + '/' + action,
                data: data,
                type: 'POST',
                success: function (data) {
                   oRetorno = data;
                }
            })
            return oRetorno;
        }();

        return await awaitAjax

    },

    getMaskTipo: function(id, inputNumero) {
        $.ajax({
            url: webroot + 'tipoDocumentos/get/' + id,
            type: "get",
            success: function (data) {
                if (data.dataExtra.mascara) {
                    inputNumero.addClass('lf-mask-input')
                    inputNumero.mask(data.dataExtra.mascara)
                } else {
                    inputNumero.unmask()
                }
            }
        })
    },

    maskTipoDocumento: function() {
        var iTipoDocumentoId = $('#tipo option:selected').val();
        var inputNumero = $('#numero');
        Liberacao.getMaskTipo(iTipoDocumentoId, inputNumero)

        $('#tipo').change( function () {
            var tipo = $(this).find('option:selected').attr('value')
            Liberacao.getMaskTipo(tipo, inputNumero)
        })
    },
}

$(document).ready(function () {
    Liberacao.init();
})