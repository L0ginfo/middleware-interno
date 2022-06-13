var ManageFrontend = {
    ordem_servico: null,
    init: function() {

    },
    cleanInputPlaca: function($oInput) {
        $oInput.inputFilter(function(value) {
            if (!value)
                return true

            return /^[A-Za-z]|[0-9]$/.test(value);
        });
    },
    setPesagemGravada: function(oPesagemVeiculo, oPesagemVeiculoRegistro = null, sOrigem = 'generateBoxesPesagens') {
        this.setRegistroGravado(oPesagemVeiculo, oPesagemVeiculoRegistro, sOrigem)
        this.setPlacaGravada(oPesagemVeiculo)
    },
    setRegistroGravado: async function(oPesagemVeiculo, oPesagemVeiculoRegistro, sOrigem = 'generateBoxesPesagens') {
        $(oPesagemVeiculo).find('.body-pesos.copy.append .registro-peso:last .form-control').each(function() {
            $(this).attr('readonly', 'readonly')
            $(this).removeClass('lf-balancas-get-peso')

            if (oPesagemVeiculoRegistro) {
                $(this).closest('.pesagem').find('.header-veiculo .pesagem_veiculo_id').val(oPesagemVeiculoRegistro.pesagem_veiculo_id)
                $(this).closest('.peso-area').find('.pesagem_veiculo_registro_id').val(oPesagemVeiculoRegistro.id)
            }

        })

        var $oRegistroPeso = $(oPesagemVeiculo).find('.body-pesos.copy.append .registro-peso')
        $oRegistroPeso.addClass('registrado')

        if ($oRegistroPeso.last().find('.input-tipo').val() == 1 && sOrigem == 'watchBtnGravarPesagem') {
            $oRegistroPeso.closest('.pesagem').find('.header-veiculo .add-pesagem').click()

            if ($('.is_carga').size() || (!$('.is_carga').size() && !$('.is_descarga').size()))
                return;

            //Coloca o peso porto para ser digitado caso for descarga
            //await Utils.waitMoment(50)

            // var $oRegistroPeso = $oRegistroPeso.closest('.pesagem').find('.body-pesos.copy.append .registro-peso:last')

            // $oRegistroPeso.find('.input-tipo').val(3)
            // $oRegistroPeso.find('.input-tipo').attr('value', 3)
            // $oRegistroPeso.find('.toggle-descricao').click()

            // $oRegistroPeso.find('.input-peso').focus()
        }
    },
    setPlacaGravada: function(oPesagemVeiculo) {
        $(oPesagemVeiculo).find('.placa-veiculo').attr('readonly', 'readonly')
    },
    removeRegistroPesagem: function(oButtonClicked) {
        var $oPesagem = $(oButtonClicked).closest('.pesagem')
        var oRegistroPeso = $(oButtonClicked).closest('.registro-peso')
        oRegistroPeso.remove()

        ManageFrontend.manageBtnAutoExecutaOs($oPesagem)
    },
    removePesagemVeiculo: function(oPesagemVeiculo) {
        oPesagemVeiculo.addClass('lf-opacity-none')
        
        setTimeout(() => {oPesagemVeiculo.css({width: 200})}, 400)
        setTimeout(() => {oPesagemVeiculo.remove()}, 470)
    },
    generateBoxesPesagens: async function(aPesagemVeiculos) {
        var $oBtnVeiculoAdd = $('.veiculo-add'),
            $oPesagemVeiculo = null,
            oPesagemRegistros = null

        $('.pesagens.copy.append .pesagem').remove()
            
        for (const key in aPesagemVeiculos) {
            $oBtnVeiculoAdd.click()
            var oOrdemServico = aPesagemVeiculos[key].pesagem.resv.ordem_servico

            await Utils.waitMoment(100)

            $oPesagemVeiculo = $('.pesagens.copy.append .pesagem').last()
            $oPesagemVeiculo.find('.header-veiculo .placa-veiculo').val(aPesagemVeiculos[key].veiculo.veiculo_identificacao)
            
            $oPesagemVeiculo.find('.header-veiculo .pesagem_veiculo_id').val(aPesagemVeiculos[key].id)

            oPesagemRegistros = aPesagemVeiculos[key].pesagem_veiculo_registros
            
            for (const keyRegistros in oPesagemRegistros) {
                $oPesagemVeiculo.find('.add-pesagem').click()

                await Utils.waitMoment(100)

                iCount = parseInt(keyRegistros) + 1

                $oPesagemVeiculoRegistro = $oPesagemVeiculo.find('.body-pesos.copy.append .registro-peso').last()

                if (oPesagemRegistros[keyRegistros].container_id) {
                    var sContainer = $('#container').find('option[value="'+oPesagemRegistros[keyRegistros].container_id+'"]').text()
                    $oPesagemVeiculoRegistro.prepend('<p style="width: 100%;text-align: center;font-weight: 700;">'+sContainer+ '</p>');
                }

                $oPesagemVeiculoRegistro.find('.sequencia-peso b').html('#' + iCount)
                $oPesagemVeiculoRegistro.find('.peso-area .pesagem_veiculo_registro_id').val(oPesagemRegistros[keyRegistros].id)
                $oPesagemVeiculoRegistro.find('.pesagem-descricao').val(oPesagemRegistros[keyRegistros].descricao)
                $oPesagemVeiculoRegistro.find('.peso-area .input-peso').val(Utils.showFormatFloat(oPesagemRegistros[keyRegistros].peso))
                $oPesagemVeiculoRegistro.find('.pesagem-tipo-area .input-tipo').val(oPesagemRegistros[keyRegistros].pesagem_tipo_id)
                $oPesagemVeiculoRegistro.find('.pesagem-tipo-area .input-tipo').attr('value', oPesagemRegistros[keyRegistros].pesagem_tipo_id)

                ManageFrontend.manageBtnAutoExecutaOs($oPesagemVeiculo)
                this.setPesagemGravada($oPesagemVeiculo)
            }

            this.setPesagemGravada($oPesagemVeiculo)
            
            this.manageActionsBtns(oOrdemServico, $oPesagemVeiculo)

            ManageFrontend.manageBtnAutoExecutaOs($oPesagemVeiculo)
        }

        if (Object.keys(aPesagemVeiculos).length == 1) {

            if ($('.is_pesagem_avulsa').size() && $('.pesagens.copy.append .pesagem .registro-peso.registrado').size() < 2) {
                $oPesagemVeiculo.find('.add-pesagem').click()
            }else if ($('.is_carga').size() && $('.pesagens.copy.append .pesagem .registro-peso.registrado').size() < 2) {
                $oPesagemVeiculo.find('.add-pesagem').click()
            }else if ($('.is_descarga').size() && $('.pesagens.copy.append .pesagem .registro-peso.registrado').size() < 3) {
                $oPesagemVeiculo.find('.add-pesagem').click()
            }
            
            // if ($('.is_descarga').size() && $('.pesagens.copy.append .pesagem').find('.registro-peso.registrado').size() < 3)
            //     $oPesagemVeiculo.find('.add-pesagem').click()
            // else if ($('.is_carga').size() && $('.pesagens.copy.append .pesagem').find('.registro-peso.registrado').size() < 2)
            //     $oPesagemVeiculo.find('.add-pesagem').click()
            
            //await Utils.waitMoment(300)
            //$oPesagemVeiculo.find('.body-pesos.copy.append .registro-peso:last .input-peso.lf-balancas-get-peso').focus()
        }
    },
    manageActionsBtns: function(oOrdemServico, $oPesagemVeiculo) {

        if (!oOrdemServico)
            return;

        ManageFrontend.ordem_servico = oOrdemServico

        if (oOrdemServico.data_hora_fim) {
            $oPesagemVeiculo.find('.auto-executar-os').addClass('lf-opacity-medium')
            $oPesagemVeiculo.find('.auto-estornar-os').removeClass('lf-opacity-medium')
        }else if (!oOrdemServico.data_hora_fim) {
            $oPesagemVeiculo.find('.auto-executar-os').removeClass('lf-opacity-medium')
            $oPesagemVeiculo.find('.auto-estornar-os').addClass('lf-opacity-medium')
        }
    },
    manageBtnAutoExecutaOs: function($oPesagemVeiculo) {
        var $oBodyPesagens = $oPesagemVeiculo.find('.body-pesos.copy.append')
        var $oRegistroPesos = $oBodyPesagens.find('.registro-peso')
        var hasPesoPortoRegistred = $('.pesagens .copy.append .registro-peso.registrado .input-tipo[value="3"]')
        var hasPesoSaidaRegistred = $('.pesagens .copy.append .registro-peso.registrado .input-tipo[value="2"]')
        var hasPesoEntradaRegistred = $('.pesagens .copy.append .registro-peso.registrado .input-tipo[value="1"]')
        
        if ($('.is_descarga').size() && hasPesoPortoRegistred.size() && hasPesoSaidaRegistred.size() && hasPesoEntradaRegistred.size()) {
            $oRegistroPesos.closest('.pesagem').find('.auto-executar-os').removeClass('lf-opacity-medium')
        }else if ($('.is_carga').size() && hasPesoSaidaRegistred.size() && hasPesoEntradaRegistred.size()) {
            $oRegistroPesos.closest('.pesagem').find('.auto-executar-os').removeClass('lf-opacity-medium')
        }else {
            $oRegistroPesos.closest('.pesagem').find('.auto-executar-os').addClass('lf-opacity-medium')
        }

        // if ($oRegistroPesos.size() >= 2 && hasPesoSaida && hasPesoEntrada) {

        //     if (ManageFrontend.ordem_servico && !ManageFrontend.ordem_servico.data_hora_fim)
        //         $oRegistroPesos.closest('.pesagem').find('.auto-executar-os').removeClass('lf-opacity-medium')
        // }else {
        //     $oRegistroPesos.closest('.pesagem').find('.auto-executar-os').addClass('lf-opacity-medium')
        // }
    }
}

ManageFrontend.init()