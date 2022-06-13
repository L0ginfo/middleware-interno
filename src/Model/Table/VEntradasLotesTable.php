<?php
namespace App\Model\Table;

use App\Model\Entity\VEntradasLote;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VEntradasLotes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Entradas
 * @property \Cake\ORM\Association\BelongsTo $Lotes
 */
class VEntradasLotesTable extends Table
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

        $this->table('v_entradas_lotes');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Entradas', [
            'foreignKey' => 'entrada_id'
        ]);
        $this->belongsTo('Lotes', [
            'foreignKey' => 'lote_id'
        ]);
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
        $rules->add($rules->existsIn(['entrada_id'], 'Entradas'));
        $rules->add($rules->existsIn(['lote_id'], 'Lotes'));
        return $rules;
    }
}
