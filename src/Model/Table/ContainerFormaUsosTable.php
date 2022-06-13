<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContainerFormaUsos Model
 *
 * @property \App\Model\Table\EntradaSaidaContainersTable&\Cake\ORM\Association\HasMany $EntradaSaidaContainers
 *
 * @method \App\Model\Entity\ContainerFormaUso get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContainerFormaUso newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ContainerFormaUso[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContainerFormaUso|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContainerFormaUso saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContainerFormaUso patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContainerFormaUso[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContainerFormaUso findOrCreate($search, callable $callback = null, $options = [])
 */
class ContainerFormaUsosTable extends Table
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
        

        $this->setTable('container_forma_usos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('EntradaSaidaContainers', [
            'foreignKey' => 'container_forma_uso_id',
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
            ->allowEmptyString('descricao');

        return $validator;
    }
}
