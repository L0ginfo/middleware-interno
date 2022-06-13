<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormacaoLotes Model
 *
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\BelongsTo $DocumentosTransportes
 * @property \App\Model\Table\FormacaoLoteItensTable&\Cake\ORM\Association\HasMany $FormacaoLoteItens
 *
 * @method \App\Model\Entity\FormacaoLote get($primaryKey, $options = [])
 * @method \App\Model\Entity\FormacaoLote newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FormacaoLote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoLote|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoLote saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoLote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoLote[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoLote findOrCreate($search, callable $callback = null, $options = [])
 */
class FormacaoLotesTable extends Table
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
        

        $this->setTable('formacao_lotes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('DocumentosTransportes', [
            'foreignKey' => 'documento_transporte_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('FormacaoLoteItens', [
            'foreignKey' => 'formacao_lote_id',
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
            ->integer('consolidado')
            ->notEmptyString('consolidado');

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
        $rules->add($rules->existsIn(['documento_transporte_id'], 'DocumentosTransportes'));

        return $rules;
    }
}
