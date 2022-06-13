<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoItemLingados Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\SentidosTable&\Cake\ORM\Association\BelongsTo $Sentidos
 * @property \App\Model\Table\TernosTable&\Cake\ORM\Association\BelongsTo $Ternos
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\PlanoCargaPoroesTable&\Cake\ORM\Association\BelongsTo $PlanoCargaPoroes
 *
 * @method \App\Model\Entity\OrdemServicoItemLingado get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingado newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingado[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingado|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingado saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingado[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingado findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoItemLingadosTable extends Table
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
        

        $this->setTable('ordem_servico_item_lingados');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Sentidos', [
            'foreignKey' => 'sentido_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Ternos', [
            'foreignKey' => 'terno_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PlanoCargaPoroes', [
            'foreignKey' => 'plano_carga_porao_id',
            'joinType' => 'INNER',
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
            ->scalar('codigo')
            ->maxLength('codigo', 45)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo');

        $validator
            ->decimal('qtde')
            ->allowEmptyString('qtde');

        $validator
            ->decimal('peso')
            ->allowEmptyString('peso');

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
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));
        $rules->add($rules->existsIn(['sentido_id'], 'Sentidos'));
        $rules->add($rules->existsIn(['terno_id'], 'Ternos'));
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));
        $rules->add($rules->existsIn(['plano_carga_porao_id'], 'PlanoCargaPoroes'));

        return $rules;
    }
}
