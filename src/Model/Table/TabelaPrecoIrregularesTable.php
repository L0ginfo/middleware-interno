<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TabelaPrecoIrregulares Model
 *
 * @method \App\Model\Entity\TabelaPrecoIrregulare get($primaryKey, $options = [])
 * @method \App\Model\Entity\TabelaPrecoIrregulare newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TabelaPrecoIrregulare[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TabelaPrecoIrregulare|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelaPrecoIrregulare saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelaPrecoIrregulare patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TabelaPrecoIrregulare[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TabelaPrecoIrregulare findOrCreate($search, callable $callback = null, $options = [])
 */
class TabelaPrecoIrregularesTable extends Table
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
        

        $this->setTable('tabela_preco_irregulares');
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
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 255)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo');

        return $validator;
    }
}
