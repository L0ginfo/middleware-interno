<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RegimeAduaneiroTipoFaturamentos Model
 *
 * @property \App\Model\Table\RegimesAduaneirosTable&\Cake\ORM\Association\BelongsTo $RegimesAduaneiros
 * @property \App\Model\Table\TiposFaturamentosTable&\Cake\ORM\Association\BelongsTo $TiposFaturamentos
 *
 * @method \App\Model\Entity\RegimeAduaneiroTipoFaturamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoFaturamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoFaturamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoFaturamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoFaturamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoFaturamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoFaturamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoFaturamento findOrCreate($search, callable $callback = null, $options = [])
 */
class RegimeAduaneiroTipoFaturamentosTable extends Table
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

        $this->setTable('regime_aduaneiro_tipo_faturamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('RegimesAduaneiros', [
            'foreignKey' => 'regime_aduaneiro_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TiposFaturamentos', [
            'foreignKey' => 'tipo_faturamento_id',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('TabelasPrecosRegimes', [
            'foreignKey'       => 'regime_id',
            'targetForeignKey' => 'regime_id',
            'bindingKey'       => 'regime_aduaneiro_id'
        ]);
        
        $this->hasMany('TabelasPrecosTiposFaturamentos', [
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
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

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
        $rules->add($rules->existsIn(['regime_aduaneiro_id'], 'RegimesAduaneiros'));
        $rules->add($rules->existsIn(['tipo_faturamento_id'], 'TiposFaturamentos'));

        return $rules;
    }
}
