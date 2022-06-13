<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FaturamentoFechamentoItens Model
 *
 * @property \App\Model\Table\FaturamentoFechamentosTable&\Cake\ORM\Association\BelongsTo $FaturamentoFechamentos
 * @property \App\Model\Table\FaturamentosTable&\Cake\ORM\Association\BelongsTo $Faturamentos
 *
 * @method \App\Model\Entity\FaturamentoFechamentoItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\FaturamentoFechamentoItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FaturamentoFechamentoItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoFechamentoItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoFechamentoItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoFechamentoItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoFechamentoItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoFechamentoItem findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FaturamentoFechamentoItensTable extends Table
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

        $this->setTable('faturamento_fechamento_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('FaturamentoFechamentos', [
            'foreignKey' => 'faturamento_fechamento_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Faturamentos', [
            'foreignKey' => 'faturamento_id',
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
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        $validator
            ->integer('updated_by')
            ->allowEmptyString('updated_by');

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
        $rules->add($rules->existsIn(['faturamento_fechamento_id'], 'FaturamentoFechamentos'));
        $rules->add($rules->existsIn(['faturamento_id'], 'Faturamentos'));

        return $rules;
    }
}
