<?php

namespace App\Model\Table;

use App\Model\Entity\ZonaPrimaria;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use PDO;
use PDOException;
use Cake\Event\Event;
use ArrayObject;
use App\Controller\Component\ClonarComponent;

/**
 * Entradas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TipoNaturezas
 * @property \Cake\ORM\Association\BelongsTo $Empresas
 * @property \Cake\ORM\Association\BelongsTo $Documentos
 * @property \Cake\ORM\Association\BelongsTo $NavioViagens
 * @property \Cake\ORM\Association\BelongsTo $Procedencias
 * @property \Cake\ORM\Association\HasMany $Agendamentos
 * @property \Cake\ORM\Association\HasMany $ItemAgendamentos
 * @property \Cake\ORM\Association\BelongsToMany $Lotes
 */
class ZonaPrimariasTable extends Table {

    /**
     * Status
     * @var type 
     */
    public $status = [
        -1 => 'Pendente',
        1 => 'Cadastrando',
        2 => 'Cadastrado',
        3 => 'Integrado',
        4 => 'Relacionado documento de entrada', //quando vincular a um documento de entrada
        10 => 'Finalizado',
        20 => "Gerado lote" // somente será visualizado no portal no lote
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('entradas');
        $this->displayField('numero_documento');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsToMany('Agendamentos', [
            'propertyName' => 'Agendamentos',
            'foreignKey' => 'entrada_id',
            'targetForeignKey' => 'agendamento_id',
            'joinTable' => 'item_agendamentos'
        ]);


        $this->belongsTo('Documentos', [
            'foreignKey' => 'documento_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('empresa_parceira_comercial', [
            'className' => 'Empresas',
            'foreignKey' => 'empresa_parceira_comercial_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('ItemAgendamentos', [
            'foreignKey' => 'entrada_id'
        ]);
        $this->belongsToMany('Containers', [
            'propertyName' => 'Containers',
            'foreignKey' => 'entrada_id',
            'targetForeignKey' => 'container_id',
            'joinTable' => 'entradas_containers'
        ]);

        $this->belongsToMany('Lotes', [
            'propertyName' => 'Lotes',
            'foreignKey' => 'entrada_id',
            'targetForeignKey' => 'lote_id',
            'joinTable' => 'entradas_lotes'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create');


        $validator
                ->add('valor_cif', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('valor_cif');

        $validator
                ->notEmpty('numero_documento')
                ->add('numero_documento', 'unique', ['rule' => 'validateUnique', 'provider' => 'table',
                    'message' => 'Já cadastrado'])
        ;

        $validator
                ->notEmpty('data_emissao');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['documento_id'], 'Documentos'));
        $rules->add($rules->isUnique(['numero_documento']));
        return $rules;
    }

    // public $conn;

    // public function conecta_db_sql_server() {
    //     try {
    //         $this->conn = new PDO(SQLSERVER_DSN, SQLSERVER_USER, SQLSERVER_PASS);
    //         $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
    //     } catch (PDOException $e) {
    //         echo $e->getMessage();
    //         //  die();
    //     }
    // }

    public function afterSave($created) {
     /*   die();
        debug($var);
        $this->clonar($created->data['entity']);*/
    }

    public function beforeSave($event, $entity, $options) {
        /*   if (!$entity->data_solicitacao) {
          $entity->data_solicitacao = date('Y-m-d H:i:s');
          }


          $entity->created = date('Y-m-d H:i:s');
          $entity->modified = date('Y-m-d H:i:s'); */
    }

    public function clonar($dados) {
        //debug($dados['entity']);die();
        $tabela = 'entradas';
        $campos_data = ['data_emissao'];
        $campos = [
            'id',
            'numero_documento',
             'status',
            'observacoes',
            'empresa_id',
            'documento_id',
            'codigo_dent_id',
            'CNPJ_transportadora',
            'transportadora',
            'empresa_parceira_comercial_id',
            'oculto',
            'controlado',
            'scanner_container'
        ];

        $conexao = new ClonarComponent(new \Cake\Controller\ComponentRegistry());
        $conn = $conexao->conecta_db_sql_server_clonar();

        $sql = "select count(*) as count from $tabela   where id = " . $dados['id'];

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

            //   debug($sql);die();
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
             //debug($sql);die();
        };
    }

    private function formataData($data) {
        if (!$data) {
            return null;
        }
        $m = explode("/", $data);
        if (count($m) > 1) {
            return implode("-", array_reverse(explode("/", $data)));
        }
        return date("Y-m-d H:i:s", strtotime($data));
    }

}
