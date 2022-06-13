$(window).load(function () {

    var aProdutosControles = JSON.parse($('.produtos_controles').val())

    $('.codigo-produto').keyup(function() {
        var sCodigoDigitado = $(this).val()
        
        iProdutoID = ''

        Object.keys(aProdutosControles).forEach(function(idx, val) {
            if (aProdutosControles[idx].codigo == sCodigoDigitado && !iProdutoID) {
                iProdutoID = aProdutosControles[idx].produto_id

                $('select.produto_id').val(iProdutoID)
                $('select.unidade_medida_id').val(aProdutosControles[idx].unidade_medida_id)
            }
        })

        if (!iProdutoID) {
            $('select.produto_id').val(null)
            $('select.unidade_medida_id').val(null)
        }

        $('select.produto_id').selectpicker('refresh')
        $('select.unidade_medida_id').selectpicker('refresh')
    })

    $('select.produto_id').change(function() {
        var iProdutoID = $(this).val()
        $('.codigo-produto').val(aProdutosControles[iProdutoID].codigo)
        $('select.unidade_medida_id').val(aProdutosControles[iProdutoID].unidade_medida_id)
        $('select.unidade_medida_id').selectpicker('refresh')
    })

})