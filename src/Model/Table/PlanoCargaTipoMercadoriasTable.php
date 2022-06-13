<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanoCargaTipoMercadorias Model
 *
 * @method \App\Model\Entity\PlanoCargaTipoMercadoria get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanoCargaTipoMercadoria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanoCargaTipoMercadoria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaTipoMercadoria|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaTipoMercadoria saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaTipoMercadoria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaTipoMercadoria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaTipoMercadoria findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanoCargaTipoMercadoriasTable extends Table
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
        

        $this->setTable('plano_carga_tipo_mercadorias');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');
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
            ->allowEmptyString('descricao');

        $validator
            ->maxLength('codigo', 255)
            ->allowEmptyString('codigo');

        return $validator;
    }
}
