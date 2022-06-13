
/*jshint esversion: 6 */

class ManutencaoEstoquesAlterarStatusView{
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

    getNf(){
        return  this.nf;
    }

    getAlterarStatusButton(){
        return this.alterarStatusButton;
    }

}



class ManutencaoEstoquesAlterarStatusModule{
    constructor(){
        this.manutencaoEstoquesView = new ManutencaoEstoquesAlterarStatusView();
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

        this.manutencaoEstoquesView.getEndereco()
            .addEventListener("change", function(){
                this.changeProduto();
        }.bind(this));

        this.manutencaoEstoquesView.getNf()
            .addEventListener("change", function(){
                this.changeProduto();
        }.bind(this));

        $('.alterar-status').click(function(event) {
           event.preventDefault();
           const value = event.target.dataset.value;
           const sStatusNovo = document.querySelector(`#${value}`).value;

           Utils.swalConfirmOrCancel({
                type:'warning',
                title:'Você realmente deseja Alterar Status desse Estoque?',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: 'Alterar!'
           })
           .then((res) => {
                if(res){
                    Utils.doPost(event.target.href, [{
                        'status_novo': sStatusNovo
                    }]);
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
            endereco:this.manutencaoEstoquesView.getEndereco().value,
            nf:this.manutencaoEstoquesView.getNf().value,
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

window.ManutencaoEstoquesAlterarStatusModule = 
    ManutencaoEstoquesAlterarStatusModule;