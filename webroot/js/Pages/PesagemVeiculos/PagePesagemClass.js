var PagePesagem = {
    html_enderecos: $('.enderecos-to-swal').html(),
    init: function() {

        this.watchBtnVeiculoAdd()
        this.watchBtnImprimirTicketClick()
        this.displayVeiculoPesagens()
        this.getPesoTaraVeiculo();
    },
    /**
     * Watchers
     */
    watchBtnImprimirTicketClick: function() {
        $('.imprimir-ticket').click(async function (e) {
            e.preventDefault()
            var sHref = $(this).attr('href')
            var hasPesoPortoRegistred = $('.pesagens .copy.append .registro-peso.registrado .input-tipo[value="3"]')
            var hasPesoSaidaRegistred = $('.pesagens .copy.append .registro-peso.registrado .input-tipo[value="2"]')
            
            if (($('.is_descarga').size() || $('.is_acerto_peso').size()) && !hasPesoPortoRegistred.size() && !hasPesoSaidaRegistred.size()) {
                var bResponse = await Utils.swalConfirmOrCancel({
                    title: 'Tem certeza?',
                    text: 'Você não digitou e gravou o peso porto, quer imprimir o ticket mesmo assim?',
                    confirmButtonText: 'Imprimir sem peso porto!',
                    cancelButtonText: 'Voltar e preencher!',
                    showCancelButton: true,
                    showConfirmButton: true
                })

                if (bResponse)
                    window.open(sHref)
                
                return;
            }

            window.open(sHref)
        })
    },
    watchBtnVeiculoAdd: function() {
        $('.veiculo-add').click(function () {
            
            PagePesagem.addVeiculoPesagem()
            PagePesagem.watchBtnPesagemAdd()
            
            PagePesagem.watchBtnPesagemVeiculoRemove()
            PagePesagem.watchBtnGravarPesagem()

            //Foca na placa
            //setTimeout(() => { $('.copy.append.pesagens').last().find('.placa-veiculo').focus() }, 200)

            setTimeout(() => { PagePesagem.watchBtnPesagemRemove() }, 200)
        }) 
    },
    watchBtnDescricao: async function($oPesagemAdded) {
        $oPesagemAdded.find('.toggle-descricao').click(function() {
            var $oPesagemDescricao = $(this).closest('.registro-peso').find('.pesagem-descricao')
            
            if ($oPesagemDescricao.hasClass('hidden')) 
                $(this).find('i').removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close')
            else 
                $(this).find('i').removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open')

            $oPesagemDescricao.toggleClass('hidden')
        })
    },
    watchBtnPesagemAdd: function() {
        $('.copy.append.pesagens .pesagem .add-pesagem:not(.watched-trigger)').each(function() {
            $(this).addClass('watched-trigger')

            $(this).click(function() {
                var oButtonClicked = $(this)
                var oLastRegistroPeso = $(oButtonClicked).closest('.pesagem').find('.body-pesos.copy.append .registro-peso').last()

                if (!oLastRegistroPeso.size() || oLastRegistroPeso.hasClass('registrado'))
                    PagePesagem.addRegistroPesagem(oButtonClicked)

                setTimeout(() => { PagePesagem.watchBtnPesagemRemove() }, 200)
            })

        })
    },
    watchBtnPesagemRemove: function() {
        $('.pesagem .body-pesos.copy.append .registro-peso .remove-pesagem:not(.watched-trigger)').each(function() {
            $(this).addClass('watched-trigger')

            $(this).click(function() {
                var oButtonClicked = $(this)
                var oRegistroPeso = $(oButtonClicked).closest('.registro-peso')

                if (!oRegistroPeso.size())
                    return;

                if (!oRegistroPeso.hasClass('registrado')) {
                    ManageFrontend.removeRegistroPesagem(oButtonClicked)
                }else {
                    PagePesagem.manageRemoveRegistroPesagem(oButtonClicked)
                }
            })

        })
    },
    watchBtnPesagemVeiculoRemove: function() {
        $('.copy.append.pesagens .pesagem .remove-pesagem-veiculo:not(.watched-trigger)').each(function() {
            $(this).addClass('watched-trigger')

            $(this).click(function() {
                var oButtonClicked = $(this)
                var oPesagemVeiculo = $(oButtonClicked).closest('.pesagem')
                var iPesagemVeiculoID = oPesagemVeiculo.find('.header-veiculo .pesagem_veiculo_id').val()
                
                //@todo ajax deletar pesagens deste veículo
                if (!iPesagemVeiculoID || iPesagemVeiculoID == 0) {
                    ManageFrontend.removePesagemVeiculo(oPesagemVeiculo)
                }else {
                    PagePesagem.manageRemovePesagemVeiculo(oPesagemVeiculo)
                }
                
            })

        })
    },
    watchBtnGravarPesagem: function() {
        $('.copy.append.pesagens .pesagem .gravar-pesagem:not(.watched-trigger)').each(function() {
            $(this).addClass('watched-trigger')

            $(this).click(async function() {
                var oButtonClicked = $(this)
                var oPesagemVeiculo = $(oButtonClicked).closest('.pesagem')
                var oRegistroPesagem = PagePesagem.getRegistroAtualPesagem(oPesagemVeiculo)
                var iContainer = $('#container') !== undefined ? $('#container').val() : '';

                console.log('oRegistroPesagem', oRegistroPesagem)
                
                if (!oRegistroPesagem)
                    return;

                if (!PagePesagem.actionCanGravarPesagem(oPesagemVeiculo))
                    return;

                var oResponse = await VeiculosPesagensService.saveVeiculoPesagem(
                    oPesagemVeiculo.find('.placa-veiculo').val(), 
                    oRegistroPesagem,
                    iContainer
                )

                if (oResponse.status != 200) {
                    Utils.swalResponseUtil(oResponse)
                    return;
                }

                ManageFrontend.setPesagemGravada(oPesagemVeiculo, oResponse.dataExtra.pesagem_veiculo_registro, 'watchBtnGravarPesagem')

                try {
                    if (BalancasComponent && BalancasComponent.removeIntervalPesagens)
                        BalancasComponent.removeIntervalPesagens()
                } catch (error) { }

                await Utils.waitMoment(150)
                
                ManageFrontend.manageBtnAutoExecutaOs(oPesagemVeiculo)

                if (oPesagemVeiculo.find('.auto-executar-os').size() && !oPesagemVeiculo.find('.auto-executar-os').hasClass('lf-opacity-medium')){
                    oPesagemVeiculo.find('.auto-executar-os').click()
                }else {
                    var hasPesoPortoRegistred = $('.pesagens .copy.append .registro-peso.registrado .input-tipo[value="3"]')
                    var hasPesoSaidaRegistred = $('.pesagens .copy.append .registro-peso.registrado .input-tipo[value="2"]')
                    var hasPesoEntradaRegistred = $('.pesagens .copy.append .registro-peso.registrado .input-tipo[value="1"]')

                    if ($('.not_fecha_pesagem_auto').size()) {
                        return;
                    }

                    if ($('.is_descarga').size() && hasPesoPortoRegistred.size() && hasPesoEntradaRegistred.size() && !hasPesoSaidaRegistred.size()) {
                        setTimeout(() => {window.location.href = url + 'resvs';}, 200)
                        $('.imprimir-ticket').click()
                    }else if ($('.is_carga').size() && hasPesoEntradaRegistred.size() && !hasPesoSaidaRegistred.size()) {

                        if ($('.is_acerto_peso').size() && !hasPesoPortoRegistred.size())
                            return;

                        setTimeout(() => {window.location.href = url + 'resvs';}, 200)
                        $('.imprimir-ticket').click()
                    }else if ($('.is_pesagem_avulsa').size() && hasPesoEntradaRegistred.size() && !hasPesoSaidaRegistred.size()) {
                        setTimeout(() => {window.location.href = url + 'resvs';}, 200)
                        $('.imprimir-ticket').click()
                    }else if ($('.is_pesagem_avulsa').size() && hasPesoEntradaRegistred.size() && hasPesoSaidaRegistred.size()) {
                        var oDate = new Date();
                        var sStr = oDate.getFullYear() + '-' + 
                                   (oDate.getMonth() + 1).toString().padStart(2, '0') + '-' + 
                                   oDate.getDate().toString().padStart(2, '0') + 'T' + 
                                    
                                   oDate.getHours().toString().padStart(2, '0') + ':' + 
                                   oDate.getMinutes().toString().padStart(2, '0')

                        $('input[name="data_hora_saida"]').attr('value', sStr)
                        $('input[name="data_hora_saida"]').val(sStr)
                        setTimeout(() => {$('.form-primary button[type="submit"]').click()}, 200)
                        $('.imprimir-ticket').click()
                    }

                }
            })

        })
    },
    watchSelectTipoPesagem: function($oPesagemAdded) {
        $oPesagemAdded.find('.input-tipo').change(function (){
            
            $(this).attr('value', $(this).val())

            if (["3"].includes($(this).val())) {
                $(this).closest('.registro-peso').find('.input-peso').removeAttr('readonly')
            }else {
                !$('.has_permission_edit_manually').size()
                    ? $(this).closest('.registro-peso').find('.input-peso').attr('readonly', 'readonly')
                    : null
            }
        })
    },
    watchBtnExecutarOs: function($oPesagemAdded) {
        var $oBtnAutoGerar = $oPesagemAdded.find('.auto-executar-os')
        
        if (!$oBtnAutoGerar.size())
            return;

        $oBtnAutoGerar.click(function() {
            if ($(this).hasClass('lf-opacity-medium'))
                return;

            VeiculosPesagensService.executeOrdemServico(
                $(this).closest('.pesagem'),
                $(this).closest('.pesagem').find('.header-veiculo .pesagem_veiculo_id').val()
            )
        })
    },
    watchBtnEstornarOs: function($oPesagemAdded) {
        var $oBtnAutoEstornar = $oPesagemAdded.find('.auto-estornar-os')
        
        if (!$oBtnAutoEstornar.size())
            return;

        $oBtnAutoEstornar.click(function() {
            if ($(this).hasClass('lf-opacity-medium'))
                return;

            VeiculosPesagensService.estornaOrdemServico(
                $(this).closest('.pesagem'),
                $(this).closest('.pesagem').find('.header-veiculo .pesagem_veiculo_id').val()
            )
        })
    },

    /**
     * Actions
     */
    manageRemovePesagemVeiculo: async function(oPesagemVeiculo) {
        var iPesagemVeiculoID = oPesagemVeiculo.find('.header-veiculo .pesagem_veiculo_id').val()

        var oResponse = await Utils.swalConfirmOrCancel({
            title: 'Tem certeza?',
            text: 'Deletar um veículo, irá deletar também os registros de suas pesagens',
            confirmButtonText: 'Sim, deletar!',
            showCancelButton: true,
            showConfirmButton: true
        }, async function() {
            
            var oResponseAjax = await $.fn.doAjax({
                url: 'pesagem-veiculos/remove-pesagem-veiculo',
                type: 'POST',
                data: {
                    pesagem_veiculo_id: iPesagemVeiculoID
                }
            })

            return oResponseAjax
        })

        if (oResponse && typeof oResponse == 'object' && oResponse.status) {
            
            if (oResponse.status == 200)
                ManageFrontend.removePesagemVeiculo(oPesagemVeiculo)
                
            Utils.swalResponseUtil(oResponse)
        }
    },
    manageRemoveRegistroPesagem: async function(oButtonClicked) {
        var $oPesagem = $(oButtonClicked).closest('.pesagem')
        var $oRegistroPeso = $(oButtonClicked).closest('.registro-peso')
        var iPesagemVeicRegistroID = $oRegistroPeso.find('.pesagem_veiculo_registro_id').val()
        var iTipo = $oRegistroPeso.find('.input-tipo').val()
        var sTipo = $oRegistroPeso.find('.input-tipo option[value="'+iTipo+'"]').text()
        var sPeso = $oRegistroPeso.find('.input-peso').val()

        // Utils.swalUtil({
        //     title: 'Função desabilitada temporáriamente!',
        //     html: 'Estamos trabalhando em melhorias, solicitar exclusão para a Loginfo no Grupo.',
        //     allowOutsideClick: true,
        //     showConfirmButton: true,
        //     confirmButtonText: 'Ok!'
        // })

        var oResponse = await Utils.swalConfirmOrCancel({
            title: 'Tem certeza que deseja remover o registro gravado?',
            html: 'Dados do Registro a deletar: <br><br> <b>Tipo do Registro</b>: ' + sTipo + ' <br> <b>Peso</b>: ' + sPeso,
            confirmButtonText: 'Sim, deletar!',
            showCancelButton: true,
            showConfirmButton: true
        });

        if (!oResponse)
            return false;

        if (iTipo != 3) {
            var oResponseToken = await ValidateToken.init();
    
            if (oResponseToken.status == 400) {
                Utils.swalResponseUtil(oResponseToken)
                return false;
            }
        }
        
        var oResponse = await $.fn.doAjax({
            url: 'pesagem-veiculo-registros/remove-registro-pesagem',
            type: 'POST',
            data: {
                pesagem_veiculo_registro_id: iPesagemVeicRegistroID
            }
        })

        if (oResponse && typeof oResponse == 'object' && oResponse.status) {
            
            if (oResponse.status == 200) 
                ManageFrontend.removeRegistroPesagem(oButtonClicked)
                
            Utils.swalResponseUtil(oResponse)
        }
    },
    displayVeiculoPesagens: async function() {
        var oResponse = await VeiculosPesagensService.getVeiculosPesagens()

        if (oResponse.status != 200) 
            return;

        ManageFrontend.generateBoxesPesagens(oResponse.dataExtra.pesagem_veiculos)
    },
    addVeiculoPesagem: async function () {
        var sCopyVeiculoPesagem = $('.copy.hidden.veiculo-pesagem').html()

        $('.copy.append.pesagens').append( $(sCopyVeiculoPesagem) )

        await Utils.waitMoment(200)

        var $oPesagemAdded = $('.copy.append.pesagens .pesagem:last-child')

        PagePesagem.watchBtnExecutarOs($oPesagemAdded)
        PagePesagem.watchBtnEstornarOs($oPesagemAdded)

        ManageFrontend.cleanInputPlaca(
            $oPesagemAdded.find('.placa-veiculo')
        )
    },
    addRegistroPesagem: function(oButtonClicked) {
        var sCopyRegistroPesagem = $(oButtonClicked).closest('.pesagem').find('.copy.hidden.registro-peso').html()
        var hasPesoPortoRegistred = $('.pesagens .copy.append .registro-peso.registrado .input-tipo[value="3"]')
        var hasPesoSaidaRegistred = $('.pesagens .copy.append .registro-peso.registrado .input-tipo[value="2"]')
        var hasPesoEntradaRegistred = $('.pesagens .copy.append .registro-peso.registrado .input-tipo[value="1"]')

        $(oButtonClicked).closest('.pesagem').find('.body-pesos.copy.append').append($(sCopyRegistroPesagem))
        $(oButtonClicked).closest('.pesagem').find('.body-pesos.copy.append .registro-peso:last .input-peso').addClass('lf-balancas-get-peso')

        if (!$('.not_fecha_pesagem_auto').size()) {
            PagePesagem.watchBtnDescricao($(oButtonClicked).closest('.pesagem').find('.body-pesos.copy.append .registro-peso:last'))
        }

        iSize = $(oButtonClicked).closest('.pesagem').find('.body-pesos.copy.append .registro-peso').size()

        var $oRegistroAdded = $(oButtonClicked).closest('.pesagem').find('.body-pesos.copy.append .registro-peso:last')
        
        PagePesagem.watchSelectTipoPesagem($oRegistroAdded)

        if ( ($('.is_descarga').size() || $('.is_carga').size() || $('.is_pesagem_avulsa').size()) && !hasPesoEntradaRegistred.size()) {
            $oRegistroAdded.find('.input-tipo').val(1)
        }else if ( ($('.is_descarga').size() || $('.is_acerto_peso').size()) && !hasPesoPortoRegistred.size() ) {
            $oRegistroAdded.find('.input-tipo').val(3)
            setTimeout(() => { 
                $oRegistroAdded.find('.pesagem-descricao').attr('placeholder', 'Número Ticket Porto')
                $oRegistroAdded.find('.toggle-descricao').click() 
                $oRegistroAdded.find('.input-peso').focus()
            }, 250)
        }else if (($('.is_descarga').size() || $('.is_carga').size() || $('.is_pesagem_avulsa').size()) && !hasPesoSaidaRegistred.size() ) {
            $oRegistroAdded.find('.input-tipo').val(2)
        }

        ManageFrontend.manageBtnAutoExecutaOs($oRegistroAdded.closest('.pesagem'))

        //se for entrada ou saida não deixa editar o campo
        setTimeout(function() {
            if (["3"].includes($oRegistroAdded.find('.input-tipo').val())) {
                $oRegistroAdded.find('.input-peso').removeAttr('readonly')
            }else {
                !$('.has_permission_edit_manually').size()
                    ? $oRegistroAdded.find('.input-peso').attr('readonly', 'readonly')
                    : null
            }
        }, 150)

        $oRegistroAdded.find('.input-tipo').change()

        $.fn.numericDouble()
    },
    getRegistroAtualPesagem: function(oPesagemVeiculo) {
        var oRegistroPesagem = oPesagemVeiculo.find('.body-pesos.copy.append .registro-peso').last()

        if (oRegistroPesagem.hasClass('registrado'))
            return false

        if (!Utils.parseFloat(oRegistroPesagem.find('.input-peso').val()))
            return false

        return {
            descricao: oRegistroPesagem.find('.pesagem-descricao').val(),
            peso: oRegistroPesagem.find('.input-peso').val(),
            tipo: oRegistroPesagem.find('.input-tipo').val(),
            balanca_codigo_id: $('.lf-balanca').val(),
            pesagem_id: VeiculosPesagensData.getPesagemID(),
        }
    },
    actionCanGravarPesagem: function($oPesagemVeiculo) {
        var oRegistroPesagem = $oPesagemVeiculo.find('.body-pesos.copy.append .registro-peso').last()
        var iTipoPesagemID   = oRegistroPesagem.find('.input-tipo').val()
        var sTipoTextPesagem = oRegistroPesagem.find('.input-tipo option[value="'+iTipoPesagemID+'"]').text()
        var iCountRegistro   = $oPesagemVeiculo.find('.copy.append .registro-peso .input-tipo[value="'+iTipoPesagemID+'"]').size()

        var aNaoPodeRepetir = ['1','2','3']
        var sTextTipoPesagem = oRegistroPesagem.find('.input-tipo option:selected').text()

        if (iCountRegistro > 1 && aNaoPodeRepetir.includes(iTipoPesagemID) && sTextTipoPesagem != 'Tara Container') {
            Utils.swalUtil({
                title: 'Já existe esse registro de pesagem!',
                html: '<b>Tipo do Registro existente</b>: ' + sTipoTextPesagem,
                timer: 3000
            })

            return false
        }

        return true
    },
    getPesoTaraVeiculo: function() {

        var buttonTara = $('.busca-tara-veiculo');

        if (!buttonTara.size())
            return;

        var iVeiculoId = $('input[name="veiculo_id"]').val();
        buttonTara.click(async function() {
    
            var oResponseAjax = await $.fn.doAjax({
                url: 'pesagem-veiculos/getPesoTaraVeiculo/' + iVeiculoId,
                type: 'GET'
            });
    
            if (oResponseAjax.status != 200) {
                Utils.swalResponseUtil(oResponseAjax)
                return;
            }
    
            $('.lf-balancas-get-peso').val(oResponseAjax.dataExtra);
        })
    }
}

PagePesagem.init()