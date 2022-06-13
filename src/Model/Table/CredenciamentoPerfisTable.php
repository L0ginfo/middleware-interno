<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CredenciamentoPerfis Model
 *
 * @property \App\Model\Table\PerfisTable&\Cake\ORM\Association\BelongsTo $Perfis
 * @property \App\Model\Table\TipoAcessosTable&\Cake\ORM\Association\BelongsTo $TipoAcessos
 * @property \App\Model\Table\CredenciamentoPessoasTable&\Cake\ORM\Association\HasMany $CredenciamentoPessoas
 *
 * @method \App\Model\Entity\CredenciamentoPerfi get($primaryKey, $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfi newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfi[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfi|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfi saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfi patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfi[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfi findOrCreate($search, callable $callback = null, $options = [])
 */
class CredenciamentoPerfisTable extends Table
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
        

        $this->setTable('credenciamento_perfis');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Perfis', [
            'foreignKey' => 'perfil_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('TipoAcessos', [
            'foreignKey' => 'tipo_acesso_id',
        ]);
        $this->hasMany('CredenciamentoPessoas', [
            'foreignKey' => 'credenciamento_perfil_id',
        ]);
        $this->hasMany('CredenciamentoPerfilAreas', [
            'foreignKey' => 'credenciamento_perfil_id',
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
            ->integer('validade_dias')
            ->allowEmptyString('validade_dias');

        $validator
            ->integer('situacao')
            ->notEmptyString('situacao');

        $validator
            ->scalar('motivo_situacao')
            ->maxLength('motivo_situacao', 255)
            ->allowEmptyString('motivo_situacao');

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
        $rules->add($rules->existsIn(['perfil_id'], 'Perfis'));
        $rules->add($rules->existsIn(['tipo_acesso_id'], 'TipoAcessos'));

        return $rules;
    }
}
