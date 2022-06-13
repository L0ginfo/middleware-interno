var Lacres = {

    init: function() {
        Lacres.watchClickButton();
        Lacres.watchAddLacres();
    },
    
    watchClickButton: function() {
        
        $('.button-lacres').click(async function(e) {
            e.preventDefault();
            var aLacres = await Lacres.getLacres(Lacres.getIdDoc());
            Lacres.renderLacres(aLacres);
            // $('#modal-documento-lacres').modal('toggle');
        })
    },

    getScope: function() {

        return $('#modal-documento-lacres');
    },

    watchAddLacres: function() {

        $scope = Lacres.getScope();
        $scope.find('#add-lacres').click(async function() {
            
            var sLacre = $('#lacre-carga-solta').val(),
                iLacreTipoId = $('#lacre-carga-solta-tipo-id').val(),
                iDocTranspId = Lacres.getIdDoc();

            if (Utils.manageRequiredCustom())
                return false;

            var oResponse = await Lacres.saveLacre(sLacre, iLacreTipoId, iDocTranspId);

            if (oResponse.status != 200)
                return Utils.swalResponseUtil(oResponse);

            $('.modal-body #lacre-carga-solta').val('');
            Lacres.renderLacres(oResponse.dataExtra);


        });
    },

    watchRemoveLacre: function() {
        $('.table-lacres-adicionados .remove-lacre:not(.watched)').each(function() {

            $(this).click(async function() {

                $(this).addClass('watched');
                var responseSwal = await Utils.swalConfirmOrCancel({
                    title:'Deseja realmente remover este lacre?',
                    text:'O lacre será removido ao prosseguir',
                    confirmButtonText: 'Sim, continuar',
                    showConfirmButton: true,
                    defaultConfirmColor: true,
                    showCancelButton: true,
                });
        
                if (!responseSwal)
                    return;

                var oResponse = await Lacres.removeLacre($(this).attr('data-lacre-id'));

                if (oResponse.status != 200)
                    return Utils.swalResponseUtil(oResponse);

                Lacres.renderLacres(oResponse.dataExtra);                
            });
        })
    },

    getIdDoc: function() {

        return $('input[name="transporte[id]"]').val();
    },

    renderLacres: function(aLacres) {

        var $table = $('.table-lacres-adicionados table');
        if (!aLacres) {
            $table.find('tbody tr').remove();
            $table.find('tbody').append('<tr><td colspan="3" align="center">Vazio</td></tr>');
            return;
        }

        $table.find('tbody tr').remove();
        aLacres.forEach(oLacre => {
            oResponse = RenderCopy.render({
                object: oLacre,
                template: $('.copy.hidden .lacre-carga-solta')[0].outerHTML,
                data_to_render: 'lacre',
            });
    
            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item.')
            console.log(oResponse)
            //Renderiza
            $table.find('tbody').append(oResponse.getDataExtra());
        });
        Lacres.watchRemoveLacre();
    },

    getLacres: async function (iDocTranspId) {
        var oResponse = await $.fn.doAjax({
            url: 'documento-transporte-lacres/getLacres/' + iDocTranspId,
            type: 'GET'
        });

        return oResponse;
    },

    saveLacre: async function(sLacre, iLacreTipoId, iDocTranspId) {

        var oResponse = await $.fn.doAjax({
            url: 'documento-transporte-lacres/saveLacre',
            type: 'POST',
            data: {
                lacre: sLacre,
                lacre_tipo: iLacreTipoId,
                doc_tranporte: iDocTranspId
            }
        });

        return oResponse;
    },

    removeLacre: async function(iLacreId) {

        var oResponse = await $.fn.doAjax({
            url: 'documento-transporte-lacres/removeLacre',
            type: 'POST',
            data: {
                lacre_id: iLacreId
            }
        });

        return oResponse;
    }

}

$(document).ready(function() {

    Lacres.init();
});