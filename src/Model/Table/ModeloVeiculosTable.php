<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ModeloVeiculos Model
 *
 * @property \App\Model\Table\VeiculosTable&\Cake\ORM\Association\HasMany $Veiculos
 *
 * @method \App\Model\Entity\ModeloVeiculo get($primaryKey, $options = [])
 * @method \App\Model\Entity\ModeloVeiculo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ModeloVeiculo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ModeloVeiculo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModeloVeiculo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModeloVeiculo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ModeloVeiculo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ModeloVeiculo findOrCreate($search, callable $callback = null, $options = [])
 */
class ModeloVeiculosTable extends Table
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
        

        $this->setTable('modelo_veiculos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Veiculos', [
            'foreignKey' => 'modelo_veiculo_id',
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
