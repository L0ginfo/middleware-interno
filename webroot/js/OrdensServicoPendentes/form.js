aAssoc = (typeof aAssoc === "undefined") ? new Array() : aAssoc
aAssocMerc = (typeof aAssocMerc === "undefined") ? new Array() : aAssocMerc
aMercs = (typeof aMercs === "undefined") ? new Array() : aMercs

Loader.showLoad();

console.log('nao entro no processamento')

var OperacaoDescargaFunc =  function () {
    console.log('entro no processamento')
    
    Form.init('master')
    Form.init('house')
    
    Loader.showLoad();
    
    Form.refreshAll()
    
    updateHeigth()
    
    EntradasFisicas.init()
}

$(window).load(function() {
    OperacaoDescargaFunc()
})

//ajuste mobile
$(window).resize(async function() {
    Utils.updateHeightBasedElement($('.entradas-fisicas.watched.active'), $('.os-estoque'), 120, 0, EntradasFisicas.casesToUpdateHeigth())
    $('.entradas.side').height(1090)
})
$(window).scroll(async function() {
    $('.entradas.side').height(1090)
})
$(window).load(async function() {
    $('.entradas.side').height(1090)
})

$('.btn-toggle-fullwidth').click(function () {
    Form.refreshAll(330)
})

$('.btn-toggle-fullwidth').click()
