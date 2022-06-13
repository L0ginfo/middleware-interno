<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PortariaUsuarios Model
 *
 * @property \App\Model\Table\PortariasTable&\Cake\ORM\Association\BelongsTo $Portarias
 * @property \App\Model\Table\ModaisTable&\Cake\ORM\Association\BelongsTo $Modais
 *
 * @method \App\Model\Entity\PortariaUsuario get($primaryKey, $options = [])
 * @method \App\Model\Entity\PortariaUsuario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PortariaUsuario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PortariaUsuario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PortariaUsuario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PortariaUsuario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PortariaUsuario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PortariaUsuario findOrCreate($search, callable $callback = null, $options = [])
 */
class PortariaUsuariosTable extends Table
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
        

        $this->setTable('portaria_usuarios');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Portarias', [
            'foreignKey' => 'portaria_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Modais', [
            'foreignKey' => 'modal_id',
            'joinType' => 'INNER',
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

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['portaria_id'], 'Portarias'));
        $rules->add($rules->existsIn(['modal_id'], 'Modais'));

        return $rules;
    }
}
