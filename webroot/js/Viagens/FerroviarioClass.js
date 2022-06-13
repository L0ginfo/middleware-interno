import { ManageFrontend } from './ManageFrontend.js'
import { ManageRoutineData } from './ManageRoutineData.js'

const Ferroviario = {

    init: async function() {
        
        await ManageFrontend.loadVagoes();
        await ManageFrontend.loadDocEntradas();
        await ManageFrontend.loadDocSaidas();
        await ManageFrontend.loadContainers();
        this.watchAddVagao();
        // this.watchRemoveVagao();
        this.watchRemoveDocumentos('entrada');
        this.watchRemoveDocumentos('saida');
        // this.watchVagaoSelected();
        this.watchAddDocEntrada();
        ManageFrontend.disableActionsMoreSelected();
        this.watchSelectAllVagoes();
        this.watchAddDocSaida();
        this.watchAddContainer();
        this.watchSaveEditContainer();
        // this.watchClickVagaoTdSelected();
        this.watchGenerateResvs();
        this.watchDeleteResvs();
        this.watchAddContainersFromDoc();
        this.watchCheckInOut();
        this.watchButtonAddContainer();
    },

    watchAddVagao: function() {

        $('#add-vagao').click(function(e) {
            e.preventDefault();
            ManageFrontend.manageAddVagao();
        })
    },

    watchRemoveVagao: function() {

        $('.remove-vagao:not(.watched)').each(function() {
            $(this).click(function() {
                $(this).addClass('watched')
                ManageFrontend.manageRemoveVagao($(this).closest('tr').attr('vagao-id'));
            });
        });
    },

    watchRemoveDocumentos: function(sTipoDoc) {

        $('.remove-doc-' + sTipoDoc + ':not(.watched)').each(function() {
            $(this).click(function() {
                $(this).addClass('watched');

                var iVagaoId = $(this).closest('tr').attr('vagao-id');
                var iProgDocumentoId = $(this).closest('tr').attr('prog-' + sTipoDoc + '-id');
                ManageFrontend.manageRemoveProgDocumento(iVagaoId, iProgDocumentoId, sTipoDoc);
            });
        });
    },

    watchRemoveContainers: function() {

        $('.remove-container:not(.watched)').each(function() {
            $(this).click(function() {
                $(this).addClass('watched');

                var iVagaoId = $(this).closest('tr').attr('vagao-id');
                var iProgContainerId = $(this).closest('tr').attr('prog-container-id');
                ManageFrontend.manageRemoveProgDocumento(iVagaoId, iProgContainerId, 'container');
                ManageFrontend.renderListaContainers();
            });
        });
    },

    watchVagaoSelected: function() {

        $('.listagem-vagoes input[name="checkbox-vagao"]:not(.watched)').each(function() {

            $(this).click(function() {
                $(this).addClass('watched');
                ManageFrontend.manageVagoesSelected($(this));
            });
        });
    },

    watchClickVagaoTdSelected: function() {

        $('.listagem-vagoes .vagao td.descricao:not(.watched)').each(function() {

            $(this).click(function() {
                $(this).addClass('watched');
                $(this).closest('tr').find('input[type="checkbox"]').click();
            });
        });

        $('.listagem-vagoes .vagao td.resv:not(.watched)').each(function() {

            $(this).click(function() {
                $(this).addClass('watched');
                $(this).closest('tr').find('input[type="checkbox"]').click();
            });
        });
    },

    watchAddDocEntrada: function() {

        $('.find_containers_doc_entrada_saida').click(function() {

            ManageFrontend.manageAddDocumento('entrada');
        })
    },

    watchAddDocSaida: function() {

        $('.submit-documento-saida').click(function() {

            ManageFrontend.manageAddDocumento('saida');
        })
    },

    watchSelectAllVagoes: function() {

        $('.listagem-vagoes input[name="checkbox-vagao-all"]').click(function() {

            $('input[type="checkbox"][name="checkbox-vagao"]').each(function() {
                $(this).click();
            })

        });
    },

    watchAddContainer: function() {

        $('.button-salvar-container-programacao').click(function() {
            ManageFrontend.manageAddEditContainer('save');
        });
    },

    watchEditContainer: function() {
        
        $('#containers .edit-container:not(.watched)').each(function() {

            $(this).addClass('watched');
            $(this).click(function() {

                var iVagaoId = $(this).closest('tr').attr('vagao-id');
                var iProgContainerId = $(this).closest('tr').attr('prog-container-id');

                ManageFrontend.manageEditContainer(iVagaoId, iProgContainerId);

            });
        });
    },

    watchSaveEditContainer: function() {

        $('.button-salvar-container-edit').click(function() {
            ManageFrontend.manageAddEditContainer('edit', $(this));
        });
    },

    watchGenerateResvs: function() {

        $('.generate-resvs:not(.watched)').click(function() {

            $(this).addClass('watched');
            ManageFrontend.manageResvs('gerar');            
        });
    },

    watchDeleteResvs: function() {

        $('.delete-resvs:not(.watched)').click(function() {

            $(this).addClass('watched');
            ManageFrontend.manageResvs('fechar');            
        });
    },

    watchAddContainersFromDoc: function() {

        $('#modal-documento-containers .save-container-doc:not(.watched)').click(function() {

            $(this).addClass('watched');
            ManageFrontend.manageAddContainerFromDocumento();
        })
    },

    watchCheckInOut: function() {

        $('.check-in').click(function() {
            ManageFrontend.manageCheckInOut('entrada');
        });

        $('.check-out').click(function() {
            ManageFrontend.manageCheckInOut('saida');
        });
    },
    
    watchButtonAddContainer: function() {
        $('.add-container').click(function() {

            setTimeout(() => {
                $('#form-modal-container #container').val('');
                $('#form-modal-container .selectpicker_armador').val('');
                $('#form-modal-container .selectpicker_armador').val('');
                $('#form-modal-container .find_drive_espaco').val('');
                $('#form-modal-container .selectpicker').selectpicker('refresh');
            }, 500);
        });
    }
}

export { ManageFrontend, ManageRoutineData, Ferroviario }