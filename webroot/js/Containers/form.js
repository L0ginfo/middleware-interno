
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

    $('#peso-tara').val($(this).attr('peso_tara'))

    if ($(this).attr('cli_id') != '') {

var armador1 = $(this).attr('cli_id')
var armador2 = $('#armador option:selected').val()

        if (armador1 != armador2)
        {
            $('#armador option')
                    .removeAttr('selected');
            $('#armador option')
                    .filter('[value=' + $(this).attr('cli_id') + ']')
                    .attr('selected', true)
        }
    }

    detalharIsoCode($(this).attr('iso_code'))
    $('.list-items-box').remove()
    return false;
})

/**
 * mudar iso code
 */
$(document).ready(function () {


    detalharIsoCode($('#iso-code-id').val())
    //AAAA999999-1
    $('#container').mask('SSSS000000-0');
})


$("#descricao").change(function () {
    detalharIsoCode($(this).val())
})

function detalharIsoCode(id) {

    $.ajax({
        url: webroot + 'iso-codes/find/' + id,
        type: "post",
        success: function (data) {
            if (data) {
                data = JSON.parse(data)
                $('#tamanho').val(data.tamanho)
                $('#iso-code-id').val(data.id)
                $('#iso-code').val(data.iso_code)
                $('#descricao option:selected').removeAttr('selected')
                $("#descricao option[value='" + data.id + "']").prop('selected', true)
            }
            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown)
            location.reload()
        }
    })

}

$('form').submit(function (e) {
    e.preventDefault()
    $('.ajaxloader').fadeIn()
    $.ajax({
        url: $(this).attr('action'),
        type: "post",
        data: $(this).serialize(),
        success: function (data) {
           //  alert(data)
            if (data.indexOf("/view") >= 2) {
                window.location = webroot  + data;
            } else {
                $('.fancybox-inner').html(data)
            }
            $('.ajaxloader').fadeOut()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro! ' + errorThrown)
            location.reload()
        }
    })
})


$(document).on('click', '#adicionar_lacres', function () {
    $('#lacre0').show();
    $('#lacre1').show();
    $('#lacre2').show();
    $('#lacre3').show();
    $('#lacre4').show();
    $('#ocultar_lacres').show();
    $('#adicionar_lacres').hide();
})

$(document).on('click', '#ocultar_lacres', function () {

    if ($("#lacre1").val() == "")
        $('#lacre1').hide();
    if ($("#lacre2").val() == "")
        $('#lacre2').hide();
    if ($("#lacre3").val() == "")
        $('#lacre3').hide();
    if ($("#lacre4").val() == "")
        $('#lacre4').hide();
    $('#ocultar_lacres').hide();
    $('#adicionar_lacres').show();
})