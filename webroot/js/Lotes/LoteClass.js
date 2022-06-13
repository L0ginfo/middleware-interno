const LoteClass = {

    init: async function() {

        this.watchClickTab();

        setTimeout(async function(){
            $("#Carga a").tab('show');
            $('#Carga').trigger('click');
        }, 200);
    },

    watchClickTab: async function() {

        $('.nav-tabs > li').click(async function(e) {

            if ($(this).hasClass('watched')) {
                return
            }

            $(this).addClass('watched');

            let parsed = (url) => {
                let urlParsed = new URL(url)
                return urlParsed.pathname.substring(15)
            }

            var oResponse = await $.fn.doAjax({
                showLoad: false,
                url: 'lotes/loteServices/' + $(this).attr('id') + '/' + parsed(window.location.href),
                type: 'GET'
            });   

            await ManageFrontend.render($(this).attr('id'), oResponse);

            return oResponse;

        })

    },

}