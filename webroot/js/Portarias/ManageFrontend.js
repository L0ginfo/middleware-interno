const ManageFrontend = {

    manageBalanca: async function(portaria, balanca) {
        if (!portaria)
            return await Utils.swalUtil({
                title:'Necessário informar uma portaria.',
                type:'error',
                timer:2000
            });

        if (!balanca)
            return await Utils.swalUtil({
                title:'Necessário informar uma balança.',
                type:'error',
                timer:2000
            });

        if (oState.getState('peso') > 0)
            return;

        var oResponse = await ManageRoutineData.validaBalanca(balanca);
        // oResponse = JSON.parse(oResponse);

        if (oResponse.dataExtra === undefined)
            return;

        if (Portaria.getInputPeso().is(":focus"))
            return;
        
        oState.setState('timer', oResponse.dataExtra.timer);
        if (oResponse.status != 200) {
            Portaria.setSituacao(oResponse.status, oResponse.message).then(function() {
                Portaria.setPeso(0);
                $('.habilita-leitura').prop('disabled', false);
            });
            return;
        }
        oState.setState('fluxo', oResponse.dataExtra.fluxo);
        if (oState.getState('pesoFocus') !== undefined && oState.getState('pesoFocus'))
            return;

        if (oResponse.dataExtra.peso > 0)
            Portaria.setSituacao(200, 'Peso capturado').then(function() {
                Portaria.setPeso(oResponse.dataExtra.peso);
            });
        else
            Portaria.setSituacao(400, 'Balança sem movimentação').then(function() {
                Portaria.setPeso(oResponse.dataExtra.peso);
            });
    },

    manageBuscaPlacas: async function() {

        var peso = oState.getState('peso');
        $inputPeso = Portaria.getInputPeso();
        $inputPeso.val(peso);
        iFluxo = oState.getState('fluxo');

        if (peso != 0 && iFluxo !== 'undefined' && iFluxo) {
            var oResponse = await ManageRoutineData.getPassagens(iFluxo);

            if (oResponse.status != 200)
                return Utils.swalResponseUtil(oResponse);

            var aPlacas = oResponse.dataExtra.placas;
            oState.setState('passagem_id', oResponse.dataExtra.passagem_id);
            oState.setState('data_registro', oResponse.dataExtra.data_registro);
            oState.setState('containers', oResponse.dataExtra.containers);

            Portaria.setSituacao(200, 'Veículo encontrado').then(function() {
                ManageFrontend.setCamposPlacas(
                    aPlacas[0] !== undefined && aPlacas[0].tipo == 'frontal' ? aPlacas[0].placa : '',
                    aPlacas[1] !== undefined ? aPlacas[1].placa : '',
                    aPlacas[2] !== undefined ? aPlacas[2].placa : ''
                );
                ManageFrontend.renderFotos(oResponse.dataExtra.fotos);
            });

        }
    },

    manageColorInputs: function($input, callback) {

        $input.removeClass('green-label');
        $input.removeClass('red-label');
        var bReturn = callback();
        if (bReturn)
            $input.addClass('green-label');
        else
            $input.addClass('red-label');
    },

    setCamposPlacas: function(placa, reboque1, reboque2) {

        Portaria.setPlaca(placa);
        Portaria.setReboque1(reboque1);
        Portaria.setReboque2(reboque2);
    },

    renderFotos: function(aPlacas) {

        if (!aPlacas)
            return;

        $('.fotos .foto').remove();
        aPlacas.forEach(key => {
            var sTemplate = $('.copy-hidden .foto')[0].outerHTML;
            oResponse = RenderCopy.render({
                object: key,
                template: sTemplate,
                data_to_render: 'foto'
            });

            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item ');
        
            //Renderiza
            $('.fotos').append(oResponse.getDataExtra());
            oState.setState('fotos', aPlacas);
            // $( '.tela').fadeIn( "slow");
        });
    },

    manageValidaCampos: function($input) {
        ManageFrontend.manageColorInputs($input, function() {
            if ($input.attr('id') != 'peso')
                return $input.val() != '' && $input.val().length == 7;

            return $input.val() > 0;
        });

        if (oState.getState($input.attr('id')) !== undefined)
            oState.setState($input.attr('id'), $input.val());

        var aCamposValidados = oState.getState('camposValidados');
        if ($input.hasClass('green-label')) {
            if (aCamposValidados !== undefined && aCamposValidados.indexOf($input.attr('id')) === -1) {
                aCamposValidados.push($input.attr('id'));
                oState.setState('camposValidados', aCamposValidados);
            } else if (aCamposValidados === undefined) {
                oState.setState('camposValidados', [$input.attr('id')]);
            }
        } else if (aCamposValidados !== undefined && aCamposValidados.indexOf($input.attr('id')) > -1) {
            aCamposValidados.splice(aCamposValidados.indexOf($input.attr('id')), 1);
            oState.setState('camposValidados', aCamposValidados);
        }
    },

    validaProgramacao: async function() {

        var oResponse = await ManageRoutineData.getProgramacao(
            Portaria.getPlaca(), 
            Portaria.getReboque1(),
            Portaria.getReboque2(),
            Portaria.getBalanca()
        );

        var sTemplate = '';
        for (const key in oResponse.dataExtra) {
            if (key != 'id' && oResponse.dataExtra[key])
                sTemplate += '<span><b>' + key.charAt(0).toUpperCase() + key.slice(1) + ': </b>' + oResponse.dataExtra[key] + '</span>';
        }

        sTemplateContainers = '';
        if (oResponse.dataExtra.containers !== undefined && oResponse.dataExtra.containers) {
            var aContainers = oResponse.dataExtra.containers.split(", ");
            oState.setState('progContainers', aContainers);
        }

        ManageFrontend.manageContainers();

        Portaria.setSituacao(oResponse.status, oResponse.message).then(function() {
            setTimeout(() => {
                $('.linha2 .programacao span').remove();
                $('.linha2 .programacao').append(sTemplate);
                if (oResponse.status == 200) {
                    ManageFrontend.bloquearCamposValidadores(true);
                    $('.busca-prog').prop('disabled', true);
                    oState.setState('iProgramacaoId', oResponse.dataExtra.id);
                } else {
                    $('.busca-prog').prop('disabled', false);
                }
            }, 2000);
        });

    },

    validaCracha: async function() {

        var oResponse = await ManageRoutineData.getCracha(Portaria.getBalanca());

        Portaria.setSituacao(oResponse.status, oResponse.message).then(function() {
            setTimeout(() => {
                if (oResponse.status == 200) {
                    oState.setState('validaProgramacao', true);
                } else {
                    oState.setState('validaCracha', true);
                }
            }, 2000);
        });

    },

    consisteResv: async function() {

        var oResponse = await ManageRoutineData.consisteResv(oState.getState('iProgramacaoId'));

        Portaria.setSituacao(oResponse.status, oResponse.message).then(function() {
            setTimeout(() => {
                if (oResponse.status == 200) {
                    $('.busca-resv').prop('disabled', true);
                    oState.setState('iResvId', oResponse.dataExtra.resv_id);
                } else {
                    $('.busca-resv').prop('disabled', false);
                }
            }, 2000);
        });

    },

    consistePeso: async function() {
        var oResponse = await ManageRoutineData.consistePeso(
            oState.getState('iResvId'),
            oState.getState('peso'),
            Portaria.getBalanca()
        );

        Portaria.setSituacao(oResponse.status, oResponse.message).then(function() {
            setTimeout(() => {
                if (oResponse.status == 200) {
                    oState.setState('bPesoRegistrado', true);
                    $('.registra-pesagem').prop('disabled', true);
                } else {
                    $('.registra-pesagem').prop('disabled', false);
                    oState.setState('bPesoRegistrado', false);
                }
            }, 2000);
        });

    },

    bloquearCamposValidadores: function($bBloqueia) {

        $('.valida-campo').each(function() {

            $(this).attr('readonly', $bBloqueia);
        })
    },

    manageAtualizarFotos: async function() {

        iFluxo = oState.getState('fluxo');

        if (iFluxo !== 'undefined') {
            var oResponse = await ManageRoutineData.getPassagens(iFluxo);

            if (oResponse.status != 200)
                return Utils.swalResponseUtil(oResponse);

            ManageFrontend.renderFotos(oResponse.dataExtra.fotos);
        }

    },

    manageFinalizaOperacao: async function() {

        var oResponse = await ManageRoutineData.finalizarOperacao(
            Portaria.getBalanca(),
            oState.getState('iProgramacaoId'),
            oState.getState('fotos'),
            oState.getState('data_registro'),
            oState.getState('passagem_id'),
            oState.getState('containers')
        );

        Portaria.setSituacao(oResponse.status, oResponse.message).then(function() {
            ManageFrontend.limpaCampos();
        });

        oState.setState('validaCracha', null);
        oState.setState('validaProgramacao', null);
        oState.setState('iProgramacaoId', null);
        oState.setState('iResvId', null);
        oState.setState('bPesoRegistrado', null);
        oState.setState('registraFotos', null);
    },

    limpaCampos: function() {
        $('.fotos .foto').remove();
        $('.linha2 .programacao span').remove();
        Portaria.setPeso(0);
        Portaria.setPlaca('');
        Portaria.setReboque1('');
        Portaria.setReboque2('');
        $('.valida-campo').each(function() {
            $(this).prop('readonly', false);
        });
        $('.class-container').remove();
        oState.setState('containers', null);
        oState.setState('progContainers', null);
        $('.busca-resv').prop('disabled', true);
        $('.busca-prog').prop('disabled', true);
    },

    manageMovimentacaoBalanca: async function() {

        var oResponse = await ManageRoutineData.setMovimentacaoBalanca(Portaria.getBalanca());

        if (oResponse.status != 200)
            return Utils.swalResponseUtil(oResponse);

        // $('.habilita-leitura').prop('disabled', true);
    },

    manageUsuarioTela: async function(iTipoRegistro) {

        var oResponse = await ManageRoutineData.consisteUsuarioTela(Portaria.getBalanca(), iTipoRegistro);

        return oResponse;
    },

    manageValidacaoContainers: function() {

        var aProgContainers = oState.getState('progContainers');
        var $inputContainers = $('.containers');

        var iCountCntValidos = 0;
        $inputContainers.each(function() {
            var $input = $(this);
            var fValidaCnt = function() {
                if (aProgContainers.includes($input.val()))
                    return true;

                return false;
            };

            ManageFrontend.manageColorInputs($input, fValidaCnt);
            
            if (fValidaCnt())
                iCountCntValidos++;
        })

        if (iCountCntValidos != aProgContainers.length)
            oState.setState('containersValidos', false);
        else 
            oState.setState('containersValidos', true);

    },

    manageContainers: function() {
        var aContainers = oState.getState('containers') !== undefined 
                ? oState.getState('containers')
                : [];

        var aProgContainers = oState.getState('progContainers') !== undefined
            ? oState.getState('progContainers')
            : [];
        var sTemplateContainers = '';
        if (aContainers && aProgContainers) {
            for (var c in aProgContainers){
                sTemplateContainers += '<div class="col-lg-3 class-container"><label for="container-' + (parseInt(c) + 1) + '">' + 'Container ' + (parseInt(c) + 1) + '</label>'
                    + '<input name="container-' + (parseInt(c) + 1) + '" class="form-control containers" value="' + aContainers[c].numero + '"></div>'
            }
        }

        if (sTemplateContainers) {
            $(sTemplateContainers).insertAfter($('.atualiza').parent());
            Portaria.watchInputContainers();
        }
    }
}