<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleCampos Model
 *
 * @property \App\Model\Table\ControladoresTable&\Cake\ORM\Association\BelongsTo $Controladores
 * @property \App\Model\Table\ControleCampoActionsTable&\Cake\ORM\Association\HasMany $ControleCampoActions
 *
 * @method \App\Model\Entity\ControleCampo get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleCampo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleCampo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleCampo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleCampo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleCampo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleCampo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleCampo findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleCamposTable extends Table
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
        

        $this->setTable('controle_campos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Controladores', [
            'foreignKey' => 'controller_id',
        ]);
        $this->hasMany('ControleCampoAcoes', [
            'foreignKey' => 'controle_campo_id',
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
            ->scalar('titulo')
            ->maxLength('titulo', 255)
            ->requirePresence('titulo', 'create')
            ->notEmptyString('titulo');

        $validator
            ->scalar('attribute')
            ->maxLength('attribute', 255)
            ->allowEmptyString('attribute');

        $validator
            ->integer('ocorrencia')
            ->notEmptyString('ocorrencia');

        $validator
            ->integer('required')
            ->notEmptyString('required');

        $validator
            ->integer('readonly')
            ->notEmptyString('readonly');

        $validator
            ->integer('hidden')
            ->notEmptyString('hidden');

        $validator
            ->scalar('pattern')
            ->maxLength('pattern', 255)
            ->allowEmptyString('pattern');

        $validator
            ->integer('ativo')
            ->notEmptyString('ativo');

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
        $rules->add($rules->existsIn(['controller_id'], 'Controladores'));

        return $rules;
    }
}
