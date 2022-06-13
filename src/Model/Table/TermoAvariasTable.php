<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TermoAvarias Model
 *
 * @property \App\Model\Table\AvariasTable&\Cake\ORM\Association\BelongsTo $Avarias
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\OrdemServicoItensTable&\Cake\ORM\Association\BelongsTo $OrdemServicoItens
 *
 * @method \App\Model\Entity\TermoAvaria get($primaryKey, $options = [])
 * @method \App\Model\Entity\TermoAvaria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TermoAvaria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TermoAvaria|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TermoAvaria saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TermoAvaria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TermoAvaria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TermoAvaria findOrCreate($search, callable $callback = null, $options = [])
 */
class TermoAvariasTable extends Table
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

        $this->setTable('termo_avarias');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Avarias', [
            'foreignKey' => 'avaria_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrdemServicoItens', [
            'foreignKey' => 'ordem_servico_item_id',
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
            ->scalar('termo_codigo')
            ->maxLength('termo_codigo', 20)
            ->requirePresence('termo_codigo', 'create')
            ->notEmptyString('termo_codigo');

        $validator
            ->requirePresence('volume', 'create')
            ->notEmptyString('volume');

        $validator
            ->requirePresence('peso', 'create')
            ->notEmptyString('peso');

        $validator
            ->requirePresence('lacre', 'create')
            ->notEmptyString('lacre');

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
        $rules->add($rules->existsIn(['avaria_id'], 'Avarias'));
        $rules->add($rules->existsIn(['ordem_servico_item_id'], 'OrdemServicoItens'));

        return $rules;
    }
}
