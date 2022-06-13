import { ManageRoutineData } from './ManageRoutineData.js'
import { Ferroviario } from './FerroviarioClass.js'

export const ManageFrontend = {

    init: async function() {

        
    },

    manageAddVagao: async function() {

        var aVagaoBuscado = ManageFrontend.getVagaoBuscado();

        if (Object.keys(aVagaoBuscado).length === 0)
            return Utils.swalUtil({
                type:'error',
                title:`Necessário selecionar um vagão.`,
                timer:3000
            });

        var responseSwal = await Utils.swalConfirmOrCancel({
            title:'Deseja realmente vincular o vagão ' + aVagaoBuscado.text + ' a esta viagem?',
            text:'O vagão será salvo ao prosseguir',
            confirmButtonText: 'Sim, continuar',
            showConfirmButton: true,
            defaultConfirmColor: true,
            showCancelButton: true,
        })
    
        if (responseSwal) {
            var oResponse = await ManageRoutineData.saveVagao(ManageFrontend.getViagemId(), ManageFrontend.getVagaoBuscado().value);

            if (oResponse.status == 200) {
                await ManageRoutineData.setObjInState(oResponse.dataExtra, oResponse.dataExtra.id, 'vagoes');
                $('select[name="vagao_id"]').val('');
                $('select[name="vagao_id"]').selectpicker('refresh');
                ManageFrontend.renderListaVagoes();
            }

            await Utils.swalResponseUtil(oResponse);
        }
    },

    manageRemoveVagao: async function(iVagaoId) {

        var aVagoes = ManageRoutineData.getState('vagoes');
        var sVeiculoDescricao = aVagoes[iVagaoId].veiculo.veiculo_identificacao;

        if (aVagoes[iVagaoId].resv_id)
            return Utils.swalUtil({
                type:'error',
                title:'Necessário excluir a RESV antes de remover a programação.',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                allowOutsideClick: true
            });

        var responseSwal = await Utils.swalConfirmOrCancel({
            title:'Deseja realmente excluir o vagão ' + sVeiculoDescricao + ' desta viagem?',
            text:'O vagão será excluído ao prosseguir',
            confirmButtonText: 'Sim, continuar',
            showConfirmButton: true,
            defaultConfirmColor: true,
            showCancelButton: true,
        })
    
        if (responseSwal) {
            var oResponse = await ManageRoutineData.deleteVagao(iVagaoId);

            if (oResponse.status == 200) {
                
                ManageRoutineData.removeInStateByVagao(iVagaoId);
                ManageRoutineData.removeInStateByVagao(iVagaoId, 'prog_entradas');
                ManageRoutineData.removeInStateByVagao(iVagaoId, 'prog_saidas');
                ManageRoutineData.removeInStateByVagao(iVagaoId, 'prog_containers');
                ManageFrontend.renderListaVagoes();
                ManageFrontend.renderListaDocumentos('entrada');
                ManageFrontend.renderListaDocumentos('saida');
                ManageFrontend.renderListaContainers();
            }

            await Utils.swalResponseUtil(oResponse);
        }
    },

    manageRemoveProgDocumento: async function(iVagaoId, iProgDocumentoId, sTipoDoc) {

        var aVagoes = ManageRoutineData.getState('vagoes');
        var sVeiculoDescricao = aVagoes[iVagaoId].veiculo.veiculo_identificacao;
        var sStateDoc = 'prog_' + sTipoDoc + 's';
        var sNumeroDoc = ManageRoutineData.getNumeroDocumento(ManageRoutineData.getState(sStateDoc)[iVagaoId], iProgDocumentoId, sTipoDoc);

        var responseSwal = await Utils.swalConfirmOrCancel({
            title:'Deseja realmente excluir este documento ' + sNumeroDoc + ' deste vagão (' + sVeiculoDescricao + ')?',
            text:'O doc. entrada será excluído ao prosseguir',
            confirmButtonText: 'Sim, continuar',
            showConfirmButton: true,
            defaultConfirmColor: true,
            showCancelButton: true,
        })
    
        if (responseSwal) {
            switch (sTipoDoc) {
                case 'entrada':
                    var oResponse = await ManageRoutineData.deleteProgDocEntrada(iProgDocumentoId);
                    break;
                case 'saida':
                    var oResponse = await ManageRoutineData.deleteProgDocSaida(iProgDocumentoId);
                    break;
                case 'container':
                    var oResponse = await ManageRoutineData.deleteProgContainer(iProgDocumentoId);
                    break;
                default:
                    break;
            }

            if (oResponse.status == 200) {
                
                ManageRoutineData.removeDocumentoLista(iVagaoId, iProgDocumentoId, sStateDoc);
                if (sTipoDoc == 'container')
                    ManageFrontend.renderListaContainers();
                else
                    ManageFrontend.renderListaDocumentos(sTipoDoc);
            }

            await Utils.swalResponseUtil(oResponse);
        }
    },

    getVagaoBuscado: function() {

        var $oVagaoBuscado = $('select[name="vagao_id"] option:selected');
        if (!$oVagaoBuscado.val())
            return {};

        return {
            text: $oVagaoBuscado.text(), 
            value: $oVagaoBuscado.val()
        };
    },

    getTemplateListaVagoes: function() {
        return $('.copy.hidden .vagao');
    },

    getTemplateListaDocumentos: function(sTipoDoc) {
        return $('.copy.hidden .prog_' + sTipoDoc);
    },

    getTemplateListaContainers: function() {
        return $('.copy.hidden .container-row');
    },

    getTemplateFormContainerEdit: function() {
        return $('.copy.hidden .copy-form-container');
    },

    loadVagoes: async function() {
        
        var oResponse = await ManageRoutineData.getVagoes(this.getViagemId());

        if (oResponse.status == 200)
            ManageRoutineData.setState('vagoes', oResponse.dataExtra);

        ManageFrontend.renderListaVagoes();
    },

    loadDocEntradas: async function() {
        
        var oResponse = await ManageRoutineData.getDocEntradas(this.getViagemId());

        if (oResponse.status == 200)
            ManageRoutineData.setState('prog_entradas', oResponse.dataExtra);
    },

    loadDocSaidas: async function() {
        
        var oResponse = await ManageRoutineData.getDocSaidas(this.getViagemId());

        if (oResponse.status == 200)
            ManageRoutineData.setState('prog_saidas', oResponse.dataExtra);
    },

    loadContainers: async function() {
        
        var oResponse = await ManageRoutineData.getContainers(this.getViagemId());

        if (oResponse.status == 200)
            ManageRoutineData.setState('prog_containers', oResponse.dataExtra);
    },

    getViagemId: function() {
        return $('input[name="viagem_id"]').val();
    },

    getListaVagoes: function() {
        return $('.listagem-vagoes table tbody');
    },

    getListaDocumentos: function(sTipoDocumento) {

        return $('#documentos-'+sTipoDocumento+' table tbody');
    },

    getListaContainers: function() {

        return $('#containers table tbody');
    },

    renderListaVagoes: function() {
        var sTemplate       = this.getTemplateListaVagoes()[0].outerHTML,
            aVagoes         = ManageRoutineData.getState('vagoes'),
            oResponse       = new window.ResponseUtil();
           
        ManageFrontend.cleanTableVagoes();
        Object.keys(aVagoes).forEach(function(sKeyVeiculoId, oDataComposicao) {
            oResponse = RenderCopy.render({
                object: aVagoes[sKeyVeiculoId],
                template: sTemplate,
                data_to_render: 'vagao',
            })

            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item ' + oDataComposicao.id)
            
            //Renderiza
            ManageFrontend.getListaVagoes().append(oResponse.getDataExtra());
        })
        Ferroviario.watchRemoveVagao();
        Ferroviario.watchVagaoSelected();
        Ferroviario.watchClickVagaoTdSelected();
        var aVagoesSelected = ManageRoutineData.getState('vagoes_selected');
        $('input[type="checkbox"][name="checkbox-vagao"]').each(function() {

            if (typeof aVagoesSelected[$(this).closest('tr').attr('vagao-id')] != 'undefined')
                $(this).click();
        });
    },

    renderListaDocumentos: function(sTipoDoc) {
        var sTemplate       = this.getTemplateListaDocumentos(sTipoDoc)[0].outerHTML,
            sStateDoc       = 'prog_' + sTipoDoc + 's',
            aDocumentos     = ManageRoutineData.getState(sStateDoc),
            oResponse       = new window.ResponseUtil(),
            aVagoesSelected = Object.keys(ManageRoutineData.getState('vagoes_selected'));
        
        ManageFrontend.cleanTableDocumentos(sTipoDoc);

        if (typeof aDocumentos == 'undefined')
            return;

        aVagoesSelected.forEach(function(sKeyVeiculoId, oDataComposicao) {

            if (typeof aDocumentos[sKeyVeiculoId] != 'undefined')
                aDocumentos[sKeyVeiculoId].forEach(oDocumento => {
                    oResponse = RenderCopy.render({
                        object: oDocumento,
                        template: sTemplate,
                        data_to_render: sStateDoc.slice(0,-1),
                    });
        
                    if (oResponse.getStatus() !== 200)
                        return console.log(oResponse.getMessage() + ' Falha ao renderizar item ' + oDataComposicao.id)
                        
                    //Renderiza
                    ManageFrontend.getListaDocumentos(sTipoDoc).append(oResponse.getDataExtra())
                    
                });
            
            Ferroviario.watchRemoveDocumentos(sTipoDoc);
            
        })
    },

    renderListaContainers: function() {
        var sTemplate       = this.getTemplateListaContainers()[0].outerHTML,
            aContainers     = ManageRoutineData.getState('prog_containers'),
            oResponse       = new window.ResponseUtil(),
            aVagoesSelected = Object.keys(ManageRoutineData.getState('vagoes_selected'));
        
        ManageFrontend.cleanTableContainers();

        if (typeof aContainers == 'undefined')
            return;

        var iCountCnt = 0;
        aVagoesSelected.forEach(function(sKeyVeiculoId, oDataComposicao) {

            if (typeof aContainers[sKeyVeiculoId] != 'undefined')
                aContainers[sKeyVeiculoId].forEach(oContainer => {
                    oResponse = RenderCopy.render({
                        object: oContainer,
                        template: sTemplate,
                        data_to_render: 'container_table',
                    });
        
                    if (oResponse.getStatus() !== 200)
                        return console.log(oResponse.getMessage() + ' Falha ao renderizar item ' + oDataComposicao.id)
                        
                    //Renderiza
                    ManageFrontend.getListaContainers().append(oResponse.getDataExtra());
                    Ferroviario.watchEditContainer();
                    iCountCnt++;
                });
            
            Ferroviario.watchRemoveContainers();
            
        });
        $('.contador-cnt').html('');
        $('.contador-cnt').append(iCountCnt);
    },

    cleanTableVagoes: function() {

        ManageFrontend.getListaVagoes().find('tr').remove();
    },

    cleanTableDocumentos: function(sTipoDoc) {

        ManageFrontend.getListaDocumentos(sTipoDoc).find('tr').remove();
    },

    cleanTableContainers: function() {

        ManageFrontend.getListaContainers().find('tr').remove();
    },

    manageVagoesSelected: function($checkbox) {

        
        var iVagaoId = $checkbox.closest('tr').attr('vagao-id');
        var sVagao = $checkbox.closest('td').siblings('.descricao').text();
        if (!iVagaoId)
            return;
        var oVagao = {[iVagaoId]: sVagao};

        if ($checkbox.is(":checked")) {
            ManageRoutineData.selectVagao(oVagao);
            $checkbox.closest('tr').addClass('selected-vagao');
        } else {
            ManageRoutineData.removeInStateByVagao(iVagaoId, 'vagoes_selected');
            $checkbox.closest('tr').removeClass('selected-vagao');
        }

        if (Object.keys(ManageRoutineData.getState('vagoes_selected')).length > 0) {
            $('.generate-resvs').attr('disabled', false);
            $('.delete-resvs').attr('disabled', false);
            $('.check-in').attr('disabled', false);
            $('.check-out').attr('disabled', false);
        } else {
            $('.generate-resvs').attr('disabled', true);
            $('.delete-resvs').attr('disabled', true);
            $('.check-in').attr('disabled', true);
            $('.check-out').attr('disabled', true);
        }

        var aVagoesSelected = ManageRoutineData.getState('vagoes_selected');
        var aVagoes = ManageRoutineData.getState('vagoes');
        var iCountNotEnableButtonHours = 0;
        for (const iProgramacaoId in aVagoesSelected) {
            if (!aVagoes[iProgramacaoId].resv_id)
                iCountNotEnableButtonHours++;
        }

        if (iCountNotEnableButtonHours > 0 
            || Object.keys(ManageRoutineData.getState('vagoes_selected')).length == 0) {
            $('.check-in').attr('disabled', true);
            $('.check-out').attr('disabled', true);
        } else {
            $('.check-in').attr('disabled', false);
            $('.check-out').attr('disabled', false);
        }

        ManageFrontend.disableActionsMoreSelected();

        ManageFrontend.renderListaDocumentos('entrada');
        ManageFrontend.renderListaDocumentos('saida');
        ManageFrontend.renderListaContainers();
    },

    disableActionsMoreSelected: function() {

        var aVagoesSelected = ManageRoutineData.getState('vagoes_selected');

        var aObjToDisabled = [
            'select[name="documento-entrada"]',
            'select.numero_doc_entrada_saida',
            '.submit-documento-entrada',
            '.submit-documento-saida',
            '.add-container'
        ];
        
        aObjToDisabled.forEach(element => {

            if (Object.keys(aVagoesSelected).length > 1
                || Object.keys(aVagoesSelected).length == 0)
                $(element).attr('disabled', 'disabled');
            else
                $(element).attr('disabled', false);
        });
        $('.selectpicker').selectpicker('refresh')
    },

    manageAddDocumento: async function(sTipoDoc) {

        var iProgramacaoSelected = Object.keys(ManageRoutineData.getState('vagoes_selected'))[0];
        var aSelectedVagao = ManageRoutineData.getState('vagoes_selected');
        var responseSwal = await Utils.swalConfirmOrCancel({
            title:'Deseja realmente vincular este documento para este vagão ' + aSelectedVagao[iProgramacaoSelected] + '?',
            text:'O documento será vínculado ao prosseguir',
            confirmButtonText: 'Sim, continuar',
            showConfirmButton: true,
            defaultConfirmColor: true,
            showCancelButton: true,
        });

        if (!responseSwal)
            return;

        await Utils.waitMoment(180);

        var oReturn = null;
        switch (sTipoDoc) {
            case 'entrada':
                oReturn = await this.manageInsertDocEntradaArray(iProgramacaoSelected);
                break;
            case 'saida':
                oReturn = await this.manageInsertDocSaidaArray(iProgramacaoSelected);
            default:
                break;
        }

        ManageFrontend.renderListaDocumentos(sTipoDoc);

        if (Object.prototype.toString.call(oReturn.dataExtra.container) !== '[object Array]') {

            $('.documento_containers').find('option').remove();

            $.each(oReturn.dataExtra.container, function(iID, sNumero) {
                $('select.documento_containers').append($('<option>', { 
                    value: parseInt(iID),
                    text : sNumero 
                }));
            });

            $('.documento_containers').selectpicker('refresh');

            // $('#modal-documento-containers').modal('toggle');
            $('#modal-documento-containers').find('.operacao_id_doc_entrada_saida').val(sTipoDoc == 'entrada' ? 1 : 2)
            // $('#modal-documento-containers').find('select.tipo_container_readonly').val('CHEIO');
            // $('#modal-documento-containers').find('select.tipo_container_readonly').selectpicker('refresh');
            // if ($('#modal-documento-containers').find('select.tipo_container_readonly').val()) {
            //     $('.selectpicker.drive_espaco_id_find').closest('.lf-selectpicker-ajax').find('.lf-opacity-medium').removeClass('lf-opacity-medium')
            // } else {
            //     $('.selectpicker.drive_espaco_id_find').addClass('lf-opacity-medium')
            // }
            
        } else if (oReturn.status == 200) {
            $('select[name="documento-' + sTipoDoc + '"]').val('');
            $('select[name="documento-' + sTipoDoc + '"]').selectpicker('refresh');
        }
    },

    manageInsertDocEntradaArray: async function(iProgramacaoSelected) {

        var iDocEntradaSaida         = $('select[name="documento-entrada"]').val();
        var iOperacaoDocEntradaSaida = 1;
        var iTipoDocEntradaSaida     = 1;

        var oReturn = await ManageRoutineData.getIfDocHasContainer(iProgramacaoSelected, iDocEntradaSaida, iOperacaoDocEntradaSaida);

        if (oReturn.status == 400)
            return await Utils.swalResponseUtil(oReturn);

        var aDocEntradas = ManageRoutineData.getState('prog_entradas');

        if (iProgramacaoSelected in aDocEntradas) {
            aDocEntradas[iProgramacaoSelected].push(oReturn.dataExtra.doc_entrada);
        } else {
            aDocEntradas = Object.assign(aDocEntradas, {[iProgramacaoSelected]: [oReturn.dataExtra.doc_entrada]}); 
        }

        $('.numero_doc_entrada_saida_hidden').val(iDocEntradaSaida);
        $('.tipo_doc_entrada_saida_hidden').val(iTipoDocEntradaSaida);

        return oReturn;
    },

    manageInsertDocSaidaArray: async function(iProgramacaoSelected) {

        var iDocSaidaId         = $('select[name="documento-saida"]').val();
        var iTipoDocumentoId    = $('select[name="tipo_documento"]').val();

        var oReturn = await ManageRoutineData.saveDocSaida(iProgramacaoSelected, iDocSaidaId, iTipoDocumentoId);

        if (oReturn.status == 400)
            return await Utils.swalResponseUtil(oReturn);

        var aDocSaidas = ManageRoutineData.getState('prog_saidas');

        if (iProgramacaoSelected in aDocSaidas) {
            aDocSaidas[iProgramacaoSelected].push(oReturn.dataExtra.doc_saida);
        } else {
            aDocSaidas = Object.assign(aDocSaidas, {[iProgramacaoSelected]: [oReturn.dataExtra.doc_saida]}); 
        }

        $('.numero_doc_entrada_saida_hidden').val(iDocSaidaId);
        $('.tipo_doc_entrada_saida_hidden').val(iTipoDocumentoId);

        return oReturn;
    },

    manageAddEditContainer: async function(sAction, $button = null) {

        var $modal = null;
        var iProgramacaoSelected = null;
        var $form = null;

        if (sAction == 'save') {
            iProgramacaoSelected = Object.keys(ManageRoutineData.getState('vagoes_selected'))[0];
            $modal = $('.modal-content').eq(2);
            $form = $('#form-modal-container');
        } else {
            $modal = $('#modal-edit-container');
            iProgramacaoSelected = $button.closest('tr').attr('vagao-id');
            $form = $('#modal-edit-container #form-modal-container-edit');

        }
        
        var oTagsLacres = sAction == 'save' ? $form.find('.tags_lacres') : $form.find('input[name= "lacres"]');
        var oLacreJson  = $form.find('.lacres_json');
        var iProgramacaoSelected = Object.keys(ManageRoutineData.getState('vagoes_selected'))[0];
        oLacreJson.val(JSON.stringify(oTagsLacres.tagsinput('items')));

        if (Utils.manageRequiredCustom())
            return false;

        var oReturn = await ManageRoutineData.saveContainer($form.serialize() + '&programacao_id=' + iProgramacaoSelected);

        if (oReturn.status == 400)
            return await Utils.swalResponseUtil(oReturn);

        var aProgContainers = ManageRoutineData.getState('prog_containers');
        var aDocEntradas = ManageRoutineData.getState('prog_entradas');
        var aDocSaidas = ManageRoutineData.getState('prog_saidas');

        if (sAction == 'edit') {
            aProgContainers[iProgramacaoSelected][aProgContainers[iProgramacaoSelected].findIndex(x => x.id == oReturn.dataExtra.id)] = oReturn.dataExtra;
        } else {
            if (iProgramacaoSelected in aProgContainers) {
                aProgContainers[iProgramacaoSelected].push(oReturn.dataExtra);
            } else {
                aProgContainers = Object.assign(aProgContainers, {[iProgramacaoSelected]: [oReturn.dataExtra]}); 
            }
        }

        if (iProgramacaoSelected in aDocEntradas) {
            aDocEntradas[iProgramacaoSelected] = oReturn.dataExtra.doc_entradas[iProgramacaoSelected];
        } else {
            aDocEntradas = Object.assign(aDocEntradas, {[iProgramacaoSelected]: [oReturn.dataExtra.doc_entradas[iProgramacaoSelected]]}); 
        }

        if (iProgramacaoSelected in aDocSaidas) {
            aDocSaidas[iProgramacaoSelected] = oReturn.dataExtra.doc_saidas[iProgramacaoSelected];
        } else {
            aDocSaidas = Object.assign(aDocSaidas, {[iProgramacaoSelected]: [oReturn.dataExtra.doc_saidas[iProgramacaoSelected]]}); 
        }

        ManageFrontend.renderListaContainers();
        setTimeout(() => {
            ManageFrontend.renderListaDocumentos('entrada');
            ManageFrontend.renderListaDocumentos('saida');
        }, 1000);

        $form.find('.button-cancelar-containers').click();

        
            
    },

    renderFormEditContainers: function(iVagaoId, iProgContainerId) {

        var sTemplate       = this.getTemplateFormContainerEdit()[0].outerHTML,
            aContainers     = ManageRoutineData.getState('prog_containers'),
            oResponse       = new window.ResponseUtil(),
            aVagoesSelected = Object.keys(ManageRoutineData.getState('vagoes_selected'));
        
        $('#modal-edit-container .modal-body').html('');

        if (typeof aContainers == 'undefined')
            return;

        aVagoesSelected.forEach(function(sKeyVeiculoId, oDataComposicao) {

            if (typeof aContainers[sKeyVeiculoId] != 'undefined')
                aContainers[sKeyVeiculoId].forEach(oContainer => {

                    if (oContainer.id != iProgContainerId)
                        return;

                    oResponse = RenderCopy.render({
                        object: oContainer,
                        template: sTemplate,
                        data_to_render: 'container_edit',
                    });
        
                    if (oResponse.getStatus() !== 200)
                        return console.log(oResponse.getMessage() + ' Falha ao renderizar item ' + oDataComposicao.id)
                        
                    //Renderiza
                    $('#modal-edit-container .modal-body').append(oResponse.getDataExtra());
                    var $modal = $('#modal-edit-container .modal-body');
                    $modal.find('select[name="operacao_id"]').val($modal.find('select[name="operacao_id"]').attr('data-value'));
                    $modal.find('select[name="tipo_container"]').val($modal.find('select[name="tipo_container"]').attr('data-value'));
                    $modal.find('select[name="container_forma_uso_id"]').val($modal.find('select[name="container_forma_uso_id"]').attr('data-value'));

                    ManageFrontend.manageInputLacres(oContainer);
                    // ContainersManager.init();

                });
            
        })
    },

    manageEditContainer: function(iVagaoId, iProgContainerId) {

        ManageFrontend.renderFormEditContainers(iVagaoId, iProgContainerId);

        setTimeout(() => {
            $('#modal-edit-container').modal('toggle');
        }, 200);
    },

    manageInputLacres: function(oContainer) {

        var $modal = $('#modal-edit-container .modal-body');
        ContainersManager.watchInputTags('.tags_lacres_edit-' + oContainer.id);

        var oTagsLacres = $modal.find('.tags_lacres_edit-' + oContainer.id);

        if (!oTagsLacres.hasClass('watched-trigger')) {
            oTagsLacres.tagsinput({
                itemValue       : 'lacre_tipo_id',
                itemText        : 'lacre_descricao',
                allowDuplicates : true
            });
            oTagsLacres.addClass('watched-trigger');
        }
        
        var oJsonLacres = oContainer.programacao_container_lacres;

        var iCount = 0
        oJsonLacres.forEach( function (oLacre) {
            oTagsLacres.tagsinput('add', {
                "lacre_tipo_id"   : parseInt(oLacre.lacre_tipo_id),
                "lacre_descricao" : oLacre.lacre_numero,
                "id"              : oLacre.id
            });

            setTimeout(function() {
                var $tag = oTagsLacres.closest('div').find('.bootstrap-tagsinput').find('span.tag').eq(iCount);
                iCount++;
                $tag.attr('class', '');
                switch (parseInt(oLacre.lacre_tipo_id)) {
                    case 1 : return $tag.addClass('tag label label-primary');
                    case 2 : return $tag.addClass('tag label label-danger label-important');
                    case 3 : return $tag.addClass('tag label label-success');
                    case 4 : return $tag.addClass('tag label label-default');
                    case 5 : return $tag.addClass('tag label label-warning');
                    case 6 : return $tag.addClass('tag label label-info');
                }
            }, 200);

        });
    },

    manageResvs: async function(sTipo) {

        var aProgramacoesSelected = ManageRoutineData.getState('vagoes_selected');
        var aVagoes = ManageRoutineData.getState('vagoes');

        var aProgramacoesToManage = [];
        for (const iProgramacaoId in aProgramacoesSelected) {
            if (!aVagoes[iProgramacaoId].resv_id && sTipo == 'gerar') {
                aProgramacoesToManage.push(iProgramacaoId);
            } else if (aVagoes[iProgramacaoId].resv_id && sTipo == 'fechar') {
                aProgramacoesToManage.push(iProgramacaoId);
            }
        }

        if (aProgramacoesToManage.length == 0)
            return Utils.swalUtil({
                type:'error',
                title:'Nenhum vagão selecionado ou já foram geradas RESVs para estes vagões.',
                html: sReturn,
                showConfirmButton: true,
                confirmButtonText: 'OK',
                allowOutsideClick: true
            });

        var oResponse = await ManageRoutineData.manageResvs(aProgramacoesToManage, sTipo);

        if (oResponse.status != 200)
            return await Utils.swalResponseUtil(oResponse);

        var sReturn = '';

        for (const iProgramacaoId in oResponse.dataExtra) {
            if (oResponse.dataExtra[iProgramacaoId].dataExtra
                && typeof oResponse.dataExtra[iProgramacaoId].dataExtra.oProgramacao != 'undefined') {
                aVagoes[iProgramacaoId] = oResponse.dataExtra[iProgramacaoId].dataExtra.oProgramacao;
            }

            sReturn += '<br> <b>Vagão: ' + aProgramacoesSelected[iProgramacaoId] + '</b><br>';
            sReturn += oResponse.dataExtra[iProgramacaoId].message + '<br>';
        }

        ManageRoutineData.setState('vagoes', aVagoes);
        ManageFrontend.renderListaVagoes();

        return Utils.swalUtil({
            type:'warning',
            title:'Retorno ' + (sTipo == 'fechar' ? 'fechamento' : 'geração') + ' de RESVS:',
            html: sReturn,
            showConfirmButton: true,
            confirmButtonText: 'OK',
            allowOutsideClick: true
        });
    },

    manageAddContainerFromDocumento: async function () {

        var $modal = $('#modal-documento-containers');

        if (Utils.manageRequiredCustom($modal))
            return false;

        var iProgramacaoId = Object.keys(ManageRoutineData.getState('vagoes_selected'))[0],
              iDocumentoId = $modal.find('.numero_doc_entrada_saida_hidden').val(),
               aContainers = $modal.find('#container').val(),
               iOperacaoId = $modal.find('#operacao-id-doc-entrada-saida').val(),
            iDriveEspacoId = $modal.find('.selectpicker.drive_espaco_id_find').val(),
            sTipoContainer = $modal.find('select[name="tipo_container"]').val();

        var oResponse = await ManageRoutineData.saveContainerFromDocumento(
            iDocumentoId, 
            aContainers,
            iOperacaoId, 
            iDriveEspacoId,
            sTipoContainer, 
            iProgramacaoId
        );

        if (oResponse.status != 200)
            return await Utils.swalResponseUtil(oResponse);

        $('select[name="documento-saida"]').val('');
        $('select[name="documento-saida"]').selectpicker('refresh');
        $('select[name="documento-entrada"]').val('');
        $('select[name="documento-entrada"]').selectpicker('refresh');

        var aContainers = ManageRoutineData.getState('prog_containers');
        for (const index in oResponse.dataExtra) {
            if (iProgramacaoId in aContainers) {
                aContainers[iProgramacaoId].push(oResponse.dataExtra[index]);
            } else {
                aContainers = Object.assign(aContainers, {[iProgramacaoId]: [oResponse.dataExtra[index]]}); 
            }
        }

        ManageRoutineData.setState('prog_containers', aContainers);
        ManageFrontend.renderListaContainers();

        $modal.find('.cancel-container-doc').click();

        return await Utils.swalResponseUtil(oResponse);
    },

    manageCheckInOut: async function(sType) {

        var aProgramacoesSelected = ManageRoutineData.getState('vagoes_selected');
        var aResvs = [];
        var aVagoes = ManageRoutineData.getState('vagoes');
        for (const iProgramacaoId in aProgramacoesSelected) {
            aResvs.push(aVagoes[iProgramacaoId].resv_id);
        }
        var oResponse = await ManageRoutineData.saveHorarioResvs(aResvs, sType);

        ManageFrontend.renderListaVagoes();
        return await Utils.swalResponseUtil(oResponse);
    }
}