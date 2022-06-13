/**
 * How to Use *
 * 
 * Crie um input com o nome correto para salvar ao enviar o form
 * <input type='hidden' name='user_id' value=''>
 * 
 * Crie *logo após*, o input que servirá para pesquisa
 * <input type='text' name='user' url='users/find' class='rapid-search' value=''>
 * 
 *@tag url - serve para mostrar em qual url irá fazer a pesquisa
 *@class rapid-search - serve para aplicar pesquisa rápida
 * 
 **/

/**
 * input que fará a pesquisa
 * @type int
 */
var input = null

/**
 * input que servirá para salvar ao enviar o form
 * @type int
 */
var input_id = null

/**
 * fara a pesquisa e mostrará lista para escolher com os resultados
 * importante ver como irá renderizar o método, ex. de como deve ser feito:
 * 
 * <div class='list-items-box'>
 *  <span class='list-items' value='xxx'>xxx</span><br />
 *  <span class='list-items' value='xxx'>xxx</span><br />
 *  ...
 * </div>
 * 
 */
$('.rapid-search').change(function () {
    input = $(this)

    //input_id = $(this).parent('div').prev('input[type=hidden]')
    if (input.val().length < 5 || (input.attr('id') == 'transportadora' && input.val().length < 3)) {
        if (input.attr('id') == 'transportadora' && input.val().length < 3) {
            alert("Preencha no minimo 3 caracteres")
            e.preventDefault();
        }
        if (input.attr('id') != 'transportadora' && input.val().length < 5){
            alert("Preencha no minimo 5 caracteres")
            e.preventDefault();
        }
    }
    
    if (input.val()) {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + input.attr('url') + '/' + input.val(), // empresas/index
            type: "post",
            //data: $('form').serialize(),
            success: function (data) {
                $('.list-items-box').remove()
                input.after(data)
                $('.ajaxloader').fadeOut()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro! ' + errorThrown)
                location.reload()
            }
        })
    } else {
        $('.list-items-box').remove()
    }
});

/**
 * escolhe na lista e popula o input que será enviado pelo form
 */
$(document).on('click', '.list-items', function () {
    var campo = input.attr('id')
    var campo_nome = input.attr('campo_nome')
    var campo_codigo = input.attr('campo_codigo')

    if (campo_codigo) {
        campo_codigo = campo_codigo.replace('_', '-').toLowerCase()
        campo_nome = campo_nome.replace('_', '-').toLowerCase()

        if ($(this).html().toLowerCase().indexOf("bloqueado") > 1) {
            alert('O CPF do motorista está bloqueado');
        } else {
            $('#' + campo_codigo).val($(this).attr('value'))
            $('#' + campo_nome).val($(this).html())

            if (campo_nome == "nome-motorista")
                $('#motorista').val($(this).html())
            
            $('.list-items-box').remove();
        }
    }
});

$(document).ready(function () {
    try {
        $(".rapid-search").each(function () {
            $(this).attr("autocomplete", "off");
        });
    } catch (e){
    }
});
