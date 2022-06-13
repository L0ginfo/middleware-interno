<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UnidadeMedidas Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EstoqueEnderecosTable&\Cake\ORM\Association\HasMany $EstoqueEnderecos
 * @property \App\Model\Table\EstoquesTable&\Cake\ORM\Association\HasMany $Estoques
 * @property \App\Model\Table\EtiquetaProdutosTable&\Cake\ORM\Association\HasMany $EtiquetaProdutos
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\HasMany $Produtos
 *
 * @method \App\Model\Entity\UnidadeMedida get($primaryKey, $options = [])
 * @method \App\Model\Entity\UnidadeMedida newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UnidadeMedida[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UnidadeMedida|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UnidadeMedida saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UnidadeMedida patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UnidadeMedida[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UnidadeMedida findOrCreate($search, callable $callback = null, $options = [])
 */
class UnidadeMedidasTable extends Table
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

        $this->setTable('unidade_medidas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('EstoqueEnderecos', [
            'foreignKey' => 'unidade_medida_id'
        ]);
        $this->hasMany('Estoques', [
            'foreignKey' => 'unidade_medida_id'
        ]);
        $this->hasMany('EtiquetaProdutos', [
            'foreignKey' => 'unidade_medida_id'
        ]);
        $this->hasMany('Produtos', [
            'foreignKey' => 'unidade_medida_id'
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
            ->scalar('descricao')
            ->maxLength('descricao', 45)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 100)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo');

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
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));

        return $rules;
    }
}
