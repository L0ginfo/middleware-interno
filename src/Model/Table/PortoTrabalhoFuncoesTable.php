<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PortoTrabalhoFuncoes Model
 *
 * @method \App\Model\Entity\PortoTrabalhoFuncao get($primaryKey, $options = [])
 * @method \App\Model\Entity\PortoTrabalhoFuncao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PortoTrabalhoFuncao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PortoTrabalhoFuncao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PortoTrabalhoFuncao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PortoTrabalhoFuncao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PortoTrabalhoFuncao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PortoTrabalhoFuncao findOrCreate($search, callable $callback = null, $options = [])
 */
class PortoTrabalhoFuncoesTable extends Table
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
        

        $this->setTable('porto_trabalho_funcoes');
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
            ->integer('chefe')
            ->requirePresence('chefe', 'create')
            ->notEmptyString('chefe');

        return $validator;
    }
}
