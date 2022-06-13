/*jshint esversion: 6 */

class PlanoCargasCoreView{

    constructor(){
    }

    render(sView, sHtml){
        document.querySelector(sView).innerHTML = sHtml;
    }

    getRenderCopy(sDataToRender, oTree, sTemplate, aDados){
        let oResponse = new window.ResponseUtil();
        let sListTemplate = '';
        aDados.forEach(function(oDataComposicao, sKeyComposicao) {
            oResponse = RenderCopy.render({
                object: oDataComposicao,
                template: sTemplate,
                data_to_render: sDataToRender,
                nested_tree: oTree
            });

            if (oResponse.getStatus() !== 200){
                console.log(oResponse.getMessage() + ' Falha ao renderizar item ' + sKeyComposicao);
                return oResponse;
            }

            sListTemplate += oResponse.getDataExtra();
        });

        return oResponse.setStatus(200).setDataExtra(sListTemplate);
    }

    getHawbValue(){
        return $('#conhecimento').val();
    }

    getDocumentosItensDestinos() {
        return $('.documento-item-destino');
    }

    getDocumentosItensLocal() {
        return $('.documento-item-local');
    }

    getPlanoCargaIdValue(){
        return $('#id').val();
    }

    getAddDocumento(){
       return $('#add-documento');
    }

    getLiberadoDocumento(){
        return $('.liberado');
    }

    getAjusteDateRender(){
        return $('.date-render');
    }

    getDeleteIndex(){
       return $('.delete-index');
    }

    getDeleteTernosIndex(){
        return $('.delete-ternos-index');
    }

    getTerno(){
        return $('#terno');
    }

    getTonelagem(){
        return $('#tonelagem');
    }

    getMostraCodigo(){
        return $('#mostra-codigo');
    }

    getMostraQtd(){
        return $('#mostra-qtd');
    }

    getMostraPeso(){
        return $('#mostra-peso');
    }

    getMostraPoraoOrigem(){
        return $('#mostra-porao-origem');
    }

    getPermiteUltrapassarLimitePrevisto(){
        return $('#permite-ultrapassar-limite-previsto');
    }

    getSelectTernosIndex(){
        return $('.select-ternos-index');
    }

    getSelectDocumentos(){
        return $('#lista-documentos .selectpicker');
    }

    setSelectTermosValues(){
        this.getSelectTernosIndex().each(function() {
            this.value = this.dataset.value ? this.dataset.value : 0;
        });
    }

    getPoraoButton(){
        return  $('#add-porao');
    }

    getPoraoValue(){
        return  $('#porao').val();
    }

    getPorao(){
        return $('#porao');
    }

    getDetalhesPoraoButtom(){
        return $('.porao-detalhes-buttom');
    }

    getPoraoTitle(){
        return $('#porao-title');
    }

    setCurrentPorao(value){
        return $('#current-porao').val(value);
    }

    getCurrentPoraoValue(){
        return $('#current-porao').val();
    }

    getLIstaPorao(){
        return $('#lista-porao');
    }

    getSalvarPorao(){
        return $('#salvar-porao');
    }

    getMercadoriaItem(){
        return  $('#documento_mercadoria_item_id');
    }

    getProdutoItem(){
        return  $('#produto');
    }

    getDestinoItem(){
        return  $('#porto-de-destino');
    }

    getOperadorItem(){
        return  $('#operador-portuario');
    }

    getQuantidadePrevista(){
        return  $('#qtde-prevista');

    }

    getQuantidadeRequistada(){
        return  $('#id="qtde-realizada');
    }

    getTipoDocItem(){
        return  $('#tipo-documento-item');
    }

    getUnidadeMedidaItem(){
        return  $('#unidade-medida-item');
    }

    getOptionsItem(iId){
        return $(`#item-options-${iId}`);
    }

    getPackinglistFile(){
        return $(`#file-packlist`);
    }

    getPackinglistButton(){
        return $(`#Import-button`);
    }

    getPackinglistLabel(){
        return $(`#text-packlist`);
    }

    getPackinglistRadio(){
        return $('#radio-delimitador input[name=delimitador]:checked');
    }

    getPackinglistGenerateButton(){
        return $('#generate-button');
    }

    getNestedTree() {
        return window.oNestedTree;
    }

    poraoChangeToDetalhesView(){
        $('#plano-porao-main').addClass('hidden');
        $('#plano-porao-detalhe').removeClass('hidden');
    }

    poraoChangeToMaminView(){
        $('#plano-porao-main').removeClass('hidden');
        $('#plano-porao-detalhe').addClass('hidden');
    }

    renderPorao(aDados) {
        const sTemplate = window.aTemplates.opcao_porao_template;
        const oTree = this.getNestedTree();
        const oRespose = this.getRenderCopy('opcao_porao', oTree, sTemplate, aDados);
        if(oRespose.getStatus() == 200){
            return this.render('#porao', oRespose.getDataExtra());
        }
    }

    renderDocumentos(aDados) {
        const sTemplate = this.getDocumentosTemplate();
        const oTree = this.getNestedTree();
        const oRespose = this.getRenderCopy('lista_documentos', oTree, sTemplate, aDados);
        if(oRespose.getStatus() == 200){
            return this.render('#lista-documentos', oRespose.getDataExtra());
        }
    }

    renderDocumentoOperdores(aDados){
        aDados.forEach((value) =>{
            const descricoa  = value.operador_portuario ? value.operador_portuario.descricao : '';
            $(`#lista-documentos #documento-${value.id} .selectpicker`)
                .html(`<option value="${value.operador_portuario_id}" selected>${descricoa}</option>`);
        });
    }

    renderDocumentoItens(aDados) {
        const sTemplate = this.getTemplate('documento_itens_template');
        const oTree = this.getNestedTree();
        const oRespose = this.getRenderCopy('lista_documentos_itens', oTree, sTemplate, aDados);
        if(oRespose.getStatus() == 200){
            return this.render('#lista-documentos-itens', oRespose.getDataExtra());
        }
    }

    renderTernos(aDados){
        const sTemplate = this.getTernosTemplate();
        const oTree = this.getNestedTree();
        const oRespose = this.getRenderCopy('lista_ternos', oTree, sTemplate, aDados);
        if(oRespose.getStatus() == 200){
            return this.render('#lista-ternos', oRespose.getDataExtra());
        }
    }

    renderPacklist(aDados) {
        const sTemplate = this.getDocumentosTemplate();
        const oTree = this.getNestedTree();
        const oRespose = this.getRenderCopy('lista_documentos', oTree, sTemplate, aDados);
        if(oRespose.getStatus() == 200){
            return this.render('#lista-documentos', oRespose.getDataExtra());
        }
    }

