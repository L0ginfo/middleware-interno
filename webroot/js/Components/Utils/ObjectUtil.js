var ObjectUtil = {

    /**
     * Retorna na profundidade exata, de forma aninhada 
     * o valor dessa posição
     * 
     * @param {*} o Object
     * @param {*} s Caminho a trilhar ex: array[2].name.location[0].city
     */
    getDepth: function(o, s) {
        s = s.replace(/\[(\w+)\]/g, '.$1') // convert indexes to properties
        s = s.replace(/^\./, '')           // strip a leading dot
        var a = s.split('.')
        
        for (var i = 0, n = a.length; i < n; ++i) {
            var k = a[i]

            if (!o)
                return;

            if (k in o) {
                o = o[k]
            } else {
                return
            }
        }
        return o 
    },

    isset: function(uVar) {
        if (typeof uVar === 'undefined')
            return false

        return true
    },

    issetProperty: function(obj, prop) {
        if (!obj)
            return false

        function hasOwnProperty(obj, prop) {
            var proto = obj.__proto__ || obj.constructor.prototype;
            return (prop in obj) &&
                (!(prop in proto) || proto[prop] !== obj[prop]);
        }
        
        if ( Object.prototype.hasOwnProperty ) {
            var hasOwnProperty = function(obj, prop) {
                return obj.hasOwnProperty(prop);
            }
        }

        return hasOwnProperty(obj, prop)
    },

    getResponse: function(uVar) {
        var oResponse = new window.ResponseUtil()

        if (typeof uVar === 'undefined')
            return oResponse.setMessage('Not Found')

        return oResponse.setStatus(200)
    }
}