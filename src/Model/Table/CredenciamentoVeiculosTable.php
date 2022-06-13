<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CredenciamentoVeiculos Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\VeiculosTable&\Cake\ORM\Association\BelongsTo $Veiculos
 * @property \App\Model\Table\PessoaVeiculosTable&\Cake\ORM\Association\HasMany $PessoaVeiculos
 *
 * @method \App\Model\Entity\CredenciamentoVeiculo get($primaryKey, $options = [])
 * @method \App\Model\Entity\CredenciamentoVeiculo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CredenciamentoVeiculo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoVeiculo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoVeiculo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoVeiculo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoVeiculo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoVeiculo findOrCreate($search, callable $callback = null, $options = [])
 */
class CredenciamentoVeiculosTable extends Table
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
        

        $this->setTable('credenciamento_veiculos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
        ]);
        $this->belongsTo('Veiculos', [
            'foreignKey' => 'veiculo_id',
        ]);
        $this->hasMany('PessoaVeiculos', [
            'foreignKey' => 'credenciamento_veiculo_id',
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
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['veiculo_id'], 'Veiculos'));

        return $rules;
    }
}
