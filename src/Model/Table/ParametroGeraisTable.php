<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Phinx\Db\Adapter\MysqlAdapter;

/**
 * ParametroGerais Model
 *
 * @method \App\Model\Entity\ParametroGeral get($primaryKey, $options = [])
 * @method \App\Model\Entity\ParametroGeral newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ParametroGeral[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ParametroGeral|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ParametroGeral saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ParametroGeral patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ParametroGeral[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ParametroGeral findOrCreate($search, callable $callback = null, $options = [])
 */
class ParametroGeraisTable extends Table
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

        $this->setTable('parametro_gerais');
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
            ->scalar('descricao')
            ->maxLength('descricao', 100000)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->scalar('nome_unico')
            ->maxLength('nome_unico', 255)
            ->requirePresence('nome_unico', 'create')
            ->notEmptyString('nome_unico');

        $validator
            ->scalar('valor')
            ->maxLength('valor', MysqlAdapter::TEXT_LONG)
            ->requirePresence('valor', 'create')
            ->notEmptyString('valor');

        return $validator;
    }
}
