<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoTemperaturaTipos Model
 *
 * @property \App\Model\Table\OrdemServicoTemperaturasTable&\Cake\ORM\Association\HasMany $OrdemServicoTemperaturas
 *
 * @method \App\Model\Entity\OrdemServicoTemperaturaTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperaturaTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperaturaTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperaturaTipo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperaturaTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperaturaTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperaturaTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoTemperaturaTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoTemperaturaTiposTable extends Table
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
        

        $this->setTable('ordem_servico_temperatura_tipos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('OrdemServicoTemperaturas', [
            'foreignKey' => 'ordem_servico_temperatura_tipo_id',
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
