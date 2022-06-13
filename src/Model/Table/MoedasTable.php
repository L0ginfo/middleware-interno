<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Moedas Model
 *
 * @property &\Cake\ORM\Association\HasMany $DocumentosMercadorias
 * @property &\Cake\ORM\Association\HasMany $MoedasCotacoes
 *
 * @method \App\Model\Entity\Moeda get($primaryKey, $options = [])
 * @method \App\Model\Entity\Moeda newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Moeda[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Moeda|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Moeda saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Moeda patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Moeda[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Moeda findOrCreate($search, callable $callback = null, $options = [])
 */
class MoedasTable extends Table
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

        $this->setTable('moedas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('DocumentosMercadorias', [
            'foreignKey' => 'moeda_id'
        ]);
        $this->hasMany('MoedasCotacoes', [
            'foreignKey' => 'moeda_id'
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
            ->maxLength('descricao', 45)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->scalar('sigla')
            ->maxLength('sigla', 10)
            ->requirePresence('sigla', 'create')
            ->notEmptyString('sigla');

        return $validator;
    }
}
