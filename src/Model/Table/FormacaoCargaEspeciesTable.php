<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormacaoCargaEspecies Model
 *
 * @method \App\Model\Entity\FormacaoCargaEspecy get($primaryKey, $options = [])
 * @method \App\Model\Entity\FormacaoCargaEspecy newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaEspecy[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaEspecy|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoCargaEspecy saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoCargaEspecy patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaEspecy[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaEspecy findOrCreate($search, callable $callback = null, $options = [])
 */
class FormacaoCargaEspeciesTable extends Table
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
        

        $this->setTable('formacao_carga_especies');
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

        return $validator;
    }
}
