<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MoedasCotacoes Model
 *
 * @property \App\Model\Table\MoedasTable&\Cake\ORM\Association\BelongsTo $Moedas
 *
 * @method \App\Model\Entity\MoedasCotacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\MoedasCotacao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MoedasCotacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MoedasCotacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MoedasCotacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MoedasCotacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MoedasCotacao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MoedasCotacao findOrCreate($search, callable $callback = null, $options = [])
 */
class MoedasCotacoesTable extends Table
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

        $this->setTable('moedas_cotacoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_id',
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
            ->scalar('tipo_cotacao')
            ->maxLength('tipo_cotacao', 45)
            ->allowEmptyString('tipo_cotacao');

        $validator
            ->date('data_cotacao')
            ->allowEmptyDate('data_cotacao');

        $validator
            ->decimal('valor_cotacao')
            ->allowEmptyString('valor_cotacao');

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
        $rules->add($rules->existsIn(['moeda_id'], 'Moedas'));

        return $rules;
    }
}
