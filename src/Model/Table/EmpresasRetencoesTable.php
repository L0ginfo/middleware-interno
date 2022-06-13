<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmpresasRetencoes Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\RetencoesTable&\Cake\ORM\Association\BelongsTo $Retencoes
 *
 * @method \App\Model\Entity\EmpresasRetencao get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmpresasRetencao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmpresasRetencao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmpresasRetencao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmpresasRetencao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmpresasRetencao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmpresasRetencao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmpresasRetencao findOrCreate($search, callable $callback = null, $options = [])
 */
class EmpresasRetencoesTable extends Table
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
        

        $this->setTable('empresas_retencoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
        ]);
        $this->belongsTo('Retencoes', [
            'foreignKey' => 'retencao_id',
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
            ->decimal('valor')
            ->allowEmptyString('valor');

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
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['retencao_id'], 'Retencoes'));

        return $rules;
    }
}
