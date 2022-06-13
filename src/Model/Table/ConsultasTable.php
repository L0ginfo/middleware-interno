<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Consultas Model
 *
 * @method \App\Model\Entity\Consulta get($primaryKey, $options = [])
 * @method \App\Model\Entity\Consulta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Consulta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Consulta|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Consulta saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Consulta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Consulta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Consulta findOrCreate($search, callable $callback = null, $options = [])
 */
class ConsultasTable extends Table
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

        $this->setTable('consultas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');
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
            ->scalar('codigo')
            ->maxLength('codigo', 255)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo');

        $validator
            ->scalar('detalhes')
            ->maxLength('detalhes', 255)
            ->requirePresence('detalhes', 'create')
            ->notEmptyString('detalhes');

        $validator
            ->scalar('cabesario')
            ->requirePresence('cabesario', 'create')
            ->notEmptyString('cabesario');

        $validator
            ->scalar('conteudo')
            ->requirePresence('conteudo', 'create')
            ->notEmptyString('conteudo');

        return $validator;
    }
}
