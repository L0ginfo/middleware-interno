<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TabelasPrecosTratamentos Model
 *
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsTo $TabelasPrecos
 * @property \App\Model\Table\TratamentosCargasTable&\Cake\ORM\Association\BelongsTo $TratamentosCargas
 *
 * @method \App\Model\Entity\TabelasPrecosTratamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\TabelasPrecosTratamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosTratamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosTratamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosTratamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosTratamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosTratamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosTratamento findOrCreate($search, callable $callback = null, $options = [])
 */
class TabelasPrecosTratamentosTable extends Table
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

        $this->setTable('tabelas_precos_tratamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('TabelasPrecos', [
            'foreignKey' => 'tabela_preco_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TratamentosCargas', [
            'foreignKey' => 'tratamento_id',
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
            ->integer('sequencia')
            ->requirePresence('sequencia', 'create')
            ->notEmptyString('sequencia');

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
        $rules->add($rules->existsIn(['tabela_preco_id'], 'TabelasPrecos'));
        $rules->add($rules->existsIn(['tratamento_id'], 'TratamentosCargas'));

        return $rules;
    }
}
