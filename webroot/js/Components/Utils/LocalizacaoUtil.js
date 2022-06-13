var Cities = {
    init: function() {
        Cities.manageCities(Cities.getSelectStates());
    },

    findCities: async function(iState, $oCities) {
        Loader.showLoad()

        var oReturn = await $.fn.doAjax({
            url: 'cidades/findCityByState/' + iState,
            type: 'GET',
        })

        if (oReturn['status'] != 200)
            return Swal.fire({
                title: 'Ops, ocorreu um erro ao buscar cidades!',
                text: 'Tente novamente mais tarde',
                type: 'error',
            });

        $oCities.html(oReturn['dataExtra'])

        if ($oCities.attr('data-selected')) {
            $oCities.val($oCities.attr('data-selected'))
        }

        setTimeout(function() {
            $('.selectpicker').selectpicker('refresh')
        }, 1000);
    

        Loader.hideLoad(1000)
    },

    manageCities: function($selectStates) {
        $selectStates.each(function () { 

            if ($(this).val() != '')
                Cities.findCities($(this).val(), $(this).closest('.localizacoes-agroup').find("select[name^='cidade']"));

            $(this).on('change', function(){
                Cities.findCities($(this).val(), $(this).closest('.localizacoes-agroup').find("select[name^='cidade']"));
            });
            
        })
    },

    getSelectStates: function() {
        return $( ".localizacoes-agroup select[name^='estado']" );
    }
}

$(document).ready(function() {
    Cities.init();
})
