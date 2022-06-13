<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResvPlanejamentoMaritimos Model
 *
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\PlanejamentoMaritimosTable&\Cake\ORM\Association\BelongsTo $PlanejamentoMaritimos
 *
 * @method \App\Model\Entity\ResvPlanejamentoMaritimo get($primaryKey, $options = [])
 * @method \App\Model\Entity\ResvPlanejamentoMaritimo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ResvPlanejamentoMaritimo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResvPlanejamentoMaritimo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvPlanejamentoMaritimo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvPlanejamentoMaritimo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ResvPlanejamentoMaritimo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResvPlanejamentoMaritimo findOrCreate($search, callable $callback = null, $options = [])
 */
class ResvPlanejamentoMaritimosTable extends Table
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
        

        $this->setTable('resv_planejamento_maritimos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
            'joinType' => 'INNER',
        ]);
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
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));
        $rules->add($rules->existsIn(['planejamento_maritimo_id'], 'PlanejamentoMaritimos'));

        return $rules;
    }
}
