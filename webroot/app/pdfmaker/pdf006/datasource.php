<?php
class pdf006DataSource
{
    public $description = '';

    public function getData($params = [])
    {
        // Retorna os valores para executar a procedure
        $data = [];
        $data = dbsara::fetch("
            SELECT a.ter_id, a.os_id, a.lote_id, a.ass_id, a.ter_cancelado
            FROM tab_termo_lote a
            WHERE a.lote_id = '" . $params['lote_id'] . "' 
                AND a.os_id = '" . $params['os_id'] . "'
                AND a.ter_cancelado is null
        ");

        $data['LOTE_ID'] = $params['lote_id']; // parametro da URL
        $data['OS_ID'] = $params['os_id']; // parametro da URL

        /**
         * EXCEL - TB termo_falta_avaria
         * @var $excel
         * @return observacao
         */
        $excel = [];
        $excel = dbsara::fetchAll("
            SELECT * FROM t_loginfo_termo_lote 
            WHERE ter_id = '". $data['TER_ID'] ."' AND os_id = '". $data['OS_ID'] ."'
        ");

        $excel_observacao = $excel[0]['TER_ADICIONAL'];
        $data['excel_observacao'] = $excel_observacao;

        // Retorna os valores da tabela sistema (nome, cnpj etc.. da Barra do Rio)
        $data['BARRA'] = dbsara::fetch("
            SELECT sis_razao_social, sis_cgc, sis_nome_filial, sis_deleg_rf, sis_orgao_rf, sis_fieldeposita 
            FROM tab_sistema
        ");
        
        $razao = $data['BARRA']['SIS_RAZAO_SOCIAL'];
        $data['razao'] = $razao;
        $cnpj = $data['BARRA']['SIS_CGC'];
        $data['cnpj'] = $cnpj;
        $unidade = $data['BARRA']['SIS_NOME_FILIAL'];
        $data['unidade'] = $unidade;
        $alfandega = $data['BARRA']['SIS_DELEG_RF'];
        $data['alfandega'] = $alfandega;
        $delegacia = $data['BARRA']['SIS_ORGAO_RF'];
        $data['delegacia'] = $delegacia;
        $sis_fieldeposita = $data['BARRA']['SIS_FIELDEPOSITA'];
        $data['sis_fieldeposita'] = $sis_fieldeposita;

        // Retorna os valores da porcedure = proc_loginfo_tfa_imp_capa 
        $data['CAPA'] = dbsara::fetch(
            'SET NOCOUNT ON; exec proc_loginfo_tfa_imp_capa @v_ter_id = ?, @v_lote_id = ?, @v_os_id = ?', 
            [ $data['TER_ID'], 
            $data['LOTE_ID'], 
            $data['OS_ID']]
        );
        
        $termo = $data['CAPA']['TER_INF'];
        $data['termo'] = $termo;
        $dent = $data['CAPA']['DENT'];
        $data['dent'] = $dent;
        $lote_conhec = $data['CAPA']['LOTE_CONHEC'];
        $data['lote_conhec'] = $lote_conhec;
        $lote_receita = $data['CAPA']['LOTE_RECEITA'];
        $data['lote_receita'] = $lote_receita;
        $proc_id = $data['CAPA']['PROC_ID'];
        $data['proc_id'] = $proc_id;
        $proc_nome = $data['CAPA']['PROC_NOME'];
        $data['proc_nome'] = $proc_nome;
        $cesv = $data['CAPA']['CESV_DT_ENTRADA'];
        $data['cesv'] = $cesv;
        $cli_nome = $data['CAPA']['CLI_NOME'];
        $data['cli_nome'] = $cli_nome;
        $trans_nome = $data['CAPA']['TRANS_NOME'];
        $data['trans_nome'] = $trans_nome;
        $lote_vol_dec = $data['CAPA']['LOTE_VOL_DEC'];
        $data['lote_vol_dec'] = $lote_vol_dec;
        $lote_vol_fisico = $data['CAPA']['LOTE_VOL_FISICO'];
        $data['lote_vol_fisico'] = $lote_vol_fisico;
        $lote_peso_bruto = $data['CAPA']['LOTE_PESO_BRUTO'];
        $data['lote_peso_bruto'] = $lote_peso_bruto;
        $lote_peso_fisico = $data['CAPA']['LOTE_VOL_FISICO'];
        $data['lote_peso_fisico'] = $lote_peso_fisico;
        $vei_id = $data['CAPA']['VEI_ID'];
        $data['vei_id'] = $vei_id;
        $vei_id_rbq = $data['CAPA']['VEI_ID_RBQ'];
        $data['vei_id_rbq'] = $vei_id_rbq;
        $ass_nome = $data['CAPA']['ASS_NOME'];
        $data['ass_nome'] = $ass_nome;
        $pes_nome = $data['CAPA']['PES_NOME'];
        $data['pes_nome'] = $pes_nome;
        $pes_cpf = $data['CAPA']['PES_CPF'];
        $data['pes_cpf'] = $pes_cpf;
        $trans_cgc = $data['CAPA']['TRANS_CGC'];
        $data['trans_cgc'] = $trans_cgc;
        $cli_cgc = $data['CAPA']['CLI_CGC'];
        $data['cli_cgc'] = $cli_cgc;
        $ter_obs = $data['CAPA']['TER_OBS'];
        $data['ter_obs'] = $ter_obs;
        $vei_id_rbq = $data['CAPA']['VEI_ID_RBQ'];
        $data['vei_id_rbq'] = $vei_id_rbq;

        // retorna os valores da procedure = proc_loginfo_tfa_imp_avarias
        // $data['AVARIAS'] = dbsara::fetch(
        //     'SET NOCOUNT ON; exec proc_loginfo_tfa_imp_avarias @v_ter_id = ?, @v_lote_id = ?, @v_os_id = ?',
        //     [ $data['TER_ID'], $data['LOTE_ID'], $data['OS_ID'] ]
        // );
        // $tas_qtd = $data['AVARIAS']['TAS_QTD'];
        // $data['tas_qtd'] = $tas_qtd;
        // $esp_id = $data['AVARIAS']['ESP_ID'];
        // $data['esp_id'] = $esp_id;
        // $efe_descricao = $data['AVARIAS']['EFE_DESCRICAO'];
        // $data['efe_descricao'] = $efe_descricao;
        // $tas_id = $data['AVARIAS']['TAS_ID'];
        // $data['tas_id'] = $tas_id;
        // $oitem_id = $data['AVARIAS']['OITEM_ID'];
        // $data['oitem_id'] = $oitem_id;
        // $vei = $data['AVARIAS']['VEICULO'];
        // $data['vei'] = $vei;

        $data['AVARIAS'] = [];
        $data['AVARIAS'] = dbsara::fetchAll(
            'SET NOCOUNT ON; exec proc_loginfo_tfa_imp_avarias @v_ter_id = ?, @v_lote_id = ?, @v_os_id = ?', 
            [ 
                $data['TER_ID'], 
                $data['LOTE_ID'], 
                $data['OS_ID']
            ]
        );

        $teste = $data['AVARIAS'];
        $data['teste'] = $teste;
        
        foreach ($data['teste'] as $i => $item) {
            $tas_id = $item['TAS_ID'];
            $oitem_id = $item['OITEM_ID'];          
            
            $data['DESC_AVARIAS'] = dbsara::fetchAll(
                'SET NOCOUNT ON; exec proc_loginfo_tfa_imp_ava_itens @v_tas_id = ?, @v_ter_id = ?, @v_oitem_id = ?', 
                [ $tas_id, $data['TER_ID'], $oitem_id ]
            );
            
            $desc_avarias[$i] = [
                'tas_id' => $tas_id,
                'desc_avarias' => $data['DESC_AVARIAS']
            ];
        }
        
        $data['desc_avarias'] = $desc_avarias;
        
        // $data['DESC_AVARIAS'] = dbsara::fetchAll(
        //     'SET NOCOUNT ON; exec proc_loginfo_tfa_imp_ava_itens @v_tas_id = ?, @v_ter_id = ?, @v_oitem_id = ?',
        //     [ $data['tas_id'], $data['TER_ID'], $data['oitem_id'] ]
        // );

        // retorna os valores do SELECT dos documentos
        $data['DOCUMENTO'] = [];
        $data['DOCUMENTO'] = dbsara::fetchAll("
            SELECT DISTINCT
                (SELECT rtrim(doc_id) FROM tab_documentos WHERE doc_ordem1 = substring(a.dent_id,5,1)) AS doc,
                (substring(a.dent_id,3,2)+'/'+substring(a.dent_id,9,13)) AS numero
            FROM rel_dent_cnt a, tab_doc_entrada b
            WHERE a.dent_id = b.dent_id 
                AND a.lote_id = '" . $data['LOTE_ID'] . "'
        ");
        
        // varre array
        $doc = $data['DOCUMENTO'][0]['DOC'];
        $data['doc'] = $doc;
        $numero = [];
        
        foreach ($data['DOCUMENTO'] as $i) {
            $numero[] = $i['NUMERO'];
        }

        $data['numero'] = array_unique($numero);

        // retorna os valores da procedure proc_opr_r_termoselvei
        $data['VEICULOS'] = [];
        $data['VEICULOS'] = dbsara::fetchAll(
            'SET NOCOUNT ON; exec proc_opr_r_termoselvei @w_lote_id = ?', 
            [ $data['LOTE_ID'] ]
        );
        
        // varre array
        $veiculo = [];
        $reboque = [];
        
        foreach ($data['VEICULOS'] as $i) {
            $veiculo[] = $i['VEI_ID'];
            $reboque[] = $i['VEI_ID_RBQ'];
        }

        $data['veiculo'] = array_unique($veiculo);
        $data['reboque'] = array_unique($reboque);

        // retorno
        return $data;
    }
}