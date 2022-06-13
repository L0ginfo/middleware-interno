<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotaFiscalCfops Model
 *
 * @property \App\Model\Table\NotaFiscaisTable&\Cake\ORM\Association\BelongsTo $NotaFiscais
 *
 * @method \App\Model\Entity\NotaFiscalCfop get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotaFiscalCfop newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotaFiscalCfop[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotaFiscalCfop|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotaFiscalCfop saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotaFiscalCfop patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotaFiscalCfop[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotaFiscalCfop findOrCreate($search, callable $callback = null, $options = [])
 */
class NotaFiscalCfopsTable extends Table
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
        

        $this->setTable('nota_fiscal_cfops');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('NotaFiscais', [
            'foreignKey' => 'nota_fiscal_id',
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
            ->scalar('numero')
            ->maxLength('numero', 255)
            ->requirePresence('numero', 'create')
            ->notEmptyString('numero');

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

        return $rules;
    }
}
