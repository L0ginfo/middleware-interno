<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TabelasPrecosTiposFaturamentos Model
 *
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsTo $TabelasPrecos
 * @property \App\Model\Table\TiposFaturamentosTable&\Cake\ORM\Association\BelongsTo $TiposFaturamentos
 *
 * @method \App\Model\Entity\TabelasPrecosTiposFaturamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\TabelasPrecosTiposFaturamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosTiposFaturamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosTiposFaturamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosTiposFaturamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosTiposFaturamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosTiposFaturamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosTiposFaturamento findOrCreate($search, callable $callback = null, $options = [])
 */
class TabelasPrecosTiposFaturamentosTable extends Table
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

        $this->setTable('tabelas_precos_tipos_faturamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('TabelasPrecos', [
            'foreignKey' => 'tabela_preco_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TiposFaturamentos', [
            'foreignKey' => 'tipo_faturamento_id',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('RegimeAduaneiroTipoFaturamentos', [
            'foreignKey'       => 'tipo_faturamento_id',
            'targetForeignKey' => 'tipo_faturamento_id',
            'bindingKey'       => 'tipo_faturamento_id'
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
        $rules->add($rules->existsIn(['tipo_faturamento_id'], 'TiposFaturamentos'));

        return $rules;
    }
}
