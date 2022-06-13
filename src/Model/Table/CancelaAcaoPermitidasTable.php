<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CancelaAcaoPermitidas Model
 *
 * @property \App\Model\Table\CancelasTable&\Cake\ORM\Association\BelongsTo $Cancelas
 * @property \App\Model\Table\CancelaAcoesTable&\Cake\ORM\Association\BelongsTo $CancelaAcoes
 *
 * @method \App\Model\Entity\CancelaAcaoPermitida get($primaryKey, $options = [])
 * @method \App\Model\Entity\CancelaAcaoPermitida newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CancelaAcaoPermitida[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CancelaAcaoPermitida|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CancelaAcaoPermitida saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CancelaAcaoPermitida patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CancelaAcaoPermitida[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CancelaAcaoPermitida findOrCreate($search, callable $callback = null, $options = [])
 */
class CancelaAcaoPermitidasTable extends Table
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
        

        $this->setTable('cancela_acao_permitidas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cancelas', [
            'foreignKey' => 'cancela_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('CancelaAcoes', [
            'foreignKey' => 'cancela_acao_id',
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
        $rules->add($rules->existsIn(['cancela_id'], 'Cancelas'));
        $rules->add($rules->existsIn(['cancela_acao_id'], 'CancelaAcoes'));

        return $rules;
    }
}
