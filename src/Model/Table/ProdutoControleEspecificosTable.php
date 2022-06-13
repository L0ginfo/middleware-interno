<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProdutoControleEspecificos Model
 *
 * @property \App\Model\Table\ControleEspecificosTable&\Cake\ORM\Association\BelongsTo $ControleEspecificos
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 *
 * @method \App\Model\Entity\ProdutoControleEspecifico get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProdutoControleEspecifico newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProdutoControleEspecifico[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProdutoControleEspecifico|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProdutoControleEspecifico saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProdutoControleEspecifico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProdutoControleEspecifico[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProdutoControleEspecifico findOrCreate($search, callable $callback = null, $options = [])
 */
class ProdutoControleEspecificosTable extends Table
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
        

        $this->setTable('produto_controle_especificos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ControleEspecificos', [
            'foreignKey' => 'controle_especifico_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
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
        $rules->add($rules->existsIn(['controle_especifico_id'], 'ControleEspecificos'));
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));

        return $rules;
    }
}
