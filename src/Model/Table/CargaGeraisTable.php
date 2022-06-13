<?php
namespace App\Model\Table;

use App\Model\Entity\CargaGeral;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CargaGerais Model
 *
 * @property \Cake\ORM\Association\BelongsTo $CodigoOnus
 * @property \Cake\ORM\Association\BelongsTo $Embalagens
 * @property \Cake\ORM\Association\BelongsTo $Entradas
 */
class CargaGeraisTable extends Table
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

        $this->table('carga_gerais');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('CodigoOnus', [
            'foreignKey' => 'codigo_onu_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Embalagens', [
            'foreignKey' => 'embalagem_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Lotes', [
            'foreignKey' => 'lote_id',
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
            ->allowEmpty('descricao_mercadoria');

        $validator
            ->allowEmpty('ncm');

        $validator
            ->add('quantidade', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('quantidade');

        $validator
            ->add('peso_bruto', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('peso_bruto');

        $validator
            ->add('peso_liquido', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('peso_liquido');

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
        $rules->add($rules->existsIn(['codigo_onu_id'], 'CodigoOnus'));
        $rules->add($rules->existsIn(['embalagem_id'], 'Embalagens'));
        $rules->add($rules->existsIn(['lote_id'], 'Lotes'));
        return $rules;
    }
}
