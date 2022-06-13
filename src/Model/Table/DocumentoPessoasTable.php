<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentoPessoas Model
 *
 * @property \App\Model\Table\TipoDocumentosTable&\Cake\ORM\Association\BelongsTo $TipoDocumentos
 * @property \App\Model\Table\PessoasTable&\Cake\ORM\Association\BelongsTo $Pessoas
 *
 * @method \App\Model\Entity\DocumentoPessoa get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentoPessoa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentoPessoa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoPessoa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoPessoa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoPessoa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoPessoa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoPessoa findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentoPessoasTable extends Table
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
        

        $this->setTable('documento_pessoas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('TipoDocumentos', [
            'foreignKey' => 'tipo_documento_id',
        ]);
        $this->belongsTo('Pessoas', [
            'foreignKey' => 'pessoa_id',
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
            ->scalar('numero_documento')
            ->maxLength('numero_documento', 255)
            ->allowEmptyString('numero_documento');

        $validator
            ->dateTime('data_documento')
            ->allowEmptyDateTime('data_documento');

        $validator
            ->scalar('orgao_emissor')
            ->maxLength('orgao_emissor', 255)
            ->allowEmptyString('orgao_emissor');

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
        $rules->add($rules->existsIn(['tipo_documento_id'], 'TipoDocumentos'));
        $rules->add($rules->existsIn(['pessoa_id'], 'Pessoas'));

        return $rules;
    }
}
