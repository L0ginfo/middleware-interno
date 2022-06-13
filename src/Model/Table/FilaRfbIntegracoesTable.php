<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FilaRfbIntegracoes Model
 *
 * @property \App\Model\Table\ClientesTable&\Cake\ORM\Association\BelongsTo $Clientes
 *
 * @method \App\Model\Entity\FilaRfbIntegracao get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilaRfbIntegracao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FilaRfbIntegracao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilaRfbIntegracao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilaRfbIntegracao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilaRfbIntegracao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilaRfbIntegracao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilaRfbIntegracao findOrCreate($search, callable $callback = null, $options = [])
 */
class FilaRfbIntegracoesTable extends Table
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
        

        $this->setTable('fila_rfb_integracoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clientes', [
            'className' => 'Empresas',
            'foreignKey' => 'cliente_id',
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
            ->scalar('rfb_endpoint_envio')
            ->maxLength('rfb_endpoint_envio', 255)
            ->requirePresence('rfb_endpoint_envio', 'create')
            ->notEmptyString('rfb_endpoint_envio');

        $validator
            ->allowEmptyString('rfb_body_retorno');

        $validator
            ->allowEmptyString('rfb_headers_retorno');

        $validator
            ->integer('rfb_status_retorno')
            ->allowEmptyString('rfb_status_retorno');

        $validator
            ->allowEmptyString('cliente_body_envio');

        $validator
            ->allowEmptyString('cliente_headers_envio');

        $validator
            ->integer('numero_tentativas')
            ->allowEmptyString('numero_tentativas');

        $validator
            ->integer('status_recebimento')
            ->allowEmptyString('status_recebimento');

        $validator
            ->integer('status_integracao')
            ->allowEmptyString('status_integracao');

        $validator
            ->dateTime('data_recebimento')
            ->allowEmptyDateTime('data_recebimento');

        $validator
            ->dateTime('data_ultima_tentativa')
            ->allowEmptyDateTime('data_ultima_tentativa');

        $validator
            ->scalar('stack_error')
            ->maxLength('stack_error', 4294967295)
            ->allowEmptyString('stack_error');

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
        $rules->add($rules->existsIn(['cliente_id'], 'Clientes'));

        return $rules;
    }
}
