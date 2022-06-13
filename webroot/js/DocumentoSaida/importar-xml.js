var form = document.getElementById("formulario");

form.onsubmit = function (e) {
    $('.ajaxloader').fadeIn(); 
    // stop the regular form submission
    e.preventDefault();
    var formData = new FormData(form);
    $.ajax ({ 
        url: webroot + 'DocumentoSaida/importar', 
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        async: false
    }).done(function (result) {
        var resultado = JSON.parse(result);

        if (resultado.result == "erro xml") {
            alert("O arquivo seleciona não é um arquivo .XML, favor selecionar um arquivo .XML");
        } else if (resultado.result == "erro tipo") {
            alert("Selecione o tipo do arquivo XML");
        } else {
            if (resultado.tipo == "XML de DI") {
                document.getElementById('doc-saida').value          = resultado.result.declaracaoImportacao.adicao.numeroDI;
                document.getElementById('data-registro').value      = resultado.result.declaracaoImportacao.dataRegistro;
                document.getElementById('quantidade').value         = resultado.result.declaracaoImportacao.embalagem.quantidadeVolume;
                document.getElementById('peso-bruto').value         = resultado.result.declaracaoImportacao.cargaPesoBruto;
                document.getElementById('peso-liq').value           = resultado.result.declaracaoImportacao.cargaPesoLiquido;
                document.getElementById('adicao').value             = resultado.result.declaracaoImportacao.adicao.numeroAdicao;
                document.getElementById('nome_adquirente').value    = resultado.result.declaracaoImportacao.caracterizacaoOperacaoNome;
                document.getElementById('cnpjadquirente').value     = resultado.result.declaracaoImportacao.caracterizacaoOperacaoNumero;
                document.getElementById('nome_cliente').value       = resultado.result.declaracaoImportacao.importadorNome;
                document.getElementById('cnpjcliente').value        = resultado.result.declaracaoImportacao.importadorNumero;
                document.getElementById('nome_representante').value = resultado.result.declaracaoImportacao.importadorNomeRepresentanteLegal;
                document.getElementById('cpfrepresentante').value   = resultado.result.declaracaoImportacao.importadorCpfRepresentanteLegal;
                document.getElementById('valor-fob').value          = resultado.result.declaracaoImportacao.localEmbarqueTotalDolares;
                document.getElementById('moeda-id-frete').value     = resultado.result.declaracaoImportacao.freteMoedaNegociadaCodigo;
                document.getElementById('valor-frete').value        = resultado.result.declaracaoImportacao.adicao.freteValorMoedaNegociada;
                document.getElementById('moeda-id-seguro').value    = resultado.result.declaracaoImportacao.seguroMoedaNegociadaCodigo;
                document.getElementById('valor-seguro').value       = resultado.result.declaracaoImportacao.seguroTotalMoedaNegociada;
                document.getElementById('valor-cif').value          = resultado.result.declaracaoImportacao.localDescargaTotalDolares;
                document.getElementById('valor-cif-reais').value    = resultado.result.declaracaoImportacao.localDescargaTotalReais;
                document.getElementById('embalagem-id').value       = resultado.result.declaracaoImportacao.embalagem.codigoTipoEmbalagem;
                document.getElementById('arquivo').value            = resultado.result.arquivo;
            } else if (resultado.tipo == "XML de DSI") {
                /* AQUI VAI CODIGO PARA ARQUIVO DO TIPO DSI */
                document.getElementById('peso-bruto').value          = resultado.result.declaracaoImportacao.pesoBrutoCarga;
                document.getElementById('peso-liq').value           = resultado.result.declaracaoImportacao.pesoLiquidoCarga;
                document.getElementById('data-registro').value      = resultado.result.declaracaoImportacao.dataRegistro;
                document.getElementById('doc-saida').value          = resultado.result.declaracaoImportacao.numero;
                document.getElementById('valor-cif-reais').value    = resultado.result.declaracaoImportacao.valorMercadoriaLocalEmbarqueReal;
                document.getElementById('quantidade').value         = resultado.result.declaracaoImportacao.volume.quantidade;
                document.getElementById('arquivo').value            = resultado.result.arquivo;
            }
        }

        $('.ajaxloader').fadeOut(); 
    });
};
