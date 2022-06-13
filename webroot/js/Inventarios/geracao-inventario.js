jQuery(function ($) {
    
    var Campos = {
        ocultarCampos: function () {
            if (parseInt($("#tipo-inventario").val()) === 0) {
                $("#tipo-inventario-parcial").show("");
            } else {
                inputsEmpty  = ['quantidade-contagem'];
                selectsEmpty = ['depositante-id', 'produto-classificacao-id'];
                    
                inputsEmpty.forEach(element => {
                    $('input[id="'+ element +'"]').val('');
                });
                selectsEmpty.forEach(element => {
                    $('select[id="'+ element +'"]').val('');
                });

                $('.selectpicker').selectpicker('refresh');
                $("#tipo-inventario-parcial").hide("");
            }
        }
    };

    $('#tipo-inventario').change(function() {
        Campos.ocultarCampos();
    });

});