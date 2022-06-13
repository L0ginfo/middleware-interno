<?php
namespace App\Model\Table;

use App\Model\Entity\DocumentoSaida;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use ArrayObject;
use Cake\Datasource\ConnectionManager;
use PDO;
use PDOException;
use App\Controller\Component\AclComponent;
use App\Model\Entity\Perfis;
use App\Controller\Component\ClonarComponent;
use App\Controller\Component\LogComponent;

/**
 * DocumentoSaida Model
 */
class DocumentoSaidaTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('documento_saida');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');
        
        $this->belongsTo('Documentos', [
            'foreignKey' => 'documento_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TipoNaturezas', [
            'foreignKey' => 'tipo_natureza_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('moedaFob', [
            'foreignKey' => 'moeda_id_fob',
            'className' => 'Moedas',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('moedaFrete', [
            'foreignKey' => 'moeda_id_frete',
            'className' => 'Moedas',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('moedaSeguro', [
            'foreignKey' => 'moeda_id_seguro',
            'className' => 'Moedas',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('moedaCif', [
            'foreignKey' => 'moeda_id_cif',
            'className' => 'Moedas',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Anexos', [
            'foreignKey' => 'documento_saida_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('DocumentoSaidaPendencias', [
            'foreignKey' => 'documento_saida_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('DocumentoSaidaItem', [
            'foreignKey' => 'documento_saida_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Canal', [
            'foreignKey' => 'canal_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Embalagens', [
            'foreignKey' => 'embalagem_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Pendencias', [
            'foreignKey' => 'id_modelo',
            'joinType' => 'LEFT',
            'conditions' => ['modelo' => 'Documento Saida'],
            'order' => 'PendenciaTipos.peso ASC',
        ]);
        $this->belongsTo('cliente', [
            'foreignKey' => 'cnpjcliente',
            'bindingKey' => 'cnpj',
            'className' => 'Empresas',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('despachante', [
            'foreignKey' => 'cnpjdespachante',
            'bindingKey' => 'cnpj',
            'className' => 'Empresas',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Perfis');

    }

    /*
     * addForaDoHorario() metodo
     *
     * Verifica se tem permissao no ACL para poder salvar
     * um documento fora do horario permitido
     */
    public function addForaDoHorario() 
    {
        $lista = $this->Perfis->find('all')
            ->where(['id' => $_SESSION['Auth']['User']['perfil_id'], 'sistema_id' => SISTEMA])
            ->first()
            ->acl;

        $acl = new AclComponent(new \Cake\Controller\ComponentRegistry());
        $permite = $acl->check('documentoSaida', 'addForaDoHorario', $lista);
        
        if ($permite == true) {
            return true; 
        } else {
            return false;
        }
    }

    public function validationDefault(Validator $validator)
    {
        /*
         * verifica se tem permissao para salvar depois do horario permitido,
         * se tiver, so valida apenas dois campos,
         * caso contrario valida os demais.
         */
        $permiteSalvar = $this->addForaDoHorario();

        if ($permiteSalvar == false) {
            $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create');
            $validator
                ->requirePresence('doc_saida', 'create')
                ->notEmpty('doc_saida');
            $validator
                ->requirePresence('documento_id', 'create')
                ->notEmpty('documento_id');
            $validator
                ->requirePresence('tipo_natureza_id', 'create')
                ->notEmpty('tipo_natureza_id');
            $validator
                ->requirePresence('data_registro', 'create')
                ->notEmpty('data_registro');
            $validator
                ->requirePresence('quantidade_declarada', 'create')
                ->notEmpty('quantidade_declarada');
            $validator
                ->requirePresence('embalagem_id', 'create')
                ->notEmpty('embalagem_id');
            $validator
                ->requirePresence('quantidade_adicao', 'create')
                ->notEmpty('quantidade_adicao');
            $validator
                ->requirePresence('peso_bruto', 'create')
                ->notEmpty('peso_bruto');
            $validator
                ->requirePresence('peso_liq', 'create')
                ->notEmpty('peso_liq');
            $validator
                ->requirePresence('cnpjcliente', 'create')
                ->notEmpty('cnpjcliente');
            $validator
                ->requirePresence('cnpjdespachante', 'create')
                ->notEmpty('cnpjdespachante');
            $validator
                ->requirePresence('cpfrepresentante', 'create')
                ->notEmpty('cpfrepresentante');
            $validator
                ->requirePresence('moeda_id_fob', 'create')
                ->notEmpty('moeda_id_fob');
            $validator
                ->requirePresence('moeda_id_seguro', 'create')
                ->notEmpty('moeda_id_seguro');
            $validator
                ->requirePresence('moeda_id_frete', 'create')
                ->notEmpty('moeda_id_frete');
            $validator
                ->requirePresence('valor_frete', 'create')
                ->notEmpty('valor_frete');
            $validator
                ->requirePresence('valor_fob', 'create')
                ->notEmpty('valor_fob');
            $validator
                ->requirePresence('valor_seguro', 'create')
                ->notEmpty('valor_seguro');
            $validator
                ->requirePresence('valor_cif', 'create')
                ->notEmpty('valor_cif');
            $validator
                ->requirePresence('data_desembaraco', 'create')
                ->notEmpty('data_desembaraco');
            $validator
                ->requirePresence('canal_id', 'create')
                ->notEmpty('canal_id');
            // if ($entity->documento_id != 9) {
            //     $validator
            //         ->requirePresence('nome_adquirente', 'create')
            //         ->notEmpty('nome_adquirente', 'Preencha');
            // }
        } else {
            $validator
                ->requirePresence('doc_saida', 'create')
                ->notEmpty('doc_saida');
            $validator
                ->requirePresence('documento_id', 'create')
                ->notEmpty('documento_id');
        }
        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['documento_id'], 'Documentos'));
        $rules->add($rules->existsIn(['tipo_natureza_id'], 'TipoNaturezas'));
        $rules->add($rules->isUnique(
            ['doc_saida'],
            'Já existe um cadastro para esse processo'
        ));

        return $rules;
    }

    public function beforeSave($event, $entity, $options) 
    {
        /* Data cadastro quando salva primeira vez */
        if (!$entity->data_cadastro) {
            $entity->data_cadastro = date('Y-m-d H:i:s');
        }

        /* Data recepcao quando status for para cadastrado */
        if ($entity->status == 1) {
            $entity->data_recepcao = date('Y-m-d H:i:s');
        }

        /* Data analise quando status for para analise */
        if ($entity->status == 2) {
            $entity->data_analise = date('Y-m-d H:i:s');
        }

        /* Data liberacao quando liberado pela primeira vez */
        if ($entity->status == 4) {
            $entity->data_liberacao = date('Y-m-d H:i:s');
        }

        /* Data liberacao quando liberado no portal pela primeira vez */
        if ($entity->status == 7) {
            $entity->data_liberacao = date('Y-m-d H:i:s');
        }

        $entity->termo_aceite = 1;
    }

    public function afterSave($created) 
    {
        $this->clonar($created->data['entity']);
        $this->logDocumentoSaida($created->data['entity']);
    }

    private function logDocumentosaida ($dados = null, $action = null) {

        $conexao = new LogComponent(new \Cake\Controller\ComponentRegistry());
        $db = $conexao->conecta_db_my_sql();
        if ($action == "D") {
            $acao = "D";
        } else {
            $sql = "select count(*) as count from l_documento_saida where l_id = " . $dados['id'];
            if (!$sql) {
                return;
            }
            $existe = false;
            $res = $db->query($sql);
            foreach ($res as $r) {
                if ($r['COUNT'] > 0) {
                    $existe = true;
                }
            }
            if ($existe) {
                $acao = "U";
            } else {
                $acao = "I";
            }
        }

        if ($dados['data_cadastro']) {
            if (getType($dados['data_cadastro']) != 'string') {
                $dados['data_cadastro'] = $dados['data_cadastro']->format("Y-m-d H:i:s");
            }
        }
        if ($dados['data_registro']) {
            if (getType($dados['data_registro']) != 'string') {
                $dados['data_registro'] = $dados['data_registro']->format("Y-m-d H:i:s");
            }
        }
        if ($dados['data_recepcao']) {
            if (getType($dados['data_recepcao']) != 'string') {
                $dados['data_recepcao'] = $dados['data_recepcao']->format("Y-m-d H:i:s");
            }
        }
        if ($dados['data_analise']) {
            if (getType($dados['data_analise']) != 'string') {
                $dados['data_analise'] = $dados['data_analise']->format("Y-m-d H:i:s");
            }
        }
        if ($dados['data_desembaraco']) {
            if (getType($dados['data_desembaraco']) != 'string') {
                $dados['data_desembaraco'] = $dados['data_desembaraco']->format("Y-m-d H:i:s");
            }
        }
        if ($dados['data_liberacao']) {
            if (getType($dados['data_liberacao']) != 'string') {
                $dados['data_liberacao'] = $dados['data_liberacao']->format("Y-m-d H:i:s");
            }
        }

        $usuario_id = $_SESSION['Auth']['User']['id'];
        $sql = "insert into l_documento_saida ("
                . 'acao,' .
                'data_hora,' .
                'usuario_id,' .
                'l_id,' .
                'l_liberacao,' .
                'l_doc_saida,' .
                'l_documento_id,' .
                'l_di_entreposto,' .
                'l_da_entreposto,' .
                'l_di_parte,' .
                'l_numero_bl_parte,' .
                'l_numero_di_parte,' .
                'l_ra_origem,' .
                'l_recinto_origem,' .
                'l_ra_destino,' .
                'l_recinto_destino,' .
                'l_scanner,' .
                'l_tipo_natureza_id,' .
                'l_nome_adquirente,' .
                'l_cnpjadquirente,' .
                'l_nome_cliente,' .
                'l_cnpjcliente,' .
                'l_nome_despachante,' .
                'l_cnpjdespachante,' .
                'l_nome_representante,' .
                'l_cpfrepresentante,' .
                'l_moeda_id_fob,' .
                'l_moeda_id_frete,' .
                'l_moeda_id_seguro,' .
                'l_moeda_id_cif,' .
                'l_data_cadastro,' .
                'l_data_registro,' .
                'l_data_recepcao,' .
                'l_data_analise,' .
                'l_data_desembaraco,' .
                'l_data_liberacao,' .
                'l_quantidade_declarada,' .
                'l_peso_bruto,' .
                'l_peso_liq,' .
                'l_quantidade_adicao,' .
                'l_valor_frete,' .
                'l_valor_fob,' .
                'l_valor_seguro,' .
                'l_valor_cif,' .
                'l_valor_cif_reais,' .
                'l_canal_id,' .
                'l_embalagem_id,' .
                'l_xml,' .
                'l_termo_aceite,' .
                'l_status,' .
                'l_status_liberacao ) values (' .
                "'" . $acao . "', " .
                "now(), " .
                "" . $usuario_id . ", " .
                "'" . $dados['id'] . "', " .
                "'" . $dados['liberacao'] . "', " .
                "'" . $dados['doc_saida'] . "', " .
                "'" . $dados['documento_id'] . "', " .
                "'" . $dados['di_entreposto'] . "', " .
                "'" . $dados['da_entreposto'] . "', " .
                "'" . $dados['di_parte'] . "', " .
                "'" . $dados['numero_bl_parte'] . "', " .
                "'" . $dados['numero_di_parte'] . "', " .
                "'" . $dados['ra_origem'] . "', " .
                "'" . $dados['recinto_origem'] . "', " .
                "'" . $dados['ra_destino'] . "', " .
                "'" . $dados['recinto_destino'] . "', " .
                "'" . $dados['scanner'] . "', " .
                "'" . $dados['tipo_natureza_id'] . "', " .
                "'" . $dados['nome_adquirente'] . "', " .
                "'" . $dados['cnpjadquirente'] . "', " .
                "'" . $dados['nome_cliente'] . "', " .
                "'" . $dados['cnpjcliente'] . "', " .
                "'" . $dados['nome_despachante'] . "', " .
                "'" . $dados['cnpjdespachante'] . "', " .
                "'" . $dados['nome_representante'] . "', " .
                "'" . $dados['cpfrepresentante'] . "', " .
                "'" . $dados['moeda_id_fob'] . "', " .
                "'" . $dados['moeda_id_frete'] . "', " .
                "'" . $dados['moeda_id_seguro'] . "', " .
                "'" . $dados['moeda_id_cif'] . "', " .
                "'" . $dados['data_cadastro'] . "', " .
                "'" . $dados['data_registro'] . "', " .
                "'" . $dados['data_recepcao'] . "', " .
                "'" . $dados['data_analise'] . "', " .
                "'" . $dados['data_desembaraco'] . "', " .
                "'" . $dados['data_liberacao'] . "', " .
                "'" . $dados['quantidade_declarada'] . "', " .
                "'" . $dados['peso_bruto'] . "', " .
                "'" . $dados['peso_liq'] . "', " .
                "'" . $dados['quantidade_adicao'] . "', " .
                "'" . $dados['valor_frete'] . "', " .
                "'" . $dados['valor_fob'] . "', " .
                "'" . $dados['valor_seguro'] . "', " .
                "'" . $dados['valor_cif'] . "', " .
                "'" . $dados['valor_cif_reais'] . "', " .
                "'" . $dados['canal_id'] . "', " .
                "'" . $dados['embalagem_id'] . "', " .
                "'" . $dados['xml'] . "', " .
                "'" . $dados['termo_aceite'] . "', " .
                "'" . $dados['status'] . "', " .
                "'" . $dados['status_liberacao'] . "') ";

        $db->query($sql);
    }

    /*
     * Metodo clonar()
     * @param $dados 
     *
     * Verifica os campos e salva na $tabela da base de dados Portal do SQLServer
     */
    private function clonar($dados) 
    {
        $tabela = 'documento_saida';
        $campos_data = ['data_cadastro', 'data_registro', 'data_recepcao', 'data_desembaraco', 'data_liberacao'];
        $campos = ['id',
            'doc_saida',
            'documento_id',
            'di_entreposto',
            'da_entreposto',
            'di_parte',
            'numero_bl_parte',
            'numero_di_parte',
            'tipo_natureza_id',
            'nome_adquirente',
            'cnpjadquirente',
            'nome_cliente',
            'cnpjcliente',
            'nome_despachante',
            'cnpjdespachante',
            'nome_representante',
            'cpfrepresentante',
            'moeda_id_fob',
            'moeda_id_frete',
            'moeda_id_seguro',
            'quantidade_declarada',
            'peso_bruto',
            'peso_liq',
            'quantidade_adicao',
            'valor_frete',
            'valor_fob',
            'valor_seguro',
            'valor_cif',
            'canal_id',
            'termo_aceite',
            'status',
        ];

        $conexao = new ClonarComponent(new \Cake\Controller\ComponentRegistry());
        $conn = $conexao->conecta_db_sql_server_clonar();
        $sql = "select count(*) as count from $tabela where id = " . $dados['id'];
        $existe = false;
        $res = $conn->query($sql);

        if (!$res) {
            return;
        }
        foreach (@$res as $i => $v) {
            if ($v['count'] > 0) {
                $existe = true;
            }
        }

        if ($existe) {
            $sql_campos = '';
            foreach ($campos as $i) {
                $sql_campos .= (@$sql_campos ? ' , ' : '' );
                $sql_campos .= " $i = '" . $dados[$i] . "' ";
            }
            foreach ($campos_data as $i) {
                if ($dados->dirty($i)) {
                    $sql_campos .= (@$sql_campos ? ' , ' : '' );
                    $sql_campos .= "$i = '" . $this->formataData($dados[$i]) . "' ";
                }
            }
            $sql = "update $tabela set " . $sql_campos . ' where id = ' . $dados['id'];
            $conn->query($sql); 
        } else {
            $sql_campos = '';
            $sql_valor = '';
            foreach ($campos as $i) {
                @$sql_valor .= (@$sql_valor ? ' , ' : '' );
                $sql_valor .= "'" . $dados[$i] . "' ";
                $sql_campos .= (@$sql_campos ? ' , ' : '' );
                $sql_campos .= $i;
            }
            foreach ($campos_data as $i) {
                if ($dados->dirty($i)) {
                    @$sql_valor .= (@$sql_valor ? ' , ' : '' );
                    @$sql_valor .= "'" . $this->formataData($dados[$i]) . "' ";
                    @$sql_campos .= (@$sql_campos ? ' , ' : '' );
                    $sql_campos .= $i;
                }
            }
            $sql = "insert into $tabela  (" . $sql_campos . ' ) VALUES ( ' . $sql_valor . ")";
            $conn->query($sql);
        }
    }

    /*
     * Metodo formataData()
     * @param $data
     *
     * Formata os $campos_data que vem do metodo clonar() para ficar no padrao do SQLServer
     */
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

    /*
     * Metodo afterDelete
     * @param $deletado
     *
     * Apos deletar do MySQL ele deleta do SQLServer tambem
     */
    public function afterDelete($deletado)
    {
        $conexao = new ClonarComponent(new \Cake\Controller\ComponentRegistry());
        $conn = $conexao->conecta_db_sql_server_clonar();

        if (@$deletado->data['entity']->id) {
            $sql = "DELETE documento_saida 
                    WHERE id = " . $deletado->data['entity']->id;
        }

        $conn->query($sql);

        $this->logDocumentoSaida($deletado->data['entity'], "D");
    }

    /*
     * Metodo beforeFind()
     *
     * Executado toda vez que é chamado a model,
     * filtrando os documentos de acordo com o perfil
     */
    function beforeFind(Event $event, Query $query, $options, $primary) 
    {
        $empresasUsuariosTable = TableRegistry::get('EmpresasUsuarios');
        $empresasUsuarios = $empresasUsuariosTable->find('all')->contain(['Empresas'])->where(['usuario_id' => $_SESSION['Auth']['User']['id']])->toArray();

        if ($_SESSION['Auth']['User']['perfil_id'] == PERFIL_ADMIN) {
            return;
        }

        if ($_SESSION['Auth']['User']['perfil_id'] == PERFIL_DESPACHANTE) {
            $list_despachantes = '0';
            $list_cliente = '0';
            foreach ($empresasUsuarios as $e) {
                if ($e['perfil_id'] == PERFIL_CLIENTE) {
                    $list_cliente .= ",'" . $e['empresa']['cnpj'] . "'";
                }
                if ($e['perfil_id'] == PERFIL_DESPACHANTE) {
                    $list_despachantes .= ",'" . $e['empresa']['cnpj'] . "'";
                }
            }
            $conditions = $query->where('cnpjcliente  in (' . $list_cliente . ') and cnpjdespachante  in (' . $list_despachantes . ')');
        }
    }

}
