simpleNumber = {
    format: function (number, precision, decimal, thousand) {
        precision = isNaN(precision = Math.abs(precision)) ? 2 : precision;
        decimal =  !decimal ? "." : decimal;
        thousand =  !thousand  ? "," : thousand;

        var sign = number < 0 ? "-" : "";
        var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(precision)));
        var j = (j = i.length) > 3 ? j % 3 : 0;
        
        return sign +
            (j ? i.substr(0, j) + thousand : "") +
            i.substr(j).replace(/(\decimal{3})(?=\decimal)/g, "$1" + thousand) +
            (precision ? decimal + Math.abs(number - i).toFixed(precision).slice(2) : "");
    },

    formatPtBr:function(string, precision){      
        return simpleNumber.format(string, precision, ',', '.');
    },
    parseFloat: function(num) {

        num = (typeof num == 'undefined') ? 0 : num

        try {
            if (num.toString().indexOf(',') == -1)
                num = parseFloat(num);
            else
                num = parseFloat(num.split('.').join('').replace(',', '.'))
        } catch (error) {
            return 0;
        }

        return num;
    },
}