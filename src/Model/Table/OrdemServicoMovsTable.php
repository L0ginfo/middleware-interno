<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoMovs Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\MovimentacaoEstoquesTable&\Cake\ORM\Association\BelongsTo $MovimentacaoEstoques
 *
 * @method \App\Model\Entity\OrdemServicoMov get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoMov newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoMov[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoMov|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoMov saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoMov patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoMov[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoMov findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoMovsTable extends Table
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
        

        $this->setTable('ordem_servico_movs');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
        ]);
        $this->belongsTo('MovimentacoesEstoques', [
            'foreignKey' => 'movimentacao_estoque_id',
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
        $rules->add($rules->existsIn(['movimentacao_estoque_id'], 'MovimentacoesEstoques'));

        return $rules;
    }
}
