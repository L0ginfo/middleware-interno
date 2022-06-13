<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanejamentoMaritimoTernos Model
 *
 * @property \App\Model\Table\PlanejamentoMaritimosTable&\Cake\ORM\Association\BelongsTo $PlanejamentoMaritimos
 * @property \App\Model\Table\TernosTable&\Cake\ORM\Association\BelongsTo $Ternos
 * @property \App\Model\Table\PlanejamentoMaritimoTernoPeriodosTable&\Cake\ORM\Association\HasMany $PlanejamentoMaritimoTernoPeriodos
 * @property \App\Model\Table\PlanejamentoMaritimoTernoUsuariosTable&\Cake\ORM\Association\HasMany $PlanejamentoMaritimoTernoUsuarios
 *
 * @method \App\Model\Entity\PlanejamentoMaritimoTerno get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTerno newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTerno[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTerno|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTerno saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTerno patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTerno[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoTerno findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanejamentoMaritimoTernosTable extends Table
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
        

        $this->setTable('planejamento_maritimo_ternos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('PlanejamentoMaritimos', [
            'foreignKey' => 'planejamento_maritimo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Ternos', [
            'foreignKey' => 'terno_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('PlanejamentoMaritimoTernoPeriodos', [
            'foreignKey' => 'planejamento_maritimo_terno_id',
        ]);
        $this->hasMany('PlanejamentoMaritimoTernoUsuarios', [
            'foreignKey' => 'planejamento_maritimo_terno_id',
        ]);
        $this->hasMany('PlanejamentoMaritimoTernoEquipamentos', [
            'foreignKey' => 'planejamento_maritimo_terno_id',
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
        $rules->add($rules->existsIn(['planejamento_maritimo_id'], 'PlanejamentoMaritimos'));
        $rules->add($rules->existsIn(['terno_id'], 'Ternos'));

        return $rules;
    }
}
