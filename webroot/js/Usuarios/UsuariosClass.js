const Usuarios = {

    init: async function() {
        setTimeout(() => {
            Usuarios.watchClickSubmit();
        }, 1000);
        
    },

    watchClickSubmit: function() {
        $('#btn-atualizar:not(.watched)').click(function(e) {
            e.preventDefault();
            if(Usuarios.checkPasswordMatch()){
                if(Usuarios.checkPasswordLength()) {
                    Usuarios.formSubmit();
                } else {
                    Usuarios.alertError('As senha deve conter entre 6 a 25 caracteres');
                }
            } else {
                Usuarios.alertError('As senhas não correspondem');
            }
        })
    },

    checkPasswordMatch: function() {
        if($('#password').val() !== $('#passwordConfirm').val()) {
            return false;
        }
        return true;
    },

    checkPasswordLength: function() {
        if($('#password').val().length < 6 || $('#password').val().length > 25) {
            return false;
        }
        return true;
    },

    formSubmit: function() {
        $('#btn-atualizar:not(.watched)')[0].parentElement.parentElement.submit();
    },

    alertError: function($msg) {
        Swal.fire({
            title: 'Erro',
            text:`${$msg}`,
            type: 'error',
            showCancelButton: false
        });
    }
}