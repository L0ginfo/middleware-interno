<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContainerTamanhos Model
 *
 * @property \App\Model\Table\TipoIsosTable&\Cake\ORM\Association\HasMany $TipoIsos
 *
 * @method \App\Model\Entity\ContainerTamanho get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContainerTamanho newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ContainerTamanho[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContainerTamanho|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContainerTamanho saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContainerTamanho patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContainerTamanho[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContainerTamanho findOrCreate($search, callable $callback = null, $options = [])
 */
class ContainerTamanhosTable extends Table
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
        

        $this->setTable('container_tamanhos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('TipoIsos', [
            'foreignKey' => 'container_tamanho_id',
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
            ->scalar('tamanho')
            ->maxLength('tamanho', 40)
            ->requirePresence('tamanho', 'create')
            ->notEmptyString('tamanho');

        return $validator;
    }
}
