<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentoTransporteLacres Model
 *
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\BelongsTo $DocumentosTransportes
 * @property \App\Model\Table\LacreTiposTable&\Cake\ORM\Association\BelongsTo $LacreTipos
 *
 * @method \App\Model\Entity\DocumentoTransporteLacre get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentoTransporteLacre newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentoTransporteLacre[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoTransporteLacre|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoTransporteLacre saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoTransporteLacre patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoTransporteLacre[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoTransporteLacre findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentoTransporteLacresTable extends Table
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
        
        $this->addBehavior('LogsTabelas');
        

        $this->setTable('documento_transporte_lacres');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('DocumentosTransportes', [
            'foreignKey' => 'documento_transporte_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('LacreTipos', [
            'foreignKey' => 'lacre_tipo_id',
            'joinType' => 'INNER',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
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
        $rules->add($rules->existsIn(['documento_transporte_id'], 'DocumentosTransportes'));
        $rules->add($rules->existsIn(['lacre_tipo_id'], 'LacreTipos'));

        return $rules;
    }
}
