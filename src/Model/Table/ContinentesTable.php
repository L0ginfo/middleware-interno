<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Continentes Model
 *
 * @property \App\Model\Table\PaisTable&\Cake\ORM\Association\HasMany $Pais
 *
 * @method \App\Model\Entity\Continente get($primaryKey, $options = [])
 * @method \App\Model\Entity\Continente newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Continente[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Continente|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Continente saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Continente patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Continente[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Continente findOrCreate($search, callable $callback = null, $options = [])
 */
class ContinentesTable extends Table
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

        $this->setTable('continentes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Pais', [
            'foreignKey' => 'continente_id'
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

            $this->addBehavior('LogsTabelas');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
