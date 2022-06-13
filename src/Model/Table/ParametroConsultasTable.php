<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ParametroConsultas Model
 *
 * @method \App\Model\Entity\ParametroConsulta get($primaryKey, $options = [])
 * @method \App\Model\Entity\ParametroConsulta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ParametroConsulta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ParametroConsulta|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ParametroConsulta saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ParametroConsulta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ParametroConsulta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ParametroConsulta findOrCreate($search, callable $callback = null, $options = [])
 */
class ParametroConsultasTable extends Table
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

        $this->setTable('parametro_consultas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');
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
            ->scalar('conteudo')
            ->requirePresence('conteudo', 'create')
            ->notEmptyString('conteudo');

        return $validator;
    }
}
