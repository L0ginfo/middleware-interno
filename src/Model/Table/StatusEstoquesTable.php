<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StatusEstoques Model
 *
 * @property \App\Model\Table\EstoqueEnderecosTable&\Cake\ORM\Association\HasMany $EstoqueEnderecos
 * @property \App\Model\Table\MovimentacoesEstoquesTable&\Cake\ORM\Association\HasMany $MovimentacoesEstoques
 *
 * @method \App\Model\Entity\StatusEstoque get($primaryKey, $options = [])
 * @method \App\Model\Entity\StatusEstoque newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StatusEstoque[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StatusEstoque|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StatusEstoque saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StatusEstoque patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StatusEstoque[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StatusEstoque findOrCreate($search, callable $callback = null, $options = [])
 */
class StatusEstoquesTable extends Table
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
        

        $this->setTable('status_estoques');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('EstoqueEnderecos', [
            'foreignKey' => 'status_estoque_id',
        ]);
        $this->hasMany('MovimentacoesEstoques', [
            'foreignKey' => 'status_estoque_id',
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
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
