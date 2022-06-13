<?php

use Cake\ORM\TableRegistry;

namespace App\Model\Table;

use App\Model\Entity\LotesDisBloqueado;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
use PDO;
use PDOException;
use Cake\Event\Event;
use ArrayObject;
use Cake\ORM\TableRegistry;

/**
 * LotesDisBloqueados Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ContratosBloqueios
 * @property \Cake\ORM\Association\BelongsTo $TiposBloqueios
 * @property \Cake\ORM\Association\BelongsTo $TiposUnidades
 */
class LotesDisBloqueadosTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('lotes_dis_bloqueados');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('ContratosBloqueios', [
            'foreignKey' => 'contratos_bloqueio_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TiposBloqueios', [
            'foreignKey' => 'tipos_bloqueio_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('LotesLiberados', [
            'foreignKey' => 'lotes_dis_bloqueado_id',
            'joinType' => 'left'
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
                ->allowEmpty('nr_lote');

        $validator
                ->allowEmpty('nr_di');

        $validator
                ->add('peso_bloqueado', 'valid', ['rule' => 'decimal'])
                ->requirePresence('peso_bloqueado', 'create')
                ->notEmpty('peso_bloqueado');

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
        $rules->add($rules->isUnique(['nr_lote'], 'Já possui um contrato vinculado a este lote', [
        ]));
        $rules->add($rules->existsIn(['contratos_bloqueio_id'], 'ContratosBloqueios'));
        $rules->add($rules->existsIn(['tipos_bloqueio_id'], 'TiposBloqueios'));
        return $rules;
    }

    public function afterSave($created) {
        $this->conecta_db_sql_server();

        $sql = "select * from t_loginfo_lotes_dis_bloqueados  where id = '" . $created->data['entity']->id . "'  ";

        $tem_log_lote = false;
        $query = $this->conn->query($sql);
        //debug($sql);die();
        foreach ($query as $item) {
            $tem_log_lote = true;
            //     debug($item);die();
        }

        $contratosBloqueios = TableRegistry::get('ContratosBloqueios');
        $contratosBloqueios_list = $contratosBloqueios->find('all')->where(['id' => @$created->data['entity']->contratos_bloqueio_id])->first();
        $nr_contrato ='';
        if($contratosBloqueios_list->nr_contrato){
            $nr_contrato = $contratosBloqueios_list->nr_contrato;
        }
      //  die();

        $peso = number_format(($created->data['entity']->peso_bloqueado), 4, '.', '');
        if ($tem_log_lote) {
            $sql = "UPDATE t_loginfo_lotes_dis_bloqueados set " .
                    "id = '" . $created->data['entity']->id . "', "
                    . "contratos_bloqueio_id = '" . $created->data['entity']->contratos_bloqueio_id . "', "
                    . "tipos_bloqueio_id = '" . $created->data['entity']->tipos_bloqueio_id . "', "
                    . "nr_lote = '" . $created->data['entity']->nr_lote . "', "
                    . "nr_di = '" . $created->data['entity']->nr_di . "', "
                    . "tipo_unidade = '" . $created->data['entity']->tipo_unidade . "', "
                    . "peso_bloqueado = '" . $peso . "', "
                    . "bloqueio_peso = '" . $created->data['entity']->bloqueio_peso . "' "
                       . "nr_contrato = '" . $nr_contrato . "' "
                    . " where id = '" . $created->data['entity']->id . "'  ";
            $this->conn->query($sql);
        } else {
            $sql = "Insert Into t_loginfo_lotes_dis_bloqueados "
                    . " (id, contratos_bloqueio_id,tipos_bloqueio_id,nr_lote,nr_di,tipo_unidade,peso_bloqueado,bloqueio_peso,nr_contrato)"
                    . " values ( "
                    . "  '" . $created->data['entity']->id . "', "
                    . "  '" . $created->data['entity']->contratos_bloqueio_id . "', "
                    . "  '" . $created->data['entity']->tipos_bloqueio_id . "', "
                    . "  '" . $created->data['entity']->nr_lote . "', "
                    . "  '" . $created->data['entity']->nr_di . "', "
                    . "  '" . $created->data['entity']->tipo_unidade . "', "
                    . "  '" . $peso . "', "
                    . "  '" . $created->data['entity']->bloqueio_peso . "' , "
                    . "  '" . $nr_contrato . "' ) ";
            $this->conn->query($sql);
        }

        // debug($sql);       die();
    }

    public $conn;

    public function conecta_db_sql_server() {
        try {
            $this->conn = new PDO(SQLSERVER_DSN, SQLSERVER_USER, SQLSERVER_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function beforeDelete($delete) {
        $this->conecta_db_sql_server();

        $sql = "delete from  t_loginfo_lotes_dis_bloqueados "
                . " where  id = '" . $delete->data['entity']['id'] . "' "
        ;
        $this->conn->query($sql);
    }

}
