<?php
namespace App\Model\Table;

use App\Util\DateUtil;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoItemLingadas Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\SentidosTable&\Cake\ORM\Association\BelongsTo $Sentidos
 * @property \App\Model\Table\TernosTable&\Cake\ORM\Association\BelongsTo $Ternos
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\PlanoCargaPoroesTable&\Cake\ORM\Association\BelongsTo $PlanoCargaPoroes
 * @property \App\Model\Table\LingadaRemocoesTable&\Cake\ORM\Association\HasMany $LingadaRemocoes
 *
 * @method \App\Model\Entity\OrdemServicoItemLingada get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingada newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingada[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingada|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingada saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingada patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingada[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItemLingada findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoItemLingadasTable extends Table
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
        

        $this->setTable('ordem_servico_item_lingadas');
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

        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('PortoTrabalhoPeriodos', [
            'foreignKey' => 'periodo_id',
            'joinType' => 'INNER',
        ]);
        
        $this->hasMany('LingadaRemocoes', [
            'foreignKey' => 'ordem_servico_item_lingada_id',
        ]);

        $this->hasMany('LingadaAvarias', [
            'foreignKey' => 'ordem_servico_item_lingada_id',
        ]);

        $this->belongsTo('Locais', [
            'foreignKey' => 'local_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Clientes', [
            'className' => 'Empresas',
            'foreignKey' => 'cliente_id',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('LingadaCaracteristicas', [
            'foreignKey' => 'ordem_servico_item_lingada_id',
        ]);

        $this->belongsTo('PortoTrabalhoPeriodos', [
            'foreignKey' => 'periodo_id',
        ]);

        $this->belongsTo('Operadores', [
            'className' => 'Empresas',
            'foreignKey' => 'operador_portuario_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('OperadorPortuarios', [
            'className' => 'Empresas',
            'foreignKey' => 'operador_portuario_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
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

    public function beforeSave($event, $entity, $options) {

        if ($entity->isNew())
            $entity->created_at = DateUtil::dateTimeToDB(date('Y-m-d H:i'));
            
    }
}
