<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoCodigoEmpresas Model
 *
 * @method \App\Model\Entity\TipoCodigoEmpresa get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoCodigoEmpresa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoCodigoEmpresa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoCodigoEmpresa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoCodigoEmpresa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoCodigoEmpresa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoCodigoEmpresa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoCodigoEmpresa findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoCodigoEmpresasTable extends Table
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
        

        $this->setTable('tipo_codigo_empresas');
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
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->scalar('mascara')
            ->maxLength('mascara', 255)
            ->allowEmptyString('mascara');

        return $validator;
    }
}
