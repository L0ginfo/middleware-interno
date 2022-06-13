<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Servicos Model
 *
 * @property \App\Model\Table\TabelasPrecosPeriodosArmsTable&\Cake\ORM\Association\HasMany $TabelasPrecosPeriodosArms
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsToMany $TabelasPrecos
 *
 * @method \App\Model\Entity\Servico get($primaryKey, $options = [])
 * @method \App\Model\Entity\Servico newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Servico[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Servico|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Servico saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Servico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Servico[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Servico findOrCreate($search, callable $callback = null, $options = [])
 */
class ServicosTable extends Table
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

        $this->setTable('servicos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('TabelasPrecosPeriodosArms', [
            'foreignKey' => 'servico_id'
        ]);
        $this->belongsToMany('TabelasPrecos', [
            'foreignKey' => 'servico_id',
            'targetForeignKey' => 'tabelas_preco_id',
            'joinTable' => 'tabelas_precos_servicos'
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
            ->maxLength('descricao', 150)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
