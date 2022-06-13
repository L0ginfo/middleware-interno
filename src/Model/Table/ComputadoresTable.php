<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Computadores Model
 *
 * @property \App\Model\Table\UsuarioComputadoresTable&\Cake\ORM\Association\HasMany $UsuarioComputadores
 *
 * @method \App\Model\Entity\Computador get($primaryKey, $options = [])
 * @method \App\Model\Entity\Computador newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Computador[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Computador|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Computador saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Computador patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Computador[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Computador findOrCreate($search, callable $callback = null, $options = [])
 */
class ComputadoresTable extends Table
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
        

        $this->setTable('computadores');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('UsuarioComputadores', [
            'foreignKey' => 'computador_id',
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
            ->scalar('hostname')
            ->maxLength('hostname', 255)
            ->allowEmptyString('hostname');

        $validator
            ->scalar('uuid')
            ->maxLength('uuid', 255)
            ->allowEmptyString('uuid');

        return $validator;
    }
}
