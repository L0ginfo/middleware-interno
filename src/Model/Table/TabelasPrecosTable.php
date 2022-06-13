<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TabelasPrecos Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 *
 * @method \App\Model\Entity\TabelasPreco get($primaryKey, $options = [])
 * @method \App\Model\Entity\TabelasPreco newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TabelasPreco[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPreco|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPreco saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPreco patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPreco[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPreco findOrCreate($search, callable $callback = null, $options = [])
 */
class TabelasPrecosTable extends Table
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

        $this->setTable('tabelas_precos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey(['id']);

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('TabelaPrecoIrregulares', [
            'propertyName' => 'tabela_preco_irregular',
            'foreignKey' => 'tabela_preco_irregular_id',
        ]);

        $this->hasMany('TabelasPrecosRegimes',[
            'foreignKey' => 'tabela_preco_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('TabelasPrecosTratamentos',[
            'foreignKey' => 'tabela_preco_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('TabelasPrecosOpcoes',[
            'foreignKey' => 'tabela_preco_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('TabelasPrecosPeriodosArms',[
            'foreignKey' => 'tabela_preco_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('TabelasPrecosServicos',[
            'foreignKey' => 'tabela_preco_id',
            'joinType' => 'LEFT'
        ]);

        // Filters       

        $this->hasMany('TabelasPrecosRegimesFilter', [
            'className'  => 'TabelasPrecosRegimes',
            'foreignKey' => 'tabela_preco_id',
            'bindingKey'  => 'id',
            'joinType' => 'INNER'
        ]); 
          

        $this->hasMany('RegimeAduaneiroTipoFaturamentosFilter',[
            'className'  => 'RegimeAduaneiroTipoFaturamentos',
            'foreignKey' => 'regime_id',
            'bindingKey'  => 'regime_aduaneiro_id',
            'joinType' => 'INNER'
        ]);

        
        $this->hasMany('TabelasPrecosTiposFaturamentos', [
            'foreignKey'       => 'tabela_preco_id',
            'targetForeignKey' => 'tabela_preco_id',
            'bindingKey'       => 'id'
        ]);

        $this->hasMany('TabelasPrecosEquipesTrabalhos',[
            'foreignKey'       => 'tabelas_preco_id',
            'targetForeignKey' => 'tabelas_preco_id',
            'bindingKey'       => 'id'
        ]);

        $this->hasMany('TabelasPrecosModais', [
            'foreignKey'       => 'tabela_preco_id',
            'targetForeignKey' => 'tabela_preco_id',
            'bindingKey'       => 'id'
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
            ->integer('empresa_id')
            ->requirePresence('empresa_id', 'create');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 45)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->date('data_inicio_vigencia')
            ->requirePresence('data_inicio_vigencia', 'create')
            ->notEmptyDate('data_inicio_vigencia');

        $validator
            ->date('data_fim_vigencia')
            ->requirePresence('data_fim_vigencia', 'create')
            ->notEmptyDate('data_fim_vigencia');

        $validator
            ->integer('ativo')
            ->requirePresence('ativo', 'create')
            ->notEmptyString('ativo');

        $validator
            ->decimal('desconto_percentual')
            ->requirePresence('desconto_percentual', 'create')
            ->notEmptyString('desconto_percentual');

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

        // $rules->add(function ($entity, $options) {
        //     return $entity->myRules();
        // }, 'MyRules');

        return $rules;
    }
}
