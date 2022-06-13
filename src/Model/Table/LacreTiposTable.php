<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LacreTipos Model
 *
 * @property \App\Model\Table\LacresTable&\Cake\ORM\Association\HasMany $Lacres
 *
 * @method \App\Model\Entity\LacreTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\LacreTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LacreTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LacreTipo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LacreTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LacreTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LacreTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LacreTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class LacreTiposTable extends Table
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
        

        $this->setTable('lacre_tipos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Lacres', [
            'foreignKey' => 'lacre_tipo_id',
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
            ->maxLength('descricao', 40)
            ->allowEmptyString('descricao');

        return $validator;
    }
}
