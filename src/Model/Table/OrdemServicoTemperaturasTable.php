<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoTemperaturas Model
 *
 * @property \App\Model\Table\EntradaSaidaContainersTable&\Cake\ORM\Association\BelongsTo $EntradaSaidaContainers
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 *
 * @method \App\Model\Entity\OrdemServicoTemperatura get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperatura newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperatura[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperatura|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperatura saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperatura patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperatura[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperatura findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoTemperaturasTable extends Table
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
        

        $this->setTable('ordem_servico_temperaturas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('EntradaSaidaContainers', [
            'foreignKey' => 'entrada_saida_container_id',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
        ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
        ]);
        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
        ]);
        $this->belongsTo('OrdemServicoTemperaturaTipos', [
            'foreignKey' => 'ordem_servico_temperatura_tipo_id',
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
            ->scalar('lote_codigo')
            ->maxLength('lote_codigo', 255)
            ->allowEmptyString('lote_codigo');

        $validator
            ->scalar('temperatura')
            ->maxLength('temperatura', 255)
            ->allowEmptyString('temperatura');

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
        $rules->add($rules->existsIn(['entrada_saida_container_id'], 'EntradaSaidaContainers'));
        $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));

        return $rules;
    }
}
