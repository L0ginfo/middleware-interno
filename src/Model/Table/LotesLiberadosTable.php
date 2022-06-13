<?php

namespace App\Model\Table;

use Cake\ORM\TableRegistry;
use App\Model\Entity\LotesLiberado;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use PDO;
use PDOException;
use Cake\Event\Event;
use ArrayObject;

/**
 * LotesLiberados Model
 *
 * @property \Cake\ORM\Association\BelongsTo $LotesDisBloqueados
 * @property \Cake\ORM\Association\BelongsTo $TiposUnidades
 * @property \Cake\ORM\Association\BelongsTo $Usuarios
 */
class LotesLiberadosTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public $virtualFields = array(
        'totalLiberado' => 'SUM(lotes_liberados.peso_liberado)'
    );

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('lotes_liberados');
        $this->displayField('id');
        $this->primaryKey('id');


        $this->addBehavior('LogsTabelas');

        $this->belongsTo('LotesDisBloqueados', [
            'foreignKey' => 'lotes_dis_bloqueado_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ItensLotesDisBloqueados', [
            'foreignKey' => 'itens_lotes_dis_bloqueados_id',
            'joinType' => 'LEFT INNER'
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
                ->add('peso_liberado', 'valid', ['rule' => 'decimal'])
                ->requirePresence('peso_liberado', 'create')
                ->notEmpty('peso_liberado');

        $validator
                ->requirePresence('dt_liberacao', 'create')
                ->notEmpty('dt_liberacao');

        
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
        $rules->add($rules->existsIn(['lotes_dis_bloqueado_id'], 'LotesDisBloqueados'));
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));
        return $rules;
    }

    public function getTotalLiberado($idLoteBloqueado) {
        //verifica a quantidade já liberada do Lote
        $query = $this->find()->where(['lotes_dis_bloqueado_id' => $idLoteBloqueado]);
        $query->select(['itens_lotes_dis_bloqueados_id', 'totalLiberado' => $query->func()->sum('peso_liberado')])->group('itens_lotes_dis_bloqueados_id');
        $totalLiberado = $query->all();
        $liberadoItem = null;
        foreach ($totalLiberado as $totalItem) {
            $liberadoItem[$totalItem->itens_lotes_dis_bloqueados_id] = $totalItem->totalLiberado;
        }

        return $liberadoItem;
    }

    public function afterSave($created) {

        $this->conecta_db_sql_server();

        $sql = "select * from t_loginfo_lotes_liberados  where id = '" . $created->data['entity']->id . "'  ";

        $tem_log_lote = false;
        $query = $this->conn->query($sql);

        foreach ($query as $item) {
            $tem_log_lote = true;
        }

        $lote_bloqueado_model = TableRegistry::get('LotesDisBloqueados');

        $lote_bloqueado = $lote_bloqueado_model->find('all', ['fields' => ['nr_lote']])->where(['id' => $created->data['entity']->lotes_dis_bloqueado_id])->first();


        $nr_lote = '';
        if ($lote_bloqueado) {
            $nr_lote = $lote_bloqueado->nr_lote;
        }


      $peso = number_format(($created->data['entity']->peso_liberado), 4, '.', '');
      
                
        if ($tem_log_lote) {
            $sql = "UPDATE t_loginfo_lotes_liberados set "
                    . "lote_id = '" . $nr_lote . "', "
                    . "lote_dis_bloqueados_id = '" . $created->data['entity']->lotes_dis_bloqueado_id . "', "
                    . "itens_lotes_dis_bloqueados_id = '" . $created->data['entity']->itens_lotes_dis_bloqueados_id . "', "
                    . "lote_tipo_unidade = '" . $created->data['entity']->tipo_unidade . "', "
                    . "lote_data_liberado = '" . $created->data['entity']->dt_liberacao->format('d-m-Y'). "', "
                    . "lote_peso_liberado = '" . $peso . "' "
                    . "where  id = '" . $created->data['entity']->id . "' "
            ;
            $this->conn->query($sql);
        } else {
            $sql = "Insert Into t_loginfo_lotes_liberados "
                    . " (id, lote_id,lote_dis_bloqueados_id,itens_lotes_dis_bloqueados_id,lote_tipo_unidade,lote_data_liberado,lote_peso_liberado)"
                    . " values ( "
                    . "  '" . $created->data['entity']->id . "', "
                    . "  '" . $nr_lote . "', "
                    . "  '" . $created->data['entity']->lotes_dis_bloqueado_id . "', "
                    . "  '" . $created->data['entity']->itens_lotes_dis_bloqueados_id . "', "
                    . "  '" . $created->data['entity']->tipo_unidade . "', "
                    . "  '" . $created->data['entity']->dt_liberacao . "', "
                    . "  '" . $peso . "' ) ";
            $this->conn->query($sql);
        }

        //     debug($sql);        die();
    }

    public $conn;

    public function conecta_db_sql_server() {
        try {
            $this->conn = new PDO(SQLSERVER_DSN, $_SESSION['SQLSERVER_USER'], $_SESSION['SQLSERVER_PASS']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function beforeDelete($delete) {
        $this->conecta_db_sql_server();
        
        $sql = "delete from  t_loginfo_lotes_liberados "
                . " where  id = '" . $delete->data['entity']['id']. "' "
        ;
          $this->conn->query($sql);
        
    }

}
