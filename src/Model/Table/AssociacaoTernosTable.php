<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AssociacaoTernos Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\PoroesTable&\Cake\ORM\Association\BelongsTo $Poroes
 * @property \App\Model\Table\TernosTable&\Cake\ORM\Association\BelongsTo $Ternos
 * @property \App\Model\Table\SentidosTable&\Cake\ORM\Association\BelongsTo $Sentidos
 * @property \App\Model\Table\PlanoCargasTable&\Cake\ORM\Association\BelongsTo $PlanoCargas
 *
 * @method \App\Model\Entity\AssociacaoTerno get($primaryKey, $options = [])
 * @method \App\Model\Entity\AssociacaoTerno newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AssociacaoTerno[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AssociacaoTerno|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AssociacaoTerno saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AssociacaoTerno patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AssociacaoTerno[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AssociacaoTerno findOrCreate($search, callable $callback = null, $options = [])
 */
class AssociacaoTernosTable extends Table
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
        

        $this->setTable('associacao_ternos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Poroes', [
            'foreignKey' => 'porao_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Ternos', [
            'foreignKey' => 'terno_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Sentidos', [
            'foreignKey' => 'sentido_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PlanoCargas', [
            'foreignKey' => 'plano_carga_id',
        ]);
        $this->belongsTo('PlanejamentoMaritimoTernos', [
            'foreignKey' => 'planejamento_maritimo_terno_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PortoTrabalhoPeriodos', [
            'foreignKey' => 'periodo_id',
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
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

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
        $rules->add($rules->existsIn(['porao_id'], 'Poroes'));
        $rules->add($rules->existsIn(['terno_id'], 'Ternos'));
        $rules->add($rules->existsIn(['sentido_id'], 'Sentidos'));
        $rules->add($rules->existsIn(['plano_carga_id'], 'PlanoCargas'));

        return $rules;
    }
}
