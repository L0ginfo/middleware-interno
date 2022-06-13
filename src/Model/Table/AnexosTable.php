<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Anexos Model
 *
 * @method \App\Model\Entity\Anexo get($primaryKey, $options = [])
 * @method \App\Model\Entity\Anexo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Anexo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Anexo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Anexo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Anexo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Anexo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Anexo findOrCreate($search, callable $callback = null, $options = [])
 */
class AnexosTable extends Table
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

        $this->setTable('anexos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('LogsTabelas');
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
            ->scalar('nome')
            ->maxLength('nome', 80)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        $validator
            ->scalar('arquivo')
            ->maxLength('arquivo', 255)
            ->requirePresence('arquivo', 'create')
            ->notEmptyString('arquivo');

        $validator
            ->scalar('diretorio')
            ->maxLength('diretorio', 80)
            ->requirePresence('diretorio', 'create')
            ->notEmptyString('diretorio');

        $validator
            ->scalar('mime')
            ->maxLength('mime', 255)
            ->allowEmptyString('mime');

        $validator
            ->scalar('size')
            ->maxLength('size', 255)
            ->allowEmptyString('size');

        return $validator;
    }
}
