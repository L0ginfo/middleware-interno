$(function(){
    var listaParametrosConsultas = [];
    var parametrosConsultas = [];
    getParametros();
    $('#clear').click(function(event){
        event.preventDefault();
        $('#conteudo').val('');
    });

    $('#save-btn').click(function(event){
        $('#save').val(1);
    });

    $('#insert-parameter').click(function(event){
        Swal.fire({
            title: 'Selecione o Paremetro',
            input: 'select',
            inputOptions: listaParametrosConsultas,
            inputPlaceholder: 'Selecione',
            showCancelButton: true,
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (value) {
                        resolve()
                    } else {
                        resolve('Por favor, selecione um parametro.')
                    }
                })
            }
        }).then(function(resultado){
            if(resultado.value){
                insertCodigo(resultado.value);
            }
        });
    });

    function getParametros(){
        $.ajax({
            method: "POST",
            url: $('#save').data('url'),
            success:function(data){
                if(data){
                    parametrosConsultas = data['aParemetros'];
                    listaParametrosConsultas = data['aListaParemetros'];
                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }

    function insertCodigo(id){
        insertAtCaret( document.getElementById('conteudo'), parametrosConsultas[id]);
    }
    
    function insertAtCaret(element, text) {
        if (document.selection) {
            element.focus();
            var sel = document.selection.createRange();
            sel.text = text;
            element.focus();
        } else if (element.selectionStart || element.selectionStart === 0) {
            var startPos = element.selectionStart;
            var endPos = element.selectionEnd;
            var scrollTop = element.scrollTop;
            element.value = element.value.substring(0, startPos) +
            text + element.value.substring(endPos, element.value.length);
            element.focus();
            element.selectionStart = startPos + text.length;
            element.selectionEnd = startPos + text.length;
            element.scrollTop = scrollTop;
        } else {
            element.value += text;
            element.focus();
        }
    }
});