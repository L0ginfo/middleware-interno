<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentoGenericoTipos Model
 *
 * @property \App\Model\Table\DocumentoGenericosTable&\Cake\ORM\Association\BelongsTo $DocumentoGenericos
 *
 * @method \App\Model\Entity\DocumentoGenericoTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentoGenericoTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentoGenericoTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoGenericoTipo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoGenericoTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoGenericoTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoGenericoTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoGenericoTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentoGenericoTiposTable extends Table
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
        

        $this->setTable('documento_generico_tipos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('DocumentoGenericos', [
            'foreignKey' => 'documento_generico_id',
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
            ->maxLength('descricao', 85)
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
        $rules->add($rules->existsIn(['documento_generico_id'], 'DocumentoGenericos'));

        return $rules;
    }
}
