<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LingadaAvariaFotos Model
 *
 * @property \App\Model\Table\LingadaAvariasTable&\Cake\ORM\Association\BelongsTo $LingadaAvarias
 *
 * @method \App\Model\Entity\LingadaAvariaFoto get($primaryKey, $options = [])
 * @method \App\Model\Entity\LingadaAvariaFoto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LingadaAvariaFoto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LingadaAvariaFoto|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LingadaAvariaFoto saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LingadaAvariaFoto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LingadaAvariaFoto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LingadaAvariaFoto findOrCreate($search, callable $callback = null, $options = [])
 */
class LingadaAvariaFotosTable extends Table
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
        

        $this->setTable('lingada_avaria_fotos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('LingadaAvarias', [
            'foreignKey' => 'lingada_avaria_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

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
        $rules->add($rules->existsIn(['lingada_avaria_id'], 'LingadaAvarias'));

        return $rules;
    }
}
