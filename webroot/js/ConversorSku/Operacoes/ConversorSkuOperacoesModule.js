/*jshint esversion: 6 */

class ConversorSkuOperacoesView{

    constructor(){
    }

    getOsId(){
        return document.querySelector('#iOSId');
    }

    getIsUnitizacao(){
        return document.querySelector('#bUnitizacao');
    }

    clearInputs(){
        $(':input').val('');
    }

    setView(html){
        document
            .querySelector('#view-to-render')
            .innerHTML = html;
    }

    getNestedTree() {
        return {
            lista_itens: {
                __produto_id__: {
                    type: 'depth',
                    referer: 'produto_id',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __os_id__: {
                    type: 'depth',
                    referer: 'ordem_servico_id',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __endereco_id__: {
                    type: 'depth',
                    referer: 'endereco_id',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __reserva_id__: {
                    type: 'depth',
                    referer: 'id',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __estoque_id__: {
                    type: 'depth',
                    referer: 'estoque_id',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __serie__: {
                    type: 'depth',
                    referer: 'serie',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __lote__: {
                    type: 'depth',
                    referer: 'lote',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __validade__: {
                    type: 'depth',
                    referer: 'validade',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __produto__: {
                    type: 'depth',
                    referer: 'produto.codigo',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __descricao__: {
                    type: 'depth',
                    referer: 'produto.descricao',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __composicao__: {
                    type: 'depth',
                    referer: 'endereco.composicao',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                }
            },
            show_item:{
                __produto_id__: {
                    type: 'depth',
                    referer: 'reserva.produto_id',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __os_id__: {
                    type: 'depth',
                    referer: 'reserva.ordem_servico_id',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __endereco_id__: {
                    type: 'depth',
                    referer: 'reserva.endereco_id',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __reserva_id__: {
                    type: 'depth',
                    referer: 'reserva.id',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __estoque_id__: {
                    type: 'depth',
                    referer: 'reserva.estoque_id',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __serie__: {
                    type: 'depth',
                    referer: 'reserva.serie',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __lote__: {
                    type: 'depth',
                    referer: 'reserva.lote',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __validade__: {
                    type: 'depth',
                    referer: 'reserva.validade',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __produto__: {
                    type: 'depth',
                    referer: 'reserva.produto.codigo',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __descricao__: {
                    type: 'depth',
                    referer: 'reserva.produto.descricao',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __composicao__: {
                    type: 'depth',
                    referer: 'reserva.endereco.composicao',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                }
            },
            apontamentos:{
                __produto_pai_id__: {
                    type: 'depth',
                    referer: 'produto_pai_id',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },

                __produto_final_id__: {
                    type: 'depth',
                    referer: 'produto_final_id',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __os_id__: {
                    type: 'depth',
                    referer: 'ordem_servico_id',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },
                __descricao__: {
                    type: 'depth',
                    referer: 'produto_final_descricao',
                    when: [
                        {
                            value_referer: {
                                type: 'static',
                                referer: null
                            },
                            value_replace: {
                                type: 'static',
                                referer: ''
                            }
                        }
                    ]
                },

            }
        };
    }

    renderElement(oObject){

        let oResponse = new window.ResponseUtil();
        const oTree = this.getNestedTree();
        const sTemplete = this.getItemTemplate();

        oResponse = RenderCopy.render({
            object: oObject,
            template: sTemplete,
            data_to_render: 'show_item',
            nested_tree: oTree
        });

        if (oResponse.getStatus() !== 200)
            return console.log(oResponse.getMessage() + ' Falha ao renderizar item ' + sKeyComposicao);

        return this.renderFrontEnd(oResponse.getDataExtra());
    }

    renderLista(aDados) {

        const sTemplate = this.getListItensTemplate();
        const oTree = this.getNestedTree();
        let oResponse = new window.ResponseUtil();
        let sListTemplate  = '';
        
        aDados.reservas.forEach(function(oDataComposicao, sKeyComposicao) {
            oResponse = RenderCopy.render({
                object: oDataComposicao,
                template: sTemplate,
                data_to_render: 'lista_itens',
                nested_tree: oTree
            });

            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item ' + sKeyComposicao);

            sListTemplate += oResponse.getDataExtra();
        });

        return this.renderFrontEnd(
            this.getListTemplateModule(sListTemplate));
    }

    renderApontamentos(aDados){

        const sTemplate = this.getApontamentoTemplate();
        const oTree = this.getNestedTree();
        let oResponse = new window.ResponseUtil();
        let sListTemplate  = '';
        aDados = aDados.produtos_estruturas;
        
        aDados.forEach(function(oDataComposicao, sKeyComposicao) {
            oResponse = RenderCopy.render({
                object: oDataComposicao,
                template: sTemplate,
                data_to_render: 'apontamentos',
                nested_tree: oTree
            });

            if (oResponse.getStatus() !== 200)
                return console.log(oResponse.getMessage() + ' Falha ao renderizar item ' + sKeyComposicao);

            
            sListTemplate += oResponse.getDataExtra();
        });

        return this.renderFrontEnd(
            this.getApontamentoTemplateModule(
                sListTemplate));
        
    }

    renderFrontEnd(html){
        try {
            this.setView(html);
            return true;
        } catch (error) {
            console.log(error);
            return false;
        }
    }

    getListTemplateModule(template){
        return `
            <div class="full-width flex-wrap no-margin" id="component-list">

            <div class="full-width title text-center">
                <h3>
                    Separar itens Finais            
                </h3>
            </div>

            <div class="full-width text-center">
                <h3>
                    Produto/ Descrição/ Locais            
                </h3>
            </div>

            <div class="full-width list-elementos">
                ${template? template:
                    '<div class="full-width text-center"><b>Vazio</b></div>'}
            </div>

            <div class="full-width flex-justify-center margin-top-10">
                <button id="voltar-main" type="button" class="btn btn-danger">voltar</button>
            </div>
        `;
    }

    getListItensTemplate(){
        return `  
            <div class="block full-width list-elementos">
                <div class="full-width component-item action-click" 
                    data-produto="__produto_id__"  
                    data-os="__os_id__" 
                    data-locais="__endereco_id__"
                    data-reserva="__reserva_id__"
                    data-estoque="__estoque_id__"
                    data-serie="__serie__"
                    data-lote="__lote__"
                    data-validade="__validade__">
                    <div class="produto">
                        Código: __produto__
                    </div>
                    <div class="descricao">
                        Descrição: __descricao__
                    </div>
                    <div class="locais">
                        __composicao__
                    </div>
                </div>
            </div>
        `;
    }

    getItemTemplate(){
        return `
            <div class="full-width flex-wrap no-margin" id="component-separar">

                <div class="full-width title text-center">
                    <h3>Separar itens Finais</h3>
                </div>

                <div class="full-width text-center">
                    <h3>Produto/ Descrição/ Locais</h3>
                </div>

                <div id="component-item-body" 
                    class="full-width component-item"
                    data-produto="__produto_id__"  
                    data-os="__os_id__" 
                    data-locais="__endereco_id__"
                    data-reserva="__reserva_id__"
                    data-estoque="__estoque_id__"
                    data-serie="__serie__"
                    data-lote="__lote__"
                    data-validade="__validade__">
                    <div class="produto">
                        Código: __produto__
                    </div>
                    <div class="descricao">
                        Descrição: __descricao__
                    </div>
                    <div class="locais">
                        __composicao__
                    </div>
                </div>

                <div class="full-width">
                    <div class="input text">
                        <label for="local">Ler Local</label>
                        <input type="text" name="local" class="form-control clique-duplo" id="local">
                    </div>        
                </div>

                <div class="full-width">
                    <div class="input text">
                        <label for="produto">Ler Produto</label>
                        <input type="text" name="produto" 
                            inputmode="none" 
                        class="form-control clique-duplo" id="produto">
                    </div>        
                </div>

                <div class="full-width flex-justify-center">
                    <button id="save-item" type="button" 
                        class="btn btn-success">Salvar</button>

                    <button id="voltar-main" type="button" 
                        class="btn btn-danger margin-left-10">Voltar</button>
                </div>
            </div>
        `;
    }

    onDoubleClickEndereco() {
        oHooks.watchDoubleClick('.clique-duplo', (that) => { 
            $(that).attr('inputmode', 'decimal') ;
        });
    }

    getApontamentoTemplateModule(template){
        return `
            <div class="full-width flex-wrap no-margin no-padding" id="component">
                <div class="full-width title text-center">
                    <h3>Apontar Montagem</h3>
                </div>
                <div class="full-width text-center no-margin no-padding">
                    <h3>Qtde Produto</h3>
                </div>
                <div class="full-width  list-note ">
                    ${template?template:
                    '<div class="full-width text-center"><b>Vazio</b></div>'}
                </div>
                <div class="full-width flex-justify-center margin-top-10">
                    <button id="voltar-main" type="button" class="btn btn-danger">
                        voltar
                    </button>
                </div>
            </div>
        `;
    }

    getApontamentoTemplate(bUnitizacao = false){
        return `
            <div class="full-width border 
                margin-top-10 padding-top-10 padding-horizontal-10  no-margin-bottom ">
                <div class="full-width text-center">
                    <div class="input text">
                        __descricao__
                    </div>
                </div>

                <div class="full-width" >
                    <div class="input text">
                        <input 
                            placeholder="Quantidade"
                            type="decimal"
                            autocomplete="off" 
                            name="produto" 
                            class="form-control numeric-double" 
                            id="component-value-__produto_final_id__">
                    </div>
                </div>

                <div class="full-width">
                    <div class="input text">
                        <input 
                            placeholder="Local"
                            type="text" 
                            name="etiqueta" 
                            class="form-control" 
                            id="component-etiqueta-__produto_final_id__">
                    </div>
                </div>

                <div class="full-width text-center">
                    <button class="btn btn-primary action-apontar" type="button"
                        data-produto="component-value-__produto_final_id__" 
                        data-etiqueta="component-etiqueta-__produto_final_id__"
                        data-produto-pai="__produto_pai_id__" 
                        data-produto-final="__produto_final_id__"  
                        data-os="__os_id__">
                        Apontar
                    </button>     
                </div>
            </div>
        `;
    }

    
}

class ConversorSkuOperacoesModule{

    constructor(){
        this.conversorSkuOperacoesView = new ConversorSkuOperacoesView();
        this._defaultAddEventListaner();
        this.id = this.conversorSkuOperacoesView.getOsId().value;
        this.bUnitizacao = this.conversorSkuOperacoesView
            .getIsUnitizacao().value;
    }

    _defaultAddEventListaner(){

        $('.compoment-view').click(function(){
            this.callView(event.target.dataset.view);
        }.bind(this));

        $('.finaliar-os-pendente').click(function(){
            this._finarlizarOs();
        }.bind(this));

        $('.voltar-os-pendente-unitizacao').click(function(){
            window.location.href = '/ordens-servico-pendentes/index-unitizacao';
        });

        $('.voltar-os-pendente-desunitizacao').click(function(){
            window.location.href = '/ordens-servico-pendentes/index-desunitizacao';
        });

        
    }

    callView(sView, data){
        switch(sView){
            case 'component-separar':
                this._showList();
            break;

            case 'component-to-separar':
                this._showList(false);
            break;

            case 'component-separar-item':
                this._showSepararItem(data);
            break;

            case 'component-apontar':
                this._showApontamentos();
            break;

            case 'main':
                this._showMain();
            break;
        }
    }


    _toogleMain(bDoti){
        if(bDoti){ 
            document.querySelector('.home')
                .classList.toggle("hidden");
        }
    }

    _showList(tootle = true){


        const aData =  $.fn.doAjax({
            method: "GET",
            contentType: "application/json",
            url: `/conversao-skus/getSkus/${this.id}`,
            dataType: "json"
        })
        .then(res =>{
            const result = this.conversorSkuOperacoesView.renderLista(res);
            if(tootle) this._toogleMain(result);
            this._addListEvents(result);
        });
    }

    _showSepararItem(data){
       
        $.fn.doAjax({
            type: "POST",
            url: '/conversao-skus/getSku',
            data: data,
        })
        .then(res => {
            const result = this.conversorSkuOperacoesView
                .renderElement(res);
            this._addListItemEvents(result);
        });
    }

    _showApontamentos($tooggle = true){
        const aData =  $.fn.doAjax({
            method: "GET",
            contentType: "application/json",
            url: `/conversao-skus/getApontamentoSkus/${this.id}`,
            dataType: "json"
        })
        .then(res =>{
            const result = this.conversorSkuOperacoesView.renderApontamentos(res);
            if($tooggle){
                this._toogleMain(result);
            }
            this._addApontamentosEvents(result);
        });


    }

    _showMain(){
        const result = 
            this.conversorSkuOperacoesView.renderFrontEnd('');
        this._toogleMain(true);
    }

    _addListEvents(bDoIt){

        if(bDoIt){
            $('#voltar-main').click(function(){
                this.callView('main');
            }.bind(this));

            $('.action-click').click(function(event){
                this.callView('component-separar-item',
                    event.target.dataset);
            }.bind(this));
        }  
    }

    _addListItemEvents(bDoIt){
        if(bDoIt){
            $('#voltar-main').click(function(){
                this.callView('component-to-separar');
            }.bind(this));

            $('#save-item').click(function(){

                const local = $('#local').val();
                const produto = $('#produto').val();
                const component = $('#component-item-body').data();
                component.etiquetaLocal =  local;
                component.etiquetaProduto =  produto;

                $.fn.doAjax({
                    type: "POST",
                    url: '/conversao-skus/moveSku',
                    data:component,
                })
                .then(res => {
                    if(res.result.success){
                        Utils.swalUtil({
                            title:'Separação salva com sucesso.',
                            type:'success',
                            timer:2000
                        });
                        this.callView('component-to-separar');
                    }else{
                        Utils.swalUtil({
                            title:'Falha ao salvar Separação.',
                            type:'error',
                            timer:2000
                        });
                    }
                });
            }.bind(this));
        }  
    }
    _addApontamentosEvents(bDoIt){

        if(bDoIt){
            
            $('#voltar-main').click(function(){
                this.callView('main');
            }.bind(this));

            $('.action-apontar').click(function(event){
                const produto = event.target.dataset.produto;
                const produto_final = event.target.dataset.produtoFinal;
                const produto_pai = event.target.dataset.produtoPai;
                const etiqueta = event.target.dataset.etiqueta;
                const os = event.target.dataset.os;
                const value = $('#'+produto).val();
                const barcode = $('#'+etiqueta).val();
                const aData =  $.fn.doAjax({
                    type: "POST",
                    url: `/conversao-skus/apontar`,
                    data:{
                        ordem_servico:os,
                        local_barcode:barcode,
                        produto_pai_id:produto_pai,
                        produto_final_id : produto_final,
                        produto_value:value
                    },
                })
                .then(res =>{
                    if(res.result.success){
                        Utils.swalUtil({
                            title:'Apontamento salvo com sucesso.',
                            type:'success',
                            timer:2000
                        });
                        this.conversorSkuOperacoesView.clearInputs();
                        this._showApontamentos(false);
                    }else{
                        Utils.swalUtil({
                            title:res.result.message,
                            type:'error',
                            timer:2000
                        });
                        this._showApontamentos(false);
                    }
                });

            }.bind(this)); 

            $.fn.numericDouble();

        }  
    }

    _finarlizarOs(){
        const url = this.bUnitizacao ? 
            `ordens-servico-pendentes/finalizar-unitizacao/${
                this.id}` : 
            `ordens-servico-pendentes/finalizar-desunitizacao/${
                this.id}`;
        Utils.swalConfirmOrCancel({
            title:'Deseja prosseguir?',
            text:'A Ordem de Serviço será finalizada ao prosseguir',
            confirmButtonText: 'Sim, continuar',
            showConfirmButton: true,
            defaultConfirmColor: true,
            showCancelButton: true,
        }, function(){
            $.fn.doAjax({
                type: "POST",
                url: url
            })
            .then(res =>{
                if(res.result.success){
                    Utils.swalUtil({
                        title:
                            'Ordem de Serviço finalizada com Sucesso.',
                        type:'success',
                        timer:2000
                    })
                    .then(this._goToindex());
                }else{
                    Utils.swalUtil({
                        title:res.result.message,
                        type:'error',
                        timer:2000
                    });
                }
            });
        }.bind(this));
    }

    _goToindex(){
        if(this.bUnitizacao){  
            window.location.href = 
            '/ordens-servico-pendentes/index-unitizacao';
        }

        window.location.href = 
            '/ordens-servico-pendentes/index-desunitizacao';
    }
}


window.ConversorSkuOperacoesModule = ConversorSkuOperacoesModule;
