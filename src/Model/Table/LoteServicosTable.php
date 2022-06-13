<?php
namespace App\Model\Table;

use App\Model\Entity\LoteServico;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoteServicos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TipoServicos
 * @property \Cake\ORM\Association\BelongsTo $TipoServicoStatus
 * @property \Cake\ORM\Association\BelongsTo $LoteSolicitacoes
 */
class LoteServicosTable extends Table
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

        $this->table('lote_servicos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('LogsTabelas');

        $this->belongsTo('TipoServicos', [
            'foreignKey' => 'tipo_servico_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TipoServicoStatus', [
            'foreignKey' => 'tipo_servico_status_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('LoteSolicitacoes', [
            'foreignKey' => 'lote_solicitacao_id',
            'joinType' => 'INNER'
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('lote', 'create')
            ->notEmpty('lote');

        $validator
            ->add('created_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('created_by');

        $validator
            ->allowEmpty('iso');

        $validator
            ->add('tipo_iso', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('tipo_iso');

        $validator
            ->allowEmpty('container');

        $validator
            ->allowEmpty('tipo_container');

        $validator
            ->allowEmpty('cesv');

        $validator
            ->allowEmpty('placa');

        $validator
            ->add('data_entrada', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('data_entrada');

        $validator
            ->allowEmpty('os_sara');

        $validator
            ->allowEmpty('CPF_motorista');

        $validator
            ->allowEmpty('nome_motorista');

        $validator
            ->allowEmpty('transportadora');

        $validator
            ->allowEmpty('CNPJ_transportadora');

        $validator
            ->add('data_avaliacao', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('data_avaliacao');

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
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->existsIn(['tipo_servico_id'], 'TipoServicos'));
        $rules->add($rules->existsIn(['tipo_servico_status_id'], 'TipoServicoStatus'));
        $rules->add($rules->existsIn(['lote_solicitacao_id'], 'LoteSolicitacoes'));
        return $rules;
    }
}
