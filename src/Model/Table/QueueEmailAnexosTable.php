<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QueueEmailAnexos Model
 *
 * @property \App\Model\Table\QueueEmailsTable&\Cake\ORM\Association\BelongsTo $QueueEmails
 * @property \App\Model\Table\AnexosTable&\Cake\ORM\Association\BelongsTo $Anexos
 *
 * @method \App\Model\Entity\QueueEmailAnexo get($primaryKey, $options = [])
 * @method \App\Model\Entity\QueueEmailAnexo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\QueueEmailAnexo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\QueueEmailAnexo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QueueEmailAnexo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QueueEmailAnexo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\QueueEmailAnexo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\QueueEmailAnexo findOrCreate($search, callable $callback = null, $options = [])
 */
class QueueEmailAnexosTable extends Table
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
        

        $this->setTable('queue_email_anexos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('QueueEmails', [
            'foreignKey' => 'queue_email_id',
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
        $rules->add($rules->existsIn(['queue_email_id'], 'QueueEmails'));
        $rules->add($rules->existsIn(['anexo_id'], 'Anexos'));

        return $rules;
    }
}
