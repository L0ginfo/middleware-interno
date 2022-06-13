<?php

namespace App\Model\Table;

use App\Model\Entity\Agendamento;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
use PDO;
use PDOException;
use Cake\Event\Event;
use ArrayObject;

/**
 * Agendamentos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Usuarios
 */
class AgendamentosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('agendamentos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Muffin/Footprint.Footprint');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'created_by',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('SituacaoAgendamentos', [
        ]);

        $this->belongsTo('Entradas', [
            'foreignKey' => 'entrada_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('Operacoes', [
            'foreignKey' => 'operacao_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('ItemAgendamentos', [
            'foreignKey' => 'agendamento_id',
            'joinType' => 'LEFT'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create');

        $validator
                ->requirePresence('operacao_id', 'create')
                ->add('operacao_id', 'valid', ['rule' => 'numeric'])
                ->add('operacao_id', 'valid', ['rule' => ['comparison', '>', 0]])
                ->notEmpty('operacao_id', 'create');

        $validator
                ->allowEmpty('titulo');

        $validator
                ->allowEmpty('descricao');

        $validator
                ->notEmpty('hora');

        $validator
                ->add('data', 'valid', ['rule' => ['date', 'dmy']])
                ->requirePresence('data', 'create')
                ->notEmpty('data');

        $validator
                ->notEmpty('hora');

        $validator
                ->allowEmpty('situacao_agendamento_id');

        $validator->add('veiculo', [
            'pesquisaPlaca' => [
                'rule' => 'pesquisaPlaca',
                'provider' => 'table',
                'message' => 'Formato invalido'
            ]
        ]);

        $validator->allowEmpty('veiculo');

        $validator->add('reboque1', [
            'pesquisaPlacareboque1' => [
                'rule' => 'pesquisaPlaca',
                'provider' => 'table',
                'message' => 'Formato invalido'
            ]
        ]);

        $validator->allowEmpty('reboque1');

        $validator->add('reboque2', [
            'pesquisaPlacareboque2' => [
                'rule' => 'pesquisaPlaca',
                'provider' => 'table',
                'message' => 'Formato invalido'
            ]
        ]);

        $validator->allowEmpty('reboque2');

        return $validator;
    }

    public function pesquisaPlaca($check, $context)
    {

        $placa = preg_replace('/[^a-zA-Z0-9]/', '', (string) $check);
        $placa = strtoupper($placa);
        // if (preg_match('/[a-zA-Z]{3}[0-9]{1}[A-Za-z0-9]{1}[0-9]{2}/', $placa)) {
            return true;
        // } else {
            // return false;
        // }
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['created_by'], 'Usuarios'));
        return $rules;
    }

    public function beforeSave($event, $entity, $options)
    {
        $campos_maisculos = ['nome_motorista', 'veiculo', 'reboque1', 'reboque2'];
        $campos_somenteNumeros = ['CPF_Motorista', 'CNPJ_transportadora', 'veiculo', 'reboque1', 'reboque2'];

        foreach ($campos_maisculos as $campo) {
            $entity->$campo = strtoupper($entity->$campo);
        }

        foreach ($campos_somenteNumeros as $campo) {
            $entity->$campo = preg_replace("[^a-zA-Z0-9_]", "", $entity->$campo);
        }

        if (!$entity->data_solicitacao) {
            $entity->data_solicitacao = date('Y-m-d H:i:s');
        }

        $entity->created = date('Y-m-d H:i:s');
        $entity->modified = date('Y-m-d H:i:s');
    }

    public function afterSave($created)
    {
        @$_SESSION['AGENDAMENTO_ITENS'][$created->data['entity']->id];
        $this->conecta_db_sql_server();
        
        if ($created->data['entity']->hora && $created->data['entity']->data) {
            if (strtotime($created->data['entity']->data)) {
                $data_s = date('Y-m-d', strtotime($created->data['entity']->data));
            } else {
                $data_s = $created->data['entity']->data->format('Y-m-d H:i');
            }
            $data_alterada = $data_s . ' ' . $created->data['entity']->hora . ':00.0';

            $sql = "UPDATE t_loginfo_doc_agendamento_carga 
                    SET data_agendamento = '" . $data_alterada . "' 
                    WHERE portal_agendamento_id = '" . $created->data['entity']->id ."' 
                        AND (data_agendamento is null OR data_agendamento <> '" . $data_alterada . "')";

            $this->conn->query($sql);
        }

        if ($created->data['entity']->cesv_codigo_sara) {
            $sql = "UPDATE  t_loginfo_doc_agendamento_carga  set  "
                    . " cesv_id =  '" . $created->data['entity']->cesv_codigo_sara . "' "
                    . " where portal_agendamento_id = " . $created->data['entity']->id .
                    " and (  cesv_id is null or cesv_id <> '" . $created->data['entity']->cesv_codigo_sara . "')";
            $this->conn->query($sql);
        }

        if ($created->data['entity']->situacao_agendamento_id) {
            $sql = "UPDATE  t_loginfo_doc_agendamento_carga  set  "
                    . " status_portal =  " . $created->data['entity']->situacao_agendamento_id . " "
                    . " where portal_agendamento_id = " . $created->data['entity']->id .
                    " and ( status_portal is null or status_portal <> " . $created->data['entity']->situacao_agendamento_id . ")";

            $this->conn->query($sql);
        }

        $this->clonarAgendamento($created->data['entity']);
    }

    private function clonarAgendamento($dados) {
        $this->conecta_db_sql_server();

        $sql = "select count(*) as count from t_loginfo_doc_agendamento_portal   where id = " . $dados['id'];

        $possui_agendamento_sara = false;
        $res = $this->conn->query($sql);
        if (!$res) {
            return;
        }

        foreach (@$res as $i => $v) {
            if ($v['count'] > 0) {
                $possui_agendamento_sara = true;
            }
        }

        if (!$possui_agendamento_sara) {
            $sql = "insert into t_loginfo_doc_agendamento_portal ("
                    . 'id,' .
                    'slot_id,' .
                    'horario_id,' .
                    'horario_liberado_id,' .
                    'situacao_agendamento_id,' .
                    'titulo,' .
                    'descricao,' .
                    'data,' .
                    'hora,' .
                    'CPF_Motorista,' .
                    'nome_motorista,' .
                    'transportadora,' .
                    'CNPJ_transportadora,' .
                    'CNPJ_cliente,' .
                    'veiculo,' .
                    'reboque1,' .
                    'reboque2,' .
                    'comentario,' .
                    'entrada_id,' .
                    'operacao_id,' .
                    'programacao_codigo_sara,' .
                    'cesv_codigo_sara,' .
                    'transito_iniciado,' .
                    'data_solicitacao,' .
                    'data_inicio,' .
                    'data_chegou,' .
                    'data_liberado,' .
                    'data_entrada_cesv,' .
                    'data_conclusao_os,' .
                    'data_saida_cesv,' .
                    'created,' .
                    'created_by,' .
                    'modified,' .
                    'modified_by ) values (' .
                    "'" . $dados['id'] . "', " .
                    "'" . $dados['slot_id'] . "', " .
                    "'" . $dados['horario_id'] . "', " .
                    "'" . $dados['horario_liberado_id'] . "', " .
                    "'" . $dados['situacao_agendamento_id'] . "', " .
                    "'" . $dados['titulo'] . "', " .
                    "'" . $dados['descricao'] . "', " .
                    "'" . $this->formataData($dados['data']) . "', " .
                    "'" . $dados['hora'] . "', " .
                    "'" . $dados['CPF_Motorista'] . "', " .
                    "'" . $dados['nome_motorista'] . "', " .
                    "'" . $dados['transportadora'] . "', " .
                    "'" . $dados['CNPJ_transportadora'] . "', " .
                    "'" . $dados['CNPJ_cliente'] . "', " .
                    "'" . $dados['veiculo'] . "', " .
                    "'" . $dados['reboque1'] . "', " .
                    "'" . $dados['reboque2'] . "', " .
                    "'" . $dados['comentario'] . "', " .
                    "'" . $dados['entrada_id'] . "', " .
                    "'" . $dados['operacao_id'] . "', " .
                    "'" . $dados['programacao_codigo_sara'] . "', " .
                    "'" . $dados['cesv_codigo_sara'] . "', " .
                    "'" . $dados['transito_iniciado'] . "', " .
                    "'" . $this->formataData($dados['data_solicitacao']) . "', " .
                    "'" . $this->formataData($dados['data_inicio']) . "', " .
                    "'" . $this->formataData($dados['data_chegou']) . "', " .
                    "'" . $this->formataData($dados['data_liberado']) . "', " .
                    "'" . $this->formataData($dados['data_entrada_cesv']) . "', " .
                    "'" . $this->formataData($dados['data_conclusao_os']) . "', " .
                    "'" . $dados['data_saida_cesv'] . "', " .
                    "'" . $dados['created'] . "', " .
                    "'" . $dados['created_by'] . "', " .
                    "'" . $dados['modified'] . "', " .
                    "'" . $dados['modified_by'] . "') ";
        } else {
            $sql = "update  t_loginfo_doc_agendamento_portal set " .
                    "slot_id = '" . $dados['slot_id'] . "', " .
                    "horario_id = '" . $dados['horario_id'] . "', " .
                    "horario_liberado_id = '" . $dados['horario_liberado_id'] . "', " .
                    "situacao_agendamento_id = '" . $dados['situacao_agendamento_id'] . "', " .
                    "titulo = '" . $dados['titulo'] . "', " .
                    "descricao = '" . $dados['descricao'] . "', " .
                    "data ='" . $this->formataData($dados['data']) . "', " .
                    "hora = '" . $dados['hora'] . "', " .
                    "CPF_Motorista = '" . $dados['CPF_Motorista'] . "', " .
                    "nome_motorista = '" . $dados['nome_motorista'] . "', " .
                    "transportadora = '" . $dados['transportadora'] . "', " .
                    "CNPJ_transportadora = '" . $dados['CNPJ_transportadora'] . "', " .
                    "CNPJ_cliente = '" . $dados['CNPJ_cliente'] . "', " .
                    "veiculo = '" . $dados['veiculo'] . "', " .
                    "reboque1 = '" . $dados['reboque1'] . "', " .
                    "reboque2 = '" . $dados['reboque2'] . "', " .
                    "comentario = '" . $dados['comentario'] . "', " .
                    "entrada_id = '" . $dados['entrada_id'] . "', " .
                    "operacao_id = '" . $dados['operacao_id'] . "', " .
                    "programacao_codigo_sara = '" . $dados['programacao_codigo_sara'] . "', " .
                    "cesv_codigo_sara = '" . $dados['cesv_codigo_sara'] . "', " .
                    "transito_iniciado = '" . $dados['transito_iniciado'] . "', " .
                    "data_solicitacao = '" . $this->formataData($dados['data_solicitacao']) . "', " .
                    ($dados->dirty("data_inicio") ? "data_inicio = '" . $this->formataData($dados['data_inicio']) . "', " : '') .
                    ($dados->dirty("data_chegou") ? "data_chegou = '" . $this->formataData($dados['data_chegou']) . "', " : '') .
                    ($dados->dirty("data_liberado") ? "data_liberado = '" . $this->formataData($dados['data_liberado']) . "', " : '') .
                    ($dados->dirty("data_entrada_cesv") ? "data_entrada_cesv = '" . $this->formataData($dados['data_entrada_cesv']) . "', " : '') .
                    ($dados->dirty("data_conclusao_os") ? "data_conclusao_os = '" . $this->formataData($dados['data_conclusao_os']) . "', " : '') .
                    ($dados->dirty("data_saida_cesv") ? "data_saida_cesv = '" . $dados['data_saida_cesv'] . "', " : '') .
                    "created = '" . $dados['created'] . "', " .
                    "created_by = '" . $dados['created_by'] . "', " .
                    "modified = '" . $dados['modified'] . "', " .
                    "modified_by = " . $dados['modified_by'] . " where id =  " . $dados['id'];
        }

        $this->conn->query($sql);
    }

    private function formataData($data)
    {
        if (!$data) {
            return null;
        }
        $m = explode("/", $data);
        if (count($m) > 1) {
            return implode("-", array_reverse(explode("/", $data)));
        }
        return date("Y-m-d H:i:s", strtotime($data));
    }

    public $conn;

    public function conecta_db_sql_server()
    {
        try {
            $this->conn = new PDO(SQLSERVER_DSN, $_SESSION['SQLSERVER_USER'], $_SESSION['SQLSERVER_PASS']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    function beforeFind(Event $event, Query $query, $options, $primary)
    {
        $perfil_id = $_SESSION['Auth']['User']['perfil_id'];
        $perfilSemFiltro = [PERFIL_ADMIN, PERFIL_TRIAGEM, PERFIL_COMERCIAL, PERFIL_ARMAZEM, PERFIL_GATE, PERFIL_FATURAMENTO, PERFIL_CPO, PERFIL_COMEX];
        // dump($perfilSemFiltro); exit;
        if (in_array($perfil_id, $perfilSemFiltro) || (isset($options['asAdmin']) && $options['asAdmin'] == true)) {
            //administrador
            return;
        }

        if ($perfil_id == PERFIL_TRANSPORTADORA) {
            $list = '-1';
            foreach ($_SESSION['empresasDoUsuarios'] as $e) {
                $list .= ",'" . $e['empresa']['cnpj'] . "'";
            }

            $conditions = $query->where('CNPJ_transportadora in('.$list.')');
            return;
        }

        $list = '-1';
        foreach ($_SESSION['empresasDoUsuarios'] as $e) {
            $list .= ",'" . $e['empresa']['cnpj'] . "'";
        }

        if (in_array($perfil_id, [PERFIL_PARCEIRO_COMERCIAL])) {

            $list_parceiro = '0';
            foreach ($_SESSION['empresasDoUsuarios'] as $e) {
                if ($e['perfil_id'] == PERFIL_PARCEIRO_COMERCIAL) {
                    $list_parceiro .= ",'" . $e['empresa']['id'] . "'";
                }
            }

            $connection = ConnectionManager::get('default');
            $sql = "select * 
                    from v_agendamento_parceiro 
                    where empresa_parceira_comercial_id in($list_parceiro) limit 1000";
            $data = $connection->execute($sql)->fetchAll('assoc');

            $list_id_agendamento_portal = '0';
            foreach ($data as $item) {
                $list_id_agendamento_portal .= ',' . $item['agendamento_id'];
            }

            $conditions = $query->where('(agendamentos.id in ('. ($list_id_agendamento_portal ? $list_id_agendamento_portal : '0') . ') or agendamentos.created_by  = ' . $_SESSION['Auth']['User']['id'] . ')');
            return;
        }

        if (@$_SESSION['liberacao_acesso']) {
            $this->conecta_db_sql_server();

            $list_id_agendamento = [];
            $list_id_agendamento_portal = '';
            foreach ($_SESSION['liberacao_acesso'] as $e) {
                $sql = "select portal_agendamento_id 
                        from t_loginfo_doc_agendamento_carga t, tab_clientes c  
                        where 
                            cli_id= ben_id and 
                            qt_carregada > 0 and  
                            cli_cgc = " . $e->empresas_cliente->cnpj . " and 
                            latu_lote = $e->lote and  
                            latu_item = $e->num and 
                            status_portal > 0  ";
                
                foreach ($this->conn->query($sql) as $agendamento_sara) {
                    if (!in_array($agendamento_sara['portal_agendamento_id'], $list_id_agendamento)) {
                        $list_id_agendamento[] = $agendamento_sara['portal_agendamento_id'];
                    }
                }

                if (count($list_id_agendamento) >= 1) {
                    $list_id_agendamento_portal .= implode(',', $list_id_agendamento);
                }
            }

            $conditions = $query->where('(agendamentos.id in ('.($list_id_agendamento_portal ? $list_id_agendamento_portal : '0').') or agendamentos.created_by = '.$_SESSION['Auth']['User']['id'].')');
            return;
        }

        $conditions = $query->where('(CNPJ_cliente in ('.$list.') or agendamentos.created_by = '.$_SESSION['Auth']['User']['id'].')');
        return;
    }

    public function afterDelete($deletado)
    {
        $this->conecta_db_sql_server();

        if (@$deletado->data['entity']->id) {
            $sql = "DELETE t_loginfo_doc_agendamento_carga 
                    WHERE portal_agendamento_id = " . $deletado->data['entity']->id;
        }

        $this->conn->query($sql);

        if (@$deletado->data['entity']->id) {
            $sql = "DELETE t_loginfo_doc_agendamento_portal 
                    WHERE id = " . $deletado->data['entity']->id;
        }

        $this->conn->query($sql);
    }
}
