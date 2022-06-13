<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VistoriaTipos Model
 *
 * @property \App\Model\Table\GradeHorariosTable&\Cake\ORM\Association\HasMany $GradeHorarios
 * @property \App\Model\Table\VistoriasTable&\Cake\ORM\Association\HasMany $Vistorias
 *
 * @method \App\Model\Entity\VistoriaTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\VistoriaTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VistoriaTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaTipo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VistoriaTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VistoriaTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class VistoriaTiposTable extends Table
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
        

        $this->setTable('vistoria_tipos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('GradeHorarios', [
            'foreignKey' => 'vistoria_tipo_id',
        ]);
        $this->hasMany('Vistorias', [
            'foreignKey' => 'vistoria_tipo_id',
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
