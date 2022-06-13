class ManutencaoEstoquesMovimentarFracaoView {
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
        return this.nf;
    }

    getAlterarStatusButton(){
        return this.alterarStatusButton;
    }
}

export default class ManutencaoEstoquesMovimentarFracaoModule {
    constructor(){
        this.manutencaoEstoquesView = new ManutencaoEstoquesMovimentarFracaoView();
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
    }
    changeEndereco(){
        $('body').on('click', '.modal:visible .change-endereco', function(){
            var $modal = $('.modal:visible');
            var $area = $modal.find('select[name="busca-endereco[area]"] option:selected');
            var $endereco = $modal.find('select[name="busca-endereco[endereco]"] option:selected');

            if($endereco.val()) {
                var $button = $('button[data-target="#' + $modal.attr('id') + '"]');
                $button.parent().find('input[name="endereco"]').val($endereco.val())
                $button.removeClass('btn btn-default').addClass('btn-link').html('<span class="glyphicon glyphicon-edit"></span>');
                $button.parent().find('.endereco_destino').html($area.text() + ' ~ ' + $endereco.text());

                $modal.modal('hide');
            }
        })
    }
    addEventLisnerMovimentar() {
        $('.movimentar').click(function (e) {
            e.preventDefault();
            var row = $(this).eq(0).closest('tr');
            var oData = {
                'status_novo': row.find('select[name="status_novo"] option:selected').val(),
                'qtd_mover': row.find('input[name="qtd_mover"]').val(),
                'endereco': row.find('input[name="endereco"]').val(),
                'divide_reserva': row.find('select[name="divide_reserva"] option:selected').val(),
            }

            if(oData.status_novo, oData.qtd_mover, parseFloat(oData.qtd_mover) > 0, oData.endereco) {
                Utils.swalConfirmOrCancel({
                    type: 'warning',
                    title: 'Você realmente deseja Movimentar essa quantidade?',
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Movimentar!'
                })
                .then((res) => {
                    if (res) {
                        Utils.doPost(e.target.href, [oData]);
                    }
                    return false;
                });
            }

        });
    }
    changeQtdMover() {
        $('input[name="qtd_mover"]').on('change keyup page', function(e){
            if(e.keyCode != 8 && e.keyCode != 46) {
                var val = parseFloat($(this).val().replace(',','.')).toFixed(3);
                var max = parseFloat($(this).attr('max')).toFixed(3);

                if(val <= 0){
                    $(this).val(0);
                }
                else if(parseFloat(val) > parseFloat(max)) {
                    console.log('ok')
                    $(this).val(max);
                }
            }
        })

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
    init() {
        EnderecoUtil.watchChanges('local')
        EnderecoUtil.watchChanges('area')
        this.changeEndereco()
        this.addEventLisnerMovimentar()
        this.changeQtdMover()
        this.addEventLisner()
    }
}
