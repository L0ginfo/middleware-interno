<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PessoaVeiculos Model
 *
 * @property \App\Model\Table\CredenciamentoVeiculosTable&\Cake\ORM\Association\BelongsTo $CredenciamentoVeiculos
 * @property \App\Model\Table\CredenciamentoPessoasTable&\Cake\ORM\Association\BelongsTo $CredenciamentoPessoas
 *
 * @method \App\Model\Entity\PessoaVeiculo get($primaryKey, $options = [])
 * @method \App\Model\Entity\PessoaVeiculo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PessoaVeiculo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PessoaVeiculo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PessoaVeiculo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PessoaVeiculo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PessoaVeiculo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PessoaVeiculo findOrCreate($search, callable $callback = null, $options = [])
 */
class PessoaVeiculosTable extends Table
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
        

        $this->setTable('pessoa_veiculos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('CredenciamentoVeiculos', [
            'foreignKey' => 'credenciamento_veiculo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('CredenciamentoPessoas', [
            'foreignKey' => 'credenciamento_pessoa_id',
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
        $rules->add($rules->existsIn(['credenciamento_veiculo_id'], 'CredenciamentoVeiculos'));
        $rules->add($rules->existsIn(['credenciamento_pessoa_id'], 'CredenciamentoPessoas'));

        return $rules;
    }
}
