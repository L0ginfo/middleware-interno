<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProdutoEstruturas Model
 *
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 *
 * @method \App\Model\Entity\ProdutoEstrutura get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProdutoEstrutura newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProdutoEstrutura[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProdutoEstrutura|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProdutoEstrutura saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProdutoEstrutura patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProdutoEstrutura[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProdutoEstrutura findOrCreate($search, callable $callback = null, $options = [])
 */
class ProdutoEstruturasTable extends Table
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
        
        $this->setTable('produto_estruturas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ProdutosComponentes', [
            'className'=>'Produtos',
            'foreignKey' => 'produto_componente_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('UnidadeMedidasComponentes', [
            'className'=>'UnidadeMedidas',
            'foreignKey' => 'unidade_medida_comp_id',
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

        // $validator
        //     ->decimal('quantidade')
        //     ->requirePresence('quantidade', 'create')
        //     ->notEmptyString('quantidade');

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
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['produto_componente_id'], 'Produtos'));
        $rules->add($rules->existsIn(['unidade_medida_comp_id'], 'UnidadeMedidas'));

        return $rules;
    }
}