    renderPoroes(aDados){
        const sTemplate = this.getPoroesTemplate();
        const oTree = this.getNestedTree();
        const oRespose = this.getRenderCopy('lista_poroes', oTree, sTemplate, aDados);
        if(oRespose.getStatus() == 200){
            return this.render('#lista_poroes', oRespose.getDataExtra());
        }
    }

    renderTernosItensButtom(aDados){
        const sTemplate = this.getTernosItemsButtom(aDados);
        this.render('#plano-porao-itens', sTemplate);
        $('#plano-porao-itens .selectpicker').selectpicker('render');
    }

    renderPacklistImport(rows){

       let template = this.getPackingListTemplate();
       let sHtml  = '';

       rows.forEach((row) => {
            const columns = row.getDataExtra();
            if(columns.length > 0){
                let copy = template;
                columns.forEach((column) => {
                    const data = column.getDataExtra();
                    if(data && data.renderName){
                        copy = copy.replace(data.renderName, data.value);
                        const classname = data.renderName.substring(0, data.renderName.length-1);
                        if(column.getStatus() == 200){
                            copy = copy.replace(classname+'CLASS__', '');
                            copy =  copy.replace(classname+'TITLE__', data.name.replaceAll('_', ' ').toUpperCase());
                            return false;
                        }
                        copy =  copy.replace(classname+'CLASS__', 'td-error');
                        copy =  copy.replace(classname+'TITLE__', column.message);
                    }
                });
                sHtml+=copy;
            }
       });

       if(sHtml){
            this.render("#packing-list-table", sHtml);
       }
    }

    renderResumos(aDados){
        const sTemplate = this.getResumoTemplate();
        const oTree = this.getNestedTree();
        const oRespose = this.getRenderCopy('lista_resumos', oTree, sTemplate, aDados);
        if(oRespose.getStatus() == 200){
            return this.render('#lista_resumos', oRespose.getDataExtra());
        }
    }

    getTemplate(template){
        return window.aTemplates[template];
    }

    getDocumentosTemplate(){
        return window.aTemplates.documento_template;
    }

    getPoroesTemplate(){
        return `
            <tr>
                <td>__porao_id__</td>
                <td>__previsto__</td>
                <td>__peso_previsto__</td>
                <td>__realizado__</td>
                <td>__peso_realizado__</td>
                <td class="text-center">
                    <button class="btn btn-warning porao-detalhes-buttom" type="buttom" data-porao="__porao_id__">Detalhes</button>
                </td>
            </tr>
        `;
    }

    getPackingListTemplate(){
        return window.aTemplates.packinglist_template;
    }

    getTernosTemplate(){
        return window.aTemplates.plano_carga_poroes_template;
    }

    getTernosSelectTemplate(sTemplate, aTernos){
        let sOptions = `<option value="0">Selecione</option>`;

        for (const key in aTernos) {
            sOptions = sOptions+`<option value="${key}">${aTernos[key]}</option>`;
        }

        const sSubString = `
            <div class="form-group" style="margin:0; padding:0;">
                <select style="margin:0; padding:0;" class="form-control select-ternos-index"
                    data-id="__id__" data-value="__terno_id__">
                    ${sOptions}
                </select>
            </div>
        `;

        return sTemplate.replace(`__select_ternos__`, sSubString);
    }

    getResumoTemplate(){
        return  window.aTemplates.resume_template;
    }

    getTernosItemsButtom($aOptions){


       const options = $aOptions.reduce(function(acumulador, valorAtual){
            const sProduto =  valorAtual.hasOwnProperty('produto') && valorAtual.produto ? `/ Produto: ${valorAtual.produto.descricao}` :  '';
            acumulador += `
                <option
                    id="item-options-${valorAtual.id}"
                    data-tokens="${valorAtual.id}"
                    value="${valorAtual.id}"
                    data-tipo ="${valorAtual.documentos_mercadoria.tipo_documento.tipo_documento}",
                    data-unidade="${valorAtual.unidade_medida.descricao}"
                    data-qtde="${valorAtual.quantidade}">
                    Documento:
                        ${valorAtual.documentos_mercadoria.numero_documento} /
                        Item: ${valorAtual.descricao} ${sProduto} /
                        Qtde: ${valorAtual.quantidade}
                </option>`;

            return acumulador;
        }, '');


        return `
            <div class="input select lf-height-input-normal">
                <label>Número</label>
                <select class="form-control selectpicker" data-size="5" data-selected="6" data-live-search="true" title="Nenhum registro selecionado" name="documento_mercadoria_item_id" id="documento_mercadoria_item_id">
                    <option data-tokens="" value=""></option>
                    ${options}
                </select>
            </div>
        `;
    }

    downloadReport(filename, text) {
        var pom = document.createElement('a');
        pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
        pom.setAttribute('download', filename);

        if (document.createEvent) {
            var event = document.createEvent('MouseEvents');
            event.initEvent('click', true, true);
            pom.dispatchEvent(event);
        }
        else {
            pom.click();
        }
    }
}


class Rules
{

    constructor(){


    }

    doRules(oRulestree, data = []){

        const oResponseResult = new window.ResponseUtil();

        if(Array.isArray(data)){
            oResponseResult.setStatus(200);
            let aDataResponse = [];

            for (const key in data) {
                const oRules = oRulestree[key];

                try {
                    const oResponse = this.applyRules(oRules, data[key], key, data);

                    aDataResponse.push(oResponse);

                    if(oResponse.getStatus() != 200){
                        oResponseResult.setStatus(500);
                    }

                } catch (error) {

                    const oResponse = new window.ResponseUtil()
                        .setStatus(500)
                        .setTitle('Valor invalido')
                        .setMessage(error.message)
                        .setDataExtra({
                             value:'',
                             name:oRules.name,
                             renderName: oRules.renderName
                        });


                    aDataResponse.push(oResponse);

                    if(oResponse.getStatus() != 200){
                        oResponseResult.setStatus(500);
                    }

                }

            }

            return oResponseResult.setDataExtra(aDataResponse);
        }

        return oResponseResult;
    }

    applyRules(oRules, value, key, elements){
        const error = {};

        if(!oRules){

            return new window.ResponseUtil().setStatus(500)
                .setTitle('Valor invalido')
                .setMessage(`Existem colunas não cadastrada no sistema.`)
                .setDataExtra({value:value, name:'', renderName: ''});

        }

        if(this.hasCallBack(oRules)){
            const customValue = oRules.customRules(oRules, value, key, elements);

            if(customValue === false){
               return new window.ResponseUtil()
                    .setStatus(500)
                    .setTitle('Valor invalido')
                    .setMessage(oRules.customMensage ? oRules.customMensage: 'Falha na validação especializada.')
                    .setDataExtra({value:value, name:oRules.name, renderName: oRules.renderName});

            }

            value = customValue;
        }

        if(this.validateIsNull(value)){

            const oResponse = new window.ResponseUtil();

            if(this.validateNotAcceptNull(oRules))
            {
                return  oResponse.setStatus(500)
                        .setTitle('Valor invalido')
                        .setMessage(`Valor do campo está vazio.`)
                        .setDataExtra({value:'', name:oRules.name, renderName: oRules.renderName});
            }

            return oResponse.setStatus(200)
                .setDataExtra({value:'', name:oRules.name, renderName: oRules.renderName});
        }

        switch (oRules.type) {
            case 'integer':
                return this._doInteger(oRules, value);
            case 'decimal':
                return this._doDecimal(oRules, value);
            case 'string':
                return this._doString(oRules, value);
        }
        return new window.ResponseUtil()
            .setStatus(500)
            .setTitle('Valor invalido')
            .setMessage(`Regras de validação não definas para o valor.`)
            .setDataExtra({value:value, name:oRules.name, renderName: oRules.renderName});

    }

