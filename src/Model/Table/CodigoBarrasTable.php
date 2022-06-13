<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CodigoBarras Model
 *
 * @property \App\Model\Table\CodigoBarraTiposTable&\Cake\ORM\Association\BelongsTo $CodigoBarraTipos
 *
 * @method \App\Model\Entity\CodigoBarra get($primaryKey, $options = [])
 * @method \App\Model\Entity\CodigoBarra newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CodigoBarra[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CodigoBarra|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CodigoBarra saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CodigoBarra patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CodigoBarra[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CodigoBarra findOrCreate($search, callable $callback = null, $options = [])
 */
class CodigoBarrasTable extends Table
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
        

        $this->setTable('codigo_barras');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('CodigoBarraTipos', [
            'foreignKey' => 'codigo_barra_tipo_id',
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
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->scalar('valor_codigo_barras')
            ->maxLength('valor_codigo_barras', 255)
            ->allowEmptyString('valor_codigo_barras');

        $validator
            ->scalar('header')
            ->maxLength('header', 4294967295)
            ->allowEmptyString('header');

        $validator
            ->scalar('footer')
            ->maxLength('footer', 4294967295)
            ->allowEmptyString('footer');

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
        $rules->add($rules->existsIn(['codigo_barra_tipo_id'], 'CodigoBarraTipos'));

        return $rules;
    }
}
