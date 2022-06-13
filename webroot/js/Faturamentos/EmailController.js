var EmailController = {

    init:function(){
        this.events();
    },

    events:function() {
        $('.lf-pdf-email').click(function(){
            const iLiberacao = $(this).data('liberacao');
            const iFaturamento = $(this).data('faturamento');
            const sEmail = $(this).data('email');
            const iVia = $(this).data('via');
            const sClassVia = iVia ? '' : 'hidden';

            Swal.fire({
                title: 'Enviar por E-mail',
                html:`
                    <div>
                        <label>Emails, por favor separar por virgula os emails.</label>
                        <input name="faturamento-email" class="swal2-input faturamento-email">
                    </div>

                    <div class="${sClassVia}">
                        label for="">Selecione a via ser enviada.</label>
                        <div style="display: flex; justify-content: space-evenly;">
                            <div>
                                <label>1ª via</label>
                                <input name="faturamento-via" class="swal2-input faturamento-via" type="radio" value="1" checked="checked">
                            </div>
                            <div>
                                <label>2ª via</label>
                                <input name="faturamento-via" class="swal2-input faturamento-via" type="radio" value="2">
                            </div>
                        </div>
                    </div>
                `,

                showCancelButton: true,
                confirmButtonText:'Enviar',
                cancelButtonText:'Cancelar',
                confirmButtonColor: '#41B314',
                cancelButtonColor: '#d9534f',
                preConfirm: () => {
                    const sEmails =$('.faturamento-email').val();
                    const sVia = $('.faturamento-via:checked').val();

                    if (sEmails) {
                        return {via:sVia, emails:sEmails};
                    }

                    Swal.showValidationMessage('por favor, digite um email.');
                }
            }).then((data) => {
                const values = data.value;
                if(!values) return false;

                const sEmails   = values.emails;
                const iVia      = values.via ? values.via :1;

                console.log(sEmails);

                if(sEmails){

                    $.fn.doAjax({
                        url : 'Faturamentos/sendEmail',
                        type: 'POST',
                        data:{
                            via:iVia,
                            emails:sEmails,
                            liberacao:iLiberacao,
                            faturamento:iFaturamento
                        }
                    })
                    .then((data) => {

                        if(!data) Utils.swalUtil({
                            title:'Ops..',
                            text:'Falha na requisição.',
                            type:'error',
                            timer:3000
                        });

                        Utils.swalUtil({
                            title: data.status == 200 ? 'Sucesso': 'Ops..',
                            text: data.message,
                            type: data.type,
                            timer:3000
                        });

                    });
                }
                
            });

        })
    },

    manage(){

    }

}


$(function(){
    EmailController.init();
});