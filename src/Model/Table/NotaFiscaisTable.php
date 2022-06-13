<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotaFiscais Model
 *
 * @property \App\Model\Table\NotaFiscalTiposTable&\Cake\ORM\Association\BelongsTo $NotaFiscalTipos
 * @property \App\Model\Table\NotaFiscalCfopsTable&\Cake\ORM\Association\HasMany $NotaFiscalCfops
 * @property \App\Model\Table\ResvNotasTable&\Cake\ORM\Association\HasMany $ResvNotas
 *
 * @method \App\Model\Entity\NotaFiscal get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotaFiscal newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotaFiscal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotaFiscal|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotaFiscal saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotaFiscal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotaFiscal[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotaFiscal findOrCreate($search, callable $callback = null, $options = [])
 */
class NotaFiscaisTable extends Table
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
        

        $this->setTable('nota_fiscais');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('NotaFiscalTipos', [
            'foreignKey' => 'nota_fiscal_tipo_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('NotaFiscalCfops', [
            'foreignKey' => 'nota_fiscal_id',
        ]);
        $this->hasMany('ResvNotas', [
            'foreignKey' => 'nota_fiscal_id',
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
        $rules->add($rules->existsIn(['nota_fiscal_tipo_id'], 'NotaFiscalTipos'));

        return $rules;
    }
}
