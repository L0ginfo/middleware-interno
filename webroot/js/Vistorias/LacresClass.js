var Lacres = {

    init: function() {
        Lacres.watchClickButton();
        Lacres.watchAddLacres();
        Lacres.verifyLacre();
    },
    
    watchClickButton: function() {
        
        $('.button-lacres').click(async function(e) {
            e.preventDefault();
            var iVistoriaId = $(this).data('vistoria-id');
            var iVistoriaItemId = $(this).data('vistoria-item-id') ? $(this).data('vistoria-item-id') : null;
            var aLacres = await Lacres.getLacres(iVistoriaId, iVistoriaItemId);

            Lacres.renderLacres(aLacres, iVistoriaItemId);
            $('#modal-documento-lacres' + (iVistoriaItemId ? iVistoriaItemId : '')).modal('toggle');
        })
    },

    getScope: function(iVistoriaItemId = null) {

        return $('#modal-documento-lacres' + (iVistoriaItemId ? iVistoriaItemId : ''));
    },

    watchAddLacres: function() {

        $('.add-lacres:not(.watched)').each(function() {
            
            $(this).click(async function() {
                $(this).addClass('watched');
                var $scope = Lacres.getScope($(this).data('vistoria-item-id') ? $(this).data('vistoria-item-id') : null);
                var sLacre = $scope.find('#lacre-carga-solta').val(),
                    iLacreTipoId = $scope.find('#lacre-carga-solta-tipo-id').val(),
                    iVistoriaId = $(this).data('vistoria-id'),
                    iVistoriaItemId = $(this).data('vistoria-item-id') ? $(this).data('vistoria-item-id') : null;
    
                if (Utils.manageRequiredCustom(Lacres.getScope(iVistoriaItemId)))
                    return false;
    
                var oResponse = await Lacres.saveLacre(sLacre, iLacreTipoId, iVistoriaId, iVistoriaItemId);
    
                if (oResponse.status != 200)
                    return Utils.swalResponseUtil(oResponse);
    
                Lacres.getScope(iVistoriaItemId).find('.modal-body #lacre-carga-solta').val('');
                Lacres.getScope(iVistoriaItemId).find('.modal-body #lacre-carga-solta').removeClass('input-color-vistoria-correto');
                Lacres.getScope(iVistoriaItemId).find('.modal-body #lacre-carga-solta').removeClass('input-color-vistoria-diferente');
                Lacres.getScope(iVistoriaItemId).find('.modal-body #lacre-carga-solta-tipo-id').removeClass('input-color-vistoria-correto');
                Lacres.getScope(iVistoriaItemId).find('.modal-body #lacre-carga-solta-tipo-id').removeClass('input-color-vistoria-diferente');
                Lacres.renderLacres(oResponse.dataExtra, iVistoriaItemId);
    
    
            });
        });
    },

    consisteLacre: async function(iVistoriaId, iVistoriaItemId = null) {

        var bHasTipoCheio = 0;
        $('input[name="tipo_carga_container"]').each(function() {
            if ($(this).val() == 'CHEIO') {
                bHasTipoCheio = 1;
                return;
            }
        });
        var oResponse = await $.fn.doAjax({
            url: 'vistoria-lacres/consisteLacres/' + iVistoriaId + '/' + (iVistoriaItemId ? iVistoriaItemId : 0) + '/' + bHasTipoCheio,
            type: 'GET'
        });

        if (oResponse.status != 200) {

            if (bHasTipoCheio)
                return await Utils.swalConfirmOrCancel({
                    title:'Existe divergência de lacres.',
                    text:'Necessário vistoriar os lacres novamente.',
                    confirmButtonText: 'Sim, continuar',
                    showConfirmButton: false,
                    defaultConfirmColor: true,
                    showCancelButton: true,
                    cancelButtonText: 'Fechar',
                });

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

                Lacres.renderLacres(oResponse.dataExtra, $(this).closest('.modal').data('vistoria-item'));                
            });
        })
    },

    getIdDoc: function() {

        return $('.os_id').val();
    },

    renderLacres: function(aLacres, iVistoriaItemId = null) {

        var $table = Lacres.getScope(iVistoriaItemId).find('.table-lacres-adicionados table');
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
            $table.find('tbody').append(sTr);
            
        });
        Lacres.watchRemoveLacre();
    },

    verifyLacre: function() {

        var fValidateInputLacre = async function ($that) {
            var $scope = Lacres.getScope($that.closest('.modal').data('vistoria-item'));
            var sLacre = $scope.find('.modal-body #lacre-carga-solta').val(), 
                iLacreTipoId = $scope.find('#lacre-carga-solta-tipo-id').val(),
                $lacreInput = $scope.find('.modal-body #lacre-carga-solta'),
                $lacreTipoInput = $scope.find('#lacre-carga-solta-tipo-id'),
                iVistoriaId = $that.closest('.modal').data('vistoria'),
                iVistoriaItemId = $that.closest('.modal').data('vistoria-item');

            if (!sLacre || !iLacreTipoId || !iVistoriaId)
                return;

            oResponse = await Lacres.validateLacre(sLacre, iLacreTipoId, iVistoriaId, iVistoriaItemId);

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

    getLacres: async function (iVistoriaId, iVistoriaItemId = null) {
        var oResponse = await $.fn.doAjax({
            url: 'vistoria-lacres/getLacres/' + iVistoriaId + '/' + (iVistoriaItemId ? iVistoriaItemId : ''),
            type: 'GET'
        });

        return oResponse;
    },

    saveLacre: async function(sLacre, iLacreTipoId, iVistoriaId, iVistoriaItemId = null) {

        var oResponse = await $.fn.doAjax({
            url: 'vistoria-lacres/saveLacre',
            type: 'POST',
            data: {
                lacre: sLacre,
                lacre_tipo: iLacreTipoId,
                vistoria: iVistoriaId,
                vistoria_item: iVistoriaItemId,
            }
        });

        return oResponse;
    },

    removeLacre: async function(iLacreId) {

        var oResponse = await $.fn.doAjax({
            url: 'vistoria-lacres/removeLacre',
            type: 'POST',
            data: {
                lacre_id: iLacreId
            }
        });

        return oResponse;
    },

    validateLacre: async function(sLacre, iLacreTipoId, iVistoriaId, iVistoriaItemId = null) {

        var oResponse = await $.fn.doAjax({
            url: 'vistoria-lacres/validateLacre',
            type: 'POST',
            data: {
                lacre: sLacre,
                lacre_tipo: iLacreTipoId,
                vistoria: iVistoriaId,
                vistoria_item: iVistoriaItemId
            }
        });

        return oResponse;
    }

}

$(document).ready(function() {

    Lacres.init();
});