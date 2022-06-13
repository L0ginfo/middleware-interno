<?php
class pdf010DataSource
{
    public $description = '';

    public function getData($params = [])
    {
        $data = [];
        $params = [];

        /* Vai precisar desses dois parametros para funcionar */
        $params['NFM_ID'] = 3;
        // $params['NUM_NFSE'] = "000004734";

        if (isset($params['NFM_ID'])){
            $data = dbsara::fetch('select v.*, m.moe_nome, c.NUM_NFSE from v_loginfo_demon_impressao v left join v_loginfo_demon_calculo c on c.capa = v.nfm_id left join tab_moedas m on m.moe_id = v.nfi_moeda where v.NFM_ID = ?', [ $params['NFM_ID']]);
            $data['VIEW_LINE_ALL'] = dbsara::fetchOne('select count(*) from v_loginfo_demon_calculo_zeradas where NFM_ID = ?', [ $params['NFM_ID']]);
        }    
            
        if (isset($params['NUM_NFSE'])) {
            $data = dbsara::fetch('select v.*, m.moe_nome, c.NUM_NFSE from v_loginfo_demon_impressao v left join v_loginfo_demon_calculo c on c.capa = v.nfm_id left join tab_moedas m on m.moe_id = v.nfi_moeda where C.NUM_NFSE = ?', [ $params['NUM_NFSE']]);
            $data['VIEW_LINE_ALL'] = false;
        }
            
        $arms = dbsara::fetchAll('SET NOCOUNT ON; exec proc_fat_s_demons_per @w_nfim_id = ?, @w_per_dt_ini = ?, @w_per_dt_fim = ?', [ $data['NFIM_ID'], $data['NFI_DT_INICIO'], $data['NFI_DT_TERMINO']]);
        foreach($arms as &$arm) {
            $arm2 = dbsara::fetch('SET NOCOUNT ON; exec proc_fat_s_demons_per_dados @w_nfim_id = ?, @w_per_dt_ini = ?, @w_per_dt_fim = ?', [ $data['NFIM_ID'], $arm['DATAINI'], $arm['DATAFIM']]);
            $arm = array_merge($arm, $arm2);
        }

        $data['ARMAZENAGEM'] = $arms;

        $data['SERVICOS'] = dbsara::fetchAll('SELECT sm.sr_id, tb.sr_descricao, coalesce(itd.nfimd_valorigem, sm.nfsm_vl_tot) nfsm_vl_tot,
            sm.nfsm_qtd_serv,
            sm.sr_imp_nf,
            sm.gfor_id,
            nfd.nfimd_justif,
            CASE
            WHEN itd.nfimdi_percent IS NOT NULL THEN Round(
            ( itd.nfimdi_percent *
             itd.nfimd_valorigem ) / 100, 2)
            ELSE itd.nfimdi_valor
            END AS val_descon,
            CASE
            WHEN (Round(
            ( itd.nfimdi_percent *
             itd.nfimd_valorigem ) / 100, 2) - coalesce(itd.nfimd_valorigem, sm.nfsm_vl_tot)) = 0 or itd.nfimdi_valor - coalesce(itd.nfimd_valorigem, sm.nfsm_vl_tot) = 0
            THEN 0
            ELSE 1
            END AS view_line
            FROM   tab_nfi_servicos_manual sm
            LEFT JOIN tab_servrec tb ON tb.sr_id = sm.sr_id
            LEFT JOIN tab_nfim_desconto nfd ON nfd.nfim_id = sm.nfim_id
            LEFT JOIN tab_nfimd_item itd ON itd.nfimd_id = nfd.nfimd_id AND sm.sr_id = itd.sr_id
            WHERE  sm.nfim_id = ?', [ $data['NFIM_ID'] ]);

        // $obs = dbsara::fetchCol('SET NOCOUNT ON; exec proc_fat_demonst_observ @w_hcar_dsai = ?, @w_lote = ?', [$data['NFI_DSAI'], $data['LOTE_ID']]);
        // $data['OBS'] = implode(' - ', $obs);

        $data['QTDE_CONT'] = dbsara::fetchOne("select count(hcar_cnt) as container from tab_historico_carga where hcar_dsai = ? and isnull(hcar_cnt, '') <> '' and hcar_lote = ?", [trim($data['NFI_DSAI']), $data['LOTE_ID']]);

        $data['USUARIO_RODAPE'] = '';


        $data['CESV_ID'] = dbsara::fetch("SELECT cesv_id FROM tab_nf_item_manual WHERE nfm_id = '" . $params['NFM_ID'] . "'");
        $cesv_id = $data['CESV_ID']['CESV_ID'];
        $data['NAVIO'] = dbsara::fetch(
            "SELECT convert(varchar(5),a.prog_cod_atracacao) ++ '/' ++ convert(varchar(4),a.prog_ano_atracacao) AS cod_atracacao,
            b.vgm_numero AS viagem,
            c.nav_id AS navio,
            c.nav_n2 AS nome,
            c.nav_comprimento AS loa,
            c.nav_calado AS calado,
            c.nav_gt AS dwt,
            c.arqueacao_bruta AS arq_bruta,
            c.arqueacao_liquida AS arq_liquida,
            d.ber_nome,
            a.prog_dt_atr AS dt_atracacao,
            a.prog_dt_desatracacao AS dt_desatracacao,
            a.prog_dt_oper_ini AS dt_ini_op,
            a.prog_dt_oper_fim AS dt_ter_op,
            a.prog_dt_chegada,
            a.prog_dt_saida, 
            a.cesv_id,
            convert(varchar(5), a.prog_id) ++ '/' ++ convert(varchar(4), a.prog_ano) AS prog_id
            FROM tab_prog_maritima a,
            tab_viagem b,
            tab_navios c,
            tab_berco d
            WHERE a.vgm_id = b.vgm_id
            AND b.vei_id = c.nav_id
            AND a.ber_id = d.ber_id
            AND a.cesv_id = '" . $cesv_id . "'"
        );

        $data['cod_atracacao'] = $data['NAVIO']['COD_ATRACACAO'];
        $data['viagem'] = $data['NAVIO']['VIAGEM'];
        $data['navio'] = $data['NAVIO']['NAVIO'];
        $data['nome'] = $data['NAVIO']['NOME'];
        $data['loa'] = $data['NAVIO']['LOA'];
        $data['calado'] = $data['NAVIO']['CALADO'];
        $data['dwt'] = $data['NAVIO']['DWT'];
        $data['arq_bruta'] = $data['NAVIO']['ARQ_BRUTA'];
        $data['arq_liquida'] = $data['NAVIO']['ARQ_LIQUIDA'];
        $data['ber_nome'] = $data['NAVIO']['BER_NOME'];
        $data['dt_atracacao'] = $data['NAVIO']['DT_ATRACACAO'];
        $data['dt_desatracacao'] = $data['NAVIO']['DT_DESATRACACAO'];
        $data['dt_ini_op'] = $data['NAVIO']['DT_INI_OP'];
        $data['dt_ter_op'] = $data['NAVIO']['DT_TER_OP'];
        $data['prog_dt_chegada'] = $data['NAVIO']['PROG_DT_CHEGADA'];
        $data['prog_dt_saida'] = $data['NAVIO']['PROG_DT_SAIDA'];
        $data['cesv_id'] = $data['NAVIO']['CESV_ID'];
        $data['prog_id'] = $data['NAVIO']['PROG_ID'];

        // var_dump($data); exit;
        /* Retorno da classe */
        return $data;
    }

}