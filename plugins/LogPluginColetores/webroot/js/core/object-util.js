ObjectUtil = {
    getDepth: function(o, s) {        
        try {

            var a = s.split('.');
            
            for (var i = 0, n = a.length; i < n; ++i) {
                var k = a[i];
                if (k in o) {
                    o = o[k];
                } else {
                    return null;
                }
            }
            return o; 
            
        } catch (error) {

            return null;
        }
        
    }
}