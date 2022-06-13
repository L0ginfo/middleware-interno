
/*jshint esversion: 6 */

class ManutencaoEstoquesDecrementarView{
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

    getDecrementButton(){
        return this.decrementButton;
    }

}



class ManutencaoEstoquesDecrementarModule{
    constructor(){
        this.manutencaoEstoquesView = new ManutencaoEstoquesDecrementarView();
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

        $('.decrement').click(function(event) {
           event.preventDefault();
           const value = event.target.dataset.value;
           const total = event.target.dataset.total;
           const quantity = document.querySelector(`#${value}`).value;

           if(!quantity){
                Utils.swalUtil({
                    type:'error',
                    title:`Valor da Quantidade a Remover Inválido.`,
                    timer:3000
                });

                return;
           }


           const valorQuantity = Utils.parseFloat(quantity);

           if(valorQuantity > total){

                Utils.swalUtil({
                    type:'error',
                    title:`Quantidade a Remover é superior a Quantidade Total.`,
                    timer:3000
                });

                return;

           }

           Utils.swalConfirmOrCancel({
                type:'warning',
                title:`Você realmente deseja decrementar Estoque?`,
                showConfirmButton: true,
                showCancelButton:true,
                confirmButtonText:'Decrementar'
           })
           .then((res) => {
                if(res){
                    Utils.doPost(event.target.href, [{
                        'decremento':valorQuantity
                    }]);
                }
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

window.ManutencaoEstoquesDecrementarModule = 
    ManutencaoEstoquesDecrementarModule;