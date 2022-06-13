<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleAcessoCodigos Model
 *
 * @property \App\Model\Table\TipoAcessosTable&\Cake\ORM\Association\BelongsTo $TipoAcessos
 * @property \App\Model\Table\CredenciamentoPessoasTable&\Cake\ORM\Association\BelongsTo $CredenciamentoPessoas
 * @property \App\Model\Table\ControleAcessoSolicitacaoLeiturasTable&\Cake\ORM\Association\BelongsTo $ControleAcessoSolicitacaoLeituras
 *
 * @method \App\Model\Entity\ControleAcessoCodigo get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleAcessoCodigo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleAcessoCodigo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoCodigo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoCodigo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoCodigo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoCodigo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoCodigo findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleAcessoCodigosTable extends Table
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
        

        $this->setTable('controle_acesso_codigos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('TipoAcessos', [
            'foreignKey' => 'tipo_acesso_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('CredenciamentoPessoas', [
            'foreignKey' => 'credenciamento_pessoa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ControleAcessoSolicitacaoLeituras', [
            'foreignKey' => 'controle_acesso_solicitacao_leitura_id',
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
            ->scalar('codigo')
            ->maxLength('codigo', 455)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo');

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
        $rules->add($rules->existsIn(['tipo_acesso_id'], 'TipoAcessos'));
        $rules->add($rules->existsIn(['credenciamento_pessoa_id'], 'CredenciamentoPessoas'));
        $rules->add($rules->existsIn(['controle_acesso_solicitacao_leitura_id'], 'ControleAcessoSolicitacaoLeituras'));

        return $rules;
    }
}
