var simpleDate = {

    dateTimeToView:function(string, divisor){
        if(!divisor) divisor = ' ';
        var dateAndTime = string.split(divisor);
        var slicesDate = dateAndTime[0].split('-');
        var slicesTime = dateAndTime[1].split(':');
        return slicesDate[2]+'/'+slicesDate[1]+'/'+slicesDate[0]+' '+
            slicesTime[0]+':'+slicesTime[1];
    },

    dateToView:function(string, divisor){
        if(!divisor) divisor = ' ';
        var dateAndTime = string.split(divisor);
        var slicesDate = dateAndTime[0].split('-');
        return slicesDate[2]+'/'+slicesDate[1]+'/'+slicesDate[0];
    },

    defaultDateTimeString:function (){
        return this.dateTimeString(new Date(), ' ');
    },

    dateTimeString:function(oDate, divisor){
        if(!(oDate instanceof Date)){
            return '';
        }
        var string = oDate.toISOString();
        return string.substring(0, string.indexOf('.')).replace('T', divisor);
    }
};