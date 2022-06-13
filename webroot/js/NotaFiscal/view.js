jQuery(function ($) {

    $(document).ready(function () {
        var link = $('#redireciona_agendamento').val();

        if (link)
            swal({
                title: "Deseja ir para o agendamento?",
                text: "Escolha uma opção",
                type: "info",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Sim",
                cancelButtonText: "Não",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                    swal.close();
                }
            });
    });

});