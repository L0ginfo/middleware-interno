ShiftsService = {

    sShitUrl: '',
    sShiftDeleteUrl:'',

    init:function(){
        ShiftsService.sShitUrl = $('[name ="planejamento_maritimo_mudanca_id"]').data('url');
        ShiftsService.sShiftDeleteUrl = $('[name ="planejamento_maritimo_mudanca_id"]').data('urlDelete');
        ShiftsService.get();
    },

    get:function(){

        $.fn.doAjax({
            url :  ShiftsService.sShitUrl,
            type: 'GET'
        })
        .then((data) => {

            if(data.status == 200){ 
                return ShiftsService.setShifts(data.dataExtra);
            }
            
            Swal.fire({
                type:'error',
                title:'Ops',
                text:data.message,
                timer:2000
            });
        });
    },

    next:function(){

        const length = oState.getState(ShiftController.sShiftEventosLength);
        let index = oState.getState(ShiftController.sShiftIndex);
        index++;

        if(index > length){
            return ShiftsService.setShift();
        }
        
        oState.setState(ShiftController.sShiftIndex, index);
    },
    back:function(){

        const length = oState.getState(ShiftController.sShiftEventosLength);
        let index = oState.getState(ShiftController.sShiftIndex);
        index--;

        if(index < 1 || length < 1 ){
            return ShiftsService.setShift();
        }
        
        oState.setState(ShiftController.sShiftIndex, index);
    },

    start:function(){

        const length = oState.getState(ShiftController.sShiftEventosLength);

        if(length < 1){
            return ShiftsService.setShift();
        }

        oState.setState(ShiftController.sShiftIndex, 1);
    },
    end:function(){
        const length = oState.getState(ShiftController.sShiftEventosLength);

        if(length < 1){
            return ShiftsService.setShift();
        }
        
        oState.setState(ShiftController.sShiftIndex, length);

    },

    add:function(){

        const length = oState.getState(ShiftController.sShiftEventosLength);

        if(length < 1 ){
            return ShiftsService.setShift();
        }

        oState.setState(ShiftController.sShiftIndex, (length+1));
    },

    remove:function(){
        const index = oState.getState(ShiftController.sShiftIndex);
        const eventos = oState.getState(ShiftController.sShiftEventos);
        const evento = eventos[(index-1)];

        if(eventos.length < index ){
            return ShiftsService.back();
        }

        if(!evento){
            return ShiftsService.setShift();
        }

        $.fn.doAjax({
            url : ShiftsService.sShiftDeleteUrl,
            type: 'POST',
            data:evento
        })
        .then((data) => {

            if(data.status == 200){ 
                return ShiftsService.setShifts(data.dataExtra);
            }
            
            Swal.fire({
                type:'error',
                title:'Ops',
                text:data.message,
                timer:2000
            });
        });

    },

    setShift:function(){

        const index = oState.getState(ShiftController.sShiftIndex);
        const eventos = oState.getState(ShiftController.sShiftEventos);
        const evento = eventos[(index-1)];

        $('#label-total').html(`Total ${index}\\${eventos.length}`);
        
        ShiftsService.clearInputs();

        if(!index || index < 1){
            return;
        }

        if(!evento && eventos.length < index){
            return;
        }


        if(evento && evento.hasOwnProperty('id')){
            let option = '';

            if(evento.berco_id){
                option = `<option selected="selected" value="${evento.berco_id}">
                    ${evento.berco.codigo} - ${evento.berco.descricao}</option>`;
            }

            $('[name ="planejamento_maritimo_mudanca_id"]').val(evento.id);
            $('[name ="shift_fwd"]').val(Utils.showFormatFloat(evento.fwd, 3));
            $('[name ="shift_aft"]').val(Utils.showFormatFloat(evento.aft, 3));
            $('[name ="shift_ifo"]').val(Utils.showFormatFloat(evento.ifo, 3));
            $('[name ="shift_mdo"]').val(Utils.showFormatFloat(evento.mdo, 3));
            $('[name ="shift_fw"]').val(Utils.showFormatFloat(evento.fw, 3));
            $('[name ="shift_berco_id"]').html(option).selectpicker('refresh');

            evento.planejamento_maritimo_evento_mudancas.forEach((event, index) => {
                $(`#data-shift-evento-id-${event.evento_id}`).val(ShiftsService.date(event.data_hora));
            });
        }
   
    },

    setShifts:function(data){
        oState.setState(ShiftController.sShiftEventos, data);
    },

    clearInputs:function(){

        $('.lf-shift input').each(function(index, element) {
            $( this ).val('');
        });

        $('.lf-shift .selectpicker')
            .html('')
            .selectpicker('refresh');

        $('.lf-shift .block-body-2 input:first').focus();
    },


    date :function(string, format = 'y-m-dTh:i'){

        if(!string){
            return string;
        }
       
        const daTeAndTime = string.split('T');
        const timeAndFuso = daTeAndTime[1].split('-');
        const date = daTeAndTime[0].split('-');
        const time = timeAndFuso[0].split(':');

        const datetime = format
            .replace('y', date[0])
            .replace('m', date[1])
            .replace('d', date[2])
            .replace('h', time[0])
            .replace('i', time[1])
            .replace('s', time[2]);

        return datetime;
    },
}

