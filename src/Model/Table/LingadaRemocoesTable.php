<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LingadaRemocoes Model
 *
 * @property \App\Model\Table\RemocoesTable&\Cake\ORM\Association\BelongsTo $Remocoes
 * @property \App\Model\Table\OrdemServicoItemLingadasTable&\Cake\ORM\Association\BelongsTo $OrdemServicoItemLingadas
 *
 * @method \App\Model\Entity\LingadaRemocao get($primaryKey, $options = [])
 * @method \App\Model\Entity\LingadaRemocao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LingadaRemocao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LingadaRemocao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LingadaRemocao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LingadaRemocao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LingadaRemocao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LingadaRemocao findOrCreate($search, callable $callback = null, $options = [])
 */
class LingadaRemocoesTable extends Table
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
        

        $this->setTable('lingada_remocoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Remocoes', [
            'foreignKey' => 'remocao_id',
            'joinType' => 'INNER',
        ]);
        
        $this->belongsTo('OrdemServicoItemLingadas', [
            'foreignKey' => 'ordem_servico_item_lingada_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Ternos', [
            'foreignKey' => 'terno_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('PortoTrabalhoPeriodos', [
            'foreignKey' => 'periodo_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('PlanoCargaPoroes', [
            'foreignKey' => 'plano_carga_porao_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('OperadorPortuarios', [
            'className' => 'Empresas',
            'foreignKey' => 'operador_portuario_id',
            'joinType' => 'LEFT',
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
        $rules->add($rules->existsIn(['remocao_id'], 'Remocoes'));
        $rules->add($rules->existsIn(['ordem_servico_item_lingada_id'], 'OrdemServicoItemLingadas'));

        return $rules;
    }
}
