<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SituacaoProgramacaoMaritimas Model
 *
 * @method \App\Model\Entity\SituacaoProgramacaoMaritima get($primaryKey, $options = [])
 * @method \App\Model\Entity\SituacaoProgramacaoMaritima newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SituacaoProgramacaoMaritima[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SituacaoProgramacaoMaritima|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SituacaoProgramacaoMaritima saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SituacaoProgramacaoMaritima patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SituacaoProgramacaoMaritima[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SituacaoProgramacaoMaritima findOrCreate($search, callable $callback = null, $options = [])
 */
class SituacaoProgramacaoMaritimasTable extends Table
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

        $this->setTable('situacao_programacao_maritimas');
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
            ->maxLength('codigo', 45)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 250)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
