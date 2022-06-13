<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FilaIntegracaoFaturamentoBaixas Model
 *
 * @property \App\Model\Table\FaturamentoBaixasTable&\Cake\ORM\Association\BelongsTo $FaturamentoBaixas
 * @property \App\Model\Table\FaturamentosTable&\Cake\ORM\Association\BelongsTo $Faturamentos
 * @property \App\Model\Table\FaturamentoArmazenagensTable&\Cake\ORM\Association\BelongsTo $FaturamentoArmazenagens
 * @property \App\Model\Table\StatusIntegracoesTable&\Cake\ORM\Association\BelongsTo $StatusIntegracoes
 *
 * @method \App\Model\Entity\FilaIntegracaoFaturamentoBaixa get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilaIntegracaoFaturamentoBaixa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FilaIntegracaoFaturamentoBaixa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilaIntegracaoFaturamentoBaixa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilaIntegracaoFaturamentoBaixa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilaIntegracaoFaturamentoBaixa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilaIntegracaoFaturamentoBaixa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilaIntegracaoFaturamentoBaixa findOrCreate($search, callable $callback = null, $options = [])
 */
class FilaIntegracaoFaturamentoBaixasTable extends Table
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
        

        $this->setTable('fila_integracao_faturamento_baixas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('FaturamentoBaixas', [
            'foreignKey' => 'faturamento_baixa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Faturamentos', [
            'foreignKey' => 'faturamento_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('FaturamentoArmazenagens', [
            'foreignKey' => 'faturamento_armazenagem_id',
        ]);
        $this->belongsTo('StatusIntegracoes', [
            'foreignKey' => 'status_integracao_id',
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
            ->scalar('json_wms_enviado')
            ->allowEmptyString('json_wms_enviado');

        $validator
            ->scalar('json_callback_recebido')
            ->allowEmptyString('json_callback_recebido');

        $validator
            ->scalar('integracao_codigo')
            ->maxLength('integracao_codigo', 255)
            ->allowEmptyString('integracao_codigo');

        $validator
            ->scalar('response_util_title')
            ->maxLength('response_util_title', 255)
            ->allowEmptyString('response_util_title');

        $validator
            ->scalar('response_util_message')
            ->maxLength('response_util_message', 255)
            ->allowEmptyString('response_util_message');

        $validator
            ->scalar('response_util_status')
            ->maxLength('response_util_status', 255)
            ->allowEmptyString('response_util_status');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('modified_at')
            ->allowEmptyDateTime('modified_at');

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
        $rules->add($rules->existsIn(['faturamento_baixa_id'], 'FaturamentoBaixas'));
        $rules->add($rules->existsIn(['faturamento_id'], 'Faturamentos'));
        $rules->add($rules->existsIn(['faturamento_armazenagem_id'], 'FaturamentoArmazenagens'));
        $rules->add($rules->existsIn(['status_integracao_id'], 'StatusIntegracoes'));

        return $rules;
    }
}
