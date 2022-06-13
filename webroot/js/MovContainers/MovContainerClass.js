const MovContainer = {

    init: async function() {
        this.observers();
        if (typeof oState.getState('breadcrumb') == 'undefined') {
            var aBreadcrumb = new Array();
            aBreadcrumb.push('local');
            oState.setState('breadcrumb', aBreadcrumb);
        }
        setTimeout(() => {
            MovContainer.watchClickBreadcrumbLocal();
            MovContainer.watchClickSearchFiltros();
            MovContainer.watchClickCleanFiltros();
            MovContainer.watchClickShowFilters();
            MovContainer.descargaContainer();
        }, 1000);
    },

    observers: function() {

        oSubject.setObserverOnEvent(function () {
            MovContainer.verifyRender();
            ManageFrontend.renderBreadcrumb();
        }, ['on_breadcrumb_change']);

        oSubject.setObserverOnEvent(function () {
            ManageFrontend.renderContainerSelected();
        }, ['on_containerSelected_change']);
    },

    watchClickBreadcrumbLocal: function() {

        $('.breadcrumb-local:not(.watched)').click(function(e) {
            e.preventDefault();
            $(this).addClass('watched');
            MovContainer.setStateBreadcrumb('local', null);
        })
    },

    watchClickLocal: function () {

        $('.tela .local:not(.watched)').each(function() {

            $(this).addClass('watched');
            $(this).click(function() {
                MovContainer.setStateBreadcrumb('area', $(this).attr('data-id'));
            });
        })
    },

    watchClickArea: function () {

        $('.tela .area:not(.watched)').each(function() {

            $(this).addClass('watched');
            $(this).click(function() {
                MovContainer.setStateBreadcrumb('cod1', $(this).attr('data-id'));
            });
        })
    },

    watchClickCod1: function () {

        $('.tela .cod1:not(.watched)').each(function() {

            $(this).addClass('watched');
            $(this).click(function() {
                MovContainer.setStateBreadcrumb('cod2', $(this).attr('data-id'));
            });
        })
    },

    watchClickCod2: function () {

        $('.tela .cod2:not(.watched)').each(function() {

            $(this).addClass('watched');
            $(this).click(function() {
                MovContainer.setStateBreadcrumb('cod3', $(this).attr('data-id'));
            });
        })
    },

    watchClickBreadcrumb: function() {

        $('.crumb:not(.watched)').each(function() {

            $(this).addClass('watched');
            $(this).click(function() {

                var iPosition = $(this).attr('data-position');
                var aBreadcrumb = oState.getState('breadcrumb');
                var aBreadcrumbNew = aBreadcrumb.slice(0, parseInt(iPosition) + 1);
                aBreadcrumbNew.push($(this).attr('data-screen'));
                oState.setState('breadcrumb', aBreadcrumbNew);
            });
        });
    },

    watchClickContainer: function() {

        $('.tela .mov-container:not(.watched)').each(function() {

            $(this).addClass('watched');
            $(this).click(function() {
                $("#buscaSimplificada").removeClass("hidden");
                var iContainerId = $(this).attr('data-id');
                var iContainerSelected = oState.getState('containerSelected');
                $("#container").val(iContainerId);
                var aBreadcrumbNew = [];
                oState.getState('breadcrumb').forEach(element => {
                    aBreadcrumbNew.push(element);
                });

                aBreadcrumbNew[aBreadcrumbNew.length - 1] = aBreadcrumbNew[aBreadcrumbNew.length - 1] + '_' + $(this).attr('data-cod3');
                aBreadcrumbNew.push('cod4_' + $(this).attr('data-cod4'));
                if (typeof iContainerSelected == 'undefined' || !iContainerSelected)
                    oState.setState('containerSelected', {[aBreadcrumbNew.join('.')]: iContainerId});
            });
        });
    },

    watchClickContainerRemove: function() {

        $('.cnt-selected .remove-container:not(.watched)').each(function() {

            $(this).addClass('watched');
            $(this).click(function() {

                oState.setState('containerSelected', null);
            });
        });
    },

    watchClickCod4: function() {

        $('.cod4:not(.watched)').each(function() {

            if (!$(this).find('.mov-container').length) {
                $(this).click(function() {
    
                    $(this).addClass('watched');
                    if(oState.getState('containerOs')){
                        var iContainerId = oState.getState('containerOs')[Object.keys(oState.getState('containerOs'))];
                        var referrer = document.referrer;
                        var iOs = referrer.substring(referrer.lastIndexOf('/') + 1)
                        ManageFrontend.executeDescargaContainer(iContainerId, $(this).attr('data-endereco'), $('#form_filtros').serialize(), iOs, referrer);
                    }else {
                        if (!oState.getState('containerSelected'))
                        return Utils.swalUtil({
                            title:'Necessário selecionar um container.',
                            type:'error',
                            timer:2000
                        });
                        var iContainerId = oState.getState('containerSelected')[Object.keys(oState.getState('containerSelected'))];
                        ManageFrontend.executeMovContainer(iContainerId, $(this).attr('data-endereco'), $('#form_filtros').serialize());
                    }
                });
            }
        });
    },

    descargaContainer: function() {
        var url = window.location.href;
        var containerOs = url.substring(url.lastIndexOf('/') + 1)
        if (containerOs != "" && containerOs !== "mov-cnt") {
            containerOs = containerOs.split("-");
            var iContainerId = containerOs[0];
            var sConteiner = containerOs[1].split("%20")[0];
            var container = `<div class="container-selected col-lg-2" data-id="${iContainerId}">
                <div class="content-container">
                    <div class="content-right">
                        <h4>${sConteiner}</h4>
                    </div>
                </div>
            </div>`;
            oState.setState("containerOs", { iContainerId });
            $("#div-cnt-selected").prepend(container);
            window.onscroll = function () {
                ManageFrontend.fixedCntSelected();
            };
        }
    },

    watchClickContainerSelected: function () {
        
        $('.cnt-selected .content-container:not(.watched)').click(function() {
            $(this).addClass('watched');
            ManageFrontend.renderContentContainer();
        })
    },

    setStateBreadcrumb: function($sComposicao, $iComposicaoOld) {

        aBreadcrumb = oState.getState('breadcrumb');
        var aBreadcrumbNew = new Array();

        if (!$iComposicaoOld) {
            aBreadcrumbNew.push($sComposicao);
            oState.setState('breadcrumb', aBreadcrumbNew);
            return;
        }

        aBreadcrumb.forEach(function(crumb, index) {

            if (index == aBreadcrumb.length - 1) {
                aBreadcrumbNew.push(aBreadcrumb[aBreadcrumb.length - 1] + '_' + $iComposicaoOld);
            } else {
                aBreadcrumbNew.push(crumb);
            }
        });

        aBreadcrumbNew.push($sComposicao);
        oState.setState('breadcrumb', aBreadcrumbNew);
    },

    watchClickSearchFiltros: function() {
        
        $('.filtrar').click(function() {
            MovContainer.verifyRender();
        });
    },

    watchClickCleanFiltros: function() {
        
        $('.limpar').click(function() {
            $('form#form_filtros .selectpicker').val(0);
            $('.selectpicker').selectpicker('refresh');
            MovContainer.verifyRender();
            $('.show-filters').click();
        });
    },

    verifyRender: function() {
        var aBreadcrumb = oState.getState('breadcrumb');
        if (aBreadcrumb.slice(-1) != 'cod3') {
            ManageFrontend.renderOnScreen();
        } else {
            ManageFrontend.renderOnScreenCod3();
        }
    },

    watchClickShowFilters: function() {

        $('.show-filters').click(function() {

            if ($(this).hasClass('active')) {
                $('.filtros').slideUp();
                $(this).removeClass('active');
                $(this).find('i').removeClass('fa-chevron-up');
                $(this).find('i').addClass('fa-chevron-down');
            } else {
                $('.filtros').slideDown();
                $(this).addClass('active');
                $(this).find('i').removeClass('fa-chevron-down');
                $(this).find('i').addClass('fa-chevron-up');
            }
        });
    }
}