<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sentidos Model
 *
 * @property \App\Model\Table\PlanejamentoMaritimosTable&\Cake\ORM\Association\HasMany $PlanejamentoMaritimos
 *
 * @method \App\Model\Entity\Sentido get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sentido newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Sentido[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sentido|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sentido saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sentido patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sentido[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sentido findOrCreate($search, callable $callback = null, $options = [])
 */
class SentidosTable extends Table
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

        $this->setTable('sentidos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('PlanejamentoMaritimos', [
            'foreignKey' => 'sentido_id'
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
            ->scalar('codigo')
            ->maxLength('codigo', 45)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 250)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
