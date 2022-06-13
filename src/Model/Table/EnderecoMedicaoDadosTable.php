<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EnderecoMedicaoDados Model
 *
 * @property \App\Model\Table\EnderecoMedicoesTable&\Cake\ORM\Association\BelongsTo $EnderecoMedicoes
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 *
 * @method \App\Model\Entity\EnderecoMedicaoDado get($primaryKey, $options = [])
 * @method \App\Model\Entity\EnderecoMedicaoDado newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EnderecoMedicaoDado[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EnderecoMedicaoDado|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EnderecoMedicaoDado saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EnderecoMedicaoDado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EnderecoMedicaoDado[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EnderecoMedicaoDado findOrCreate($search, callable $callback = null, $options = [])
 */
class EnderecoMedicaoDadosTable extends Table
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
        

        $this->setTable('endereco_medicao_dados');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('EnderecoMedicoes', [
            'foreignKey' => 'endereco_medicao_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
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
            ->decimal('area_m2')
            ->requirePresence('area_m2', 'create')
            ->notEmptyString('area_m2');

        $validator
            ->decimal('volume_m3')
            ->requirePresence('volume_m3', 'create')
            ->notEmptyString('volume_m3');

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
        $rules->add($rules->existsIn(['endereco_medicao_id'], 'EnderecoMedicoes'));
        $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));

        return $rules;
    }
}
