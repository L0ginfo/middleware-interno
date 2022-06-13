<?php
namespace App\Model\Table;

use App\Model\Entity\TipoRecursoStatus;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoRecursoStatus Model
 *
 * @property \Cake\ORM\Association\HasMany $LoteRecursos
 */
class TipoRecursoStatusTable extends Table
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

        $this->table('tipo_recurso_status');
        $this->displayField('nome');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('LoteRecursos', [
            'foreignKey' => 'tipo_recurso_status_id'
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('nome', 'create')
            ->notEmpty('nome');

        return $validator;
    }
}
