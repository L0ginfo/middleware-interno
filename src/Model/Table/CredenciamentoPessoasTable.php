<?php
namespace App\Model\Table;

use App\RegraNegocio\Rfb\RfbManager;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CredenciamentoPessoas Model
 *
 * @property \App\Model\Table\PessoasTable&\Cake\ORM\Association\BelongsTo $Pessoas
 * @property \App\Model\Table\CredenciamentoPerfisTable&\Cake\ORM\Association\BelongsTo $CredenciamentoPerfis
 * @property \App\Model\Table\ControleAcessoCodigosTable&\Cake\ORM\Association\HasMany $ControleAcessoCodigos
 * @property \App\Model\Table\ControleAcessoLogsTable&\Cake\ORM\Association\HasMany $ControleAcessoLogs
 * @property \App\Model\Table\ControleAcessoSolicitacaoLeiturasTable&\Cake\ORM\Association\HasMany $ControleAcessoSolicitacaoLeituras
 * @property \App\Model\Table\CredenciamentoPessoaAreasTable&\Cake\ORM\Association\HasMany $CredenciamentoPessoaAreas
 * @property \App\Model\Table\PessoaVeiculosTable&\Cake\ORM\Association\HasMany $PessoaVeiculos
 *
 * @method \App\Model\Entity\CredenciamentoPessoa get($primaryKey, $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoa findOrCreate($search, callable $callback = null, $options = [])
 */
class CredenciamentoPessoasTable extends Table
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
        

        $this->setTable('credenciamento_pessoas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Pessoas', [
            'foreignKey' => 'pessoa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('CredenciamentoPerfis', [
            'foreignKey' => 'credenciamento_perfil_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ControleAcessoCodigos', [
            'foreignKey' => 'credenciamento_pessoa_id',
        ]);
        $this->hasMany('ControleAcessoLogs', [
            'foreignKey' => 'credenciamento_pessoa_id',
        ]);
        $this->hasMany('ControleAcessoSolicitacaoLeituras', [
            'foreignKey' => 'credenciamento_pessoa_id',
        ]);
        $this->hasMany('CredenciamentoPessoaAreas', [
            'foreignKey' => 'credenciamento_pessoa_id',
        ]);
        $this->hasMany('PessoaVeiculos', [
            'foreignKey' => 'credenciamento_pessoa_id',
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
            ->dateTime('data_inicio_acesso')
            ->allowEmptyDateTime('data_inicio_acesso');

        $validator
            ->dateTime('data_fim_acesso')
            ->allowEmptyDateTime('data_fim_acesso');

        $validator
            ->integer('ativo')
            ->notEmptyString('ativo');

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
        $rules->add($rules->existsIn(['pessoa_id'], 'Pessoas'));
        $rules->add($rules->existsIn(['credenciamento_perfil_id'], 'CredenciamentoPerfis'));

        return $rules;
    }

    public function afterSave($event, $entity, $options)
    {
        RfbManager::doAction('rfb', 'credenciamento-pessoas', 'init', $entity, ['nome_model' => 'Integracoes']);
    }

    public function beforeDelete($event, $entity, $options)
    {
        RfbManager::doAction('rfb', 'credenciamento-pessoas', 'init', $entity, ['nome_model' => 'Integracoes', 'operacao' => 'delete']);
    }

}
