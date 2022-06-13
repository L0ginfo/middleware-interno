<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProdutoClassificacaoVinculos Model
 *
 * @property \App\Model\Table\ProdutoClassificacoesTable&\Cake\ORM\Association\BelongsTo $ProdutoClassificacoes
 *
 * @method \App\Model\Entity\ProdutoClassificacaoVinculo get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProdutoClassificacaoVinculo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProdutoClassificacaoVinculo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProdutoClassificacaoVinculo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProdutoClassificacaoVinculo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProdutoClassificacaoVinculo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProdutoClassificacaoVinculo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProdutoClassificacaoVinculo findOrCreate($search, callable $callback = null, $options = [])
 */
class ProdutoClassificacaoVinculosTable extends Table
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
        

        $this->setTable('produto_classificacao_vinculos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProdutoClassificacoes', [
            'foreignKey' => 'produto_classificacao_id',
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
            ->scalar('texto_comparar')
            ->requirePresence('texto_comparar', 'create')
            ->notEmptyString('texto_comparar');

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
        $rules->add($rules->existsIn(['produto_classificacao_id'], 'ProdutoClassificacoes'));

        return $rules;
    }
}
