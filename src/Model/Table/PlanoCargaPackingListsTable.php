<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanoCargaPackingLists Model
 *
 * @property \App\Model\Table\PlanoCargasTable&\Cake\ORM\Association\BelongsTo $PlanoCargas
 *
 * @method \App\Model\Entity\PlanoCargaPackingList get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanoCargaPackingList newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanoCargaPackingList[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaPackingList|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaPackingList saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaPackingList patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaPackingList[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaPackingList findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanoCargaPackingListsTable extends Table
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
        
        $this->setTable('plano_carga_packing_lists');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('PlanoCargas', [
            'foreignKey' => 'plano_carga_id',
        ]);

        $this->belongsTo('Produtos', [
            'bindingKey' => 'produto_codigo',
            'foreignKey' => 'codigo',
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
            ->integer('sequencia')
            ->allowEmptyString('sequencia');

        $validator
            ->scalar('produto_codigo')
            ->maxLength('produto_codigo', 255)
            ->allowEmptyString('produto_codigo');

        $validator
            ->decimal('peso_bruto')
            ->allowEmptyString('peso_bruto');

        $validator
            ->decimal('peso_liquido')
            ->allowEmptyString('peso_liquido');

        $validator
            ->scalar('recebedor')
            ->maxLength('recebedor', 255)
            ->allowEmptyString('recebedor');

        $validator
            ->scalar('cnpj')
            ->maxLength('cnpj', 14)
            ->allowEmptyString('cnpj');

        $validator
            ->integer('porao')
            ->allowEmptyString('porao');

        $validator
            ->decimal('largura')
            ->allowEmptyString('largura');

        $validator
            ->decimal('espessura')
            ->allowEmptyString('espessura');

        $validator
            ->decimal('diametro')
            ->allowEmptyString('diametro');

        $validator
            ->integer('doc_fiscal')
            ->allowEmptyString('doc_fiscal');

        $validator
            ->scalar('municipio')
            ->maxLength('municipio', 255)
            ->allowEmptyString('municipio');

        $validator
            ->scalar('localizacao')
            ->maxLength('localizacao', 255)
            ->allowEmptyString('localizacao');

        $validator
            ->scalar('destino')
            ->maxLength('destino', 255)
            ->allowEmptyString('destino');

        $validator
            ->scalar('emb')
            ->maxLength('emb', 255)
            ->allowEmptyString('emb');

        $validator
            ->scalar('aspecto')
            ->maxLength('aspecto', 255)
            ->allowEmptyString('aspecto');

        $validator
            ->scalar('grupo')
            ->maxLength('grupo', 255)
            ->allowEmptyString('grupo');

        $validator
            ->scalar('sub')
            ->maxLength('sub', 255)
            ->allowEmptyString('sub');

        $validator
            ->integer('seq_nav')
            ->allowEmptyString('seq_nav');

        $validator
            ->decimal('m3')
            ->allowEmptyString('m3');

        $validator
            ->scalar('cliente_1')
            ->maxLength('cliente_1', 255)
            ->allowEmptyString('cliente_1');

        $validator
            ->scalar('cliente_1')
            ->maxLength('cliente_1', 14)
            ->allowEmptyString('cliente_1');

        $validator
            ->decimal('cliente_3')
            ->allowEmptyString('cliente_3');

        $validator
            ->integer('versao')
            ->allowEmptyString('versao');

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
        $rules->add($rules->existsIn(['plano_carga_id'], 'PlanoCargas'));

        return $rules;
    }
}
