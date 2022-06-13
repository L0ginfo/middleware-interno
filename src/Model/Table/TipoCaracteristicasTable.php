<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoCaracteristicas Model
 *
 * @property \App\Model\Table\CaracteristicasTable&\Cake\ORM\Association\HasMany $Caracteristicas
 * @property \App\Model\Table\TabelaTipoCaracteristicasTable&\Cake\ORM\Association\HasMany $TabelaTipoCaracteristicas
 *
 * @method \App\Model\Entity\TipoCaracteristica get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoCaracteristica newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoCaracteristica[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoCaracteristica|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoCaracteristica saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoCaracteristica patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoCaracteristica[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoCaracteristica findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoCaracteristicasTable extends Table
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
        

        $this->setTable('tipo_caracteristicas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Caracteristicas', [
            'foreignKey' => 'tipo_caracteristica_id',
        ]);
        $this->hasMany('TabelaTipoCaracteristicas', [
            'foreignKey' => 'tipo_caracteristica_id',
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
