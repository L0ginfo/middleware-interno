<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleProducoes Model
 *
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\ControleProducaoParalizacoesTable&\Cake\ORM\Association\HasMany $ControleProducaoParalizacoes
 * @property \App\Model\Table\PlanejamentoMovimentacaoProdutosTable&\Cake\ORM\Association\HasMany $PlanejamentoMovimentacaoProdutos
 *
 * @method \App\Model\Entity\ControleProducao get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleProducao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleProducao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleProducao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleProducao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleProducao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleProducao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleProducao findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleProducoesTable extends Table
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
        

        $this->setTable('controle_producoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_producao_id',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
        ]);
        $this->hasMany('ControleProducaoParalizacoes', [
            'foreignKey' => 'controle_producao_id',
        ]);
        $this->hasMany('PlanejamentoMovimentacaoProdutos', [
            'foreignKey' => 'controle_producao_id',
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
            ->dateTime('data_hora_inicio')
            ->allowEmptyDateTime('data_hora_inicio');

        $validator
            ->dateTime('data_hora_fim')
            ->allowEmptyDateTime('data_hora_fim');

        $validator
            ->decimal('quantidade')
            ->allowEmptyString('quantidade');

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
        $rules->add($rules->existsIn(['endereco_producao_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));

        return $rules;
    }
}
