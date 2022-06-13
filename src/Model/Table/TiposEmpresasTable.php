<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TiposEmpresas Model
 *
 * @property &\Cake\ORM\Association\HasMany $Empresas
 *
 * @method \App\Model\Entity\TiposEmpresa get($primaryKey, $options = [])
 * @method \App\Model\Entity\TiposEmpresa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TiposEmpresa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TiposEmpresa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TiposEmpresa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TiposEmpresa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TiposEmpresa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TiposEmpresa findOrCreate($search, callable $callback = null, $options = [])
 */
class TiposEmpresasTable extends Table
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

        $this->setTable('tipos_empresas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('Empresas', [
            'foreignKey' => 'tipos_empresa_id'
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
            ->maxLength('descricao', 45)
            ->allowEmptyString('descricao');

        $validator
            ->integer('is_empresa_master')
            ->requirePresence('is_empresa_master', 'create')
            ->notEmptyString('is_empresa_master');

        return $validator;
    }
}
