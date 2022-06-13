<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CodigoBarraTipos Model
 *
 * @property \App\Model\Table\CodigoBarrasTable&\Cake\ORM\Association\HasMany $CodigoBarras
 *
 * @method \App\Model\Entity\CodigoBarraTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\CodigoBarraTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CodigoBarraTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CodigoBarraTipo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CodigoBarraTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CodigoBarraTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CodigoBarraTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CodigoBarraTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class CodigoBarraTiposTable extends Table
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
        

        $this->setTable('codigo_barra_tipos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('CodigoBarras', [
            'foreignKey' => 'codigo_barra_tipo_id',
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
            ->integer('dimensao_tipo')
            ->requirePresence('dimensao_tipo', 'create')
            ->notEmptyString('dimensao_tipo');

        $validator
            ->scalar('tipo_codigo')
            ->maxLength('tipo_codigo', 255)
            ->requirePresence('tipo_codigo', 'create')
            ->notEmptyString('tipo_codigo');

        return $validator;
    }
}
