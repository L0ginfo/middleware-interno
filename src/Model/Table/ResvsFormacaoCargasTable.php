<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResvsFormacaoCargas Model
 *
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\FormacaoCargasTable&\Cake\ORM\Association\BelongsTo $FormacaoCargas
 *
 * @method \App\Model\Entity\ResvsFormacaoCarga get($primaryKey, $options = [])
 * @method \App\Model\Entity\ResvsFormacaoCarga newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ResvsFormacaoCarga[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResvsFormacaoCarga|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvsFormacaoCarga saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvsFormacaoCarga patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ResvsFormacaoCarga[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResvsFormacaoCarga findOrCreate($search, callable $callback = null, $options = [])
 */
class ResvsFormacaoCargasTable extends Table
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
        

        $this->setTable('resvs_formacao_cargas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('FormacaoCargas', [
            'foreignKey' => 'formacao_carga_id',
            'joinType' => 'INNER',
        ]);
        
        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'resv_id',
            'targetForeignKey' => 'resv_id',
            'bindingKey' => 'resv_id',
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
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));
        $rules->add($rules->existsIn(['formacao_carga_id'], 'FormacaoCargas'));

        return $rules;
    }
}
