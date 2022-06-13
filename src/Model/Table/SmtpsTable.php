<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Smtps Model
 *
 * @property \App\Model\Table\EmailsTable&\Cake\ORM\Association\HasMany $Emails
 *
 * @method \App\Model\Entity\Smtp get($primaryKey, $options = [])
 * @method \App\Model\Entity\Smtp newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Smtp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Smtp|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Smtp saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Smtp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Smtp[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Smtp findOrCreate($search, callable $callback = null, $options = [])
 */
class SmtpsTable extends Table
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
        

        $this->setTable('smtps');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Emails', [
            'foreignKey' => 'smtp_id',
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
            ->scalar('host')
            ->maxLength('host', 255)
            ->requirePresence('host', 'create')
            ->notEmptyString('host');

        $validator
            ->integer('port')
            ->notEmptyString('port');

        $validator
            ->scalar('user')
            ->maxLength('user', 255)
            ->requirePresence('user', 'create')
            ->notEmptyString('user');

        $validator
            ->scalar('pass')
            ->maxLength('pass', 255)
            ->requirePresence('pass', 'create')
            ->notEmptyString('pass');

        $validator
            ->integer('auth')
            ->notEmptyString('auth');

        $validator
            ->scalar('smtp_secure')
            ->maxLength('smtp_secure', 255)
            ->notEmptyString('smtp_secure');

        return $validator;
    }
}
