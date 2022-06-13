var simpleRules = {

    init:function(string, oTree){

        if(!oTree.hasOwnProperty('rule')){
            return string;
        }

        if(oTree.rule.type == 'custom'){
            return oTree.rule.customRule(string, oTree);
        }

        return simpleRules[oTree.rule.type](string, oTree);

    },


    date :function(string, oTree){

        if(!string){
            return string;
        }
        
        if(!oTree.rule.format){
            return string;
        }

        if(!oTree.rule.divider){
            oTree.divider = ' ';
        }

        var format = oTree.rule.format;
        var daTeAndTime = string.split(oTree.rule.divider);
        var timeAndFuso = daTeAndTime[1].split('-');
        var date = daTeAndTime[0].split('-');
        var time = timeAndFuso[0].split(':');

        return format
            .replace('y', date[0])
            .replace('m', date[1])
            .replace('d', date[2])
            .replace('h', time[0])
            .replace('i', time[1])
            .replace('s', time[2]);
    },
    dateAsDate:function(string, oTree){

        if(!string){
            return string;
        }
        
        if(!oTree.rule.format){
            return string;
        }

        if(!oTree.rule.divider){
            oTree.divider = ' ';
        }

        var format = oTree.rule.format;
        var dateAndTime = string.split(oTree.rule.divider);
        var timeAndFuso = dateAndTime[1].split('-');
        var date = dateAndTime[0].split('-');
        var time = timeAndFuso[0].split(':');
        var oDate = new Date(date.join('/')+' '+time.join(':'));

        return format
            .replace('y', oDate.getFullYear())
            .replace('m', oDate.getMonth().toString().padStart(2, '0'))
            .replace('d', oDate.getDate().toString().padStart(2, '0'))
            .replace('h', oDate.getHours().toString().padStart(2, '0'))
            .replace('i', oDate.getMinutes().toString().padStart(2, '0'))
            .replace('s', oDate.getSeconds().toString().padStart(2, '0'));

    },

    float:function(string, oTree){      
        //return simpleNumber.format(string,  oTree.rule.precision, oTree.rule.decimal, oTree.rule.thousand);
        return string;
    },

    floatPtBr:function(string, oTree){      
        return simpleNumber.format(string, oTree.rule.precision, ',', '.');
        // return string;
    }
};