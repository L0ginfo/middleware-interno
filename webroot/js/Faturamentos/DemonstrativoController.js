var DemonstrativoController = {

    init:function(){
        this.events();
    },

    events:function() {
        $('.selecionar-servico-bancario').change(function(){
            const iTipoServicoBancario  = $(this).val();
            const iFaturamento          = $(this).data('faturamento_id');
            
            $.fn.doAjax({
                url : 'Faturamentos/updateServicoBancario',
                type: 'POST',
                data:{
                    faturamento_id:iFaturamento,
                    tipo_servico_bancario_id:iTipoServicoBancario,
                }
            })
            .then((data) => {

                if(!data) 
                    Utils.swalUtil({
                        title:'Ops..',
                        text:'Falha na requisição.',
                        type:'error',
                        timer:3000
                    }).then(() => {
                        window.location.reload(true);
                    });

                Utils.swalUtil({
                    title: data.status == 200 ? 'Sucesso': 'Ops..',
                    text: data.message,
                    type: data.type,
                    timer:3000
                }).then(() => {
                   window.location.reload(true);
                });
            });

        })
    },

    manage(){

    }

}

$(function(){
    DemonstrativoController.init();
    console.log('entrou');
});