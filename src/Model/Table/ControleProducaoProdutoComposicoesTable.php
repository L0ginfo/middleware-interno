<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleProducaoProdutoComposicoes Model
 *
 * @property \App\Model\Table\ControleProducoesTable&\Cake\ORM\Association\BelongsTo $ControleProducoes
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 *
 * @method \App\Model\Entity\ControleProducaoProdutoComposicao get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleProducaoProdutoComposicao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleProducaoProdutoComposicao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleProducaoProdutoComposicao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleProducaoProdutoComposicao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleProducaoProdutoComposicao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleProducaoProdutoComposicao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleProducaoProdutoComposicao findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleProducaoProdutoComposicoesTable extends Table
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
        

        $this->setTable('controle_producao_produto_composicoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ControleProducoes', [
            'foreignKey' => 'controle_producao_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_composicao_id',
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
            ->decimal('percentual')
            ->allowEmptyString('percentual');

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
        $rules->add($rules->existsIn(['controle_producao_id'], 'ControleProducoes'));
        $rules->add($rules->existsIn(['produto_composicao_id'], 'Produtos'));

        return $rules;
    }
}
