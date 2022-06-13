<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InventarioItens Model
 *
 * @property \App\Model\Table\InventariosTable&\Cake\ORM\Association\BelongsTo $Inventarios
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\EtiquetaProdutosTable&\Cake\ORM\Association\BelongsTo $EtiquetaProdutos
 * @property \App\Model\Table\OperadoresTable&\Cake\ORM\Association\BelongsTo $Operadores
 *
 * @method \App\Model\Entity\InventarioItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\InventarioItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InventarioItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InventarioItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InventarioItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InventarioItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InventarioItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InventarioItem findOrCreate($search, callable $callback = null, $options = [])
 */
class InventarioItensTable extends Table
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
        

        $this->setTable('inventario_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Inventarios', [
            'foreignKey' => 'inventario_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('EtiquetaProdutos', [
            'foreignKey' => 'etiqueta_produto_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER',
        ]);
        $this->hasOne('EtiquetaProdutoByEndereco', [
            'className' => 'EtiquetaProdutos',
            'foreignKey' => 'endereco_id',
            'bindingKey' => 'endereco_id',
            'targetForeignKey' => 'endereco_id',
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
            ->decimal('quantidade_lida')
            ->requirePresence('quantidade_lida', 'create')
            ->notEmptyString('quantidade_lida');

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
        $rules->add($rules->existsIn(['inventario_id'], 'Inventarios'));
        $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['etiqueta_produto_id'], 'EtiquetaProdutos'));
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));

        return $rules;
    }
}
