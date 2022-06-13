$(function(){
    $('#equipes-trabalhos').click(function(event){
        event.preventDefault();
        Swal.fire({
            title: 'Cadastro de Equipe',
            text:'Digite a descrição da equipe.',
            input: 'text',
            showCancelButton: true,
            inputValidator: (value) => {
                console.log(value)

                if (!value) {
                    return 'Por favor, digite a descrição da equipe para adicioná-la.';
                }
            }
        }).then(res =>{
            if(res.dismiss){
                return;
            }
            location.href = this.getAttribute("href")+"&is_new=true&descricao="+res.value;
        });
    });
})