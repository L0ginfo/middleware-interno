<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LingadaCaracteristicas Model
 *
 * @property \App\Model\Table\PlanoCargaCaracteristicasTable&\Cake\ORM\Association\BelongsTo $PlanoCargaCaracteristicas
 * @property \App\Model\Table\OrdemServicoItemLingadasTable&\Cake\ORM\Association\BelongsTo $OrdemServicoItemLingadas
 * @property \App\Model\Table\CaracteristicasTable&\Cake\ORM\Association\BelongsTo $Caracteristicas
 * @property \App\Model\Table\PlanoCargaPoraoCaracteristicasTable&\Cake\ORM\Association\BelongsTo $PlanoCargaPoraoCaracteristicas
 *
 * @method \App\Model\Entity\LingadaCaracteristica get($primaryKey, $options = [])
 * @method \App\Model\Entity\LingadaCaracteristica newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LingadaCaracteristica[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LingadaCaracteristica|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LingadaCaracteristica saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LingadaCaracteristica patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LingadaCaracteristica[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LingadaCaracteristica findOrCreate($search, callable $callback = null, $options = [])
 */
class LingadaCaracteristicasTable extends Table
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
        

        $this->setTable('lingada_caracteristicas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('PlanoCargaCaracteristicas', [
            'foreignKey' => 'plano_carga_caracteristica_id',
        ]);
        $this->belongsTo('OrdemServicoItemLingadas', [
            'foreignKey' => 'ordem_servico_item_lingada_id',
        ]);
        $this->belongsTo('Caracteristicas', [
            'foreignKey' => 'caracteristica_id',
        ]);
        $this->belongsTo('PlanoCargaPoraoCaracteristicas', [
            'foreignKey' => 'plano_carga_caracteristica_porao_id',
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
        $rules->add($rules->existsIn(['plano_carga_caracteristica_id'], 'PlanoCargaCaracteristicas'));
        $rules->add($rules->existsIn(['ordem_servico_item_lingada_id'], 'OrdemServicoItemLingadas'));
        $rules->add($rules->existsIn(['caracteristica_id'], 'Caracteristicas'));
        $rules->add($rules->existsIn(['plano_carga_caracteristica_porao_id'], 'PlanoCargaPoraoCaracteristicas'));

        return $rules;
    }
}
