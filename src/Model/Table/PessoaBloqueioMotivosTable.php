<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PessoaBloqueioMotivos Model
 *
 * @property \App\Model\Table\PessoaBloqueiosTable&\Cake\ORM\Association\HasMany $PessoaBloqueios
 *
 * @method \App\Model\Entity\PessoaBloqueioMotivo get($primaryKey, $options = [])
 * @method \App\Model\Entity\PessoaBloqueioMotivo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PessoaBloqueioMotivo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PessoaBloqueioMotivo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PessoaBloqueioMotivo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PessoaBloqueioMotivo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PessoaBloqueioMotivo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PessoaBloqueioMotivo findOrCreate($search, callable $callback = null, $options = [])
 */
class PessoaBloqueioMotivosTable extends Table
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
        

        $this->setTable('pessoa_bloqueio_motivos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('PessoaBloqueios', [
            'foreignKey' => 'pessoa_bloqueio_motivo_id',
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
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