    _doInteger(oRules, value){

        const oResponseUtil = new window.ResponseUtil();
        oResponseUtil
            .setTitle('Valor Invalido')
            .setStatus(500)
            .setDataExtra({value:value, name:oRules.name, renderName: oRules.renderName});


        if(isNaN(value)){
            return oResponseUtil
                .setMessage(`O valor do campo não é número.`);
        }

        if(value.toString().indexOf('.') >= 0 || value.toString().indexOf(',') >= 0){
            return oResponseUtil
                .setMessage(`O valor do campo não é inteiro.`);
        }

        if(this.validateNegative(value)){
            return oResponseUtil
                .setMessage(`O valor do campo é negativo.`);
        }

        if(!this.validatePrecision(oRules, value)){
            return oResponseUtil
                .setMessage(`O tamanho do campo maior que o limite de ${oRules.precision} números.`);
        }

        if(!this.validateRegex(oRules, value)){
            return oResponseUtil
                .setMessage(`O valor do cmapo falhou na do validação do regex.`);
        }

        return oResponseUtil
            .setTitle('Ok')
                .setStatus(200);
    }

    _doDecimal(oRules, value){
        const oResponseUtil = new window.ResponseUtil();
        oResponseUtil
            .setTitle('Valor Invalido')
            .setStatus(500)
            .setDataExtra({value:value, name:oRules.name, renderName: oRules.renderName});

        value = this.decimalParse(value);

        if(isNaN(value)){
            return oResponseUtil
                .setMessage(`O valor do campo não é número.`);
        }

        if(this.validateNegative(value)){
            return oResponseUtil
                .setMessage(`O valor do campo é negativo.`);
        }

        if(!this.validatePrecisionScale(oRules, value)){
            return oResponseUtil
                .setMessage(`O tamanho do campo maior que o limite de ${oRules.precision} por ${oRules.scale ? oRules.scale: '0'}` );
        }

        if(!this.validateRegex(oRules, value)){
            return oResponseUtil
                .setMessage(`O valor  do campo falhou na validação do regex.`);
        }

        value = this.decimalMask(oRules, value);

        return oResponseUtil
            .setTitle('Ok')
            .setStatus(200)
            .setDataExtra({value:value, name:oRules.name, renderName: oRules.renderName});


    }

    _doString(oRules, value){

        const oResponseUtil = new window.ResponseUtil();
        oResponseUtil
            .setTitle('Valor Invalido')
            .setStatus(500)
            .setDataExtra({value:value, name:oRules.name, renderName: oRules.renderName});

        if(!this.validatePrecision(oRules, value)){
            return oResponseUtil
                .setMessage(`O tamanho do campo maior que o limite de ${oRules.precision}` );
        }

        if(!this.validateRegex(oRules, value)){
            return oResponseUtil
            .setMessage(`O valor do campo falhou na validação do regex.`);
        }

        return oResponseUtil
            .setTitle('Ok')
            .setStatus(200);

    }

    hasCallBack(oRules){
        return oRules.customRules;
    }

    validateIsNull(value){
        return !value;
    }

    validatePrecision(oRules, value){
        return !oRules.precision || value.toString().length <= oRules.precision;
    }

    validateNegative(value){
        return (value < 0);
    }

    validateNotAcceptNull(oRules){
        return !oRules.null;
    }

    validatePrecisionScale(oRules, value){

        if(value.toString().indexOf('.') < 0){
            return !oRules.precision || this.validatePrecision(oRules, value);
        }

        const parts = value.toString().split('.');

        if(!oRules.scale){
            oRules.scale = 0;
        }

        if(parts.length > 2){
            return false;
        }

        if(parts[0].toString().length > oRules.precision) {
            return false;
        }

        if(parts[1].toString().length > oRules.scale) {
            return false;
        }

        return true;
    }

    validateRegex(oRules, value){
        if(!oRules.regex){
            return true;
        }
        const regex  = new RegExp(oRules.regex, 'g');
        return regex.test(value);
    }

    validateNotAcceptNegative(oRules, value){
        if(oRules.negative) return true;
        return !this.validateNegative(value);
    }

    decimalParse(value){
        if(!value) return '';
        const sValue = value.toString();
        const valores = sValue.split(/[,.]/g);
        if(valores.length > 1){
            return valores.slice(0, -1).join('') + '.' + valores.slice(-1);
        }

        return valores.join('');
    }

    decimalMask(Rules, value){
        return parseFloat(value).toFixed(Rules.scale);
    }

}

class PlaneCargaRules{

    constructor(){
        this.oRules = new Rules();
    }

    _getPackingListRuleTree(){
        return window.oNestedTree.packlist_rules;
    }

    doRules(array = []){

            const oRulesTree = this._getPackingListRuleTree();
            const oResponse = new window.ResponseUtil();
            oResponse.setStatus(200);
            const aResult = array.map((element)=>{

                try {

                    const oResult = this.oRules.doRules(oRulesTree, element);

                    if(oResult.getStatus() != 200){
                        oResponse.setStatus(500);
                    }

                    return oResult;

                } catch (error) {
                    return;
                }
            });

            oResponse.setDataExtra(aResult);

        return oResponse;
    }
}

class PlanoCargasCoreModule{

    constructor(){
        this.oPlanoCargasView = new PlanoCargasCoreView();
        this.oPlaneCargaRules = new PlaneCargaRules();
        this.packlists = [];
        this._defaultAddEvent();
        this._loadDocumentos();
        this._loadPoroes();
        this._saveDocumento();
    }

    _defaultAddEvent(){
        this._addDocumentoEvent();
        this._addPoraoEvent();
        this._addPacktlistEvent();
    }

    _load(){
        this._loadDocumentos();
        this._loadPoroes();
        this._loadResumo();
        this._loadTernos();
    }

