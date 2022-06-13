const Checklist = {

    init: async function () {

        this.observers()

        Checklist.watchClickChecked()
        Checklist.watchCheckboxNaoPermite()
        Checklist.watchBtnFinalizarChecklist()
        Checklist.watchBtnObservacoes()
        Checklist.watchInputObservacoes()

    },

    watchCheckboxNaoPermite: function () {

        var oInputsCheckboxs = $('input[type="checkbox"]')
        oInputsCheckboxs.each( function() {

            $(this).on('change', function() {

                $(this).addClass('watched')
                oState.setState('multiplos', {
                    this: $(this)
                })

            })

            if ($(this).is(":checked")) {
                oState.setState('multiplos', {
                    this: $(this)
                })
            }

        })

    },

    observers: function() {

        oSubject.setObserverOnEvent(async function () {

            var oReturn = await Services.updateChecklistResvPerguntasOrRespostas(oState.getState('checked'))

            if (oReturn.status != 200) {
                Swal.fire({
                    type: 'warning',
                    title: oReturn.message
                })
            }

        }, ['on_checked_change'])

        oSubject.setObserverOnEvent(async function () {

            var $this = oState.getState('hide').this
            var oDiv = $this.closest('.group_textarea')
            oDiv.find('.input_textarea').toggleClass('hide')

        }, ['on_hide_change'])

        oSubject.setObserverOnEvent(async function () {

            var oReturn = await Services.updateChecklistResvPerguntasOrRespostas(oState.getState('observacoes'))

            if (oReturn.status != 200) {
                Swal.fire({
                    type: 'warning',
                    title: oReturn.message
                })
            }

        }, ['on_observacoes_change'])

        oSubject.setObserverOnEvent(async function () {

            var $this = oState.getState('multiplos').this

            if ($this.data("class") == "nao_permite") {

                if ($this.is(":checked")) {

                    $('input[name="' + $this.attr('name') + '"]').attr('disabled', true)
                    $this.removeAttr('disabled')

                } else {

                    $('input[name="' + $this.attr('name') + '"]').removeAttr('disabled')

                }
            }
                

        }, ['on_multiplos_change'])

        oSubject.setObserverOnEvent(async function () {

            var $this = oState.getState('obrigatorio').this

            var bPermiteFinalizar = await Checklist.verifyInputsRequired($this) 

            if (bPermiteFinalizar) {
                Checklist.returnConfirm($this) 
            } else {
                return Swal.fire({
                    title: 'Atenção',
                    html: 'Ainda existem perguntas obrigatórias que não foram respondidas <strong style="color: red;">*</strong>',
                    type: 'warning'
                })
            }        

        }, ['on_obrigatorio_change'])

    },

    verifyInputsRequired: async function($this) {

        var oDivGlobal = $this.closest('.global_div')

        var oDivGroupPerguntaResposta = oDivGlobal.find('.group_pergunta_resposta')
        var bPermiteFinalizar = true
        oDivGroupPerguntaResposta.each( function() {

            var $thisPerguntaReposta = $(this)
            var oDivPergunta = $(this).find('.div_pergunta')
            if (oDivPergunta.data("required") == "obrigatorio") {

                var oDivRespostas = $thisPerguntaReposta.find('.div_respostas')
                var iCount = 0;
                oDivRespostas.each( function() {

                    var oInputCheckbox = $(this).find('input[type="checkbox"]')
                    if (oInputCheckbox.is(":checked"))
                        iCount++

                })

                if (iCount <= 0 && bPermiteFinalizar)
                    bPermiteFinalizar = false

            }

        })

        return bPermiteFinalizar
    },

    returnConfirm: function($this) {

        return Swal.fire({

            title: 'Atenção',
            text: 'Tem certeza que deseja finalizar o Checklist?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#41B314',
            cancelButtonColor: '#ac2925',
            confirmButtonText: 'Sim, continuar',
            cancelButtonText: 'Não',
            showLoaderOnConfirm: true

        }).then (async result => {

            if (result.dismiss != 'cancel') {

                var iChecklistResvID  = $this.data("id")
                var sUrlFinalizar     = $this.closest('.footer').find('.url_finalizar').val()

                window.location.href = url + sUrlFinalizar + iChecklistResvID
                Loader.showLoad();

            } else {

                return false

            }

        })

    },

    watchClickChecked: function() {

        $('.checked:not(.watched)').click(function(e) {

            $(this).addClass('watched');

            oState.setState('checked', {
                resposta_id: $(this).data("id"),
                checked: $(this).is(":checked"),
                campo: 'selecionado'
            })

        })

    },

    watchBtnObservacoes: function() {

        $('.button_observacoes:not(.watched)').click(function(e) {
            $(this).addClass('watched');

            oState.setState('hide', {
                this: $(this)
            })

        })

    },

    watchInputObservacoes: function() {

        $('.input_textarea:not(.watched)').focusout(function(e) {
            $(this).addClass('watched');

            oState.setState('observacoes', {
                pergunta_id: $(this).data("id"),
                observacao: $(this).val(),
                campo: 'observacao'
            })

        })

    },

    watchBtnFinalizarChecklist: function () {

        $('.button_finalizar_checklist').click( async function () {

            oState.setState('obrigatorio', {
                this: $(this)
            })

        })

    },

}
