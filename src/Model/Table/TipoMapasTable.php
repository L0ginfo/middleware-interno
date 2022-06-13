<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoMapas Model
 *
 * @property \App\Model\Table\MapasTable&\Cake\ORM\Association\HasMany $Mapas
 *
 * @method \App\Model\Entity\TipoMapa get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoMapa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoMapa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoMapa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoMapa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoMapa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoMapa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoMapa findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoMapasTable extends Table
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
        

        $this->setTable('tipo_mapas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Mapas', [
            'foreignKey' => 'tipo_mapa_id',
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
