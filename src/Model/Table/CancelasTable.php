<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cancelas Model
 *
 * @property \App\Model\Table\CancelasTable&\Cake\ORM\Association\BelongsTo $Cancelas
 * @property \App\Model\Table\BalancasTable&\Cake\ORM\Association\BelongsTo $Balancas
 * @property \App\Model\Table\CancelaAcaoPermitidasTable&\Cake\ORM\Association\HasMany $CancelaAcaoPermitidas
 * @property \App\Model\Table\CancelasTable&\Cake\ORM\Association\HasMany $Cancelas
 *
 * @method \App\Model\Entity\Cancela get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cancela newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cancela[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cancela|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cancela saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cancela patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cancela[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cancela findOrCreate($search, callable $callback = null, $options = [])
 */
class CancelasTable extends Table
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
        

        $this->setTable('cancelas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('CancelasDestino', [
            'foreignKey' => 'cancela_id',
            'className' => 'Cancelas',
            'propertyName' => 'cancela',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Balancas', [
            'foreignKey' => 'balanca_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('CancelaAcaoPermitidas', [
            'foreignKey' => 'cancela_id',
        ]);
        // $this->hasMany('Cancelas', [
        //     'foreignKey' => 'cancela_id',
        // ]);
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

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 255)
            ->allowEmptyString('codigo');

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
        $rules->add($rules->existsIn(['cancela_id'], 'CancelasDestino'));
        $rules->add($rules->existsIn(['balanca_id'], 'Balancas'));

        return $rules;
    }
}
