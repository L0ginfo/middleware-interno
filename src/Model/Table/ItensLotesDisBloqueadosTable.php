<?php
namespace App\Model\Table;

use App\Model\Entity\ItensLotesDisBloqueado;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItensLotesDisBloqueados Model
 *
 * @property \Cake\ORM\Association\BelongsTo $LotesDisBloqueados
 */
class ItensLotesDisBloqueadosTable extends Table
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

        $this->table('itens_lotes_dis_bloqueados');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('LotesDisBloqueados', [
            'foreignKey' => 'lotes_dis_bloqueado_id',
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
            ->allowEmpty('item_bloqueado');

        $validator
            ->add('peso_bloqueado', 'valid', ['rule' => 'decimal'])
            ->requirePresence('peso_bloqueado', 'create')
            ->notEmpty('peso_bloqueado');

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
        $rules->add($rules->existsIn(['lotes_dis_bloqueado_id'], 'LotesDisBloqueados'));
        return $rules;
    }
}
