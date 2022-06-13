<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MapaComentarioTipos Model
 *
 * @property \App\Model\Table\MapaComentariosTable&\Cake\ORM\Association\HasMany $MapaComentarios
 *
 * @method \App\Model\Entity\MapaComentarioTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\MapaComentarioTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MapaComentarioTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MapaComentarioTipo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaComentarioTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaComentarioTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MapaComentarioTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MapaComentarioTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class MapaComentarioTiposTable extends Table
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
        

        $this->setTable('mapa_comentario_tipos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('MapaComentarios', [
            'foreignKey' => 'mapa_comentario_tipo_id',
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