    _saveDocumento() {
        $('table').on('loaded.bs.select', '.lf-selectpicker-ajax', function () {
            var selectpicker = $(this);

            selectpicker.on('click', '.dropdown-menu li', function () {
                var newValue = selectpicker.find('select option:selected').attr('value');
                var documentoID = $(this).closest('tr').attr('data-documento-mercadoria-id')

                if(newValue) {
                    $.fn.doAjax({
                        url : `plano-cargas/save-operador-portuario/${documentoID}/${newValue}`,
                        type: 'GET',
                    })
                }


            });
        })
    }

    _loadDocumentos(){
        const iId = this.oPlanoCargasView.getPlanoCargaIdValue();

        const aData =  $.fn.doAjax({
            type: "GET",
            url: `/PlanoCargaDocumentos/index/${iId}`,
        })
        .then(res =>{
            if(res.planoCargaDocumentos){
                this.oPlanoCargasView.renderDocumentos(res.planoCargaDocumentos);
                this.oPlanoCargasView.renderDocumentoOperdores(res.planoCargaDocumentos);

                this.oPlanoCargasView.getLiberadoDocumento().each(function() {
                    this.value = this.dataset.value;
                });

                this.oPlanoCargasView.getAjusteDateRender().each(function() {
                    const date = $(this).html().replace(/^(\d+)-(\d+)-(\d+)(.*):\d+$/, '$3/$2/$1');
                    $(this).html(date);
                });

                this._initDocumentosSelectPickerAjax();
                this._addItensModalEvent();
                this._deleteDocumentoEvent();
                this._liberadoEvent();
            }
        });

    }

    _initDocumentosSelectPickerAjax(){
        this.oPlanoCargasView.getSelectDocumentos().each(function(){
            var oThatElement = $(this)
            var oThat = this

            $(this).closest('tr').hover(function() {
                $(oThatElement)
                    .selectpicker()
                    .ajaxSelectPicker({
                        type: 'POST',
                        dataType: "json",
                        ajax: {
                            url: oThat.dataset.url,
                            data: oThat.dataset
                        },
                        preprocessData: function(data){
                            var aReturn = [];
        
                            if (data.hasOwnProperty('status') && data.status == 400) {
                                Utils.swalResponseUtil(data)
                            }else if(data.hasOwnProperty('results') && Object.entries(data.results).length > 0){
                                for (var [key, value] of Object.entries(data.results)) {
                                    aReturn.push(
                                        {
                                            'value': key,
                                            'text': value,
                                        }
                                    );
                                }
                            }
                            else {
                                aReturn.push(defaultValue);
                            }
        
                            return aReturn;
                        },
                        preserveSelected: false
                    });
            })

        });

        this.oPlanoCargasView.getSelectDocumentos().change(function(){ 
            $.fn.doAjax({
                url : 'plano-carga-documentos/save-documento-operador',
                type: 'POST',
                data: {
                    id:this.dataset.id,
                    mercadoria_id : this.dataset.mercadoriaId,
                    operador_id :this.value
                }
            }).then(data =>{
                if(data.status !== 200){
                    Utils.swalUtil({
                        title:'Ops' ,
                        text : data.message,
                        timer: 2000
                    });
                }
            });
        });
    }

    _loadTernos(){

        const iPoraoId = this.oPlanoCargasView.getCurrentPoraoValue();
        const iId = this.oPlanoCargasView.getPlanoCargaIdValue();

        $.fn.doAjax({
            type: "POST",
            url: `/PlanoCargaPoroes/cargoHold`,
            data:{
                plano_carga_id:iId,
                porao_id:iPoraoId
            }
        })
        .then(res =>{

            if(res.status == 200){

                res.dataExtra.aPlanoCargaPoroes.forEach((value)=>{
                    value.qtde_realizada = parseInt(value.qtde_realizada ? value.qtde_realizada:0);
                });

                this.oPlanoCargasView.renderTernos(res.dataExtra.aPlanoCargaPoroes);
                this.oPlanoCargasView.setSelectTermosValues();
                this._deleteTernosEvent();
                this._selectTernosEvent();
                this._mercadoriaItemEvent();
                return;
            }

            Utils.swalUtil({
                tile:'Ops..',
                text:'Falha ao renderizar itens.',
                type:'erro',
                timer:2000
            });

        });
    }

    _loadPoroes(){
        const iId = this.oPlanoCargasView.getPlanoCargaIdValue();
        const aData =  $.fn.doAjax({
            type: "GET",
            url: `/PlanoCargaPoroes/indexCargoHold/${iId}`,
        })
        .then(res =>{

            res.aPlanoCargaPoroes.forEach((value)=>{
                value.realizado = parseInt(value.realizado ? value.realizado : 0);
                value.peso_previsto = parseFloat(value.peso_previsto ? value.peso_previsto: 0);
                value.peso_realizado = parseFloat(value.peso_realizado ? value.peso_realizado: 0);
                value.peso_previsto = value.peso_previsto
                    .toFixed(3)
                    .toLocaleString('pt-BR');
                value.peso_realizado = value.peso_realizado
                    .toFixed(3)
                    .toLocaleString('pt-BR');
            });
            this.oPlanoCargasView.renderPoroes(res.aPlanoCargaPoroes);
            this.oPlanoCargasView.renderTernosItensButtom(res.aItems);
            this._addDetalhesButtomEvent();
        });

        this._loadResumo();
    }

    _loadResumo(){
        const iId = this.oPlanoCargasView.getPlanoCargaIdValue();
        const aData =  $.fn.doAjax({
            type: "GET",
            url: `/PlanoCargaPoroes/resume/${iId}`,
        })
        .then(res =>{

            const isGranel = $('#codigo-mercadoria').val() == 'GRANEL';
            const iPrecision = isGranel ? 3 : 0;

            res.aResumos.forEach((value)=>{

                value.qtde_prevista = parseFloat(value.qtde_prevista ? value.qtde_prevista: 0);
                value.qtde_realizada = parseFloat(value.qtde_realizada ? value.qtde_realizada: 0);
                value.saldo = value.qtde_prevista - value.qtde_realizada;
                value.peso_previsto = parseFloat(value.peso_previsto ? value.peso_previsto: 0);
                value.peso_realizado = parseFloat(value.peso_realizado ? value.peso_realizado: 0);
                value.peso_saldo =  value.peso_previsto - value.peso_realizado;

                value.saldo =  value.saldo < 0 ? 0 : value.saldo;
                value.peso_saldo = value.peso_saldo < 0 ? 0 : value.peso_saldo;

                value.qtde_prevista = value.qtde_prevista
                    .toFixed(iPrecision)
                    .toLocaleString('pt-BR');
                value.qtde_realizada = value.qtde_realizada
                    .toFixed(iPrecision)
                    .toLocaleString('pt-BR');
                value.saldo = value.saldo
                    .toFixed(iPrecision)
                    .toLocaleString('pt-BR');
                value.peso_previsto = value.peso_previsto
                    .toFixed(3)
                    .toLocaleString('pt-BR');
                value.peso_realizado = value.peso_realizado
                    .toFixed(3)
                    .toLocaleString('pt-BR');
                value.peso_saldo = value.peso_saldo
                    .toFixed(3)
                    .toLocaleString('pt-BR');
            });

            this.oPlanoCargasView.renderResumos(res.aResumos);
        });
    }

