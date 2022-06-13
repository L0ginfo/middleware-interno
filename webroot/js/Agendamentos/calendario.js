$('#calendar').fullCalendar({
    schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
    aspectRatio: 1.8,
    editable: false,
    scrollTime: $('#hora_inicio').val(),
    navLinks: true,
    slotWidth: 100,
    defaultDate: moment($("#data_pesquisa_frm").val()),
    header: {
        left: 'title operacoesButton',
        center: '',
        right: 'today timelineTenDay month prev,next',
        //right: 'today prev,next'
    },
    height: 450,
    views: {
        today: {
            type: 'timeline',
            slotDuration: $('#intervalo').val(),
            slotLabelInterval: $('#intervalo').val(),
        },
        timelineTenDay: {
            type: 'timeline',
            slotDuration: '02:00',
            slotLabelInterval: "2:00",
            duration: {days: 10}
        },
    },
    defaultView: 'today',
    events: webroot + 'agendamentos/get-data/' + $('#operacao').val(),
    resources: webroot + 'agendamentos/get-Operacoes/' + $('#operacao').val(),
    resourceAreaWidth: '20%',
    slotLabelFormat: [
        'D MMM dd', // top level of text
        'H:mm'        // lower level of text
    ],
    eventOverlap: false,
    resourceLabelText: 'Agendamento',
    eventClick: function (call, jsEvent, view) {
        // console.log(call)
        $('.ajaxloader').fadeIn();
        
        switch (call.tag) {
            case 'sem_acao':
                alert('Bloqueado para agendamento');
                break;
            case 'Livre':
                $.ajax({
					cache: false,
                    url: webroot + 'agendamentos/agendarLivre/'+ call.operacao_documento_id,
                    type: "post",
                    data: { 
                        operacao_doc:  call.operacao_documento_id,
                        horario_id: call.horario_id,
                        horario_lib_id: call.horario_liberado_id,
                        operacao_id: call.operacao_id,
                        data_ini: call.data_inicio,
                        hora: call.hora +'_'+call.minuto
                    },
                    success: function (data) {
                        $('.ajaxloader').fadeOut();
                        var retorno_url = JSON.parse(data);
                        
                        if (retorno_url[0]['error'] == '1') {
                            alert(retorno_url[0]['msgError']);
                            location.reload();
                        } else {
                            window.location = webroot + retorno_url[0]['url'];
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('.ajaxloader').fadeOut();
                        alert('Erro! ' + errorThrown);
                    }
                });

                /* 
                if (call.operacao_documento_id == 1)
                 window.location = webroot + 'agendamentos/agendar/1/0/' + call.horario_id + '/' + call.horario_liberado_id + '/' + call.operacao_id + '/' + call.data_inicio + '/' + call.hora + ':' + call.minuto;
                if (call.operacao_documento_id == 2)
                 window.location = webroot + 'agendamentos/agendarCarga/1/0/' + call.horario_id + '/' + call.horario_liberado_id + '/' + call.operacao_id + '/' + call.data_inicio + '/' + call.hora + ':' + call.minuto;
                */

                break;
            case 'Editar_desbloqueio':
                $.ajax({
                    url: webroot + 'horarioLiberados/edit/' + call.horario_liberado_id + '/' + call.horario_id + '/' + call.data_inicio + '/' + call.hora + ':' + call.minuto,
                    type: "post",
                    success: function (data) {
                        $('.ajaxloader').fadeOut();
                        $.fancybox({
                            content: data,
                            autoSize: false,
                            width: '800px',
                            height: 'auto'
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Erro! ' + errorThrown);
                        location.reload();
                    }
                });
                break;
            case 'Desbloquear':
                $.ajax({
                    url: webroot + 'horarioLiberados/edit/0/' + call.horario_id + '/' + call.data_inicio + '/' + call.hora + ':' + call.minuto,
                    type: "post",
                    success: function (data) {
                        $('.ajaxloader').fadeOut();
                        $.fancybox({
                            content: data,
                            autoSize: false,
                            width: '800px',
                            height: 'auto'
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Erro! ' + errorThrown);
                        location.reload();
                    }
                });
                break;
            default:
                $.ajax({
                    url: webroot + 'agendamentos/calendarioProgramacao/' + call.id,
                    type: "post",
                    success: function (data) {
                        $('.ajaxloader').fadeOut();
                        $.fancybox({
                            content: data,
                            autoSize: false,
                            width: '800px',
                            height: 'auto'
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('.ajaxloader').fadeOut();
                        alert('Erro! ' + errorThrown);
                        location.reload();
                    }
                });
                break;
        }
    },
    
    dayClick: function (date, jsEvent, view, resource) {
        if (view.type != 'today') {
            $("#calendar").fullCalendar('changeView', 'today');
            $("#calendar").fullCalendar('gotoDate', date);
        } else {
            if (jsEvent.target.classList.contains('fc-bgevent')) {
                console.log(date.format());
                console.log(resource);
            }

            /* 
            if (jsEvent.target.classList.contains('fc-bgevent')) {
            d = date
            mes = (parseInt(d._i[1]) + 1)
            dia = parseInt(d._i[2]) < 10 ? '0' + d._i[2] : d._i[2]
            mes = mes < 10 ? '0' + mes : mes
            data_inicio = dia + '-' + mes + '-' + d._i[0]
            hora = parseInt(d._i[3]) < 10 ? '0' + d._i[3] : d._i[3]
            minuto = parseInt(d._i[4]) < 10 ? '0' + d._i[4] : d._i[4]
            console.log(resource);
            }
            */
        }
    },
    
    eventRender: function (event, element) {
        // console.log(event);   
        // console.log(element)
        // element.find('span.fc-title').prepend('<span class="' + event.icon + '"></span> ')
        element.find('div.fc-content').attr('title', event.title);
        element.find('div.fc-content').html('<span class="' + event.icon + '"></span> ' + event.descricao + ' ' + event.icon_status + ' ');
    },
    
    resourceRender: function (resourceObj, labelTds, bodyTds) {
        //   console.log(resourceObj.cor)
        labelTds.css('background', resourceObj.cor);
    }
});

var data_pesquisa = $("#data_pesquisa").val().replace('-', '/').replace('-', '/');
$("#data_pesquisa").val(data_pesquisa);

$('#operacao').change(function () {
    var id = $("#operacao option:selected").val();
    var data_pesquisa = $("#data_pesquisa").val().replace('/', '-').replace('/', '-');
    window.location = webroot + 'agendamentos/calendario/' + id + '/' + data_pesquisa;
});

$('#data_pesquisa').change(function () {
    var data = $("#data_pesquisa").val();
    atualizarCalendario(data);
});

function atualizarCalendario(data) {
    var array = data.split('/');
    if (array.length == 3) {
        array.reverse();
        var data_pesquisa = array.join('-');
        $("#calendar").fullCalendar('gotoDate', data_pesquisa);
    }
}