<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CredenciamentoPessoaAreas Model
 *
 * @property \App\Model\Table\CredenciamentoPessoasTable&\Cake\ORM\Association\BelongsTo $CredenciamentoPessoas
 * @property \App\Model\Table\ControleAcessoAreasTable&\Cake\ORM\Association\BelongsTo $ControleAcessoAreas
 *
 * @method \App\Model\Entity\CredenciamentoPessoaArea get($primaryKey, $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaArea newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaArea[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaArea|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaArea saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaArea patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaArea[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPessoaArea findOrCreate($search, callable $callback = null, $options = [])
 */
class CredenciamentoPessoaAreasTable extends Table
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
        

        $this->setTable('credenciamento_pessoa_areas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('CredenciamentoPessoas', [
            'foreignKey' => 'credenciamento_pessoa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ControleAcessoAreas', [
            'foreignKey' => 'controle_acesso_area_id',
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
        $rules->add($rules->existsIn(['credenciamento_pessoa_id'], 'CredenciamentoPessoas'));
        $rules->add($rules->existsIn(['controle_acesso_area_id'], 'ControleAcessoAreas'));

        return $rules;
    }
}
