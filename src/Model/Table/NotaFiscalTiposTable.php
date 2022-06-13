<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotaFiscalTipos Model
 *
 * @property \App\Model\Table\NotaFiscaisTable&\Cake\ORM\Association\HasMany $NotaFiscais
 *
 * @method \App\Model\Entity\NotaFiscalTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotaFiscalTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotaFiscalTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotaFiscalTipo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotaFiscalTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotaFiscalTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotaFiscalTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotaFiscalTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class NotaFiscalTiposTable extends Table
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
        

        $this->setTable('nota_fiscal_tipos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('NotaFiscais', [
            'foreignKey' => 'nota_fiscal_tipo_id',
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
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
