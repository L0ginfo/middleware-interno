<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MotivoAcessos Model
 *
 * @method \App\Model\Entity\MotivoAcesso get($primaryKey, $options = [])
 * @method \App\Model\Entity\MotivoAcesso newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MotivoAcesso[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MotivoAcesso|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MotivoAcesso saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MotivoAcesso patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MotivoAcesso[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MotivoAcesso findOrCreate($search, callable $callback = null, $options = [])
 */
class MotivoAcessosTable extends Table
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
        

        $this->setTable('motivo_acessos');
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

        return $validator;
    }
}
