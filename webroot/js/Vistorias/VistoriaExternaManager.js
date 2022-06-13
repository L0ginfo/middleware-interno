const VistoriaExternaManager = {

    init: async function() {

        VistoriaExternaManager.functionNull()
        VistoriaExternaManager.watchAddLacreVistoriaExterna()
        VistoriaExternaManager.watchRemoveLacre()
        VistoriaExternaManager.watchBtnFinalizar()
        VistoriaExternaManager.watchBtnFinalizarSemAbertura()

    },

    watchGetLacres: async function() {
        
        var iVistoriaId     = VistoriaExternaManager.getScope().find('.vistoria_id_lacres').val()
        var iVistoriaItemId = VistoriaExternaManager.getScope().find('.vistoria_item_id_lacres').val()
        if (!iVistoriaId)
            return;

        var aLacres         = await VistoriaExternaServices.getLacres(iVistoriaId, iVistoriaItemId)
            
        VistoriaExternaManager.renderLacres(aLacres, iVistoriaItemId)

    },

    getScope: function() {

        return $('.div_global_lacres')

    },

    functionNull: function () {

        return ''

    },

    watchAddLacreVistoriaExterna: function() {

        $('.add-lacres:not(.watched)').click( async function(e) {

            $(this).addClass('watched')

            var oDivGlobalLacres = $(this).closest('.div_global_lacres')
            var iLacreTipoID     = oDivGlobalLacres.find('.lacre_tipo_id').val()
            var sLacreNumero     = oDivGlobalLacres.find('.lacre_numero').val()

            if (!iLacreTipoID || !sLacreNumero)
                return Swal.fire({
                    title: 'Atenção',
                    html: 'É necessário preencher o Lacre e o Tipo!',
                    type: 'warning'
                })

            var sLacre          = sLacreNumero,
                iLacreTipoId    = iLacreTipoID,
                iVistoriaId     = oDivGlobalLacres.find('.vistoria_id_lacres').val(),
                iVistoriaItemId = oDivGlobalLacres.find('.vistoria_item_id_lacres').val()

            var oResponse = await VistoriaExternaServices.saveLacre(sLacre, iLacreTipoId, iVistoriaId, iVistoriaItemId)

            if (oResponse.status != 200) {
                Swal.fire({
                    type: 'warning',
                    title: oReturn.message
                })
            }

            oDivGlobalLacres.find('.lacre_numero').val('')

            VistoriaExternaManager.renderLacres(oResponse.dataExtra, iVistoriaItemId)

        })

    },

    watchRemoveLacre: function() {

        $('.table-lacres-adicionados .remove-lacre:not(.watched)').each(function() {

            $(this).click(async function() {

                $(this).addClass('watched')

                var responseSwal = await Utils.swalConfirmOrCancel({
                    title:'Deseja realmente remover este lacre?',
                    text:'O lacre será removido ao prosseguir',
                    confirmButtonText: 'Sim, continuar',
                    showConfirmButton: true,
                    defaultConfirmColor: true,
                    showCancelButton: true,
                })
        
                if (!responseSwal)
                    return

                var oResponse = await VistoriaExternaServices.removeLacre($(this).attr('data-lacre-id'))

                if (oResponse.status != 200)
                    return Utils.swalResponseUtil(oResponse)

                VistoriaExternaManager.renderLacres(oResponse.dataExtra)

            })

        })

    },

    renderLacres: function(aLacres) {

        var $table = VistoriaExternaManager.getScope().find('.table-lacres-adicionados table')
        if (!aLacres) {
            $table.find('tbody tr').remove()
            $table.find('tbody').append('<tr><td colspan="3" align="center">Vazio</td></tr>')
            return
        }

        $table.find('tbody tr').remove()

        aLacres.forEach(oLacre => {

            oResponse = RenderCopy.render({
                object: oLacre,
                template: $('.copy.hidden .lacre-carga-solta')[0].outerHTML,
                data_to_render: 'lacre',
            })
    
            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item.')

            //Renderiza
            var sTr = oResponse.getDataExtra()
            $table.find('tbody').append(sTr)
            
        })

        VistoriaExternaManager.watchRemoveLacre()

    },

    watchBtnFinalizar: function() {

        $('.btn_finalizar').click( function(e) {

            e.preventDefault()

            return Swal.fire({

                title: 'Atenção',
                text: 'Tem certeza que deseja finalizar a vistoria?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#41B314',
                cancelButtonColor: '#ac2925',
                confirmButtonText: 'Sim, continuar',
                cancelButtonText: 'Não',
                showLoaderOnConfirm: true

            }).then (async result => {

                if (result.dismiss != 'cancel') {

                    var iVistoriaId     = VistoriaExternaManager.getScope().find('.vistoria_id_lacres').val()
                    var iVistoriaItemId = VistoriaExternaManager.getScope().find('.vistoria_item_id_lacres').val()
                    var aLacres         = await VistoriaExternaServices.getLacres(iVistoriaId, iVistoriaItemId)
                    if (aLacres.length === 0)
                        return Swal.fire({
                            title: 'Atenção',
                            html: 'Para vistorias com abertura de porta é necessário informar os Lacres!',
                            type: 'warning'
                        })

                    $(this).closest('.finalizar_externa').find('.abertura_porta').val('com_abertura')
                    $(this).closest('.finalizar_externa').submit()

                } else {

                    return false

                }

            })

        })

    },

    watchBtnFinalizarSemAbertura: function() {

        $('.btn_finalizar_sem_abertura').click( function(e) {

            e.preventDefault()

            return Swal.fire({

                title: 'Atenção',
                text: 'Tem certeza que deseja finalizar a vistoria sem abertura de porta?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#41B314',
                cancelButtonColor: '#ac2925',
                confirmButtonText: 'Sim, continuar',
                cancelButtonText: 'Não',
                showLoaderOnConfirm: true

            }).then (async result => {

                if (result.dismiss != 'cancel') {

                    var iVistoriaId     = VistoriaExternaManager.getScope().find('.vistoria_id_lacres').val()
                    var iVistoriaItemId = VistoriaExternaManager.getScope().find('.vistoria_item_id_lacres').val()
                    var aLacres         = await VistoriaExternaServices.getLacres(iVistoriaId, iVistoriaItemId)
                    if (aLacres.length != 0)
                        return Swal.fire({
                            title: 'Atenção',
                            html: 'Para vistorias sem abertura de porta não podem conter Lacres!',
                            type: 'warning'
                        })

                    $(this).closest('.finalizar_externa').find('.abertura_porta').val('sem_abertura')
                    $(this).closest('.finalizar_externa').submit()

                } else {

                    return false

                }

            })

        })

    },


}
