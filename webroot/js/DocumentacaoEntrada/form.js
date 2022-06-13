aAssoc = (typeof aAssoc === "undefined") ? new Array() : aAssoc
aAssocMerc = (typeof aAssocMerc === "undefined") ? new Array() : aAssocMerc
aMercs = (typeof aMercs === "undefined") ? new Array() : aMercs
aAssocContainer = (typeof aAssocContainer === "undefined") ? new Array() : aAssocContainer
aAssocLacre = (typeof aAssocLacre === "undefined") ? new Array() : aAssocLacre

Loader.showLoad();

var fManageAllInits = async function () {
    Form.validaQtdeMinimaItem()
    Form.validaProdutoIdOnNf()
    Form.findUnidadeMedidaByProduto()
    Form.saveControleEspecificosInDocMercadoria()
    
    Form.init('master')
    Form.init('house')
    Form.refreshAll()
    
    updateHeigth()

    await Loader.hideLoad(1000);

    Form.watchShowBsSelect()

    $('.btn-toggle-fullwidth').click(function () {
        Form.refreshAll(330)
    })
}

$(window).load(fManageAllInits)

    