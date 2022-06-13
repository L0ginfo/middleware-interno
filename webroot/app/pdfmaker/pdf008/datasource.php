<?php
class pdf008DataSource
{
    public $description = '';

    public function getData($params = [])
    {
        $data = [];

        $data['LOTE_ID'] = $params['lote_id']; // parametro da URL

        $data['LOTE'] = dbsara::fetch("SELECT 
                    max(container) container,
                    max(cnt_tipo) cnt_tipo,
                    max(tiso_id) tiso_id,
                    sum(volumes) volumes,
                    max(especie) especie,
                    max(produto) produto,
                    sum(peso_bruto) peso_bruto,
                    sum(peso_liquido) peso_liquido, 
                    max(tipo_documento) tipo_documento,
                    max(numero_documento) numero_documento,
                    max(cesv_id) cesv_id,
                    max(lote_id) lote_id,
                    max(conhecimento) conhecimento,
                    max(conhec_nome) conhec_nome,
                    max(cliente) cliente,
                    max(situacao) situacao, 
                    max(cif_dolar) cif_dolar, 
                    max(reg_nome) reg_nome,
                    max(emissao) emissao, 
                    max(vencimento) vencimento,
                    max(lote_manifesto) lote_manifesto,
                    max(cli_cgc) cli_cgc,
                    max(proc_id) proc_id,
                    max(pais_nome) pais_nome FROM v_loginfo_lotes_entradas WHERE lote_id = '" . $data['LOTE_ID'] . "'");
        
        $container = $data['LOTE']['CONTAINER'];
        $data['container'] = $container;
        $cliente = $data['LOTE']['CLIENTE'];
        $data['cliente'] = $cliente;
        $cnpj = $data['LOTE']['CLI_CGC'];
        $data['cnpj'] = $cnpj;
        $tipo_documento = $data['LOTE']['TIPO_DOCUMENTO'];
        $data['tipo_documento'] = $tipo_documento;
        $numero_documento = $data['LOTE']['NUMERO_DOCUMENTO'];
        $data['numero_documento'] = $numero_documento;
        $reg_nome = $data['LOTE']['REG_NOME'];
        $data['reg_nome'] = $reg_nome;
        $conhec_nome = $data['LOTE']['CONHEC_NOME'];
        $data['conhec_nome'] = $conhec_nome;
        $conhecimento = $data['LOTE']['CONHECIMENTO'];
        $data['conhecimento'] = $conhecimento;
        $especie = $data['LOTE']['ESPECIE'];
        $data['especie'] = $especie;
        $vencimento = $data['LOTE']['VENCIMENTO'];
        $data['vencimento'] = $vencimento;
        $peso_bruto = $data['LOTE']['PESO_BRUTO'];
        $data['peso_bruto'] = $peso_bruto;
        $proc_id = $data['LOTE']['PROC_ID'];
        $data['proc_id'] = $proc_id;


        $data['LOTE_SALDO'] = dbsara::fetch("SELECT sum(latu_qt_saldo) latu_qt_saldo, sum(latu_m3_saldo) latu_m3_saldo, sum(latu_m2_saldo) latu_m2_saldo FROM tab_lote_atual WHERE latu_lote = '" . $data['LOTE_ID'] . "'");
        $latu_qt_saldo = $data['LOTE_SALDO']['LATU_QT_SALDO'];
        $data['latu_qt_saldo'] = $latu_qt_saldo;
        $latu_m3_saldo = $data['LOTE_SALDO']['LATU_M3_SALDO'];
        $data['latu_m3_saldo'] = $latu_m3_saldo;
        $latu_m2_saldo = $data['LOTE_SALDO']['LATU_M2_SALDO'];
        $data['latu_m2_saldo'] = $latu_m2_saldo;

        $data['LOTE_DATA'] = dbsara::fetch("SELECT  min(cesv_dt_entrada) cesv_dt_entrada FROM rel_cesv_dent dent LEFT OUTER JOIN tab_cesv cesv ON dent.cesv_id = cesv.cesv_id 
            WHERE dent_id IN ( SELECT dent_id FROM v_loginfo_lotes_entradas 
            WHERE   lote_id='" . $data['LOTE_ID'] . "')");
        $cesv_dt_entrada = $data['LOTE_DATA']['CESV_DT_ENTRADA'];
        $data['cesv_dt_entrada'] = $cesv_dt_entrada;
        
        $data['LOTE_TFA'] = [];
        $data['LOTE_TFA'] = dbsara::fetchAll("SELECT a.ter_id, a.os_id, a.lote_id, a.ass_id
            FROM tab_termo_lote a, tab_assinatura b
            WHERE b.ass_id = a.ass_id
                AND a.ter_cancelado IS NULL
                AND a.lote_id = '" . $data['LOTE_ID'] . "' ");

        $data['AVARIAS'] = [];
        foreach ($data['LOTE_TFA'] as $value) {
            $data['AVARIAS'][] = dbsara::fetchAll(
                'SET NOCOUNT ON; exec proc_loginfo_tfa_imp_avarias @v_ter_id = ?, @v_lote_id = ?, @v_os_id = ?', 
                [ 
                    $value['TER_ID'], 
                    $value['LOTE_ID'], 
                    $value['OS_ID']
                ]
            );
        }

        $teste = $data['AVARIAS'];
        $data['teste'] = $teste;

        $resultado = [];
        foreach ($data['teste'] as $result) { 
            $resultado[] = $result;
        }
        $data['resultado'] = $resultado;

        $data['DESC_CARGA'] = [];
        foreach ($resultado as $i => $item) {
            $tas_id = $item[0]['TAS_ID'];
            $oitem_id = $item[0]['OITEM_ID']; 

            $data['DESC_CARGA'][] = dbsara::fetch("SELECT litem_descricao FROM tab_lote_item WHERE lote_id = '" . $data['LOTE_ID'] . "' AND litem_numero = '" . $item[0]['LOTE_ITEM'] . "'");

            $data['DESC_AVARIAS'] = dbsara::fetchAll(
                'SET NOCOUNT ON; exec proc_loginfo_tfa_imp_ava_itens @v_tas_id = ?, @v_ter_id = ?, @v_oitem_id = ?', 
                [ $tas_id, $data['LOTE_TFA'][$i]['TER_ID'], $oitem_id ]
            );
            
            $desc_avarias[$i] = [
                'tas_id' => $tas_id,
                'desc_avarias' => $data['DESC_AVARIAS']
            ];
        }
        $data['desc_avarias'] = $desc_avarias;
        
        // retorno
        return $data;
    }

}