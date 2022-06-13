<?php

namespace App\Model\Table;

use App\Model\Entity\ItemAgendamento;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;
use Cake\Datasource\ConnectionManager;
use PDO;
use PDOException;
use App\Controller\Component\ClonarComponent;

/**
 * ItemAgendamentos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Agendamentos
 * @property \Cake\ORM\Association\BelongsTo $Entradas
 * @property \Cake\ORM\Association\BelongsTo $Itens
 * @property \Cake\ORM\Association\BelongsTo $Containers
 */
class ItemAgendamentosTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('item_agendamentos');

        $this->addBehavior('LogsTabelas');
        
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Agendamentos', [
            'foreignKey' => 'agendamento_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Entradas', [
            'foreignKey' => 'entrada_id',
            'joinType' => 'left'
        ]);
        $this->belongsTo('Itens', [
            'foreignKey' => 'item_id',
            'joinType' => 'left'
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'left'
        ]);

        $this->belongsTo('Lotes', [
            'foreignKey' => 'lote_id'
        ]);

        $this->belongsTo('NotaFiscalItem', [
            'foreignKey' => 'nota_fiscal_item_id',
            'joinType' => 'INNER'
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
                ->add('quantidade', 'valid', ['rule' => 'numeric'])
                ->requirePresence('quantidade', 'create')
                ->notEmpty('quantidade');

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
        $rules->add($rules->existsIn(['agendamento_id'], 'Agendamentos'));
        $rules->add($rules->existsIn(['entrada_id'], 'Entradas'));
        $rules->add($rules->existsIn(['item_id'], 'Itens'));
        return $rules;
    }

    public function beforeSave($event, $entity, $options) {
        $entity->entrada_id = ($entity->entrada_id ? $entity->entrada_id : null);
        $entity->item_id = ($entity->item_id ? $entity->item_id : null);
        $entity->container_id = ($entity->container_id ? $entity->container_id : null);
        $entity->lote_id = ($entity->lote_id ? $entity->lote_id : null);
    }

    public function afterDelete($deletado) {

        $conexao = new ClonarComponent(new \Cake\Controller\ComponentRegistry());
        $conn = $conexao->conecta_db_sql_server_clonar();

        if (@$deletado->data['entity']->id) {
            $sql = "delete  item_agendamentos  where"
                    . " id = " . $deletado->data['entity']->id;
            ;
        }
        $conn->query($sql);
    }

    public function afterSave($created) {
        $this->clonar($created->data['entity']);
    }

    
    private function clonar($dados) {

        $tabela = 'item_agendamentos';
        $campos_data = [];
        $campos = [
            'id',
            'agendamento_id',
            'quantidade',
            'entrada_id',
            'item_id',
            'container_id',
            'lote_id',
            'lote_sara',
            'item_id_sara',
            'doc_sara',
            'lote_item',
            'produto_item',
            'todasDI'
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


            //debug($sql);die();
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
