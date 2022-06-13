<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FaturamentoVias Model
 *
 * @property \App\Model\Table\FaturamentosTable&\Cake\ORM\Association\BelongsTo $Faturamentos
 *
 * @method \App\Model\Entity\FaturamentoVia get($primaryKey, $options = [])
 * @method \App\Model\Entity\FaturamentoVia newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FaturamentoVia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoVia|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoVia saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoVia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoVia[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoVia findOrCreate($search, callable $callback = null, $options = [])
 */
class FaturamentoViasTable extends Table
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
        

        $this->setTable('faturamento_vias');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Faturamentos', [
            'foreignKey' => 'faturamento_id',
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
            ->integer('numero_via')
            ->allowEmptyString('numero_via');

        $validator
            ->dateTime('data_hora_emissao')
            ->allowEmptyDateTime('data_hora_emissao');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('modified_at')
            ->allowEmptyDateTime('modified_at');

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
        $rules->add($rules->existsIn(['faturamento_id'], 'Faturamentos'));

        return $rules;
    }
}
