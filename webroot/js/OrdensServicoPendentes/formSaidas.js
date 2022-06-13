jQuery(function ($) {
    aAssoc = (typeof aAssoc === "undefined") ? new Array() : aAssoc
    aAssocMerc = (typeof aAssocMerc === "undefined") ? new Array() : aAssocMerc
    aMercs = (typeof aMercs === "undefined") ? new Array() : aMercs
    
    $(document).ready(function() {
        setTimeout(function() {
            Loader.showLoad()
        }, 1600)
    })

    $(window).load(async function () {

        Saidas.init()
        Form.refreshAll()
        
        updateHeigth()

        Loader.hideLoad(3200)

        setInterval(function() {
            $(window).resize()
        }, 1000)  
    })

    $('.btn-toggle-fullwidth').click(function () {
        Form.refreshAll(330)
    })

    $('.btn-toggle-fullwidth').click()
    
})