<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleAcessoEventos Model
 *
 * @property \App\Model\Table\ControleAcessoLogsTable&\Cake\ORM\Association\HasMany $ControleAcessoLogs
 *
 * @method \App\Model\Entity\ControleAcessoEvento get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleAcessoEvento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleAcessoEvento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoEvento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoEvento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoEvento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoEvento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoEvento findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleAcessoEventosTable extends Table
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
        

        $this->setTable('controle_acesso_eventos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('ControleAcessoLogs', [
            'foreignKey' => 'controle_acesso_evento_id',
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
