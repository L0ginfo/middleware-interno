<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoBalancas Model
 *
 * @property \App\Model\Table\BalancasTable&\Cake\ORM\Association\HasMany $Balancas
 *
 * @method \App\Model\Entity\TipoBalanca get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoBalanca newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoBalanca[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoBalanca|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoBalanca saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoBalanca patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoBalanca[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoBalanca findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoBalancasTable extends Table
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
        

        $this->setTable('tipo_balancas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Balancas', [
            'foreignKey' => 'tipo_balanca_id',
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
