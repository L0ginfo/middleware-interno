<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PortoTrabalhoPeriodos Model
 *
 * @method \App\Model\Entity\PortoTrabalhoPeriodo get($primaryKey, $options = [])
 * @method \App\Model\Entity\PortoTrabalhoPeriodo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PortoTrabalhoPeriodo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PortoTrabalhoPeriodo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PortoTrabalhoPeriodo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PortoTrabalhoPeriodo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PortoTrabalhoPeriodo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PortoTrabalhoPeriodo findOrCreate($search, callable $callback = null, $options = [])
 */
class PortoTrabalhoPeriodosTable extends Table
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

        $this->hasMany('PlanejamentoMaritimoTernoPeriodos', [
            'foreignKey' => 'periodo_id',
            'joinType' => 'LEFT',
        ]);

        $this->setTable('porto_trabalho_periodos');
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
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->allowEmptyString('descricao');

        $validator
            ->integer('ordem')
            ->requirePresence('ordem', 'create')
            ->notEmptyString('ordem');

        $validator
            ->time('hora_inicio')
            ->requirePresence('hora_inicio', 'create')
            ->notEmptyTime('hora_inicio');

        $validator
            ->time('hora_fim')
            ->requirePresence('hora_fim', 'create')
            ->notEmptyTime('hora_fim');

        return $validator;
    }
}
