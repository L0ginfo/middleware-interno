<?php
// Classe onde sao feitas as consultas no banco SQLServer 
class pdf012DataSource
{
    public $description = '';

    // Metodo onde sao executadas as consultas e atribui os valores no retorno para o arquivo index.phtml
    public function getData($params = [])
    {
        // Cria variavel de array que sera o retorno do metodo
        $data = [];
        // Atribui o paramentro da url para uma variavel
        $cesv_id = $params['cesv_id'];
        // Atribui os dados na posicao do array de rotorno do metodo
        $data['cesv_id'] = $cesv_id;

        // Retorna os valores da tabela sistema (nome, cnpj etc.. da Barra do Rio)
        $data['INFO_BARRA'] = dbsara::fetch("SELECT sis_nome_filial, sis_endereco, sis_bairro, sis_cidade, sis_cep FROM tab_sistema");
        // Atribui os dados na posicao do array de rotorno do metodo
        $sis_nome_filial = $data['INFO_BARRA']['SIS_NOME_FILIAL'];
        $data['sis_nome_filial'] = $sis_nome_filial;
        $sis_endereco = $data['INFO_BARRA']['SIS_ENDERECO'];
        $data['sis_endereco'] = $sis_endereco;
        $sis_bairro = $data['INFO_BARRA']['SIS_BAIRRO'];
        $data['sis_bairro'] = $sis_bairro;
        $sis_cidade = $data['INFO_BARRA']['SIS_CIDADE'];
        $data['sis_cidade'] = $sis_cidade;
        $sis_cep = $data['INFO_BARRA']['SIS_CEP'];
        $data['sis_cep'] = $sis_cep;

        // Retorna o numero do ticket de pesagem
        $data['NUMERO_TICKET_PESAGEM'] = dbsara::fetch("SELECT bal_numero FROM tab_balanca WHERE cesv_id='" . $cesv_id . "' AND bal_ordem=1");
        // Atribui os dados na posicao do array de rotorno do metodo
        $bal_numero = $data['NUMERO_TICKET_PESAGEM']['BAL_NUMERO'];
        $data['bal_numero'] = $bal_numero;

        // Retorna os dados da cesv

        $data['DADOS_CESV'] = dbsara::fetch("SELECT a.vei_id, c.op_descricao, a.cesv_dt_entrada, cesv_dt_saida, a.cesv_observacao, cli.cli_nome as OPERADOR
        FROM tab_cesv a, tab_veiculos b, tab_operacao c, tab_prog_maritima p, tab_viagem v, tab_clientes cli 
        WHERE a.vei_id = b.vei_id 
        AND a.op_id = c.op_id
        AND P.cesv_id = A.cesv_rel        
        AND P.vgm_id=V.vgm_id
        AND V.vgm_operador = CLI.CLI_ID AND a.cesv_id = '" . $cesv_id . "'");
        // Atribui os dados na posicao do array de rotorno do metodo
        $vei_id =  $data['DADOS_CESV']['VEI_ID'];
        $data['vei_id'] = $vei_id;
        $op_descricao =  $data['DADOS_CESV']['OP_DESCRICAO'];
        $data['op_descricao'] = $op_descricao;
        $cesv_dt_entrada =  $data['DADOS_CESV']['CESV_DT_ENTRADA'];
        $data['cesv_dt_entrada'] = $cesv_dt_entrada;
        $cesv_dt_saida =  $data['DADOS_CESV']['CESV_DT_SAIDA'];
        $data['cesv_dt_saida'] = $cesv_dt_saida;
        $cesv_observacao =  $data['DADOS_CESV']['CESV_OBSERVACAO'];
        $data['cesv_observacao'] = $cesv_observacao;
        $operador =  $data['DADOS_CESV']['OPERADOR'];
        $data['operador'] = $operador;

        // Retorna os reboques dos dados da cesv
        $data['REBOQUE'] = [];
        $data['REBOQUE'] = dbsara::fetchAll("SELECT vei_id FROM rel_cesv_reboque WHERE cesv_id = '" . $cesv_id . "'");
        // Varre o array e monta os arrays para o html
        $reboques = [];
        foreach ($data['REBOQUE'] as $i) {
            $reboques[] = $i['VEI_ID'];
        }
        // Atribui os dados na posicao do array de rotorno do metodo
        $data['reboques'] = $reboques;

        // Retorna os valores de pesagem de entrada
        $data['PESAGEM_ENTRADA'] = [];
        $data['PESAGEM_ENTRADA'] = dbsara::fetchAll("SELECT BAL_DT, BAL_TIPO, BAL_PESO, VEI_ID, CNT_ID FROM tab_balanca WHERE bal_ordem=1 AND cesv_id ='" . $cesv_id . "'");
        // Cria variaveis de array para receber os valores
        $bal_dt = [];
        $bal_tipo = [];
        $bal_peso = [];
        $vei_id = [];
        $cnt_id = [];
        // varre os array e mosta os arrays para o html
        foreach ($data['PESAGEM_ENTRADA'] as $i) {
            $bal_dt[] = $i['BAL_DT'];
            $bal_tipo[] = $i['BAL_TIPO'];
            $bal_peso[] = $i['BAL_PESO'];
            $vei_id[] = $i['VEI_ID'];
            $cnt_id[] = $i['CNT_ID'];
        }
        // Atribui os dados na posicao do array de rotorno do metodo
        $data['bal_dt_entrada'] = $bal_dt;
        $data['bal_tipo_entrada'] = $bal_tipo;
        $data['bal_peso_entrada'] = $bal_peso;
        $data['vei_id_entrada'] = $vei_id;
        $data['cnt_id_entrada'] = $cnt_id;
        // calcula soma de todos os pesos de entrada
        $soma = 0;
        foreach ($data['bal_peso_entrada'] as $value) {
            $soma = $soma + $value;
        }
        // Atribui os dados na posicao do array de rotorno do metodo
        $data['soma_peso_entrada'] = number_format($soma, 2, '.', '');

        // Retorna os valores de pesagem de saida
        $data['PESAGEM_SAIDA'] = [];
        $data['PESAGEM_SAIDA'] = dbsara::fetchAll("SELECT BAL_DT, BAL_TIPO, BAL_PESO, VEI_ID, CNT_ID FROM tab_balanca WHERE bal_ordem=2 AND cesv_id = '" . $cesv_id . "'");
        // Cria variaveis de array para receber os valores
        $bal_dt = [];
        $bal_tipo = [];
        $bal_peso = [];
        $vei_id = [];
        $cnt_id = [];
        // varre os array e mosta os arrays para o html
        foreach ($data['PESAGEM_SAIDA'] as $i) {
            $bal_dt[] = $i['BAL_DT'];
            $bal_tipo[] = $i['BAL_TIPO'];
            $bal_peso[] = $i['BAL_PESO'];
            $vei_id[] = $i['VEI_ID'];
            $cnt_id[] = $i['CNT_ID'];
        }
        // Atribui os dados na posicao do array de rotorno do metodo
        $data['bal_dt_saida'] = $bal_dt;
        $data['bal_tipo_saida'] = $bal_tipo;
        $data['bal_peso_saida'] = $bal_peso;
        $data['vei_id_saida'] = $vei_id;
        $data['cnt_id_saida'] = $cnt_id;
        // calcula soma de todos os pesos de saida
        $soma = 0;
        foreach ($data['bal_peso_saida'] as $value) {
            $soma = $soma + $value;
        }
        // Atribui os dados na posicao do array de rotorno do metodo
        $data['soma_peso_saida'] = number_format($soma, 2, '.', '');

        // Retorna quantidade de containers
        $data['QUANTIDADE_DE_CONTAINERS'] = dbsara::fetch("SELECT count(*) FROM tab_mov_cnt WHERE cesv_id_ent='" . $cesv_id . "' OR cesv_id_sai='" . $cesv_id . "'");
        // Atribui os dados na posicao do array de rotorno do select
        $data['qtd_containers'] = $data['QUANTIDADE_DE_CONTAINERS'][''];

        // Retorna valores para soma de tara container
        $data['TARA_CONTAINER_UM'] = dbsara::fetch("SELECT isnull(sum(cnt_tara),0) AS cnt_tara FROM tab_container WHERE cnt_id IN (SELECT cnt_id FROM tab_mov_cnt WHERE cesv_id_sai = '" . $cesv_id . "')");
        $tara_container_um = $data['TARA_CONTAINER_UM']['CNT_TARA'];
        $data['TARA_CONTAINER_DOIS'] = dbsara::fetch("SELECT isnull(sum(cnt_tara),0) AS cnt_tara FROM tab_container WHERE cnt_id IN (SELECT cnt_id FROM tab_mov_cnt WHERE cesv_id_ent = '" . $cesv_id . "' AND coalesce(cesv_id_sai,'nulo') <>'" . $cesv_id . "')");
        $tara_container_dois = $data['TARA_CONTAINER_DOIS']['CNT_TARA'];
        // faz a soma do tara container e Atribui os dados na posicao do array de rotorno do metodo
        $data['tara_container'] = $tara_container_um + $tara_container_dois;

        // Retorna valores para Observacoes
        $data['OBSERVACOES'] = dbsara::fetch("SELECT TOP 1 OBS FROM tab_balanca WHERE bal_ordem=2 AND cesv_id ='" . $cesv_id . "'");
        $observacoes = $data['OBSERVACOES']['OBS'];
        // Atribui os dados na posicao do array de rotorno do select
        $data['observacoes'] = $observacoes;

        // retorno do metodo
        return $data;
 	}
}