    _addDocumentoEvent(){
        this.oPlanoCargasView.getAddDocumento().click(function(event){

            event.preventDefault();

            const iDocumento = this.oPlanoCargasView.getHawbValue();
            const iId = this.oPlanoCargasView.getPlanoCargaIdValue();

            if(!iDocumento){

                Utils.swalUtil({
                    title:'Ops..',
                    text:'Por favor, selecione um Conhecimento.',
                    type:'warning',
                    timer:2000
                });

                return;

            }

            $.fn.doAjax({
                type: "POST",
                url: `/PlanoCargaDocumentos/addRest`,
                data:{
                    plano_carga_id:iId,
                    documento_mercadoria_id: iDocumento
                },
            })
            .then(res =>{


                Utils.swalUtil({
                    title:res.title,
                    text:res.message,
                    type:res.type,
                    timer:2000
                });

                if(res.status == 200){
                    window.location.reload(true); return;
                }

                this._load();
            });

        }.bind(this));
    }

    _addItensModalEvent(){
        $('.show-modal-itens').click(function(event){

            const iId = this.oPlanoCargasView.getPlanoCargaIdValue();
            const iDocumento = event.target.dataset.id;

            const aData =  $.fn.doAjax({
                type: "POST",
                url: `/PlanoCargaDocumentos/getItens`,
                data:{
                    plano_carga_id:iId,
                    documento_mercadoria_id: iDocumento
                },
            })
            .then(res =>{

                if(res.hasOwnProperty('status') && res.status == 200){
                    this.oPlanoCargasView.renderDocumentoItens(res.dataExtra);
                    this.oPlanoCargasView.getDocumentosItensDestinos().each(function(){
                        this.value = this.dataset.value;
                        if(this.dataset.local > 0){
                            $(`#local-${this.dataset.id} .documento-item-local`).val(this.dataset.local);
                            $(`#local-${this.dataset.id} .armazens`).show();
                            $(`#local-${this.dataset.id} .cliente`).hide();
                        }
                    });
                    this._addDocumentoItensEvent();
                    $('#modal-documento-itens').modal();
                    return ;
                }

                Utils.swalUtil({
                    title:res.title,
                    text:res.message,
                    type:res.type,
                    timer:2000
                });
            });
        }.bind(this));
    }

    _addDocumentoItensEvent(){
        this.oPlanoCargasView.getDocumentosItensDestinos().change((event) =>{
            const iID = event.target.dataset.id;
            const iValue = event.target.value;
            if(iValue == 0){
                $(`#local-${iID} .cliente`).show();
                $(`#local-${iID} .armazens`).hide();
                $(`#local-${iID} .armazens .documento-item-local`).val(0);
                this._saveDocumentoItemDestino(0, 0, iID);
                return;
            }

            $(`#local-${iID} .armazens`).show();
            $(`#local-${iID} .cliente`).hide();

        });

        this.oPlanoCargasView.getDocumentosItensLocal().change((event) =>{

            const iID = event.target.dataset.id;
            const iOldValue = event.target.dataset.value;
            const iValue = event.target.value;

            if(iValue == 0){
                return $(`#local-${iID} .armazens .documento-item-local`).val(iOldValue);
            }

            this._saveDocumentoItemDestino(1, iValue, iID)
            .then(response => {
                if(response){
                    event.target.dataset.value = iValue;
                }else{
                    event.target.value = iOldValue;
                }
            });

        });
    }

    _saveDocumentoItemDestino(destino, local, item){

        const iId = this.oPlanoCargasView.getPlanoCargaIdValue();

        return $.fn.doAjax({
            type: "POST",
            url: `/PlanoCargaDocumentos/setLocalItens`,
            data:{
                destino:destino,
                local_id: local,
                documento_mercadoria_item_id:item,
                plano_carga_id:iId,
            },
        })
        .then(res =>{

            Utils.swalUtil({
                title:res.title,
                text:res.message,
                type:res.type,
                timer:2000
            });

            if(res.status == 200){
                return true;
            }

            //window.location.reload(true);
        }).catch(() => {
            //window.location.reload(true);
        });
    }

    _selectTernosEvent(){

        this.oPlanoCargasView.getSelectTernosIndex().change((event)=>{
            event.preventDefault();
            const iTermoid = event.target.value;
            const iPlanoPoraoid = event.target.dataset.id;
            if(iTermoid && iPlanoPoraoid){
                $.fn.doAjax({
                    type: "POST",
                    url: `/PlanoCargaPoroes/updateTerno/${iPlanoPoraoid}/${iTermoid}`
                })
                .then((res) =>{

                    if(res.status == 200){

                        Utils.swalUtil({
                            title:'Sucesso.',
                            text:'Sucesso ao salvar terno.',
                            type:'success',
                            timer:2000
                        });

                    }else{

                        Utils.swalUtil({
                            title:'Falha ao salvar o terno.',
                            message: (res.message?res.message:''),
                            type:'error',
                            timer:2000
                        });
                    }
                });

            }else{

                Utils.swalUtil({
                    title:'Falha ao salvar o terno.',
                    message: (res.message?res.message:''),
                    type:'error',
                    timer:2000
                });
            }

            this._loadTernos();
        });
    }

    _delete(sController, iId, aData){
        return  $.fn.doAjax({
            type: "POST",
            url: `/${sController}/deleteRest/${iId}`,
            data:  aData ? aData: {}
        })
        .then(res =>{

            Utils.swalUtil({
                title:res.title,
                text:res.message,
                type:res.type,
                timer:2000
            });
        });
    }

    _deleteDocumentoEvent(callback){
        this.oPlanoCargasView.getDeleteIndex().click(function(event){
            event.preventDefault();
            const iId = event.target.dataset.id;
            Swal.fire({
                title: 'Deletar Documento Mercadoria',
                type:'warning',
                html:`
                    <h4><b>Obs: Vínculos do documento com o plano de carga podem ser deletados.</b><h4>
                    <br>
                    <h4>Habilitar deleção dos Plano de Carga Porões vínculados.</h4>
                    <div>
                        <label style="margin-right:10px;">
                            <input type="radio" name="radio-documento-vinculos" id="radio1" value="1"> Sim
                        </label>
                        <label>
                            <input checked="checked" type="radio" name="radio-documento-vinculos" id="radio2" value="0"> Não
                        </label>
                    </div>
                `,
                showCancelButton: true,
                showConfirmButton:  true,
                confirmButtonColor: '#41B314',
                cancelButtonColor: '#ac2925',
                confirmButtonText: 'Confirmar',
                cancelButtonText:  'Não',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                preConfirm: (confirm) => {
                    if (!confirm) {return;}
                    return (() => {
                        const sController = event.target.dataset.controller;
                        const value = $('input[name=radio-documento-vinculos]:checked').val();
                        this._delete(sController, iId, {deletarVinculos:value}).then(() => window.location.reload(true));
                    })();
                }

            });

        }.bind(this));
    }

