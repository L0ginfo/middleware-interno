var segundos = 30000; 
window.setInterval(AjaxTrintaSegundos, segundos); /* Executa funcao a cada 30 segundos */
function AjaxTrintaSegundos() {
    $.ajax({ cache: false,
        url: webroot + 'nota-fiscal/verifica-importador-sara/'
    });
}