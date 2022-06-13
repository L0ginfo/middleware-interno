$(document).ready(function(){
    function ltrim(char, str) {
        if (str.slice(0, char.length) === char)
            return ltrim(char, str.slice(char.length));

        return str;
    }

    function rtrim(char, str) {
        if (char && str && str.slice(str.length - char.length) === char)
            return rtrim(char, str.slice(0, 0 - char.length));

        return str;
    }

    function validateRoute(sType, sString) {
        if(sType === '{string}') {
            return (sString >= 0 || sString < 0) ? false : true;
        }
        else if(sType === '{integer}') {
            return (sString >= 0 || sString < 0) ? true : false;
        }
        else if(sType === sString) {
            return true;
        }

        return false;
    }

    oColetorApp.core.getRoute = function(sCurrentRoute) {

        if (!sCurrentRoute) {
            sCurrentRoute = window.location.pathname;
        }
        
        
        sCurrentRoute = ltrim('/', rtrim('/', sCurrentRoute)).split("/");
        
        for (var route in oColetorApp.oRoutes) {
            var sRoute = ltrim('/', rtrim('/', oColetorApp.oRoutes[route].url)).split("/");
            var bMatched = false;

            if(sRoute.length === sCurrentRoute.length){
                for (var index = 0; index < sRoute.length; index++) {
                    if(!validateRoute(sRoute[index], sCurrentRoute[index])){
                        bMatched = false;
                        break;
                    }

                    bMatched = true;
                }
            }

            if(bMatched){
                return oColetorApp.oRoutes[route];
            }
        }
    }

    oColetorApp.core.renderRoute = function(oRoute) {

        if(oRoute === undefined) {
            console.log('Page 404');
        }
        else {
            
            $('.lf-pages > div').fadeOut('fast');
            $('#' + oRoute.id).fadeIn('slow');

            // $('.lf-pages > div').hide();
            // $('#' + oRoute.id).show();
        }
    }

    var bButtonActive = false;

    oColetorApp.core.goToNextRoute = function(sHref){
        if(!bButtonActive) {
            bButtonActive = true;
            var sNewLink = rtrim('/', sHref);
            var sCurrentLink = rtrim('/', window.location.pathname);

            if(sNewLink !== sCurrentLink) {
                var aReferrer = oColetorApp.oUrl.aReferrer;


                if(aReferrer.indexOf(sCurrentLink) === -1) {
                    if(sCurrentLink.indexOf('menu') === -1) {
                        aReferrer.push(sCurrentLink);
                    }

                    if(aReferrer.length) {
                        var sOldLink = rtrim('/', aReferrer[aReferrer.length-1]);
                        $('.btn-back').attr('href', sOldLink);
                    }
                }

                history.pushState({page: 1}, "title 1", sNewLink);
                oColetorApp.core.renderRoute(oColetorApp.core.getRoute());
            }

            setTimeout(function() {
                bButtonActive = false;
            }, 500);
        }
    }

    oColetorApp.core.goToBackRoute = function(){
        if(!bButtonActive) {
            bButtonActive = true;
            var sNewLink = $('a.btn-back').attr('href');
            var aReferrer = oColetorApp.oUrl.aReferrer;

            if(aReferrer.length) {
                history.pushState({page: 1}, "title 1", sNewLink);
                aReferrer.pop();
                var sLinktoBack =  aReferrer[aReferrer.length-1];
                var sLinktoBack = rtrim('/', aReferrer[aReferrer.length-1]);
                $('.btn-back').attr('href', sLinktoBack);
                oColetorApp.core.renderRoute(oColetorApp.core.getRoute());
            }

            setTimeout(function() {
                bButtonActive = false;
            }, 500);
        }
    }

    oColetorApp.core.router = function(routes){

        if(!routes){
            routes = [];
        }

        if(!Array.isArray(routes)){
            console.log('Routes is not array.');
        }

        if(routes.length == 0){
            oColetorApp.core.goToNextRoute(webroot);
        }

        oColetorApp.core.goToNextRoute(webroot+'/'+routes.join('/'));
    }


    $('#coletor-app').on('click', 'a.btn-back', function(e){
        e.preventDefault();
        oColetorApp.core.goToBackRoute();
    })
    $('#coletor-app').on('submit', 'form.lf-route', function(e){
        e.preventDefault();
        oColetorApp.core.goToNextRoute($(this).attr('action'));
    })
    $('#coletor-app').on('click', 'a.lf-route', function(e){
        e.preventDefault();
        oColetorApp.core.goToNextRoute($(this).attr('href'));
    })

    var aReferrer = oColetorApp.oUrl.aReferrer;

    var data = {
        action: "index",
        controller: "MenuContoller",
        id: "menu",
        url: "/coletores/coletor-maritimo"
    };

    oColetorApp.core.renderRoute(oColetorApp.core.getRoute());
 
    $('.btn-back').attr('href', aReferrer[aReferrer.length-1]);
})
