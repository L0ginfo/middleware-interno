<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SeparacaoCargaItens Model
 *
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\SeparacaoCargasTable&\Cake\ORM\Association\BelongsTo $SeparacaoCargas
 * @property &\Cake\ORM\Association\HasMany $OrdemServicoItemSeparacoes
 *
 * @method \App\Model\Entity\SeparacaoCargaItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeparacaoCargaItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SeparacaoCargaItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeparacaoCargaItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeparacaoCargaItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeparacaoCargaItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeparacaoCargaItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeparacaoCargaItem findOrCreate($search, callable $callback = null, $options = [])
 */
class SeparacaoCargaItensTable extends Table
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
        

        $this->setTable('separacao_carga_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('SeparacaoCargas', [
            'foreignKey' => 'separacao_carga_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('OrdemServicoItemSeparacoes', [
            'foreignKey' => 'separacao_carga_item_id',
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
            ->decimal('qtde')
            ->requirePresence('qtde', 'create')
            ->notEmptyString('qtde');

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
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        $rules->add($rules->existsIn(['separacao_carga_id'], 'SeparacaoCargas'));

        return $rules;
    }
}
