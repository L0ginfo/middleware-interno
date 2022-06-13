<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SeparacaoSituacoes Model
 *
 * @property \App\Model\Table\SeparacaoCargaItensTable&\Cake\ORM\Association\HasMany $SeparacaoCargaItens
 *
 * @method \App\Model\Entity\SeparacaoSituacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeparacaoSituacao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SeparacaoSituacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeparacaoSituacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeparacaoSituacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeparacaoSituacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeparacaoSituacao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeparacaoSituacao findOrCreate($search, callable $callback = null, $options = [])
 */
class SeparacaoSituacoesTable extends Table
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
        

        $this->setTable('separacao_situacoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('SeparacaoCargaItens', [
            'foreignKey' => 'separacao_situacao_id',
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
