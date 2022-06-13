<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DetalhamentoCargas Model
 *
 * @property \App\Model\Table\TabelaPrecoDetalhamentoCargasTable&\Cake\ORM\Association\HasMany $TabelaPrecoDetalhamentoCargas
 *
 * @method \App\Model\Entity\DetalhamentoCarga get($primaryKey, $options = [])
 * @method \App\Model\Entity\DetalhamentoCarga newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DetalhamentoCarga[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DetalhamentoCarga|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DetalhamentoCarga saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DetalhamentoCarga patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DetalhamentoCarga[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DetalhamentoCarga findOrCreate($search, callable $callback = null, $options = [])
 */
class DetalhamentoCargasTable extends Table
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
        

        $this->setTable('detalhamento_cargas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('TabelaPrecoDetalhamentoCargas', [
            'foreignKey' => 'detalhamento_carga_id',
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

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 255)
            ->allowEmptyString('codigo');

        return $validator;
    }
}