    _deleteTernosEvent(){

        this.oPlanoCargasView.getDeleteTernosIndex().click(function(event){
            event.preventDefault();
            Swal.fire({
                title: 'Tem certeza que deseja excluir?',
                type:'warning',
                showCancelButton: true,
                showConfirmButton:  true,
                confirmButtonColor: '#41B314',
                cancelButtonColor: '#ac2925',
                confirmButtonText: 'Confirmar',
                cancelButtonText:  'Não',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                preConfirm: (confirm) => {
                    if (!confirm) {return;}
                    return (() => {
                        const iId = event.target.dataset.id;
                        const sController = event.target.dataset.controller;
                        this._delete(sController, iId).then(()=> {
                            this._load();
                        });
                    })();
                }

            });
        }.bind(this));
    }

    _liberadoEvent(){
        this.oPlanoCargasView.getLiberadoDocumento()
        .change(function(event){

            event.preventDefault();
            const iId = event.target.dataset.id;
            const sController = event.target.dataset.controller;


            const aData =  $.fn.doAjax({
                type: "POST",
                url: `/PlanoCargaDocumentos/freeRest/${iId}`,
                data:{
                    liberado: event.target.value
                }
            })
            .then(res =>{
                Utils.swalUtil({
                    title:res.title,
                    text:res.message,
                    type:res.type,
                    timer:2000
                });

                this._loadDocumentos();
            });
        }.bind(this));
    }

    _addPacktlistEvent(){

        this.oPlanoCargasView.getPackinglistButton().click(function(event){
            event.preventDefault();
            this.oPlanoCargasView.getPackinglistFile().val('');
            this.oPlanoCargasView.getPackinglistFile().trigger('click');
        }.bind(this));

        this.oPlanoCargasView.getPackinglistFile().change(function(event){
            event.preventDefault();
            const file = event.target;
            this.oPlanoCargasView.getPackinglistLabel().val(file.value);
            this._doPkFile(file.files[0]);
        }.bind(this));

        this.oPlanoCargasView.getPackinglistGenerateButton().click(function(event){
            event.preventDefault();
            this._generatePlanosPorao();
        }.bind(this));
    }

    _doPkFile(file){
        if(!file){
            return;
        }
        readXlsxFile(file)
            .then((rows)=>{
                rows.splice(0, 2);
                const id = this.oPlanoCargasView.getPlanoCargaIdValue();
                const oResponse = this.oPlaneCargaRules.doRules(rows);
                const dataExtra = oResponse.getDataExtra();
                dataExtra.sort(function (a, b) {
                    const sRecA = a.dataExtra[4].dataExtra.value;
                    const sRecB = b.dataExtra[4].dataExtra.value;
                    const sPesoA = parseFloat(a.dataExtra[2].dataExtra.value ?a.dataExtra[2].dataExtra.value: 0);
                    const sPesoB = parseFloat(b.dataExtra[2].dataExtra.value ?b.dataExtra[2].dataExtra.value: 0);
                    
                    if(sRecA == sRecB){
                        return sPesoA > sPesoB ? -1 : sPesoA < sRecB ? 1 : 0;
                    }

                    return sRecA > sRecB ? -1 : 1;
                });

                if(oResponse.getStatus() == 200){
                    let totalPesoBruto = 0;
                    let totalPesoLiquido = 0;
                    const aRequestData = oResponse.getDataExtra().map((rows)=>{
                        let result = rows.getDataExtra().reduce((acumulador, columm)=>{
                            const data = columm.getDataExtra();
                            acumulador[data.name] = data.value?data.value:null;
                            return acumulador;
                        }, {});
                        result.plano_carga_id = id;
                        totalPesoBruto += Number(result.peso_bruto)
                        totalPesoLiquido += Number(result.peso_liquido)
                        return result;
                    });

                    Utils.swalConfirmOrCancel({
                        type: 'warning',
                        html:`
                            <h4>Atualizar apenas Prioridades</h4>
                            <div>
                                <label style="margin-right:10px;">
                                    <input type="radio" name="radio-prioridades" id="radio1" value="1"> Sim
                                </label>
                                <label>
                                    <input checked="checked" type="radio" name="radio-prioridades" id="radio2" value="0"> Não
                                </label>
                            </div>
                        `,
                        title:'Você deseja importar este Packinglist?',
                        text: `Quantidade: ${aRequestData.length} - Peso: ${totalPesoBruto.toFixed(3)}`,
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Confirmar!'
                    })
                    .then((res) => {
                        if(res){
                            const value = $('input[name=radio-prioridades]:checked').val();
                            const aData =  $.fn.doAjax({
                                type: "POST",
                                url: `/PlanoCargaPackingLists/register/${id}/${value}`,
                                data:JSON.stringify({
                                    entities:aRequestData
                                }),
                                headers :{
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                },
                                loadInfinity: true
                            })
                            .then(res =>{
        
                                this.oPlanoCargasView.renderPacklistImport(dataExtra);
        
                                if(res.status == 200){
                                    Utils.swalUtil({
                                        title:'Sucesso',
                                        text:'Dados do XLSX importados com sucesso.',
                                        type:'success',
                                        timer:2000
                                    });
                                    return;
                                }
        
                                Utils.swalUtil({
                                    title:'Ops..',
                                    text:'falha ao armazenar os dados do XLSX no banco de dados.',
                                    type:'error',
                                    timer:2000
                                });
                            });
                        }
                        return false;
                   });
                   return;
                }
                this.oPlanoCargasView.renderPacklistImport(dataExtra);
                this._relatorio(dataExtra);
            })
            .catch((ex) =>{

                console.log(ex);
                Utils.swalUtil({
                    title:'Ops..',
                    text:'O arquivo importado não é XLSX!',
                    type:'error',
                    timer:2000
                });
            });

    }

    _relatorio(dataExtra){
        let content = '';

        dataExtra.forEach((row, indice) => {
            const columns = row.getDataExtra();
            if(columns.length > 0){
                if(row.getStatus() != 200){
                    columns.forEach((column, index) => {
                        if(column.getStatus() != 200){
                            content += `ERRO (linha ${indice+1}/ coluna ${index}): ${column.message}\n\r`;
                        }
                    });
                }
            }else{
                content += `ERRO (linha ${indice+1}): , sem conteúdo.\n\r`;
            }
       });

       this.oPlanoCargasView.downloadReport('relatorio.txt', content);
    }

