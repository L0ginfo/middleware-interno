<?php

class pdf005DataSource {

    public $description = '';

    public function getData($params = [])
    {
		$loteLike = '%'.$params['LOTE_ID'].'%';

        $data = [];

$data = dbsara::fetch("
select distinct lote_id,
reg_nome,
'viagem/navio',
conhecimento,
emissao,
vencimento,
lote_manifesto,
imp.cli_nome as importador,
com.cli_nome as despachante,
pais_nome,
cif_dolar,
volumes,
peso_bruto,
peso_liquido
from v_loginfo_lotes_entradas a
left join tab_doc_entrada b on a.dent_id = b.dent_id
left join tab_clientes com on b.com_id = com.cli_id
left join tab_clientes imp on b.ben_id = imp.cli_id
where a.lote_id like ?", [ $loteLike]);

$data['CARGA'] = dbsara::fetchAll("
select container, a.cnt_tipo, volumes, especie, produto, peso_bruto,tipo_documento,numero_documento, round(cnt_tara,2) CNT_TARA, round(peso_liquido,2)  peso_liquido
from v_loginfo_lotes_entradas a
left join tab_container b on a.container = b.cnt_id
where lote_id like ?", [ $loteLike ]);


$data['LOCALIZACAO'] = dbsara::fetchAll("
select latu_lote, arm_id as armazem, sum(loclo_qt) as quantidade, sum(loclo_m3_saldo) as saldo_m3, sum(loclo_m2_saldo) as saldo_m2
from tab_local_lote
where latu_lote like ?
group by latu_lote, arm_id", [ $loteLike ]);


$data['SERVICOS'] = dbsara::fetchAll("
select distinct c.os_id, a.lote_id as lote,
        d.cnt_id,
        f.sr_descricao as servico,
        '' as data_solicitacao,
        CONVERT(VARCHAR(24),c.os_dt_geracao,103)+' '+CONVERT(VARCHAR(24),c.os_dt_geracao,114) as dt_aprovacao,
        CONVERT(VARCHAR(24),c.os_dt_inicio,103)+' '+CONVERT(VARCHAR(24),c.os_dt_inicio,114) as dt_inicio,
        CONVERT(VARCHAR(24),c.os_dt_termino,103)+' '+CONVERT(VARCHAR(24),c.os_dt_termino,114) as dt_fim
    from tab_lote a
join tab_os_lote b on a.lote_id = b.lote_id
join tab_os c on b.os_id = c.os_id
join tab_os_interna d on d.os_id = b.os_id
join tab_os_servrec e on e.os_id = d.os_id
join tab_servrec f on f.sr_id = e.sr_id and f.sr_tipo = 'S'
join tab_assinatura g on g.ass_id = c.ass_id_arm
where a.lote_id like ?", [ $loteLike ]);

foreach($data['SERVICOS'] as &$item){
    $item['DATA_SOLICITACAO'] = dbportal::fetchOne('SELECT data_solicitacao FROM lote_servicos WHERE os_sara = ?', [$item['OS_ID']]);
}

$data['DEVOLUCAO'] = dbsara::fetchAll("select distinct
b.cnt_id as container,
CONVERT(VARCHAR(24),c.cesv_dt_saida,103)+' '+CONVERT(VARCHAR(24),c.cesv_dt_saida,114) as dt_sai_cnt,
a.cesv_id as CESV,
c.vei_id as placa,
d.pes_nome as motorista,
e.lote_id,
a.os_id
from tab_os a
join tab_os_interna b on a.os_id = b.os_id
join tab_cesv c on a.cesv_id = c.cesv_id
join tab_pessoas d on c.pes_id = d.pes_id
join tab_lote_item e on b.cnt_id = e.cnt_id
where a.os_subtipo = 'C'
and e.lote_id like ?", [ $loteLike ]);

$data['DADIDDE'] = dbsara::fetchAll("select distinct
rtrim(b.doc_id) +' - '+ substring(a.hcar_dsai,1,4)+'/'+substring(a.hcar_dsai,6,12) as doc,
dsai_qt_volume as qtd_liberada,
convert(varchar,c.dsai_dt_registro,103) as dt_registro,
convert(varchar,c.dsai_dt_desemb,103) dt_desembaraco,
	case dsai_canal	when 0 then 'VERDE'
					when 1 then 'AMARELO'
					when 2 then 'VERMELHO'
	end as canal
from tab_historico_carga a
join tab_documentos b on substring(a.hcar_dsai,5,1) = b.doc_ordem1
join tab_doc_saida c on a.hcar_dsai = c.dsai_id
where hcar_lote like ?", [ $loteLike ]);


$data['AVARIA'] = dbsara::fetchAll("select
a.ter_id as numero_termo,
convert(varchar,a.ter_dt_geracao,103) TER_DT_GERACAO,
a.os_id,
c.litem_descricao,
a.ter_obs
from tab_termo_lote a
left join tab_termo_item b on a.ter_id = b.ter_id
left join tab_lote_item c on b.lote_id = c.lote_id and b.oitem_id = c.litem_numero
where a.lote_id like ?", [ $loteLike ]);


        $data['USUARIO_RODAPE'] = '';

        return $data;
    }
}
