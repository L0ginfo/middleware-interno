<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SolicitacaoLeituraOcrs Model
 *
 * @property \App\Model\Table\BalancasTable&\Cake\ORM\Association\BelongsTo $Balancas
 *
 * @method \App\Model\Entity\SolicitacaoLeituraOcr get($primaryKey, $options = [])
 * @method \App\Model\Entity\SolicitacaoLeituraOcr newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SolicitacaoLeituraOcr[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SolicitacaoLeituraOcr|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SolicitacaoLeituraOcr saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SolicitacaoLeituraOcr patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SolicitacaoLeituraOcr[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SolicitacaoLeituraOcr findOrCreate($search, callable $callback = null, $options = [])
 */
class SolicitacaoLeituraOcrsTable extends Table
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
        

        $this->setTable('solicitacao_leitura_ocrs');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Balancas', [
            'foreignKey' => 'balanca_id',
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
            ->integer('ativo')
            ->allowEmptyString('ativo');

        $validator
            ->scalar('fluxo')
            ->maxLength('fluxo', 255)
            ->allowEmptyString('fluxo');

        $validator
            ->scalar('tipo_fluxo')
            ->maxLength('tipo_fluxo', 255)
            ->allowEmptyString('tipo_fluxo');

        $validator
            ->scalar('tipo_entrada')
            ->maxLength('tipo_entrada', 255)
            ->allowEmptyString('tipo_entrada');

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
        $rules->add($rules->existsIn(['balanca_id'], 'Balancas'));

        return $rules;
    }
}
