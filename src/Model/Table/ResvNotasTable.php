<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResvNotas Model
 *
 * @property \App\Model\Table\NotaFiscaisTable&\Cake\ORM\Association\BelongsTo $NotaFiscais
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 *
 * @method \App\Model\Entity\ResvNota get($primaryKey, $options = [])
 * @method \App\Model\Entity\ResvNota newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ResvNota[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResvNota|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvNota saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvNota patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ResvNota[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResvNota findOrCreate($search, callable $callback = null, $options = [])
 */
class ResvNotasTable extends Table
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
        

        $this->setTable('resv_notas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('NotaFiscais', [
            'foreignKey' => 'nota_fiscal_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
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
        $rules->add($rules->existsIn(['nota_fiscal_id'], 'NotaFiscais'));
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));

        return $rules;
    }
}
