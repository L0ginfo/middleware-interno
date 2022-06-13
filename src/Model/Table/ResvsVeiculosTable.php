<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResvsVeiculos Model
 *
 * @property \App\Model\Table\VeiculosTable&\Cake\ORM\Association\BelongsTo $Veiculos
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 *
 * @method \App\Model\Entity\ResvsVeiculo get($primaryKey, $options = [])
 * @method \App\Model\Entity\ResvsVeiculo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ResvsVeiculo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResvsVeiculo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvsVeiculo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvsVeiculo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ResvsVeiculo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResvsVeiculo findOrCreate($search, callable $callback = null, $options = [])
 */
class ResvsVeiculosTable extends Table
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

        $this->setTable('resvs_veiculos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Veiculos', [
            'foreignKey' => 'veiculo_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
            'joinType' => 'INNER'
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
            ->integer('sequencia_veiculo')
            ->requirePresence('sequencia_veiculo', 'create')
            ->notEmptyString('sequencia_veiculo');

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
        $rules->add($rules->existsIn(['veiculo_id'], 'Veiculos'));
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));

        return $rules;
    }
}
