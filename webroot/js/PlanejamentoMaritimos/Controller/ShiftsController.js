ShiftController = {

    sShiftIndex : 'shift_index',
    sShiftEventos:'shift_eventos',
    sShiftEventosLength: 'shift_eventos_lenght',

    observers: function() {

        oSubject.setObserverOnEvent(function () {
            const eventos = oState.getState(ShiftController.sShiftEventos);
            oState.setState(ShiftController.sShiftEventosLength, eventos.length);
            oState.setState(ShiftController.sShiftIndex, eventos.length);
        }, ['on_shift_eventos_change']);

        oSubject.setObserverOnEvent(function () {
            ShiftsService.setShift();
        }, ['on_shift_index_change']);

    },

    init:function(){

        ShiftController.observers();
        ShiftsService.init();

        $('.lf-shift #shift-next').click(function(){
            ShiftsService.next();
        });

        $('.lf-shift #shift-back').click(function(){
            ShiftsService.back();
        });

        $('.lf-shift #shift-start').click(function(){
            ShiftsService.start();
        });

        $('.lf-shift #shift-end').click(function(){
            ShiftsService.end();

        });

        $('.lf-shift #shift-plus').click(function(){
            ShiftsService.add();
        });

        $('.lf-shift #shift-minus').click(function(){
            ShiftsService.remove();
        });
    }
}

ShiftController.init();
