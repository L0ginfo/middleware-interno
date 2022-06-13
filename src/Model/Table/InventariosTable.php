<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Inventarios Model
 *
 * @property \App\Model\Table\InventarioItensTable&\Cake\ORM\Association\HasMany $InventarioItens
 *
 * @method \App\Model\Entity\Inventario get($primaryKey, $options = [])
 * @method \App\Model\Entity\Inventario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Inventario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Inventario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Inventario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Inventario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Inventario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Inventario findOrCreate($search, callable $callback = null, $options = [])
 */
class InventariosTable extends Table
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
        

        $this->setTable('inventarios');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('InventarioItens', [
            'foreignKey' => 'inventario_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->belongsTo('ProdutoClassificacoes', [
            'foreignKey' => 'produto_classificacao_id',
        ]);
        $this->belongsTo('Depositantes', [
            'className'=>'Empresas', 
            'foreignKey' => 'depositante_id',
        ]);
        $this->belongsTo('Areas', [
            'foreignKey' => 'area_id',
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
            ->dateTime('data_geracao')
            ->requirePresence('data_geracao', 'create')
            ->notEmptyDateTime('data_geracao');

        $validator
            ->integer('situacao')
            ->requirePresence('situacao', 'create')
            ->notEmptyString('situacao');

        return $validator;
    }
}
