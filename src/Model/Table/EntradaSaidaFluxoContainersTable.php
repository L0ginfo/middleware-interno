<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EntradaSaidaFluxoContainers Model
 *
 * @method \App\Model\Entity\EntradaSaidaFluxoContainer get($primaryKey, $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoContainer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoContainer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoContainer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoContainer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoContainer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoContainer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoContainer findOrCreate($search, callable $callback = null, $options = [])
 */
class EntradaSaidaFluxoContainersTable extends Table
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
        

        $this->setTable('entrada_saida_fluxo_containers');
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

        return $validator;
    }
}
