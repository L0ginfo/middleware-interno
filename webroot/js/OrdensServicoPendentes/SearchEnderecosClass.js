var SearchEnderecos = {
    init: function () {
        SearchEnderecos.watchChanges()  
    },

    searchForAlreadyInFrontEnd: function (bShowLoad = true) {  
        var enderecoSelecionado      

        $('.entradas-fisicas.watched .copy-inputs .armazem.watched').each(function () {
            var $oEndereco = $(this).closest('.armazem-enderecos').find('.enderecos')

            enderecoSelecionado = $(this).closest('.armazem-enderecos').find('select.enderecos').attr('endereco-selecionado')

            if ( $(this).closest('.armazem-enderecos').find('select.enderecos').val() )
                enderecoSelecionado = null

            SearchEnderecos.findEnderecos( $(this), $oEndereco, enderecoSelecionado, bShowLoad )
        })

        if (!enderecoSelecionado)
            return 'nenhum_selecionado'
    },

    watchChanges: function () {
        
        $('.entradas-fisicas.active .copy-inputs .armazem:not(.watched)').each(function () {
            $(this).removeClass('no-watched')
            $(this).addClass('watched')
        })

        $('.entradas-fisicas.active .copy-inputs .armazem.watched').change(function () {
            var $oEndereco = $(this).closest('.armazem-enderecos').find('.enderecos')
            SearchEnderecos.findEnderecos( $(this), $oEndereco )
        })
    },

    findEnderecos: function ( $oArmazem, $oEndereco, enderecoSelecionado = null, bShowLoad = true ) {
        var iArmazemID = $oArmazem.val()
        
        if (iArmazemID != '') {

            if (bShowLoad)
                Loader.showLoad();
            
            $.ajax({
                url: url + '/enderecos/findEnderecosByLocal/' + iArmazemID,
                data: { alreadySelected: enderecoSelecionado },
                type: 'GET',
            }).success(function (oReturn) {
                $select = $oEndereco.find('select');

                if (!$select.size()){
                    $oEndereco.html(oReturn['html'])
                    $oEndereco.change()
                    //atualiza o selectpicker
                    $oEndereco.selectpicker('refresh')
                }else {
                    $oEndereco.find('select').html(oReturn['html'])
                    $oEndereco.find('select').change()
                    //atualiza o selectpicker
                    $oEndereco.selectpicker('refresh')
                }

                Loader.hideLoad();

            }).error(function (oReturn) {
                console.log(oReturn)
            })
        }
    }
}