    _generatePlanosPorao(){
        const iId = this.oPlanoCargasView.getPlanoCargaIdValue();
        $.ajax({
            type:"post",
            url: `/PlanoCargas/getGerandoPlanoPoroes/${iId}`,
            data:{},
            success: function(data) {
                if(!data.dataExtra) {
                    Swal.fire({
                        title: 'Geração de Planos Porão',
                        type:'warning',
                        html:`
                            <h4><b>Obs: cadastros antigos, podem ser substituidos com a nova geração.</b><h4>
                            <br>
                            <h4>Habilitar Cadastro de Documentos</h4>
                            <div>
                                <label style="margin-right:10px;">
                                    <input checked="checked" type="radio" name="radio-documentos" id="radio1" value="1"> Sim
                                </label>
                                <label>
                                    <input type="radio" name="radio-documentos" id="radio2" value="0"> Não
                                </label>
                            </div>
                        `,
                        showCancelButton: true,
                        showConfirmButton:  true,
                        confirmButtonColor: '#41B314',
                        cancelButtonColor: '#ac2925',
                        confirmButtonText: 'Confirmar',
                        cancelButtonText:  'Não',
                        showLoaderOnConfirm: true,
                        allowOutsideClick: false,
            
                        preConfirm: (confirm) => {
            
                            if (!confirm) {return;}
            
                            $('#generate-button').attr("disabled", 'disabled');
                            const value = $('input[name=radio-documentos]:checked').val();
                            $.ajax({
                                type:"post",
                                url: `/PlanoCargas/edit/${iId}`,
                                data: {'gerando_plano_poroes': 1},
                                success: function () {
                                    return (() => {
                                        const aData =  $.fn.doAjax({
                                            type: "POST",
                                            url: `/PlanoCargaPoroes/generateCargo/${iId}/${value}`,
                                            loadInfinity: true
                                        })
                                        .then((res) =>{
                    
                                            if(res.status == 200){
                    
                                                Utils.swalUtil({
                                                    title:'Sucesso.',
                                                    text:'Sucesso na geração do plano de porões.',
                                                    type:'success',
                                                    timer:2000
                                                });
                                                window.location.reload(true);
                                                $.ajax({
                                                    type:"post",
                                                    url: `/PlanoCargas/edit/${iId}`,
                                                    data: {'gerando_plano_poroes': 0},
                                                    success: function () {
                                                        $('#generate-button').removeAttr('disabled');
                                                    }
                                                })
                                                return;
                    
                                            }else{
                    
                                                Utils.swalUtil({
                                                    title:'Ops..',
                                                    text:'Falha na geração do plano de porões.',
                                                    message: (res.message?res.message:''),
                                                    type:'error',
                                                    timer:2000
                                                });

                                                $.ajax({
                                                    type:"post",
                                                    url: `/PlanoCargas/edit/${iId}`,
                                                    data: {'gerando_plano_poroes': 0},
                                                    success: function () {
                                                        $('#generate-button').removeAttr('disabled');
                                                    }
                                                })
                    
                                                this._relarioErros(res);
                                                window.location.reload(true);
                                                return;
                                            }
                                        });
                                    })();
                                }
                            })
                        }
            
                    });
                } else {
                    Utils.swalUtil({
                        title:'Aviso.',
                        text:'Já existe uma geração de planos poroão em andamento',
                        type:'warning',
                        timer:3000
                    });
                }
            }
        })
        
    }

    _relarioErros(erro){

        if(Array.isArray(erro.dataExtra)){
            let content = '';

            erro.dataExtra.forEach((data, indice) => {
                if(data.status != 200){
                    content += `ERRO : ${data.message}\n\r`;
                }
            });

            this.oPlanoCargasView.downloadReport('erros.txt', content);
        }

    }

    _porao(iId, iPoraoId){
        const aData =  $.fn.doAjax({
            type: "POST",
            url: `/PlanoCargaPoroes/cargoHold`,
            data:{
                plano_carga_id:iId,
                porao_id:iPoraoId
            }
        })
        .then(res =>{

            if(res.status == 200){
                res.dataExtra.aPlanoCargaPoroes.forEach((value)=>{
                    value.qtde_realizada = parseInt(value.qtde_realizada ? value.qtde_realizada:0);
                });

                this.oPlanoCargasView.getPoraoTitle().html(iPoraoId);
                this.oPlanoCargasView.setCurrentPorao(iPoraoId);
                this.oPlanoCargasView.renderTernos(res.dataExtra.aPlanoCargaPoroes);
                this.oPlanoCargasView.poraoChangeToDetalhesView();
                this.oPlanoCargasView.setSelectTermosValues();
                this._mercadoriaItemEvent();
                this._listaPoraoEvent();
                this._savePlanoCargaPoraoEvent();
                this._deleteTernosEvent();
                this._selectTernosEvent();
                return;
            }

            Utils.swalUtil({
                tile:'Ops..',
                text:'Falha ao renderizar tela.',
                type:'erro',
                timer:2000
            });

        });
    }

    _addPoraoEvent(){
        this.oPlanoCargasView.getPoraoButton().click(function(event){
            event.preventDefault();
            const iPoraoId = this.oPlanoCargasView.getPoraoValue();
            const iId = this.oPlanoCargasView.getPlanoCargaIdValue();

            if(!iPoraoId){
                Utils.swalUtil({
                    title:'Ops..',
                    text:'Por favor, selecione um Porão.',
                    type:'warning',
                    timer:2000
                });
                return;
            }

            this._porao(iId, iPoraoId);

        }.bind(this));

        this.oPlanoCargasView.getPorao().change(function(){
            const jOption = $(`#porao option[value="${this.value}"]`);
            const iPorao = jOption.val();
            const iCodigo = iPorao ? jOption.data('codigo') : 0 ;
            const iQtd = iPorao ? jOption.data('quantidade') : 0;
            const iPeso = iPorao ? jOption.data('peso'): 0;
            const iValidar = iPorao ? jOption.data('validar'): 0;
            const iPoraoOrigem = iPorao ? jOption.data('poraoOrigem'): 0;
            $('#mostra-codigo').prop('checked', iCodigo);
            $('#mostra-qtd').prop('checked', iQtd);
            $('#mostra-peso').prop('checked', iPeso);
            $('#validar-pela-media').prop('checked', iValidar);
            $('#mostra-porao-origem').prop('checked', iPoraoOrigem);
        });

        $('#mostra-codigo, #mostra-qtd, #mostra-peso, #validar-pela-media, #mostra-porao-origem').change(function(){
            const iPoraoId = this.oPlanoCargasView.getPoraoValue();
            const iPlanoCargaId = this.oPlanoCargasView.getPlanoCargaIdValue();

            if(!iPoraoId) return false;

            const iCodigo =  $('#mostra-codigo').is(":checked") ? 1 : 0;
            const iQtd =  $('#mostra-qtd').is(":checked") ? 1 : 0; 
            const iPeso =  $('#mostra-peso').is(":checked") ? 1 : 0;
            const iMedia =  $('#validar-pela-media').is(":checked") ? 1 : 0;
            const iPoraoOrigem =  $('#mostra-porao-origem').is(":checked") ? 1 : 0;

            $.fn.doAjax({
                type: "POST",
                url: `/Poroes/addCondicoes`,
                data:{
                    mostra_codigo:iCodigo,
                    mostra_qtd:iQtd,
                    mostra_peso:iPeso,
                    validar_pela_media:iMedia,
                    plano_carga_id:iPlanoCargaId,
                    porao_id:iPoraoId,
                    mostra_porao_origem:iPoraoOrigem
                }
            })
            .then(res =>{
                if(res.status == 200){
                    this.oPlanoCargasView.renderPorao(res.dataExtra.aPoroes);
                    $('#mostra-codigo').prop('checked', res.dataExtra.oEntity.mostra_codigo);
                    $('#mostra-qtd').prop('checked', res.dataExtra.oEntity.mostra_qtd);
                    $('#mostra-peso').prop('checked', res.dataExtra.oEntity.mostra_peso);
                    $('#validar-pela-media').prop('checked', res.dataExtra.oEntity.validar_pela_media);
                    $('#mostra-porao-origem').prop('checked', res.dataExtra.oEntity.mostra_porao_origem);
                    $('#porao').selectpicker('refresh').selectpicker('val', res.dataExtra.oEntity.porao_id);
                }
            });

        }.bind(this));
    }

