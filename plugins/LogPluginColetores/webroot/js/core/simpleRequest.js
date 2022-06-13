var simpleRequest = {
    doAjax: function(oRequest, _callback, _error) {
        $.ajax({
            url:  oRequest.url,
            type: oRequest.type,
            headers: oRequest.headers,
            data:oRequest.data,
            success:function (params) {
                _callback(params);
            },
            error : function (request, status, error) {
                _error(request);
            }
        }); 
    },

    ajax: function(oRequest) {
        return $.ajax({
            url:  oRequest.url,
            type: oRequest.type,
            headers: oRequest.headers,
            data:oRequest.data
        });
    }
};
