var Lacres = {

    init: function() {
        Lacres.watchClickButton();
        Lacres.watchAddLacres();
        Lacres.verifyLacre();
    },
    
    watchClickButton: function() {
        
        $('#button-lacres').click(async function(e) {
            e.preventDefault();
            await Lacres.getLacresByVistoria(Lacres.getIdDoc());
            var aLacres = await Lacres.getLacres(Lacres.getIdDoc());
            Lacres.renderLacres(aLacres);
            $('#modal-documento-lacres').modal('toggle');
        })
    },

    getScope: function() {

        return $('#modal-documento-lacres');
    },

    watchAddLacres: function() {

        $('#add-lacres').click(async function() {
            var sLacre = $('#lacre-carga-solta').val(),
                iLacreTipoId = $('#lacre-carga-solta-tipo-id').val(),
                iOsId = Lacres.getIdDoc();

            if (Utils.manageRequiredCustom(Lacres.getScope()))
                return false;

            var oResponse = await Lacres.saveLacre(sLacre, iLacreTipoId, iOsId);

            if (oResponse.status != 200)
                return Utils.swalResponseUtil(oResponse);

            $('.modal-body #lacre-carga-solta').val('');
            $('.modal-body #lacre-carga-solta').removeClass('input-color-vistoria-correto');
            $('.modal-body #lacre-carga-solta').removeClass('input-color-vistoria-diferente');
            $('.modal-body #lacre-carga-solta-tipo-id').removeClass('input-color-vistoria-correto');
            $('.modal-body #lacre-carga-solta-tipo-id').removeClass('input-color-vistoria-diferente');
            Lacres.renderLacres(oResponse.dataExtra);


        });
    },

    consisteLacre: async function(iOsId) {

        var oResponse = await $.fn.doAjax({
            url: 'ordem-servico-lacres/consisteLacres/' + iOsId,
            type: 'GET'
        });

        if (oResponse.status != 200) {
            return await Utils.swalConfirmOrCancel({
                title:'Existe divergência de lacres, deseja prosseguir?',
                text:'Será realizado sequência no processo de finalização',
                confirmButtonText: 'Sim, continuar',
                showConfirmButton: true,
                defaultConfirmColor: true,
                showCancelButton: true,
            });
        }

        return true;

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

        return $('.os_id').val();
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
            var sTr = oResponse.getDataExtra().replace('__class_color__', oLacre.valido ? 'input-color-vistoria-correto' : 'input-color-vistoria-diferente');
            console.log(sTr);
            $table.find('tbody').append(sTr);
            
        });
        Lacres.watchRemoveLacre();
    },

    verifyLacre: function() {

        var fValidateInputLacre = async function ($that) {
            var sLacre = $('.modal-body #lacre-carga-solta').val(), 
                iLacreTipoId = $('#lacre-carga-solta-tipo-id').val(),
                $lacreInput = $('.modal-body #lacre-carga-solta'),
                $lacreTipoInput = $('#lacre-carga-solta-tipo-id'),
                iOsId = Lacres.getIdDoc();

            if (!sLacre || !iLacreTipoId || !iOsId)
                return;

            oResponse = await Lacres.validateLacre(sLacre, iLacreTipoId, iOsId);

            if (oResponse.status == 200) {
                $lacreInput.removeClass('input-color-vistoria-diferente');
                $lacreInput.addClass('input-color-vistoria-correto');
                $lacreTipoInput.removeClass('input-color-vistoria-diferente');
                $lacreTipoInput.addClass('input-color-vistoria-correto');
            } else if (oResponse.status == 406) {
                $lacreInput.removeClass('input-color-vistoria-correto');
                $lacreInput.addClass('input-color-vistoria-diferente');
                $lacreTipoInput.removeClass('input-color-vistoria-correto');
                $lacreTipoInput.addClass('input-color-vistoria-diferente');
                
            }
        }

        $('.modal-body #lacre-carga-solta').focusout(async function() {

            fValidateInputLacre($(this));
        });

        $('.modal-body #lacre-carga-solta-tipo-id').change(async function() {

            fValidateInputLacre($(this));
        });
    },

    getLacres: async function (iOsId) {
        var oResponse = await $.fn.doAjax({
            url: 'ordem-servico-lacres/getLacres/' + iOsId,
            type: 'GET'
        });

        return oResponse;
    },

    saveLacre: async function(sLacre, iLacreTipoId, iOsId) {

        var oResponse = await $.fn.doAjax({
            url: 'ordem-servico-lacres/saveLacre',
            type: 'POST',
            data: {
                lacre: sLacre,
                lacre_tipo: iLacreTipoId,
                ordem_servico: iOsId
            }
        });

        return oResponse;
    },

    removeLacre: async function(iLacreId) {

        var oResponse = await $.fn.doAjax({
            url: 'ordem-servico-lacres/removeLacre',
            type: 'POST',
            data: {
                lacre_id: iLacreId
            }
        });

        return oResponse;
    },

    validateLacre: async function(sLacre, iLacreTipoId, iOsId) {

        var oResponse = await $.fn.doAjax({
            url: 'ordem-servico-lacres/validateLacre/' + sLacre + '/' + iLacreTipoId + '/' + iOsId,
            type: 'GET'
        });

        return oResponse;
    },

    getLacresByVistoria: async function(iOsId) {

        var oResponse = await $.fn.doAjax({
            url: 'ordem-servico-lacres/getLacresByVistoria/' + iOsId,
            type: 'GET'
        });

        return oResponse;
    }

}

$(document).ready(function() {

    Lacres.init();
});