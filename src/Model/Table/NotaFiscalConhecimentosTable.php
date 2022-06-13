<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotaFiscalConhecimentos Model
 *
 * @property \App\Model\Table\NotaFiscaisTable&\Cake\ORM\Association\BelongsTo $NotaFiscais
 *
 * @method \App\Model\Entity\NotaFiscalConhecimento get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotaFiscalConhecimento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotaFiscalConhecimento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotaFiscalConhecimento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotaFiscalConhecimento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotaFiscalConhecimento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotaFiscalConhecimento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotaFiscalConhecimento findOrCreate($search, callable $callback = null, $options = [])
 */
class NotaFiscalConhecimentosTable extends Table
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
        

        $this->setTable('nota_fiscal_conhecimentos');
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
            ->scalar('numero_documento')
            ->maxLength('numero_documento', 255)
            ->allowEmptyString('numero_documento');

        $validator
            ->scalar('cnpj_cliente')
            ->maxLength('cnpj_cliente', 255)
            ->allowEmptyString('cnpj_cliente');

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
