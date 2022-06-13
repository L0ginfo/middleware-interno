const VeiculosPesagensService = {
    saveVeiculoPesagem: async function(sPlaca, oRegistroPesagem, iContainer = '') {
        var oResponse = await $.fn.doAjax({
            url: 'pesagem-veiculos/save-veiculo-pesagem',
            data: { 
                placa: sPlaca,
                registro_pesagem: oRegistroPesagem,
                container: iContainer
            },
            type: 'POST'
        })

        return oResponse
    },
    getVeiculosPesagens: async function() {
        var oResponse = await $.fn.doAjax({
            url: 'pesagem-veiculos/get-pesagens-veiculos',
            type: 'POST',
            data: {
                pesagem_id: VeiculosPesagensData.getPesagemID()
            }
        })
        
        try {
            var oOrdemServico = oResponse.dataExtra.pesagem_veiculos[0].pesagem.resv.ordem_servico
            ManageFrontend.ordem_servico = oOrdemServico
        } catch (e) {}

        return oResponse
    },
    validateProcess: async function(iPesagemVeiculoID, iPesagemID, aEnderecos, iTotalBags) {
        var bAcceptedValidate = true
        const oResponse = await $.fn.doAjax({
            url: 'pesagem-veiculos/validate-process',
            type: 'POST',
            data: {
                pesagem_id         : iPesagemID,
                pesagem_veiculo_id : iPesagemVeiculoID,
                endereco_id        : aEnderecos,
                total_bags         : iTotalBags
            }
        })

        if (oResponse.status == 200)
            return {
                accepted_validate: bAcceptedValidate,
                validate_object: JSON.stringify(oResponse),
            }

        const bConfirmOrCancel = await Utils.swalConfirmOrCancel({
            title: oResponse.title,
            text: oResponse.message,
            html: oResponse.message,
            showCancelButton: true,
            showConfirmButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Prosseguir com Execução',
            cancelButtonText: 'Cancelar'
        })

        return {
            accepted_validate: bConfirmOrCancel,
            validate_object: JSON.stringify(oResponse),
        }
    },
    executeOrdemServico: async function(oPesagemVeiculo, iPesagemVeiculoID){
        var $oBtnGerarOs = oPesagemVeiculo.find('.auto-executar-os')

        //So pode executar se tiver peso entrada e saida
        if ($oBtnGerarOs.hasClass('lf-opacity-medium'))
            return;

        var iPesagemID = VeiculosPesagensData.getPesagemID() ? VeiculosPesagensData.getPesagemID() : oState.getState('pesagem_id')
        var aEnderecos = null
        var iTotalBags = 0
        var bBtnClicked = false
        var aEstoqueEnderecosPossiveis = JSON.parse($('.estoque-enderecos-possiveis').html())

        const oSwalResponse = await Swal.fire({
            title: 'Selecione o Endereço',
            icon: 'info',
            width: 700,
            html: PagePesagem.html_enderecos,
            showCloseButton: false,
            showCancelButton: false,
            allowOutsideClick: false,
            confirmButtonText: 'Selecionar Endereço',
            onOpen: async function() { 
                var sModo = 'all-enderecos';

                $('.swal2-header').append('<div class="lf-close" style="position: absolute;right: 25px;top: 10px;"></div>')
                $('.swal2-header .lf-close').click(function() {
                    Swal.close()
                })

                $('.lf-busca-endereco[data-modo="'+sModo+'"] select').each(function() {
                    $(this).css({display: 'block'})
                    $(this).selectpicker()
                })

                $('.swal2-container.swal2-center.swal2-shown').css({
                    zIndex: 1051
                })

                await Utils.waitMoment(150)

                // EnderecoUtil.watchChanges('local', aEstoqueEnderecosPossiveis)

                // await Utils.waitMoment(300)

                $('.swal2-confirm').addClass('lf-opacity-medium')

                $('.swal2-confirm').mousedown(function() {
                    bBtnClicked = true
                })

                $('.swal2-content .quantidade-bags').change(function() {
                    iTotalBags = $(this).val()
                })

                $('.swal2-content .lf-busca-endereco[data-modo="'+sModo+'"] select.busca-endereco.endereco').change(function() {
                    aEnderecos = $(this).val()

                    if (aEnderecos)
                        $('.swal2-confirm').removeClass('lf-opacity-medium')
                    else
                        $('.swal2-confirm').addClass('lf-opacity-medium')
                })

                //pre-seleciona os que ja foram selecionados na table resv_enderecos
                if (aResvEnderecosSelected) {

                    if ($('.is_carga').size())
                        $('.selectpicker.busca-endereco').selectpicker('val', aResvEnderecosSelected)
                    
                    if ($('.is_descarga').size() && ObjectUtil.issetProperty(aResvEnderecosSelected, 0))
                        $('.selectpicker.busca-endereco').selectpicker('val', aResvEnderecosSelected[0])

                    await Utils.waitMoment(150)
                    $('.swal2-content .lf-busca-endereco[data-modo="'+sModo+'"] select.busca-endereco.endereco').change()
                }
            }
        })

        if (!aEnderecos || (aEnderecos && !bBtnClicked))
            return Utils.swalUtil({
                title: 'Você deve selecionar um endereço!',
                allowOutsideClick: true,
                showConfirmButton: true,
                confirmButtonText: 'Ok!'
            })
        
        var bAcceptedValidate = true
        var sValidateObject = '{}'

        if ($('.is_carga').size()) {
            oResponseValidate = await this.validateProcess(iPesagemVeiculoID, iPesagemID, aEnderecos, iTotalBags)
            bAcceptedValidate = oResponseValidate.accepted_validate
            sValidateObject = oResponseValidate.validate_object
        }

        const oResponse = await $.fn.doAjax({
            url: 'pesagem-veiculos/execute-ordem-servico',
            type: 'POST',
            data: {
                pesagem_id         : iPesagemID,
                pesagem_veiculo_id : iPesagemVeiculoID,
                endereco_id        : aEnderecos,
                total_bags         : iTotalBags,
                accepted_validate  : bAcceptedValidate,
                validate_object    : sValidateObject
            }
        })

        await Utils.waitMoment(100)

        iStatus = oResponse.status
        iTimer = 2000

        var oOrdemServico = oResponse.dataExtra.ordem_servico
        
        if (oOrdemServico) {
            ManageFrontend.manageActionsBtns(oOrdemServico, oPesagemVeiculo)
        }

        if (iStatus == 201)
            iTimer = 6000

        await Utils.swalResponseUtil(oResponse, {
            timer: iTimer
        })

        if (oResponse.status == 200 || oResponse.status == 201) {
            
            await Utils.waitMoment(700)
            
            window.open( url + $('.imprimir-ticket').attr('href'))

            await Utils.waitMoment(1200)

            window.location.href = url + 'resvs';
        }
    },
    estornaOrdemServico: async function(oPesagemVeiculo, iPesagemVeiculoID){
        var $oBtnGerarOs = oPesagemVeiculo.find('.auto-estornar-os')

        //So pode executar se tiver peso entrada e saida
        if ($oBtnGerarOs.hasClass('lf-opacity-medium'))
            return;

        const bConfirmOrCancel = await Utils.swalConfirmOrCancel({
            title: 'Deseja realmente estornar?',
            html: 'Essa ação fará o estoque retornar o saldo!',
            showCancelButton: true,
            showConfirmButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Prosseguir com Execução',
            cancelButtonText: 'Cancelar'
        })

        if (!bConfirmOrCancel)
            return;

        var iPesagemID = VeiculosPesagensData.getPesagemID() 
            ? VeiculosPesagensData.getPesagemID() 
            : oState.getState('pesagem_id')

        const oResponse = await $.fn.doAjax({
            url: 'pesagem-veiculos/estorna-ordem-servico',
            type: 'POST',
            data: {
                pesagem_id         : iPesagemID,
                pesagem_veiculo_id : iPesagemVeiculoID
            }
        })

        await Utils.waitMoment(200)

        iStatus = oResponse.status
        iTimer = 2000

        var oOrdemServico = oResponse.dataExtra.ordem_servico

        if (oOrdemServico) {
            ManageFrontend.manageActionsBtns(oOrdemServico, oPesagemVeiculo)
        }

        await Utils.swalResponseUtil(oResponse, {
            timer: iTimer
        })

    }
}