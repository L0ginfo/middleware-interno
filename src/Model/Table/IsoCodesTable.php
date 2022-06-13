<?php
namespace App\Model\Table;

use App\Model\Entity\IsoCode;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IsoCodes Model
 *
 * @property \Cake\ORM\Association\HasMany $Containers
 */
class IsoCodesTable extends Table
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

        $this->table('iso_codes');
        $this->displayField('valor');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('Containers', [
            'foreignKey' => 'iso_code_id',
                      'joinType' => 'left'
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
            ->requirePresence('valor', 'create')
            ->notEmpty('valor');

        return $validator;
    }
}
