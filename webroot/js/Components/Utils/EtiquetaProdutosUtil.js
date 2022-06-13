var EtiquetaProdutosUtil = {

    getEtiquetaProdutos: async function(iCodigoBarrasProduto, sFormato = null, bWithObj = true) {
        return await $.fn.doAjax({
            url: 'etiqueta-produtos/get-etiqueta-produtos',
            type: 'POST',
            data: {
                codigo_barras_produto: iCodigoBarrasProduto,
                formato: sFormato,
                with_obj: bWithObj
            }
        })
    }

}