<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MarcaVeiculos Model
 *
 * @property \App\Model\Table\VeiculosTable&\Cake\ORM\Association\HasMany $Veiculos
 *
 * @method \App\Model\Entity\MarcaVeiculo get($primaryKey, $options = [])
 * @method \App\Model\Entity\MarcaVeiculo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MarcaVeiculo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MarcaVeiculo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MarcaVeiculo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MarcaVeiculo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MarcaVeiculo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MarcaVeiculo findOrCreate($search, callable $callback = null, $options = [])
 */
class MarcaVeiculosTable extends Table
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
        

        $this->setTable('marca_veiculos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Veiculos', [
            'foreignKey' => 'marca_veiculo_id',
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
