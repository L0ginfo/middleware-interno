const AvariasManager = {

    init: async function() {

        AvariasManager.watchBtnAddAvaria()
        AvariasManager.watchBtnRemoveAvaria()

    },

    watchGetAvarias: async function() {

        $('.button_conferencia:not(.watched)').click( async function(e) {

            $(this).addClass('watched')

            var sDataTarget = $(this).attr("data-target")
            var oDivGlobal  = $(sDataTarget).find('.global_avarias')
            
            var iOSID        = oDivGlobal.find('.ordem_servico_id_avaria').val()
            var iContainerID = oDivGlobal.find('.container_id_avaria').val()

            var aAvarias = await AvariasServices.getAvarias(iOSID, iContainerID)

            AvariasManager.renderLacres(aAvarias.dataExtra, oDivGlobal)

        })

    },

    watchBtnAddAvaria: function() {

        $('.add_avaria:not(.watched)').click( async function(e) {

            $(this).addClass('watched')

            var oDivGlobalAvarias = $(this).closest('.global_avarias')

            var oData = {
                'iOSID': oDivGlobalAvarias.find('.ordem_servico_id_avaria').val(),
                'iContainerID': oDivGlobalAvarias.find('.container_id_avaria').val(),
                'iAvariaID': oDivGlobalAvarias.find('.avaria_id').val(),
                'iAvariaTipoID': oDivGlobalAvarias.find('.avaria_tipo_id').val(),
                'iVolume': oDivGlobalAvarias.find('.volume_avaria').val(),
                'obs': oDivGlobalAvarias.find('#observacoes').val(),
            }

            var oResponse = await AvariasServices.saveAvaria(oData)

            if (oResponse.status != 200) {
                Swal.fire({
                    type: 'warning',
                    title: oReturn.message
                })
            }

            oDivGlobalAvarias.find('.volume_avaria').val('')
            oDivGlobalAvarias.find('.peso_avaria').val('')

            AvariasManager.renderLacres(oResponse.dataExtra, oDivGlobalAvarias)

        })

    },

    watchBtnRemoveAvaria: function() {

        $('.remove-avaria:not(.watched)').each(function() {

            $(this).click(async function() {
                
                $(this).addClass('watched')

                var responseSwal = await Utils.swalConfirmOrCancel({
                    title:'Deseja realmente remover esta avaria?',
                    text:'A avaria será removido ao prosseguir',
                    confirmButtonText: 'Sim, continuar',
                    showConfirmButton: true,
                    defaultConfirmColor: true,
                    showCancelButton: true,
                })

                if (!responseSwal)
                    return

                var oResponse = await AvariasServices.removeAvaria($(this).attr('data-avaria-id'))

                if (oResponse.status != 200)
                    return Utils.swalResponseUtil(oResponse)

                var oDivGlobal  = $(this).closest('.global_avarias')
                AvariasManager.renderLacres(oResponse.dataExtra, oDivGlobal)

            })

        })

    },

    renderLacres: function(aAvarias, oDivGlobal) {

        var $table = oDivGlobal.find('.table-avarias-adicionadas table')
        if (!aAvarias) {
            $table.find('tbody tr').remove()
            $table.find('tbody').append('<tr><td colspan="3" align="center">Vazio</td></tr>')
            return
        }

        $table.find('tbody tr').remove()

        aAvarias.forEach(oAvaria => {

            oResponse = RenderCopy.render({
                object: oAvaria,
                template: $('.copy.hidden .os_avarias')[0].outerHTML,
                data_to_render: 'avaria',
            })

            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item.')

            //Renderiza
            var sTr = oResponse.getDataExtra()
            $table.find('tbody').append(sTr)

        })

        AvariasManager.watchBtnRemoveAvaria()

    },


}
