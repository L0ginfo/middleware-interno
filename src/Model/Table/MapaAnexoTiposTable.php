<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MapaAnexoTipos Model
 *
 * @property \App\Model\Table\MapaAnexosTable&\Cake\ORM\Association\HasMany $MapaAnexos
 *
 * @method \App\Model\Entity\MapaAnexoTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\MapaAnexoTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MapaAnexoTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MapaAnexoTipo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaAnexoTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaAnexoTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MapaAnexoTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MapaAnexoTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class MapaAnexoTiposTable extends Table
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
        

        $this->setTable('mapa_anexo_tipos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('MapaAnexos', [
            'foreignKey' => 'mapa_anexo_tipo_id',
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