    _addDetalhesButtomEvent(){
        this.oPlanoCargasView.getDetalhesPoraoButtom().click(function(event){
            const iId = this.oPlanoCargasView.getPlanoCargaIdValue();
            const iPorao = event.target.dataset.porao;
            this._porao(iId, iPorao);
        }.bind(this));

    }


    _mercadoriaItemEvent(){
        this.oPlanoCargasView.getMercadoriaItem()
        .change(function(event){
            const iId =  event.target.value;
            if(iId){
                const oOption = this.oPlanoCargasView.getOptionsItem(iId);
                const sTipo = oOption.data('tipo');
                const sUnidade = oOption.data('unidade');
                const sQtde = oOption.data('qtde');
                this.oPlanoCargasView.getTipoDocItem().val(sTipo);
                this.oPlanoCargasView.getUnidadeMedidaItem().val(sUnidade);
                this.oPlanoCargasView.getQuantidadePrevista().val(sQtde);
                return;

            }

            this.oPlanoCargasView.getTipoDocItem().val('');
            this.oPlanoCargasView.getUnidadeMedidaItem().val('');
        }.bind(this));

        $('#produto').change(function(){

            if(!this.value){
                return;
            }

            $.fn.doAjax({
                type: "GET",
                url: `/Produtos/get/${this.value}`,
                dataType: 'json'
            })
            .then(data =>{

                const oData = data.dataExtra;

                if(data.status != 200){
                    return;
                }

                if(oData.hasOwnProperty('unidade_medida')){
                    $('#unidade-medida-item').val(`${oData.unidade_medida.descricao}`);
                }
               
            });

        });

        $('.edit-ternos-index').click(function(e){

            try {
                const jElement = $(e.target);
                const sUrl = `${jElement.data('controller')}/${jElement.data('action')}/${jElement.data('id')}`;
                SaveBackModal.showCallBackModal(() => {
                    this._load();
                }, sUrl, {id:jElement.data('id')});
            } catch (error) {
                console.log(error);
            }

            return false;
        }.bind(this));


        $('.view-ternos-caracteristicas').click(function(e){
            try {
                const jElement = $(e.target);
                const sUrl = `${jElement.data('controller')}/${jElement.data('action')}/${jElement.data('id')}`;
                SaveBackModal.showCallBackModal(() => {}, sUrl, {id:jElement.data('id')});
            } catch (error) {
                console.log(error);
            }
            return false;
        }.bind(this));

    }

    _listaPoraoEvent(){
        this.oPlanoCargasView.getLIstaPorao().click(function(event){
            window.location.reload(true);
        }.bind(this));
    }

    _savePlanoCargaPoraoEvent(){
        this.oPlanoCargasView.getSalvarPorao().click(function(event){

            event.preventDefault();
            const iPoraoId = this.oPlanoCargasView.getCurrentPoraoValue();
            const iId = this.oPlanoCargasView.getPlanoCargaIdValue();
            const iItemId = this.oPlanoCargasView.getMercadoriaItem().val();
            const sQuantidadePrevista = this.oPlanoCargasView.getQuantidadePrevista().val();
            const iTerno = this.oPlanoCargasView.getTerno().val();
            const fTonelagem = this.oPlanoCargasView.getTonelagem().val();
            const iMostraCodigo = this.oPlanoCargasView.getMostraCodigo().prop('checked');
            const iMostraQtd = this.oPlanoCargasView.getMostraQtd().prop('checked');
            const iMostraPeso = this.oPlanoCargasView.getMostraPeso().prop('checked');
            const iLimite = this.oPlanoCargasView.getPermiteUltrapassarLimitePrevisto().prop('checked') ? 1: 0;
            const iProduto = this.oPlanoCargasView.getProdutoItem().val();
            const iDestino = this.oPlanoCargasView.getDestinoItem().val();
            const iOPerador = this.oPlanoCargasView.getOperadorItem().val();
            const iMostraPoraoOrigem = this.oPlanoCargasView.getMostraPoraoOrigem().prop('checked');


            console.log(iDestino);


            if(!iItemId && !iProduto){
                Utils.swalUtil({
                    title:'Ops..',
                    text:'Por favor, selecione um mercadoria.',
                    type:'warning',
                    timer:2000
                });
                return;
            }

            const aData =  $.fn.doAjax({
                type: "POST",
                url: `/PlanoCargaPoroes/addRest`,
                data:{
                    plano_carga_id:iId,
                    porao_id:iPoraoId,
                    documento_mercadoria_item_id:iItemId,
                    produto_id:iProduto,
                    qtde_prevista:sQuantidadePrevista,
                    terno_id:iTerno,
                    tonelagem:fTonelagem,
                    mostra_codigo:iMostraCodigo,
                    mostra_qtd:iMostraQtd,
                    mostra_peso: iMostraPeso,
                    permite_ultrapassar_limite_previsto:iLimite,
                    porto_destino_id:iDestino,
                    operador_id: iOPerador,
                    mostra_porao_origem: iMostraPoraoOrigem,
                }
            })
            .then(res =>{

                Utils.swalUtil({
                    title:res.title,
                    text:res.message,
                    type:res.type,
                    timer:2000
                });

                if(res.status == 200){
                    this._load();
                }

            });

        }.bind(this));
    }

}


window.PlanoCargasCoreModule = PlanoCargasCoreModule;
window.PlanoCargasCoreView = PlanoCargasCoreView;
