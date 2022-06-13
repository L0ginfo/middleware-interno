<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleAcessoSolicitacaoLeituras Model
 *
 * @property \App\Model\Table\ControleAcessoControladorasTable&\Cake\ORM\Association\BelongsTo $ControleAcessoControladoras
 * @property \App\Model\Table\CredenciamentoPessoasTable&\Cake\ORM\Association\BelongsTo $CredenciamentoPessoas
 * @property \App\Model\Table\ControleAcessoEquipamentosTable&\Cake\ORM\Association\BelongsTo $ControleAcessoEquipamentos
 * @property \App\Model\Table\ControleAcessoCodigosTable&\Cake\ORM\Association\HasMany $ControleAcessoCodigos
 *
 * @method \App\Model\Entity\ControleAcessoSolicitacaoLeitura get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleAcessoSolicitacaoLeitura newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleAcessoSolicitacaoLeitura[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoSolicitacaoLeitura|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoSolicitacaoLeitura saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoSolicitacaoLeitura patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoSolicitacaoLeitura[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoSolicitacaoLeitura findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleAcessoSolicitacaoLeiturasTable extends Table
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
        

        $this->setTable('controle_acesso_solicitacao_leituras');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ControleAcessoControladoras', [
            'foreignKey' => 'controle_acesso_controladora_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('CredenciamentoPessoas', [
            'foreignKey' => 'credenciamento_pessoa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ControleAcessoEquipamentos', [
            'foreignKey' => 'controle_acesso_equipamento_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ControleAcessoCodigos', [
            'foreignKey' => 'controle_acesso_solicitacao_leitura_id',
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
            ->dateTime('data_hora')
            ->requirePresence('data_hora', 'create')
            ->notEmptyDateTime('data_hora');

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
        //$rules->add($rules->existsIn(['controle_acesso_controladora_id'], 'ControleAcessoControladoras'));
        $rules->add($rules->existsIn(['credenciamento_pessoa_id'], 'CredenciamentoPessoas'));
        $rules->add($rules->existsIn(['controle_acesso_equipamento_id'], 'ControleAcessoEquipamentos'));

        return $rules;
    }
}
