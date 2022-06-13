<?php
namespace App\Model\Table;

use App\Model\Entity\FaturamentoDtcRepasse;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FaturamentoDtcRepasse Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Parceiros
 */
class FaturamentoDtcRepasseTable extends Table
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

        $this->table('faturamento_dtc_repasse');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Parceiros', [
            'foreignKey' => 'parceiro_id'
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
            ->add('id_entrada', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id_entrada');

        $validator
            ->allowEmpty('valor_area_primaria');

        $validator
            ->allowEmpty('valor_final');

        $validator
            ->allowEmpty('situacao');

        $validator
            ->allowEmpty('taxa_administrativa');

        $validator
            ->allowEmpty('numero_demostrativo');

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
        return $rules;
    }
}
