<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PessoaBloqueios Model
 *
 * @property \App\Model\Table\PessoasTable&\Cake\ORM\Association\BelongsTo $Pessoas
 * @property \App\Model\Table\PessoaBloqueioMotivosTable&\Cake\ORM\Association\BelongsTo $PessoaBloqueioMotivos
 *
 * @method \App\Model\Entity\PessoaBloqueio get($primaryKey, $options = [])
 * @method \App\Model\Entity\PessoaBloqueio newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PessoaBloqueio[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PessoaBloqueio|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PessoaBloqueio saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PessoaBloqueio patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PessoaBloqueio[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PessoaBloqueio findOrCreate($search, callable $callback = null, $options = [])
 */
class PessoaBloqueiosTable extends Table
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
        
        $this->setTable('pessoa_bloqueios');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Pessoas', [
            'foreignKey' => 'pessoa_bloqueada_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Usuarios', [
            'className' => 'Usuarios',
            'propertyName' => 'pessoa_created_by',
            'foreignKey' => 'created_by',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PessoaBloqueioMotivos', [
            'foreignKey' => 'pessoa_bloqueio_motivo_id',
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

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        $validator
            ->dateTime('data_inicio_bloqueio')
            ->requirePresence('data_inicio_bloqueio', 'create')
            ->notEmptyDateTime('data_inicio_bloqueio');

        $validator
            ->dateTime('data_fim_bloqueio')
            ->requirePresence('data_fim_bloqueio', 'create')
            ->allowEmptyDateTime('data_fim_bloqueio');

        $validator
            ->scalar('observacao')
            ->allowEmptyString('observacao');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

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
        $rules->add($rules->existsIn(['pessoa_bloqueada_id'], 'Pessoas'));
        $rules->add($rules->existsIn(['pessoa_bloqueio_motivo_id'], 'PessoaBloqueioMotivos'));

        return $rules;
    }
}
