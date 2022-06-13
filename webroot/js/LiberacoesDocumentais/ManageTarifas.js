const ManageTarifas = {
    init: function() {
        this.events();
    },

    events:function(){
        $('[name="valor_cif_moeda"]').change(function(){
            ManageTarifas.calcula();
        });

        $('[name="valor_frete_moeda"]').change(function(){
            ManageTarifas.calcula();
        });

        $('[name="valor_seguro_moeda"]').change(function(){
            ManageTarifas.calcula();
        });

        $('[name="valor_fob_moeda"]').change(function(){
            ManageTarifas.calculaFob();
        });

        $('[name="moeda_cif_id"]').change(function(){
            ManageTarifas.updateCotacao($('[name="cotacao_moeda_cif"]'), $(this).val());
        });

        $('[name="moeda_frete_id"]').change(function(){
            ManageTarifas.updateCotacao($('[name="cotacao_moeda_frete"]'), $(this).val());
        });

        $('[name="moeda_seguro_id"]').change(function(){
            ManageTarifas.updateCotacao($('[name="cotacao_moeda_seguro"]'), $(this).val());
        });

        $('[name="moeda_fob_id"]').change(function(){
            ManageTarifas.updateCotacao($('[name="cotacao_moeda_fob"]'), $(this).val(), true);
        });
    },
    
    calcula:function(){
        const fCif    = Utils.parseFloat($('[name="valor_cif_moeda"]').val());
        const fFrete  = Utils.parseFloat($('[name="valor_frete_moeda"]').val());
        const fSeguro = Utils.parseFloat($('[name="valor_seguro_moeda"]').val());
        const fFob    = Utils.parseFloat($('[name="valor_fob_moeda"]').val());
        let fCotacaoCif       = Utils.parseFloat($('[name="cotacao_moeda_cif"]').val());
        let fCotacaoFrete     = Utils.parseFloat($('[name="cotacao_moeda_frete"]').val());
        let fCotacaoSeguro    = Utils.parseFloat($('[name="cotacao_moeda_seguro"]').val());
        let fCotacaoFob       = Utils.parseFloat($('[name="cotacao_moeda_fob"]').val());

        fCotacaoCif     = fCotacaoCif       ? fCotacaoCif : 1;
        fCotacaoFrete   = fCotacaoFrete     ? fCotacaoFrete : 1;
        fCotacaoSeguro  = fCotacaoSeguro    ? fCotacaoSeguro : 1;
        fCotacaoFob     = fCotacaoFob       ? fCotacaoFob : 1;

        let fResultCif      = fCif * fCotacaoCif;
        let fResultFrete    = fFrete * fCotacaoFrete;
        let fResultSeguro   = fSeguro * fCotacaoSeguro;
        let fResultFob      = fFob * fCotacaoFob;
        let fResultadoCusto = fResultFrete + fResultSeguro;
        let fTotalResultadoCusto = fResultCif + fResultFrete + fResultSeguro;
        let fValorCif = fCif;

        if(fResultFob > fTotalResultadoCusto){
            fResultCif = fResultFob + fResultadoCusto;
            fValorCif = parseFloat((fResultCif / fCotacaoCif).toFixed(2));
            $('[name="valor_cif_moeda"]').val(Utils.showFormatFloat(fValorCif));
        }

        if(fResultadoCusto > fResultCif) {
            fResultCif = fResultadoCusto;
            fValorCif = parseFloat((fResultCif / fCotacaoCif).toFixed(2));
            $('[name="valor_cif_moeda"]').val(Utils.showFormatFloat(fValorCif));
        }

        let fResultadoFob = fResultCif - fResultFrete - fResultSeguro;
        let fFobCalculado = parseFloat((fResultadoFob / fCotacaoFob).toFixed(2));
        $('[name="valor_fob_moeda"]').val(Utils.showFormatFloat(fFobCalculado));
        ManageTarifas.resultado();
    },

    calculaFob:function(){
        const fCif    = Utils.parseFloat($('[name="valor_cif_moeda"]').val());
        const fFrete  = Utils.parseFloat($('[name="valor_frete_moeda"]').val());
        const fSeguro = Utils.parseFloat($('[name="valor_seguro_moeda"]').val());
        const fFob    = Utils.parseFloat($('[name="valor_fob_moeda"]').val());
        let fCotacaoCif       = Utils.parseFloat($('[name="cotacao_moeda_cif"]').val());
        let fCotacaoFrete     = Utils.parseFloat($('[name="cotacao_moeda_frete"]').val());
        let fCotacaoSeguro    = Utils.parseFloat($('[name="cotacao_moeda_seguro"]').val());
        let fCotacaoFob       = Utils.parseFloat($('[name="cotacao_moeda_fob"]').val());

        fCotacaoCif     = fCotacaoCif       ? fCotacaoCif : 1;
        fCotacaoFrete   = fCotacaoFrete     ? fCotacaoFrete : 1;
        fCotacaoSeguro  = fCotacaoSeguro    ? fCotacaoSeguro : 1;
        fCotacaoFob     = fCotacaoFob       ? fCotacaoFob : 1;
        
        let fResultCif      = fCif * fCotacaoCif;
        let fResultFrete    = fFrete * fCotacaoFrete;
        let fResultSeguro   = fSeguro * fCotacaoSeguro;
        let fResultFob      = fFob * fCotacaoFob;
        let fResultadoCusto = fResultFrete + fResultSeguro;
        let fTotalResultadoCusto = fResultCif + fResultFrete + fResultSeguro;
        let fValorCif = fCif;

        if(fResultCif < fResultFob){
            fResultCif = fResultFob + fResultadoCusto;
            fValorCif = parseFloat((fResultCif / fCotacaoCif).toFixed(2));
            $('[name="valor_cif_moeda"]').val(Utils.showFormatFloat(fValorCif));
        }

        let fResultadoFob = fResultCif - fResultFrete - fResultSeguro;
        let fFobCalculado = parseFloat((fResultadoFob / fCotacaoFob).toFixed(2));
        ManageTarifas.resultado();
    },
    updateCotacao: async (e, iId, fob) =>{
        const sDateTime = $('[name="data_registro"]').val();
        const sDate = sDateTime.trim().split('T').find(e => true);

        const oResult = await $.fn.doAjax({
            url : 'MoedasCotacoes/get',
            type: 'GET', 
            data:{
                moeda_id:iId,
                data_cotacao:sDate
            }
        });

        if(!oResult){
            return Swal.fire({
                title: 'Ops..',
                text: 'Falha ao buscar a cotação.',
                type: 'error',
                timer: 3000,
                showConfirmButton: false
            });
        }

        if(oResult.status == 200){
            const oCotacao = oResult.dataExtra;
            const fValor   = oCotacao ? oCotacao.valor_cotacao : 0;
            $(e).val(Utils.showFormatFloat(fValor, 4));
            await ManageTarifas.calcula();
            return ManageTarifas.resultado();
        }

        return Swal.fire({
            title: 'Ops..',
            text: oResult.message,
            type: 'error',
            timer: 3000,
            showConfirmButton: false
        });

    },
    resultado:() =>{
        const fCif    = Utils.parseFloat($('[name="valor_cif_moeda"]').val());
        const fFrete  = Utils.parseFloat($('[name="valor_frete_moeda"]').val());
        const fSeguro = Utils.parseFloat($('[name="valor_seguro_moeda"]').val());
        const fFob    = Utils.parseFloat($('[name="valor_fob_moeda"]').val());
        let fCotacaoCif       = Utils.parseFloat($('[name="cotacao_moeda_cif"]').val());
        let fCotacaoFrete     = Utils.parseFloat($('[name="cotacao_moeda_frete"]').val());
        let fCotacaoSeguro    = Utils.parseFloat($('[name="cotacao_moeda_seguro"]').val());
        let fCotacaoFob       = Utils.parseFloat($('[name="cotacao_moeda_fob"]').val());

        fCotacaoCif     = fCotacaoCif       ? fCotacaoCif : 1;
        fCotacaoFrete   = fCotacaoFrete     ? fCotacaoFrete : 1;
        fCotacaoSeguro  = fCotacaoSeguro    ? fCotacaoSeguro : 1;
        fCotacaoFob     = fCotacaoFob       ? fCotacaoFob : 1;
        
        let fResultCif      = fCif * fCotacaoCif;
        let fResultFrete    = fFrete * fCotacaoFrete;
        let fResultSeguro   = fSeguro * fCotacaoSeguro;
        let fResultFob      = fFob * fCotacaoFob;

        $('[name="resultado_moeda_cif"]').val(Utils.showFormatFloat(fResultCif));
        $('[name="resultado_moeda_frete"]').val(Utils.showFormatFloat(fResultFrete));
        $('[name="resultado_moeda_seguro"]').val(Utils.showFormatFloat(fResultSeguro));
        $('[name="resultado_moeda_fob"]').val(Utils.showFormatFloat(fResultFob));
    }
}

$(document).ready(function() {
    ManageTarifas.init();
})