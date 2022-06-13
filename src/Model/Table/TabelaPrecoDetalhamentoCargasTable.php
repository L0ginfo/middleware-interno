<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TabelaPrecoDetalhamentoCargas Model
 *
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsTo $TabelasPrecos
 * @property \App\Model\Table\DetalhamentoCargasTable&\Cake\ORM\Association\BelongsTo $DetalhamentoCargas
 *
 * @method \App\Model\Entity\TabelaPrecoDetalhamentoCarga get($primaryKey, $options = [])
 * @method \App\Model\Entity\TabelaPrecoDetalhamentoCarga newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TabelaPrecoDetalhamentoCarga[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TabelaPrecoDetalhamentoCarga|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelaPrecoDetalhamentoCarga saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelaPrecoDetalhamentoCarga patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TabelaPrecoDetalhamentoCarga[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TabelaPrecoDetalhamentoCarga findOrCreate($search, callable $callback = null, $options = [])
 */
class TabelaPrecoDetalhamentoCargasTable extends Table
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
        

        $this->setTable('tabela_preco_detalhamento_cargas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('TabelasPrecos', [
            'foreignKey' => 'tabela_preco_id',
        ]);
        $this->belongsTo('DetalhamentoCargas', [
            'foreignKey' => 'detalhamento_carga_id',
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
        $rules->add($rules->existsIn(['tabela_preco_id'], 'TabelasPrecos'));
        $rules->add($rules->existsIn(['detalhamento_carga_id'], 'DetalhamentoCargas'));

        return $rules;
    }
}
