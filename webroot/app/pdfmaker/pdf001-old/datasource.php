<?php

class pdf001DataSource {

    public $description = '';

    public function getData($params = [])
    {
        $data = [];

        if (isset($params['NFM_ID']))
            $data = dbsara::fetch('select v.*, m.moe_nome, c.NUM_NFSE from v_loginfo_demon_impressao v left join v_loginfo_demon_calculo c on c.capa = v.nfm_id left join tab_moedas m on m.moe_id = v.nfi_moeda where v.NFM_ID = ?', [ $params['NFM_ID']]);

        if (isset($params['NUM_NFSE']))
            $data = dbsara::fetch('select v.*, m.moe_nome, c.NUM_NFSE from v_loginfo_demon_impressao v left join v_loginfo_demon_calculo c on c.capa = v.nfm_id left join tab_moedas m on m.moe_id = v.nfi_moeda where C.NUM_NFSE = ?', [ $params['NUM_NFSE']]);

        $arms = dbsara::fetchAll('SET NOCOUNT ON; exec proc_fat_s_demons_per @w_nfim_id = ?, @w_per_dt_ini = ?, @w_per_dt_fim = ?', [ $data['NFIM_ID'], $data['NFI_DT_INICIO'], $data['NFI_DT_TERMINO']]);

        foreach($arms as &$arm) {
            $arm2 = dbsara::fetch('SET NOCOUNT ON; exec proc_fat_s_demons_per_dados @w_nfim_id = ?, @w_per_dt_ini = ?, @w_per_dt_fim = ?', [ $data['NFIM_ID'], $arm['DATAINI'], $arm['DATAFIM']]);
            $arm = array_merge($arm, $arm2);
        }

        $data['ARMAZENAGEM'] = $arms;

        $data['SERVICOS'] = dbsara::fetchAll('
    SELECT sm.sr_id,
       tb.sr_descricao,
       coalesce(itd.nfimd_valorigem, sm.nfsm_vl_tot) nfsm_vl_tot,
       sm.nfsm_qtd_serv,
       sm.sr_imp_nf,
       sm.gfor_id,
       CASE
         WHEN itd.nfimdi_percent IS NOT NULL THEN Round(
         ( itd.nfimdi_percent *
             itd.nfimd_valorigem ) / 100, 2)
         ELSE itd.nfimdi_valor
       END AS val_descon
FROM   tab_nfi_servicos_manual sm
LEFT JOIN tab_servrec tb ON tb.sr_id = sm.sr_id
LEFT JOIN tab_nfim_desconto nfd ON nfd.nfim_id = sm.nfim_id
LEFT JOIN tab_nfimd_item itd ON itd.nfimd_id = nfd.nfimd_id AND sm.sr_id = itd.sr_id
WHERE  sm.nfim_id = ?', [ $data['NFIM_ID'] ]);

        $obs = dbsara::fetchCol('SET NOCOUNT ON; exec proc_fat_demonst_observ @w_hcar_dsai = ?, @w_lote = ?', [$data['NFI_DSAI'], $data['LOTE_ID']]);
        $data['OBS'] = implode(' - ', $obs);

        $data['QTDE_CONT'] = dbsara::fetchOne("select count(hcar_cnt) as container from tab_historico_carga where hcar_dsai = ? and isnull(hcar_cnt, '') <> '' and hcar_lote = ?", [trim($data['NFI_DSAI']), $data['LOTE_ID']]);

        $data['USUARIO_RODAPE'] = '';

        return $data;
    }
}
