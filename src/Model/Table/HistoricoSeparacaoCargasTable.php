<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HistoricoSeparacaoCargas Model
 *
 * @property \App\Model\Table\SeparacaoCargasTable&\Cake\ORM\Association\BelongsTo $SeparacaoCargas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 *
 * @method \App\Model\Entity\HistoricoSeparacaoCarga get($primaryKey, $options = [])
 * @method \App\Model\Entity\HistoricoSeparacaoCarga newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\HistoricoSeparacaoCarga[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HistoricoSeparacaoCarga|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HistoricoSeparacaoCarga saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HistoricoSeparacaoCarga patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HistoricoSeparacaoCarga[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\HistoricoSeparacaoCarga findOrCreate($search, callable $callback = null, $options = [])
 */
class HistoricoSeparacaoCargasTable extends Table
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
        

        $this->setTable('historico_separacao_cargas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('SeparacaoCargas', [
            'foreignKey' => 'separacao_carga_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'cliente_id',
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
            ->scalar('codigo_pedido')
            ->maxLength('codigo_pedido', 255)
            ->allowEmptyString('codigo_pedido');

        $validator
            ->scalar('numero_pedido')
            ->maxLength('numero_pedido', 255)
            ->allowEmptyString('numero_pedido');

        $validator
            ->dateTime('data_recepcao')
            ->allowEmptyDateTime('data_recepcao');

        $validator
            ->scalar('separacao_situacao')
            ->maxLength('separacao_situacao', 255)
            ->requirePresence('separacao_situacao', 'create')
            ->notEmptyString('separacao_situacao');

        $validator
            ->dateTime('created_at_original')
            ->allowEmptyDateTime('created_at_original');

        $validator
            ->dateTime('updated_at_original')
            ->allowEmptyDateTime('updated_at_original');

        $validator
            ->date('date_created')
            ->allowEmptyDate('date_created');

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
        $rules->add($rules->existsIn(['separacao_carga_id'], 'SeparacaoCargas'));
        $rules->add($rules->existsIn(['cliente_id'], 'Empresas'));

        return $rules;
    }
}
