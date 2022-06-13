<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoMovimentacoes Model
 *
 * @property \App\Model\Table\MovimentacoesEstoquesTable&\Cake\ORM\Association\HasMany $MovimentacoesEstoques
 *
 * @method \App\Model\Entity\TipoMovimentacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoMovimentacao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoMovimentacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoMovimentacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoMovimentacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoMovimentacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoMovimentacao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoMovimentacao findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoMovimentacoesTable extends Table
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

        $this->setTable('tipo_movimentacoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('MovimentacoesEstoques', [
            'foreignKey' => 'tipo_movimentacao_id'
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
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
