<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TabelasPrecosServicos Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsTo $TabelasPrecos
 * @property \App\Model\Table\ServicosTable&\Cake\ORM\Association\BelongsTo $Servicos
 * @property \App\Model\Table\TiposValoresTable&\Cake\ORM\Association\BelongsTo $TiposValores
 * @property \App\Model\Table\SistemaCamposTable&\Cake\ORM\Association\BelongsTo $SistemaCampos
 *
 * @method \App\Model\Entity\TabelasPrecosServico get($primaryKey, $options = [])
 * @method \App\Model\Entity\TabelasPrecosServico newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosServico[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosServico|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosServico saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosServico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosServico[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosServico findOrCreate($search, callable $callback = null, $options = [])
 */
class TabelasPrecosServicosTable extends Table
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

        $this->setTable('tabelas_precos_servicos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey(['id']);

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TabelasPrecos', [
            'foreignKey' => 'tabela_preco_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Servicos', [
            'foreignKey' => 'servico_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TiposValores', [
            'foreignKey' => 'tipo_valor_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SistemaCampos', [
            'foreignKey' => 'campo_valor_sistema_id',
            'joinType' => 'INNER'
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
            ->requirePresence('valor', 'create')
            ->notEmptyString('valor');

        $validator
            ->allowEmptyString('desconto_percentual_serv');

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
        $rules->add($rules->existsIn(['tabela_preco_id'], 'TabelasPrecos'));
        $rules->add($rules->existsIn(['servico_id'], 'Servicos'));
        $rules->add($rules->existsIn(['tipo_valor_id'], 'TiposValores'));
        $rules->add($rules->existsIn(['campo_valor_sistema_id'], 'SistemaCampos'));

        return $rules;
    }
}
