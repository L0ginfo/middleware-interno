<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CredenciamentoPessoaAnexos Model
 *
 * @property \App\Model\Table\AnexosTable&\Cake\ORM\Association\BelongsTo $Anexos
 * @property \App\Model\Table\CredenciamentoPessoasTable&\Cake\ORM\Association\BelongsTo $CredenciamentoPessoas
 *
 * @method \App\Model\Entity\CredenciamentoPessoaAnexo get($primaryKey, $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaAnexo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaAnexo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaAnexo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaAnexo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaAnexo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaAnexo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaAnexo findOrCreate($search, callable $callback = null, $options = [])
 */
class CredenciamentoPessoaAnexosTable extends Table
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
        

        $this->setTable('credenciamento_pessoa_anexos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Anexos', [
            'foreignKey' => 'anexo_id',
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
        $rules->add($rules->existsIn(['anexo_id'], 'Anexos'));
        $rules->add($rules->existsIn(['credenciamento_pessoa_id'], 'CredenciamentoPessoas'));

        return $rules;
    }
}
