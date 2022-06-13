<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleAcessoNiveis Model
 *
 * @method \App\Model\Entity\ControleAcessoNivei get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleAcessoNivei newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleAcessoNivei[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoNivei|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoNivei saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoNivei patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoNivei[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoNivei findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleAcessoNiveisTable extends Table
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
        

        $this->setTable('controle_acesso_niveis');
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
