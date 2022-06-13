<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProgramacaoSituacoes Model
 *
 * @property \App\Model\Table\ProgramacaoHistoricoSituacoesTable&\Cake\ORM\Association\HasMany $ProgramacaoHistoricoSituacoes
 * @property \App\Model\Table\ProgramacoesTable&\Cake\ORM\Association\HasMany $Programacoes
 *
 * @method \App\Model\Entity\ProgramacaoSituacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProgramacaoSituacao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProgramacaoSituacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoSituacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoSituacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoSituacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoSituacao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoSituacao findOrCreate($search, callable $callback = null, $options = [])
 */
class ProgramacaoSituacoesTable extends Table
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
        

        $this->setTable('programacao_situacoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('ProgramacaoHistoricoSituacoes', [
            'foreignKey' => 'programacao_situacao_id',
        ]);
        $this->hasMany('Programacoes', [
            'foreignKey' => 'programacao_situacao_id',
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

        $validator
            ->integer('depende_aprovacao')
            ->notEmptyString('depende_aprovacao');

        return $validator;
    }
}
