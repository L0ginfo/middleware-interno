<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoDocumentoPessoas Model
 *
 * @property \App\Model\Table\PessoasTable&\Cake\ORM\Association\HasMany $Pessoas
 *
 * @method \App\Model\Entity\TipoDocumentoPessoa get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoDocumentoPessoa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoDocumentoPessoa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoDocumentoPessoa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoDocumentoPessoa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoDocumentoPessoa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoDocumentoPessoa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoDocumentoPessoa findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoDocumentoPessoasTable extends Table
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
        

        $this->setTable('tipo_documento_pessoas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Pessoas', [
            'foreignKey' => 'tipo_documento_pessoa_id',
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
