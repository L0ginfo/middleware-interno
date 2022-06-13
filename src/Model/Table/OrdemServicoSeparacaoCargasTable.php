<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoSeparacaoCargas Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\SeparacaoCargasTable&\Cake\ORM\Association\BelongsTo $SeparacaoCargas
 *
 * @method \App\Model\Entity\OrdemServicoSeparacaoCarga get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoSeparacaoCarga newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoSeparacaoCarga[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoSeparacaoCarga|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoSeparacaoCarga saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoSeparacaoCarga patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoSeparacaoCarga[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoSeparacaoCarga findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoSeparacaoCargasTable extends Table
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
        

        $this->setTable('ordem_servico_separacao_cargas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
            'joinType' => 'INNER',
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
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));
        $rules->add($rules->existsIn(['separacao_carga_id'], 'SeparacaoCargas'));

        return $rules;
    }
}
