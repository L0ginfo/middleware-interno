var oState = {
    setState: function(sVarName, uValue){
        var uOldValue = oState[sVarName];
        var sEvent = 'on_' + sVarName + '_change';
        oState[sVarName] = uValue;

        if (typeof oSubject.observersEvents()[sEvent] !== 'undefined'){
            oSubject.notifyAll(sEvent);
        }
        else{
            oSubject.setEvents(sEvent, function(){
                oSubject.notifyAll(sEvent);
            });
        }
    },
    getState: function(sVarName) {
        return oState[sVarName];
    }
}
