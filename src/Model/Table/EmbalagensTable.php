<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Embalagens Model
 *
 * @property \App\Model\Table\OrdemServicoItensTable&\Cake\ORM\Association\HasMany $OrdemServicoItens
 *
 * @method \App\Model\Entity\Embalagem get($primaryKey, $options = [])
 * @method \App\Model\Entity\Embalagem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Embalagem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Embalagem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Embalagem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Embalagem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Embalagem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Embalagem findOrCreate($search, callable $callback = null, $options = [])
 */
class EmbalagensTable extends Table
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

        $this->setTable('embalagens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');
        
        $this->hasMany('OrdemServicoItens', [
            'foreignKey' => 'embalagem_id'
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
            ->scalar('codigo')
            ->maxLength('codigo', 10)
            ->requirePresence('codigo', 'create')
            ->allowEmptyString('codigo');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 150)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
