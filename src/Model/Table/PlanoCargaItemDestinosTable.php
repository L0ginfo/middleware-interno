<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanoCargaItemDestinos Model
 *
 * @property \App\Model\Table\PlanoCargasTable&\Cake\ORM\Association\BelongsTo $PlanoCargas
 * @property \App\Model\Table\DocumentosMercadoriasItensTable&\Cake\ORM\Association\BelongsTo $DocumentosMercadoriasItens
 * @property \App\Model\Table\LocaisTable&\Cake\ORM\Association\BelongsTo $Locais
 *
 * @method \App\Model\Entity\PlanoCargaItemDestino get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanoCargaItemDestino newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanoCargaItemDestino[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaItemDestino|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaItemDestino saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaItemDestino patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaItemDestino[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaItemDestino findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanoCargaItemDestinosTable extends Table
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
        

        $this->setTable('plano_carga_item_destinos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('PlanoCargas', [
            'foreignKey' => 'plano_carga_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('DocumentosMercadoriasItens', [
            'foreignKey' => 'documento_mercadoria_item_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Locais', [
            'foreignKey' => 'local_id',
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
            ->integer('destino')
            ->notEmptyString('destino');

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
        $rules->add($rules->existsIn(['plano_carga_id'], 'PlanoCargas'));
        $rules->add($rules->existsIn(['documento_mercadoria_item_id'], 'DocumentosMercadoriasItens'));
        $rules->add($rules->existsIn(['local_id'], 'Locais'));

        return $rules;
    }
}
