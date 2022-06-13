<?php
class pdf009DataSource
{
    public $description = '';

    public function getData($params = [])
    {
        $data = [];

        /* Procedure que retorna as informações do termo */
        $data['CABECALHO'] = dbsara::fetch(
            'SET NOCOUNT ON; exec proc_loginfo_tfa_cnt_capa @v_ter_id = ?', 
            [
            	$params['ter_id'] //paramentro da URL
            ]
        );
        $ter_inf = $data['CABECALHO']['TER_INF'];
        $data['ter_inf'] = $ter_inf;
        $dent = $data['CABECALHO']['DENT'];
        $data['dent'] = $dent;
        $proc_nome = $data['CABECALHO']['PROC_NOME'];
        $data['proc_nome'] = $proc_nome;
        $cesv_dt_chegada = $data['CABECALHO']['CESV_DT_CHEGADA'];
        $data['cesv_dt_chegada'] = $cesv_dt_chegada;
        $cesv_dt_entrada = $data['CABECALHO']['CESV_DT_ENTRADA'];
        $data['cesv_dt_entrada'] = $cesv_dt_entrada;
        $os_dt_inicio = $data['CABECALHO']['OS_DT_INICIO'];
        $data['os_dt_inicio'] = $os_dt_inicio;
        $cnt_id = $data['CABECALHO']['CNT_ID'];
        $data['cnt_id'] = $cnt_id;
        $trans_nome = $data['CABECALHO']['TRANS_NOME'];
        $data['trans_nome'] = $trans_nome;
        $cli_nome = $data['CABECALHO']['CLI_NOME'];
        $data['cli_nome'] = $cli_nome;
        $cnt_tipo = $data['CABECALHO']['CNT_TIPO'];
        $data['cnt_tipo'] = $cnt_tipo;
        $cnt_tara = $data['CABECALHO']['CNT_TARA'];
        $data['cnt_tara'] = $cnt_tara;
        $ter_dt_geracao = $data['CABECALHO']['TER_DT_GERACAO'];
        $data['ter_dt_geracao'] = $ter_dt_geracao;

        /* Procedure que retorna as informações do terminal */
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

        /* Procedure que retorna as informações das avarias */
        $data['AVARIAS'] = [];
        $data['AVARIAS'] = dbsara::fetchAll(
            'SET NOCOUNT ON; exec proc_opr_r_teravariacntseq0 @v_ter_id = ?', 
            [
            	$params['ter_id'] 
            ]
        );
        $teste = $data['AVARIAS'];
        $data['teste'] = $teste;
        foreach ($data['teste'] as $i => $item) {
            $avpc_id = $item['AVPC_ID'];                      
            $data['DESC_AVARIAS'] = dbsara::fetchAll(
                'SET NOCOUNT ON; exec proc_opr_r_teravacntSeqItem0 @v_avpc_id = ?', 
                [ $avpc_id ]
            );
            $desc_avarias[$i] = [
                'avpc_id' => $avpc_id,
                'desc_avarias' => $data['DESC_AVARIAS']
            ];
        }        
        $data['desc_avarias'] = $desc_avarias;

        /* Retorno da classe */
        return $data;
    }

}