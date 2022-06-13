<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailAnexos Model
 *
 * @property \App\Model\Table\EmailsTable&\Cake\ORM\Association\BelongsTo $Emails
 * @property \App\Model\Table\AnexosTable&\Cake\ORM\Association\BelongsTo $Anexos
 *
 * @method \App\Model\Entity\EmailAnexo get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmailAnexo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmailAnexo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailAnexo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailAnexo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailAnexo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmailAnexo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailAnexo findOrCreate($search, callable $callback = null, $options = [])
 */
class EmailAnexosTable extends Table
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
        

        $this->setTable('email_anexos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Emails', [
            'foreignKey' => 'email_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Anexos', [
            'foreignKey' => 'anexo_id',
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
        $rules->add($rules->existsIn(['email_id'], 'Emails'));
        $rules->add($rules->existsIn(['anexo_id'], 'Anexos'));

        return $rules;
    }
}
