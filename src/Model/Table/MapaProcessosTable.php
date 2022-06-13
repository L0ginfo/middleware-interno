<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MapaProcessos Model
 *
 * @property \App\Model\Table\MapasTable&\Cake\ORM\Association\HasMany $Mapas
 *
 * @method \App\Model\Entity\MapaProcesso get($primaryKey, $options = [])
 * @method \App\Model\Entity\MapaProcesso newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MapaProcesso[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MapaProcesso|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaProcesso saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaProcesso patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MapaProcesso[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MapaProcesso findOrCreate($search, callable $callback = null, $options = [])
 */
class MapaProcessosTable extends Table
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
        

        $this->setTable('mapa_processos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Mapas', [
            'foreignKey' => 'mapa_processo_id',
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
