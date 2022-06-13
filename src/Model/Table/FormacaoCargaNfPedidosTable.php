<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormacaoCargaNfPedidos Model
 *
 * @property \App\Model\Table\FormacaoCargasTable&\Cake\ORM\Association\BelongsTo $FormacaoCargas
 * @property &\Cake\ORM\Association\BelongsTo $SeparacaoCargas
 *
 * @method \App\Model\Entity\FormacaoCargaNfPedido get($primaryKey, $options = [])
 * @method \App\Model\Entity\FormacaoCargaNfPedido newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaNfPedido[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaNfPedido|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoCargaNfPedido saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoCargaNfPedido patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaNfPedido[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaNfPedido findOrCreate($search, callable $callback = null, $options = [])
 */
class FormacaoCargaNfPedidosTable extends Table
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
        

        $this->setTable('formacao_carga_nf_pedidos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('FormacaoCargas', [
            'foreignKey' => 'formacao_carga_id',
        ]);
        $this->belongsTo('SeparacaoCargas', [
            'foreignKey' => 'separacao_carga_id',
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
            ->scalar('numero_nf')
            ->maxLength('numero_nf', 255)
            ->allowEmptyString('numero_nf');

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
        $rules->add($rules->existsIn(['formacao_carga_id'], 'FormacaoCargas'));
        $rules->add($rules->existsIn(['separacao_carga_id'], 'SeparacaoCargas'));

        return $rules;
    }
}
