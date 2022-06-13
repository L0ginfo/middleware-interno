<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProgramacaoHistoricoSituacoes Model
 *
 * @property \App\Model\Table\ProgramacoesTable&\Cake\ORM\Association\BelongsTo $Programacoes
 * @property \App\Model\Table\ProgramacaoSituacoesTable&\Cake\ORM\Association\BelongsTo $ProgramacaoSituacoes
 *
 * @method \App\Model\Entity\ProgramacaoHistoricoSituacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProgramacaoHistoricoSituacao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProgramacaoHistoricoSituacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoHistoricoSituacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoHistoricoSituacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoHistoricoSituacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoHistoricoSituacao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoHistoricoSituacao findOrCreate($search, callable $callback = null, $options = [])
 */
class ProgramacaoHistoricoSituacoesTable extends Table
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
        

        $this->setTable('programacao_historico_situacoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Programacoes', [
            'foreignKey' => 'programacao_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ProgramacaoSituacoes', [
            'foreignKey' => 'programacao_situacao_id',
            'joinType' => 'INNER',
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
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['programacao_id'], 'Programacoes'));
        $rules->add($rules->existsIn(['programacao_situacao_id'], 'ProgramacaoSituacoes'));

        return $rules;
    }
}
