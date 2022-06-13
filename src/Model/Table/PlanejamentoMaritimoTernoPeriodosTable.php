<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanejamentoMaritimoTernoPeriodos Model
 *
 * @property \App\Model\Table\PlanejamentoMaritimoTernosTable&\Cake\ORM\Association\BelongsTo $PlanejamentoMaritimoTernos
 * @property \App\Model\Table\PortoTrabalhoPeriodosTable&\Cake\ORM\Association\BelongsTo $PortoTrabalhoPeriodos
 *
 * @method \App\Model\Entity\PlanejamentoMaritimoTernoPeriodo get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTernoPeriodo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTernoPeriodo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTernoPeriodo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTernoPeriodo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTernoPeriodo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTernoPeriodo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTernoPeriodo findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanejamentoMaritimoTernoPeriodosTable extends Table
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
        

        $this->setTable('planejamento_maritimo_terno_periodos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('PlanejamentoMaritimoTernos', [
            'foreignKey' => 'planejamento_maritimo_terno_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PortoTrabalhoPeriodos', [
            'foreignKey' => 'periodo_id',
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
        $rules->add($rules->existsIn(['planejamento_maritimo_terno_id'], 'PlanejamentoMaritimoTernos'));
        $rules->add($rules->existsIn(['periodo_id'], 'PortoTrabalhoPeriodos'));

        return $rules;
    }
}
