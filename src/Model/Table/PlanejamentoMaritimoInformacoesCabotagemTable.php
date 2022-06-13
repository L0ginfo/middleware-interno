<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanejamentoMaritimoInformacoesCabotagem Model
 *
 * @property \App\Model\Table\PlanejamentoMaritimosTable&\Cake\ORM\Association\BelongsTo $PlanejamentoMaritimos
 *
 * @method \App\Model\Entity\PlanejamentoMaritimoInformacoesCabotagem get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoInformacoesCabotagem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoInformacoesCabotagem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoInformacoesCabotagem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoInformacoesCabotagem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoInformacoesCabotagem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoInformacoesCabotagem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoInformacoesCabotagem findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanejamentoMaritimoInformacoesCabotagemTable extends Table
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
        

        $this->setTable('planejamento_maritimo_informacoes_cabotagem');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('PlanejamentoMaritimos', [
            'foreignKey' => 'planejamento_maritimo_id',
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
            ->scalar('ce_mercante')
            ->maxLength('ce_mercante', 15)
            ->allowEmptyString('ce_mercante');

        $validator
            ->scalar('ncm')
            ->maxLength('ncm', 45)
            ->allowEmptyString('ncm');

        $validator
            ->decimal('peso')
            ->allowEmptyString('peso');

        $validator
            ->decimal('quantidade')
            ->allowEmptyString('quantidade');

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
        $rules->add($rules->existsIn(['planejamento_maritimo_id'], 'PlanejamentoMaritimos'));

        return $rules;
    }
}
