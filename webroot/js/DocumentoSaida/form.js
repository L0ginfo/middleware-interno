/*
 * Quando selecionado Documento DI
 * habilita o campo para informar se é entreposto ou di parte
 * se for entreposto, habilita o campo para informar o numero da DA entreposto
 * se for parte, habilita os campos para informar o BL e a DI parte
 *
 * Quando selecionado Documento DTA
 * habilita os campos para informar sobre os recintos de origem e destino
 * e verificar se precisa de scanner
 */
$(document).ready(function () {
    ocultarCampos();
})
$(document).on('change blur', '#documento-id', function () {
    ocultarCampos()
});
$(document).ready(function () {
    if ($("#di-entreposto").val() == 1) {
        $("#da").show("");
    } else {
        $("#da").hide("");
    }
})
$(document).on('change blur', '#di-entreposto', function () {
    if ($(this).val() == 1) {
        $("#da").show("");
    } else {
        $("#da").hide("");
    }
});
$(document).ready(function () {
     if ($("#di-parte").val() == 1) {
        $("#bl").show("");
        $("#di").show("");
    } else {
        $("#bl").hide("");
        $("#di").hide("");
    }
})
$(document).on('change blur', '#di-parte', function () {
    if ($(this).val() == 1) {
        $("#bl").show("");
        $("#di").show("");
    } else {
        $("#bl").hide("");
        $("#di").hide("");
    }
});
function ocultarCampos() {
    if ($("#documento-id").val() == '4') {
        $("#entreposto").show("");
    } else {
        $("#entreposto").hide("");
        $("#da").hide("");
        $("#di").hide("");
        $("#bl").hide("");
    }

    if ($("#documento-id").val() == '9') {
        $("#scanner").show("");
    } else {
        $("#scanner").hide("");
    }
}