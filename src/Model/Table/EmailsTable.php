<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Emails Model
 *
 * @property \App\Model\Table\SmtpsTable&\Cake\ORM\Association\BelongsTo $Smtps
 * @property \App\Model\Table\TipoEmailsTable&\Cake\ORM\Association\BelongsTo $TipoEmails
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 * @property \App\Model\Table\EmailAnexosTable&\Cake\ORM\Association\HasMany $EmailAnexos
 * @property \App\Model\Table\QueueEmailsTable&\Cake\ORM\Association\HasMany $QueueEmails
 *
 * @method \App\Model\Entity\Email get($primaryKey, $options = [])
 * @method \App\Model\Entity\Email newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Email[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Email|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Email saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Email patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Email[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Email findOrCreate($search, callable $callback = null, $options = [])
 */
class EmailsTable extends Table
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
        

        $this->setTable('emails');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Smtps', [
            'foreignKey' => 'smtp_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('TipoEmails', [
            'foreignKey' => 'tipo_email_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->hasMany('EmailAnexos', [
            'foreignKey' => 'email_id',
        ]);
        $this->hasMany('QueueEmails', [
            'foreignKey' => 'email_id',
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
            ->scalar('de')
            ->maxLength('de', 255)
            ->allowEmptyString('de');

        $validator
            ->scalar('para')
            ->allowEmptyString('para');

        $validator
            ->scalar('assunto')
            ->maxLength('assunto', 255)
            ->allowEmptyString('assunto');

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 255)
            ->allowEmptyString('codigo');

        $validator
            ->scalar('header')
            ->maxLength('header', 4294967295)
            ->allowEmptyString('header');

        $validator
            ->scalar('body')
            ->maxLength('body', 4294967295)
            ->allowEmptyString('body');

        $validator
            ->scalar('footer')
            ->maxLength('footer', 4294967295)
            ->allowEmptyString('footer');

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
        $rules->add($rules->existsIn(['smtp_id'], 'Smtps'));
        $rules->add($rules->existsIn(['tipo_email_id'], 'TipoEmails'));
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));

        return $rules;
    }
}
