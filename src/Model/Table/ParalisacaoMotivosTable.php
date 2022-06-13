<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ParalisacaoMotivos Model
 *
 * @property \App\Model\Table\ParalisacoesTable&\Cake\ORM\Association\HasMany $Paralisacoes
 *
 * @method \App\Model\Entity\ParalisacaoMotivo get($primaryKey, $options = [])
 * @method \App\Model\Entity\ParalisacaoMotivo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ParalisacaoMotivo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ParalisacaoMotivo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ParalisacaoMotivo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ParalisacaoMotivo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ParalisacaoMotivo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ParalisacaoMotivo findOrCreate($search, callable $callback = null, $options = [])
 */
class ParalisacaoMotivosTable extends Table
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
        

        $this->setTable('paralisacao_motivos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParalisacaoResponsaveis', [
            'foreignKey' => 'responsavel_id',
        ]);

        $this->hasMany('Paralisacoes', [
            'foreignKey' => 'paralisacao_motivo_id',
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
            ->allowEmptyString('descricao');

        $validator
            ->scalar('descricao_ingles')
            ->maxLength('descricao_ingles', 255)
            ->allowEmptyString('descricao_ingles');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 50)
            ->allowEmptyString('codigo');

        return $validator;
    }
}
