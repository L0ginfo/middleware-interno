var form = document.getElementById("formulario");

form.onsubmit = function (e) {
    // stop the regular form submission
    e.preventDefault();
// $("#formulario").submit(function() {
    var formData = new FormData(this);
    $.ajax({
        url: webroot + 'nota-fiscal/verificaSeExiste/',
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        async: false
    }).done(function (result) {
        if (result) { 
            if (result == "inalteravel") {
                alert("Nota fiscal já importada e sem possibilidade de substituir");
                location.reload()
            } else if (result == "desvinculada") {
                alert("Você não tem vinculo com esta empresa, favor solicitar cadastro para cadastro@barradorio.com.br");
                location.reload()
            } else {
                if (confirm("A nota fiscal já existe, deseja substituir?")) {
                    $.ajax ({ 
                        url: webroot + 'NotaFiscal/importar/' + result, 
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        async: false
                    }).done(function (result) {
                        var resultado = JSON.parse(result);
                        alert(resultado.result);
                        window.location.replace(webroot + 'nota-fiscal/view/' + resultado.id);
                    });
                } 
            }
        } else {
            $.ajax ({ 
                url: webroot + 'NotaFiscal/importar', 
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                async: false
            }).done(function (result) {
                var resultado = JSON.parse(result);
                alert(resultado.result);
                window.location.replace(webroot + 'nota-fiscal/view/' + resultado.id);	
            });
        }
    });
};