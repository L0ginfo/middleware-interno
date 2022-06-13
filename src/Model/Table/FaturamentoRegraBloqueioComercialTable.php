<?php
namespace App\Model\Table;

use App\Model\Entity\FaturamentoRegraPrazoLcl;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Controller\Component\ClonarComponent;

/**
 * FaturamentoRegra Model
 *
 */
class FaturamentoRegraBloqueioComercialTable extends Table
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

        $this->table('Faturamento_regra_bloqueio_comercial');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        // $this->belongsTo('TipoEmpresas', [
        //     'foreignKey' => 'tipo_empresa_id',
        //     'joinType' => 'INNER'
        // ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FaturamentoRegra', [
            'foreignKey' => 'faturamento_regra_id',
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
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('empresa_id', 'create')
            ->notEmpty('empresa_id');

        $validator
            ->requirePresence('faturamento_regra_id', 'create')
            ->notEmpty('faturamento_regra_id');

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
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['faturamento_regra_id'], 'FaturamentoRegra'));
        return $rules;
    }
}
