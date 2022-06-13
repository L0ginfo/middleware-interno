
var doJson = {

    tryParseJSON: function(jsonString){
        try {
            var o = JSON.parse(jsonString);
            if (o && typeof o === "object") {
                return o;
            }
            return false;
        }
        catch (e) { 
            return false;
        }
    },

    tryStringfy: function(oData){
        try {
            return JSON.stringify(oData);
        }
        catch (e) { 
            return false;
        }
    },


};