const ManageFrontend = {

    renderOnScreen: async function() {

        this.cleanScreen();
        await ManageRoutineData.getStructure(ManageFrontend.serializeFiltros());
        var aBreadcrumb     = oState.getState('breadcrumb'),
            aStructure      = oState.getState('structure'),
            oResponse       = new window.ResponseUtil();
           
        $('.tela').removeClass('filas');
        var aStructureToRender = aBreadcrumb.length > 1
            ? ObjectUtil.getDepth(aStructure, aBreadcrumb.slice(0, -1).join('.'))
            : aStructure;

        var objectKeys = this.matchKeys(Object.keys(aStructureToRender), aBreadcrumb[aBreadcrumb.length - 1].split('_')[0]);
        objectKeys.forEach(key => {
            var sTemplate = this.getTemplate(key.split('_')[0])[0].outerHTML;
            oResponse = RenderCopy.render({
                object: aStructureToRender[key],
                template: sTemplate,
                data_to_render: key.split('_')[0]
            });

            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item ');
        
            //Renderiza
            $('.tela').append(oResponse.getDataExtra());
            $( '.tela').fadeIn( "slow");
        });
        MovContainer.watchClickArea();
        MovContainer.watchClickCod1();
        MovContainer.watchClickCod2();
        MovContainer.watchClickLocal();
    },

    renderOnScreenCod3: async function() {

        await ManageRoutineData.getStructure(ManageFrontend.serializeFiltros());
        var aBreadcrumb     = oState.getState('breadcrumb'),
            aStructure      = oState.getState('structure'),
            oResponse       = new window.ResponseUtil();
           
        $('.tela').find('div').remove();
        var aStructureToRender = ObjectUtil.getDepth(aStructure, aBreadcrumb.slice(0, -1).join('.'));
        var objectKeys = this.matchKeys(Object.keys(aStructureToRender), aBreadcrumb[aBreadcrumb.length - 1].split('_')[0]);
        var sTemplateCod3 = this.getTemplate('cod3')[0].outerHTML;
        var sTemplateCod4 = this.getTemplate('cod4')[0].outerHTML;
        var sTemplateContainer = this.getTemplate('mov-container')[0].outerHTML;
        $('.tela').addClass('filas');
        objectKeys.forEach(i => {
            
            oResponse = RenderCopy.render({
                object: aStructureToRender[i],
                template: sTemplateCod3,
                data_to_render: 'cod3'
            });

            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item ');
        
            //Renderiza
            $('.tela').append(oResponse.getDataExtra());

            var aKeys = this.matchKeys(Object.keys(aStructureToRender[i]), 'cod4');
            aKeys.forEach(k => {
                
                oResponse = RenderCopy.render({
                    object: aStructureToRender[i][k],
                    template: sTemplateCod4,
                    data_to_render: 'cod4'
                });
    
                if (oResponse.getStatus() !== 200)
                    return console.log(oResponse.getMessage() + ' Falha ao renderizar item ');
            
                //Renderiza
                $('.tela .cod3[data-id="' + aStructureToRender[i].id + '"]').append(oResponse.getDataExtra());

                var aContainers = aStructureToRender[i][k]['container'];
                aContainers.forEach(oContainer => {
                    
                    oResponse = RenderCopy.render({
                        object: oContainer,
                        template: sTemplateContainer,
                        data_to_render: 'container'
                    });
        
                    if (oResponse.getStatus() !== 200)
                        return console.log(oResponse.getMessage() + ' Falha ao renderizar item ');
                
                    var sReturn = oResponse.getDataExtra().replace(new RegExp('__cod3__', 'g'), aStructureToRender[i].id);
                    sReturn = sReturn.replace(new RegExp('__cod4__', 'g'), aStructureToRender[i][k].id);
                    //Renderiza
                    $('.tela .cod4[data-endereco="'+ oContainer.endereco_id +'"]').append(sReturn);
                    $('.tela .cod4[data-endereco="' + oContainer.endereco_id + '"]').css({height: '100%'});
                    $('.tela').fadeIn('slow')
                });
            });
        });
        MovContainer.watchClickContainer();
        MovContainer.watchClickCod4();
    },

    getTemplate: function (sTipo) {
        
        return $('.copy-hidden .' + sTipo);
    },

    cleanScreen: function() {

        $('.tela').fadeOut('slow');
        $('.tela').find('div').remove();
    },

    matchKeys: function(aKeys, sMatch) {

        var aKeysCombined = [];
        aKeys.forEach(key => {
            if (key.indexOf(sMatch) > -1)
                aKeysCombined.push(key);
        });

        if (sMatch == 'cod4')
            return aKeysCombined;

        return aKeysCombined.sort(function(a, b) {
            var idA = a.split('_')[1];
            var idB = b.split('_')[1];
            return idA - idB;
        });
    },

    renderBreadcrumb: function() {

        var aBreadcrumb = oState.getState('breadcrumb');
        var aStructure = oState.getState('structure');
        var sFinder = '';
        var oBreadcrumbStructure = [];
        $('.breadcrumb .crumbs').html('');
        aBreadcrumb.forEach(function (element, key) {
            
            if (element.indexOf('_') == -1)
                return;

            sFinder += '.' + element;
            var oStructurePosition = ObjectUtil.getDepth(aStructure, sFinder);
            oBreadcrumbStructure.push('<a class="crumb" data-position="' + key + '" data-screen="' + aBreadcrumb[key + 1].split('_')[0] + '">' + oStructurePosition.descricao + '</a>');
        });

        oBreadcrumbStructure.forEach(element => {
            $('.breadcrumb .crumbs').append('  > ');
            $('.breadcrumb .crumbs').append($(element));
        });
        MovContainer.watchClickBreadcrumb();
    },

    renderContainerSelected: function() {

        var oContainerSelected = oState.getState('containerSelected');
        if (!oContainerSelected) {
            $('.cnt-selected').html('');
            return;

        }
        var aStructure = oState.getState('structure');
        var oCod4Structure = ObjectUtil.getDepth(aStructure, Object.keys(oContainerSelected)[0]);
        var sTemplateContainer = this.getTemplate('container-selected')[0].outerHTML;
        var oResponse = new window.ResponseUtil();
        var oComposicaoEndereco = {};
        Object.keys(oState.getState('containerSelected'))[0].split('.').forEach(element => {
            var aElement = element.split('_');
            oComposicaoEndereco[aElement[0]] = aElement[1];
        });

        oCod4Structure.container.forEach(oContainer => {
            if (oContainer.id != oContainerSelected[Object.keys(oContainerSelected)[0]])
                return;

            oResponse = this.render(oContainer, sTemplateContainer, 'container');
            
            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item ');
                
            var sReturn = oResponse.getDataExtra().replace(new RegExp('__cod3__', 'g'), oComposicaoEndereco['cod3']);
            sReturn = sReturn.replace(new RegExp('__cod4__', 'g'), oComposicaoEndereco['cod4']);
    
            $('.cnt-selected').append(sReturn);
        });
        MovContainer.watchClickContainerSelected();
        MovContainer.watchClickContainerRemove();
        window.onscroll = function() {ManageFrontend.fixedCntSelected()};

    },

    executeMovContainer: async function(iContainerId, iEnderecoId, sFormSerialize) {

        sFormSerialize += '&container=' + iContainerId + '&endereco=' + iEnderecoId;
        var oResponse = await ManageRoutineData.movimentarContainer(sFormSerialize);

        if (oResponse.status != 200)
            return await Utils.swalResponseUtil(oResponse);

        oState.setState('structure', oResponse.dataExtra.dataExtra);
        oState.setState('breadcrumb', oState.getState('breadcrumb'));
        oState.setState('containerSelected', null);
        $('.cnt-selected').removeClass('sticky');
    },

    executeDescargaContainer: async function(iContainerId, iEnderecoId, sFormSerialize, iOs, referrer) {

        sFormSerialize += '&os=' + iOs  + '&endereco=' + iEnderecoId + '&container_id=' + iContainerId ;
        var oResponse = await ManageRoutineData.descargaContainer(sFormSerialize, referrer);

        if (oResponse.status != 200)
            return await Utils.swalResponseUtil(oResponse);
    },

    renderContentContainer: function() {

        var sTemplate           = this.getTemplate('conteudo-container')[0].outerHTML,
            sTemplateProduto    = this.getTemplate('produto')[0].outerHTML,
            oContainerSelected  = oState.getState('containerSelected'),
            aStructure          = oState.getState('structure'),
            oCod4Structure      = ObjectUtil.getDepth(aStructure, Object.keys(oContainerSelected)[0]),
            oResponse           = new window.ResponseUtil();

        oCod4Structure.container.forEach(oContainer => {
            if (oContainer.id != oContainerSelected[Object.keys(oContainerSelected)[0]])
                return;

            oResponse = this.render(oContainer, sTemplate, 'conteudo_container');
            
            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item ');
    
            $('.modal-container .modal-body').html('')
            $('.modal-container .modal-body').append(oResponse.getDataExtra());
            oContainer.estoque_enderecos.forEach(oEstoqueEndereco => {
                oResponse = this.render(oEstoqueEndereco, sTemplateProduto, 'produto');
            
                if (oResponse.getStatus() !== 200)
                    return console.log(oResponse.getMessage() + ' Falha ao renderizar item ');

                $('.modal-container .modal-body .table-produtos-container tbody').append(oResponse.getDataExtra());
            });
            $('.modal-container').modal('toggle');
        });
    },

    render: function(object, sTemplate, sData) {

        oResponse = RenderCopy.render({
            object: object,
            template: sTemplate,
            data_to_render: sData
        });

        return oResponse;
    },
    
    fixedCntSelected: function() {
        if (!oState.getState('containerSelected'))
            return;

        var header = document.getElementById("div-cnt-selected");
        if (window.pageYOffset > 195) {
            header.classList.add("sticky");
            $('.sticky').css({padding: '8px 0'})
        } else {
            header.classList.remove("sticky");
        }
    },

    serializeFiltros: function() {

        return $('#form_filtros').serialize();
    }
  
}