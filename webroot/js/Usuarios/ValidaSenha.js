const ValidaSenha = {

    senha_is_valid: false,

    init: function() {

        this.watchSubmit()
        this.watchSenhaField()
    },

    watchSubmit: function() {
        $('form.usuario').submit(function (e) {
            if (!ValidaSenha.senha_is_valid) {
                e.preventDefault()
                Utils.swalUtil({
                    title:'Ops!' ,
                    text : 'A senha não atingiu os requisitos mínimos!',
                    timer: 4000
                });
                return false
            }
        })
    },

    watchSenhaField: function() {
        $('[name="senha"]').keyup(function() {
            var sSenha = $(this).val()

            ValidaSenha.validaSenha(sSenha)
        })
    },

    validaSenha: function(sSenha) {

        var aCondicoes = ['.cond-1', '.cond-2', '.cond-3']
        var aCondicoesInvalidas = []
        var sRegExpLetter = /[a-zA-Z]/g;
        var sRegExpNumber = /[0-9]/g;

        ValidaSenha.senha_is_valid = true

        if (sSenha.length < 8)
            aCondicoesInvalidas.push('.cond-1')

        if (!sRegExpLetter.test(sSenha))
            aCondicoesInvalidas.push('.cond-2')

        if (!sRegExpNumber.test(sSenha))
            aCondicoesInvalidas.push('.cond-3')

        var aCondicao = '';

        for (var aCondicaoKey in aCondicoes) {
            aCondicao = aCondicoes[aCondicaoKey]

            if (aCondicoesInvalidas.includes(aCondicao)) {
                $(aCondicao).css({color: 'red'})
                ValidaSenha.senha_is_valid = false
            }else {
                $(aCondicao).css({color: 'green'})
            }

        }
    }

}

$(document).ready(function() {
    ValidaSenha.init()
})