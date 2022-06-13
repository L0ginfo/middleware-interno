function Timer(seq, target, cb) {
    this.counter = seq;
    this.target = target;
    this.callback = cb;
}
Timer.prototype.pad = function(s) {
    return (s < 10) ? '0' + s : s;
}
Timer.prototype.start = function(s) {
    this.count();
}
Timer.prototype.stop = function(s) {
    this.count();
}
Timer.prototype.done = function(s) {
    if (this.callback) this.callback();
}
Timer.prototype.display = function(s) {
    this.target.innerHTML = this.pad(s);
}
Timer.prototype.count = function(s) {
    var self = this;
    self.display.call(self, self.counter);
    self.counter--;
    var clock = setInterval(function() {
        self.display(self.counter);
        self.counter--;
        if (self.counter < 0) {
            clearInterval(clock);
            self.done.call(self);
        }
    }, 1000);
}

const Portaria = {

    init: async function() {
        oResponse = await ManageFrontend.manageUsuarioTela(0);
        Portaria.watchInputBalanca();

        if (oResponse.status != 200) {
            Portaria.setSituacao(oResponse.status, oResponse.dataExtra);
            Portaria.watchModoVisualizacao();
            return;

        } else {
            setInterval(async function(){
                await ManageFrontend.manageUsuarioTela(1); 
            }, 4000);
        }
         
        oState.setState('peso', 0);

        this.observers();
        Portaria.watchValidaCampo();
        Portaria.setSituacao(201, 'Buscando informações').then(function() {
            setTimeout(() => {
                ManageFrontend.manageBalanca(Portaria.getPortaria(), Portaria.getBalanca());
            }, 3000);
            oState.setState('fluxo', null);
            Portaria.watchButtonAtualizar();
            Portaria.watchButtonBuscaProg();
            Portaria.watchButtonBuscaResv();
            Portaria.watchButtonRegistraPesagem();
            Portaria.watchButtonAtualizarFotos();
            Portaria.watchButtonHabilitaLeitura();
            Portaria.watchFocusInputPeso();
            Portaria.watchCommandCancelas();
            Portaria.watchButtonInserirFotos();
            Portaria.watchButtonFotos();
        });
    },

    observers: function() {

        oSubject.setObserverOnEvent(async function () {
            var peso = oState.getState('peso')
            setTimeout(() => {
                ManageFrontend.manageBalanca(Portaria.getPortaria(), Portaria.getBalanca());
            }, 3000);
            if (peso != 0) {
                Portaria.setSituacao(201, 'Buscando passagem').then(function() {
                    setTimeout(() => {
                        ManageFrontend.manageBuscaPlacas();
                    }, 2000);
                });
            }
            // $('.atualiza').attr('disabled', (peso != 0 ? 'disabled' : ''));
        }, ['on_peso_change']);

        oSubject.setObserverOnEvent(async function () {
            var aCamposValidados = oState.getState('camposValidados');
            if (aCamposValidados !== undefined && aCamposValidados.length == 2) {
                new Timer(oState.getState('timer'), document.querySelector('.temporizador h3 b'), function() {
                    oState.setState('validaCracha', true);
                }).start();
            } else {
                oState.setState('validaCracha', false);
                Portaria.setSituacao(400, 'Campos não validados');
            }
        }, ['on_camposValidados_change']);

        oSubject.setObserverOnEvent(async function () {

            if (!oState.getState('validaCracha'))
                return;

            var bValidaCracha = oState.getState('validaCracha');
            if (bValidaCracha) {
                Portaria.setSituacao(200, 'Buscando Crachá').then(function() {
                    setTimeout(() => {
                        ManageFrontend.validaCracha();
                    }, 2000);
                });
            }
            
        }, ['on_validaCracha_change']);

        oSubject.setObserverOnEvent(async function () {

            if (!oState.getState('validaProgramacao'))
                return;

            var bValidaProgramacao = oState.getState('validaProgramacao');
            if (bValidaProgramacao) {
                Portaria.setSituacao(200, 'Buscando Programação').then(function() {
                    setTimeout(() => {
                        ManageFrontend.validaProgramacao();
                    }, 2000);
                });
            }
            
        }, ['on_validaProgramacao_change']);

        oSubject.setObserverOnEvent(async function () {

            var registraFotosState = oState.getState('registraFotos');
            if (oState.getState('iProgramacaoId') && $('.button-fotos').size()
                && (registraFotosState === null || registraFotosState === undefined)) {
                $('#dropzone-xml').attr('data-id', oState.getState('iProgramacaoId'));
                $('#dropzone-xml').attr('data-initOnReady', 1);
                $('.button-fotos').prop('disabled', false);
                oState.setState('registraFotos', true);
                return;
            }

            if (!oState.getState('progContainers')) {
                oState.setState('containersValidos', true);
                return;
            }

            Portaria.setSituacao(200, 'Validando Containers').then(function() {
                setTimeout(() => {
                    ManageFrontend.manageValidacaoContainers();
                }, 2000);
            });
        }, ['on_iProgramacaoId_change']);

        oSubject.setObserverOnEvent(async function () {

            var registraFotos = oState.getState('registraFotos');
            if (registraFotos) {
                Portaria.setSituacao(201, 'Registrando fotos');
                return;
            } else if (registraFotos === false) {
                setByRegistraFoto = true;
                oState.setState('iProgramacaoId', oState.getState('iProgramacaoId'));
            }

        }, ['on_registraFotos_change']);

        oSubject.setObserverOnEvent(async function () {

            Portaria.setSituacao(200, 'Fotos Registradas');
            oState.setState('registraFotos', false);
            $('#dropzone-xml').attr('data-id', '');
            $('#dropzone-xml').attr('data-initOnReady', 0);
            $('.button-fotos').prop('disabled', true);
        }, ['on_fotosRegistradas_change']);

        oSubject.setObserverOnEvent(async function () {

            if (!oState.getState('containersValidos')) {
                Portaria.setSituacao(400, 'Containers não validados.');
                return;
            }

            Portaria.setSituacao(200, 'Buscando RESV').then(function() {
                setTimeout(() => {
                    ManageFrontend.consisteResv(oState.getState('iProgramacaoId'));
                }, 2000);
            });
        }, ['on_containersValidos_change']);

        oSubject.setObserverOnEvent(async function () {

            if (!oState.getState('iResvId'))
                return;

            Portaria.setSituacao(200, 'Registrando peso').then(function() {
                setTimeout(() => {
                    ManageFrontend.consistePeso(oState.getState('iResvId'));
                }, 2000);
            });
            
        }, ['on_iResvId_change']);

        oSubject.setObserverOnEvent(async function () {

            if (!oState.getState('bPesoRegistrado'))
                return;

            var bPesoRegistrado = oState.getState('bPesoRegistrado');
            if (bPesoRegistrado) {
                Portaria.setSituacao(200, 'Enviando comando para cancela').then(function() {
                    setTimeout(() => {
                        ManageFrontend.manageFinalizaOperacao();
                    }, 2000);
                });
            }
            
        }, ['on_bPesoRegistrado_change']);
    },

    getInputPeso: function() {

        return $('#peso');
    },

    getPortaria: function() {

        return $('#portaria').val();
    },

    getBalanca: function() {

        return $('#balanca').val();
    },

    setPeso: function(peso) {

        ManageFrontend.manageColorInputs($('#peso'), function() {
            return peso > 0;
        });
        $('#peso').val(peso);
        $('#peso').change();
    },

    setPlaca: function(placa) {

        ManageFrontend.manageColorInputs($('#placa'), function() {
            return placa != '';
        });
        $('#placa').val(placa);
        $('#placa').change();
    },

    setReboque1: function(reboque1) {

        ManageFrontend.manageColorInputs($('#reboque1'), function() {
            return reboque1 != '';
        });
        $('#reboque1').val(reboque1);
        $('#reboque1').change();
    },

    setReboque2: function(reboque2) {

        ManageFrontend.manageColorInputs($('#reboque2'), function() {
            return reboque2 != '';
        });
        $('#reboque2').val(reboque2);
        $('#reboque2').change();
    },

    getPlaca: function() {

        return $('#placa').val();
    },

    getReboque1: function() {

        return $('#reboque1').val();
    },

    getReboque2: function() {

        return $('#reboque2').val();
    },

    watchValidaCampo: function() {

        $('.valida-campo:not(.watched)').each(function() {

            $(this).change(function() {
                $(this).addClass('watched');
                ManageFrontend.manageValidaCampos($(this));
            });
        });
    },

    setSituacao: function (status, message) {

        var sClass = '';
        switch (status) {
            case 201:
                sClass = 'orange-label';
                break;
            case 400:
                sClass = 'red-label';
                break;
            case 200:
                sClass = 'green-label';
                break;
            case 404:
                sClass = 'red-label';
                break;
        
            default:
                break;
        }

        $('.temporizador h4').text('');

        return new Promise (function (resolve, reject) {
            
            var aColors = ['orange-label' ,'red-label' ,'green-label'];
            aColors.forEach(sColor => {
                $('.temporizador').removeClass(sColor);
            });
            $('.temporizador').addClass(sClass);
            $('.temporizador h4').text(message);

            ManageRoutineData.setSituacaoGate(Portaria.getBalanca(), message);
            
            return resolve(1)
        })
    },

    watchButtonAtualizar: function () {
        
        $('.atualiza:not(.watched)').click(function() {
            $(this).addClass('watched');
            ManageFrontend.limpaCampos();
        })
    },

    watchButtonBuscaProg: function () {
        
        $('.busca-prog:not(.watched)').click(function() {
            $(this).addClass('watched');
            oState.setState('camposValidados', oState.getState('camposValidados'));
        })
    },

    watchButtonBuscaResv: function () {
        
        $('.busca-resv:not(.watched)').click(function() {
            $(this).addClass('watched');
            oState.setState('iProgramacaoId', oState.getState('iProgramacaoId'));
        })
    },

    watchButtonRegistraPesagem: function () {
        
        $('.registra-pesagem:not(.watched)').click(function() {
            $(this).addClass('watched');
            oState.setState('iResvId', oState.getState('iResvId'));
        })
    },

    watchButtonAtualizarFotos: function() {

        $('.atualizar-fotos:not(.watched)').click(function() {
            $(this).addClass('watched');
            ManageFrontend.manageAtualizarFotos();
        })
    },

    watchButtonHabilitaLeitura: function() {

        $('.habilita-leitura:not(.watched)').click(function() {
            $(this).addClass('watched');
            ManageFrontend.manageMovimentacaoBalanca();
        })
    },

    watchFocusInputPeso: function() {

        $('#peso').focus(function() {
            oState.setState('pesoFocus', true);
        });

        $('#peso').focusout(function() {
            oState.setState('pesoFocus', false);
        });
    },

    watchCommandCancelas: function() {

        $('.comando-cancela:not(.watched)').each(function() {

            $(this).click(async function() {
                $(this).addClass('watched');
                var iCancelaId = $('select[name="cancela_id"]').val();
                var sTipo = $(this).val();
                var iAtivo = $(this).attr('data-tipo') != undefined ? $(this).attr('data-tipo') : '';
                iAtivo = iAtivo == 'abrir' || sTipo == 'pulso' ? 1 : 0;

                if (!iCancelaId)
                    return await Utils.swalUtil({
                        title:'Necessário selecionar uma cancela.',
                        type:'error',
                        timer:2000
                    });

                await ManageRoutineData.setComandoCancela(iCancelaId, sTipo, iAtivo);
                return Utils.swalResponseUtil(oResponse);
            });
        });
    },

    watchModoVisualizacao: function() {
        $('.panel-headline .page-header').html(
            $('.panel-headline .page-header').text() + ' <b> ( MODO VISUALIZAÇÃO ) </b>');
        $('button:not(.dropdown-toggle)').prop('disabled', true);
    },
    
    watchInputContainers: function() {

        $('.containers:not(watched)').each(function() {

            $(this).focusout(function() {
                $(this).addClass('watched');

                Portaria.setSituacao(200, 'Validando Containers').then(function() {
                    setTimeout(() => {
                        ManageFrontend.manageValidacaoContainers();
                    }, 2000);
                });
            })
        })
    },

    watchInputBalanca: function() {

        $('select[name="balanca_id"]').change(function() {
            window.location.href = '/portarias/dashboardPortarias/' + $(this).val();
        });
    },

    watchButtonFotos: function() {
        $('.button-fotos').click(function() {
            $('#modal-fotos .modal-body').html('')
            $('#modal-fotos .modal-body').html('<div id="dropzone-xml" callback-on-complete="" data-show-get-files="1" class="dropzone component  needsclick dz-clickable dz-remove-progress lf-margin-top full-width lf-margin-bottom" data-id="" data-caminho="programacao-fotos-ocrs/fotos" data-tipo="png,jpeg,jpg" data-coluna="programacao_id" data-tabela="ProgramacaoAnexos" data-max-files="10" data-show-image-by-php="1" data-id-auxiliar="" data-coluna-auxiliar="" data-tabela-auxiliar="" data-initonready="0"><div class="dz-message needsclick">Solte os arquivos aqui ou clique para fazer o upload.<br><span class="note needsclick">(É possivel anexar 10 arquivo(s))</span></div></div>')
            $('#dropzone-xml').attr('data-id', oState.getState('iProgramacaoId'));
            $('#dropzone-xml').attr('data-initOnReady', 1);
            DropzoneElement.init();
        })
    },

    watchButtonInserirFotos: function() {
        $('#importXml').click(function() {
            $('#modal-fotos').modal('toggle');
            oState.setState('fotosRegistradas', true);
        });
    }
}