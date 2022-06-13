<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContainerModelos Model
 *
 * @property \App\Model\Table\TipoIsosTable&\Cake\ORM\Association\HasMany $TipoIsos
 *
 * @method \App\Model\Entity\ContainerModelo get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContainerModelo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ContainerModelo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContainerModelo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContainerModelo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContainerModelo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContainerModelo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContainerModelo findOrCreate($search, callable $callback = null, $options = [])
 */
class ContainerModelosTable extends Table
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
        

        $this->setTable('container_modelos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('TipoIsos', [
            'foreignKey' => 'container_modelo_id',
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
            ->integer('refeer')
            ->allowEmptyString('refeer');

        return $validator;
    }
}
