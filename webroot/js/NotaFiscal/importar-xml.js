var form = document.getElementById("formulario");

form.onsubmit = function (e) {
    $('.ajaxloader').fadeIn(); 
    // stop the regular form submission
    e.preventDefault();
    var formData = new FormData(form);
    $.ajax ({ 
        url: webroot + 'NotaFiscal/importar', 
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        async: false
    }).done(function (result) {
        if (result == "erro xml") {
            alert("Não foi possível importar: Arquivo inválido \nSelecione um arquivo XML");
            location.reload();
        }
        if (result == "desvinculada") {
            alert("Não foi possível importar: Você não tem vinculo com esta empresa \nFavor solicitar cadastro para cadastro@barradorio.com.br");
            location.reload();
        }
        if (result == "existe") {
            alert("Não foi possível importar: Essa Nota Fiscal já existe \nPara importar remova a existente se possível");
            location.reload();
        }
        var resultado = JSON.parse(result);
        document.getElementById('numero-documento').value = resultado.result.NFe.infNFe.ide.nNF;           
        document.getElementById('modelo').value           = resultado.result.NFe.infNFe.ide.mod;           
        document.getElementById('serie').value            = resultado.result.NFe.infNFe.ide.serie;           
        document.getElementById('empresa-id').value       = resultado.result.NFe.infNFe.empresaId;
        document.getElementById('uf').value               = resultado.result.NFe.infNFe.emit.enderEmit.UF;
        document.getElementById('data-emissao').value     = resultado.result.NFe.infNFe.ide.dhEmi;
        document.getElementById('valor-total').value      = resultado.result.NFe.infNFe.total.ICMSTot.vNF;
        document.getElementById('volume-total').value     = resultado.result.NFe.infNFe.transp.vol.qVol;
        document.getElementById('peso-bruto').value       = resultado.result.NFe.infNFe.transp.vol.pesoB;
        document.getElementById('peso-liquido').value     = resultado.result.NFe.infNFe.transp.vol.pesoL;
        document.getElementById('itens-nota').value       = JSON.stringify(resultado.result.NFe.infNFe.det);
        document.getElementById('anexo').value            = resultado.result.arquivo;
        $('.ajaxloader').fadeOut(); 
    });
};
