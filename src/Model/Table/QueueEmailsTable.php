<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QueueEmails Model
 *
 * @property \App\Model\Table\EmailsTable&\Cake\ORM\Association\BelongsTo $Emails
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\QueueEmailAnexosTable&\Cake\ORM\Association\HasMany $QueueEmailAnexos
 *
 * @method \App\Model\Entity\QueueEmail get($primaryKey, $options = [])
 * @method \App\Model\Entity\QueueEmail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\QueueEmail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\QueueEmail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QueueEmail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QueueEmail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\QueueEmail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\QueueEmail findOrCreate($search, callable $callback = null, $options = [])
 */
class QueueEmailsTable extends Table
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
        
        // $this->addBehavior('LogsTabelas');
        

        $this->setTable('queue_emails');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Emails', [
            'foreignKey' => 'email_id',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Mensagens', [
            'foreignKey' => 'mensagem_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('QueueEmailAnexos', [
            'foreignKey' => 'queue_email_id',
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
            ->scalar('from_name')
            ->maxLength('from_name', 255)
            ->allowEmptyString('from_name');

        $validator
            ->scalar('from_email')
            ->maxLength('from_email', 255)
            ->allowEmptyString('from_email');

        $validator
            ->scalar('to_email')
            ->allowEmptyString('to_email');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 255)
            ->allowEmptyString('subject');

        $validator
            ->scalar('max_attempts')
            ->maxLength('max_attempts', 4)
            ->notEmptyString('max_attempts');

        $validator
            ->integer('attempts')
            ->notEmptyString('attempts');

        $validator
            ->integer('success')
            ->notEmptyString('success');

        $validator
            ->dateTime('date_published')
            ->allowEmptyDateTime('date_published');

        $validator
            ->dateTime('last_attempt')
            ->allowEmptyDateTime('last_attempt');

        $validator
            ->dateTime('date_sent')
            ->allowEmptyDateTime('date_sent');

        $validator
            ->scalar('profile')
            ->maxLength('profile', 10)
            ->allowEmptyFile('profile');

        $validator
            ->scalar('attachs')
            ->allowEmptyString('attachs');

        $validator
            ->scalar('html')
            ->maxLength('html', 255)
            ->notEmptyString('html');

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
        $rules->add($rules->existsIn(['email_id'], 'Emails'));
        $rules->add($rules->existsIn(['user_id'], 'Usuarios'));

        return $rules;
    }
}
