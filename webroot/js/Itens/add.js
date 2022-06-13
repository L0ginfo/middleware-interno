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
})

/**
 * escolhe na lista e popula o input que será enviado pelo form
 */
$(document).on('click', '.list-items', function () {
    input.val($(this).attr('value'))
    $('textarea[name=descricao]').val($(this).attr('descricao'))
    $('.list-items-box').remove()
})

$(document).on('change', '#codigo', function () {

    codigo = $("#codigo option:selected").val()

    $('textarea[name=descricao]').removeAttr('readonly');
    $('textarea[name=descricao]').val('')
    if (codigo) {
        $('.ajaxloader').fadeIn()
        $.ajax({
            url: webroot + 'itens/findProdutoCaracteristicas' + '/' + codigo, // empresas/index
            type: "post",
            //data: $('form').serialize(),
            success: function (data) {
                var obj = JSON.parse(data);
                console.log(obj[0])
                //   console.log(obj[0].esp_id)
                $('#ncm').val(obj[0].prod_ncm)
                $('#descricao-produto').val(obj[0].prod_desc)
                $('textarea[name=descricao]').val(obj[0].ncm_descricao)
                $('textarea[name=descricao]').attr('readonly', 'readonly');
                $("select#embalagem-id option")
                        .each(function () {
                            this.selected = (this.text == obj[0].esp_id);
                        });

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro! ' + errorThrown)
                location.reload()
            }
        })
    }
})


$(document).ready(function () {
    if ($('#codigo').val() > 0)
        $('textarea[name=descricao]').attr('readonly', 'readonly');

})

$(document).ready(function () {
    if ($('#anvisa').val() == 'Sim') {
        $('#dv_controlado').show();
    } else {
        $('#dv_controlado').hide();
    }
})

$('#anvisa').change(function () {

    input = $(this)
    if (input.val() == 'Sim') {
        $('#controlado').val('');
        $('#dv_controlado').show();
    } else {
        $('#controlado').val('Não');
         $('#dv_controlado').hide();
    }

})