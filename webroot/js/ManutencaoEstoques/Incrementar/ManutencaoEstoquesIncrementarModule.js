
/*jshint esversion: 6 */

class ManutencaoEstoquesIncrementarView{
    constructor(){
        this.codigo = document.querySelector('#codigo');
        this.barras = document.querySelector('#barras');
        this.produto = document.querySelector('select[name="produto_id"]');
        this.endereco = document.querySelector('#endereco');
        this.nf = document.querySelector('#nf');

    }

    getCodigo(){
        return this.codigo;
    }

    getBarras(){
        return this.barras;
    }

    getProduto(){
        return this.produto;
    }

    getEndereco(){
        return this.endereco;
    }
}



class ManutencaoEstoquesIncrementarModule{
    constructor(){
        this.manutencaoEstoquesView = new 
            ManutencaoEstoquesIncrementarView();
        this.addEventLisner();
    }

    addEventLisner(){

        this.manutencaoEstoquesView.getCodigo()
            .addEventListener("change", function(){
                this.changeProduto();
        }.bind(this));
        
        this.manutencaoEstoquesView.getBarras()
            .addEventListener("change", function(){
                this.changeProduto();
        }.bind(this));

        this.manutencaoEstoquesView.getProduto()
            .addEventListener("change", function(){
                this.changeProduto();
        }.bind(this));

        $('.salvar-incremento').click(function(event) {

            if (Utils.manageRequiredCustom()) {
                return false
            }

            if (!$('select.endereco_por_composicao').val() && !$('.endereco_id').val()) {
                Utils.swalUtil({
                    timer: 3000,
                    title: 'Você precisa selecionar um Endereço!'
                })
                return false
            }

            Utils.swalConfirmOrCancel({
                 type:'warning',
                 title:'Você realmente deseja inserir esse Produto?',
                 showConfirmButton: true,
                 showCancelButton: true,
                 confirmButtonText: 'Inserir!'
            })
            .then((res) => {
                 if(res){
                    $('.form-incremento').submit()
                 }
                 return false;
            });
 
         });

    }

    changeProduto(){
        this.changeUrl({
            codigo:this.manutencaoEstoquesView.getCodigo().value,
            barras:this.manutencaoEstoquesView.getBarras().value,
            produto:this.manutencaoEstoquesView.getProduto().value,
        });
    }

    changeUrl(oParams){

        if(!oParams){
            return;
        }

        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search.slice(1));
        const aKeys = Object.keys(oParams);

        for (const index of aKeys) {
            params.delete(index);
            params.append(index, oParams[index]);
        }

        url.search = '?' + params.toString();
        window.location.href = url.href;
    }
}

window.ManutencaoEstoquesIncrementarModule = 
ManutencaoEstoquesIncrementarModule;