<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TabelasPrecosRegimes Model
 *
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsTo $TabelasPrecos
 * @property \App\Model\Table\RegimesAduaneirosTable&\Cake\ORM\Association\BelongsTo $RegimesAduaneiros
 *
 * @method \App\Model\Entity\TabelasPrecosRegime get($primaryKey, $options = [])
 * @method \App\Model\Entity\TabelasPrecosRegime newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosRegime[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosRegime|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosRegime saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosRegime patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosRegime[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosRegime findOrCreate($search, callable $callback = null, $options = [])
 */
class TabelasPrecosRegimesTable extends Table
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

        $this->setTable('tabelas_precos_regimes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('TabelasPrecos', [
            'foreignKey' => 'tabela_preco_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('RegimesAduaneiros', [
            'foreignKey' => 'regime_id',
            'joinType' => 'INNER'
        ]);
        

        // $this->hasMany('TabelasPrecosRegimesFilter', [
        //     'className'  => 'TabelasPrecosRegimes',
        //     'foreignKey' => 'tabela_preco_id',
        //     'bindingKey'  => 'id',
        //     'joinType' => 'INNER'
        // ]); 

        
        $this->hasMany('RegimeAduaneiroTipoFaturamentos', [
            'foreignKey'       => 'regime_aduaneiro_id',
            'targetForeignKey' => 'regime_aduaneiro_id',
            'bindingKey'       => 'regime_id'
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
        $rules->add($rules->existsIn(['regime_id'], 'RegimesAduaneiros'));

        return $rules;
    }
}
