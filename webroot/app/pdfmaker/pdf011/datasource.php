<?php
class pdf011DataSource
{
    public $description = '';

    public function getData($params = [])
    {
        $data = [];

        $data['INFORMACOES'] = dbsara::fetchAll("
            SELECT
         b.vgm_numero,
         convert(varchar(10),a.prog_cod_atracacao) +''+'/'+'' + a.prog_ano_atracacao as atracacao,
          a.cesv_id,
          b.vei_id,
          h.nav_n2,
          c.op_descricao,
          d.sub_descricao,
          f.eve_desc,
          a.prog_dt_cadastro,
          case
            when a.prog_dt_chegada is null then
               b.vgm_eta
            else
               a.prog_dt_chegada
          end prog_dt_chegada,
          a.prog_dt_oper_ini,
          a.prog_dt_oper_fim,
          case
            when a.prog_dt_saida is null then
              b.vgm_ets
            else
              a.prog_dt_saida
          end prog_dt_saida,
         CASE
             WHEN NF.nfi_id IS NULL theN
            'NAO FATURADO'
            ELSE
               'FATURADO'
             end FATURAMENTO,
             b.vgm_operador
        from
          tab_prog_maritima a
            left join tab_sub_operacao d
            on a.sub_id = d.sub_id
            left join tab_berco e
            on a.ber_id = e.ber_id
            left join tab_operacao c
            on a.op_id = c.op_id
            left join tab_nf_item_manual nf
            on nf.cesv_id = a.cesv_id,
          tab_viagem b
            left join tab_veiculos g
              left join tab_navios h
              on g.vei_id = h.nav_id
            on b.vei_id = g.vei_id,
          tab_evento_maritimo f
         
        where
          a.vgm_id = b.vgm_id
          and a.eve_id = f.eve_id
          and a.prog_cancelado is null
          and a.cesv_id = '" . $params['cesv_id'] . "'");

        $data['VEICULOS'] = dbsara::fetchAll("
            SELECT c.cesv_id,
            c.vei_id,
            c.vei_id_rbq,
            o.op_descricao,
            p.pes_nome,
            c.cesv_dt_entrada,
            c.cesv_dt_saida
            from tab_cesv c
            left outer join tab_pessoas p on p.pes_id = c.pes_id
            left outer join tab_operacao o on o.op_id = c.op_id
            where cesv_rel='" . $params['cesv_id'] . "'
               AND cesv_cancelada is null");

        $veiculo = [];
        $i = 0;
        foreach ($data['VEICULOS'] as $v) {
            // var_dump($v);
            $veiculo[$i]['CESV_ID'] = $v['CESV_ID'];
            $veiculo[$i]['VEI_ID'] = $v['VEI_ID'];
            $veiculo[$i]['VEI_ID_RBQ'] = $v['VEI_ID_RBQ'];
            $veiculo[$i]['OP_DESCRICAO'] = $v['OP_DESCRICAO'];
            $veiculo[$i]['PES_NOME'] = $v['PES_NOME'];
            $veiculo[$i]['CESV_DT_ENTRADA'] = $v['CESV_DT_ENTRADA'];
            $veiculo[$i]['CESV_DT_SAIDA'] = $v['CESV_DT_SAIDA'];

            $pesos = dbsara::fetchAll("EXECUTE proc_loginfo_cesv_pesos '" . $v['CESV_ID'] . "'");
            foreach ($pesos as $peso) {
                $veiculo[$i]['PESO_BRUTO'] = $peso['PESO_BRUTO'];
                $veiculo[$i]['PESO_ENTRADA'] = $peso['PESO_ENTRADA'];
                $veiculo[$i]['PESO_SAIDA'] = $peso['PESO_SAIDA'];
            }
            $i++;
        }
        $data['VEICULO'] = $veiculo;

        // var_dump($data['INFORMACOES']);
        // var_dump($data['VEICULOS']);
        // var_dump($veiculo);
        // exit;

        /* Retorno da classe */
        return $data;
    }

}