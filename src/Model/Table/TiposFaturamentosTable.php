<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TiposFaturamentos Model
 *
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsToMany $TabelasPrecos
 *
 * @method \App\Model\Entity\TiposFaturamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\TiposFaturamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TiposFaturamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TiposFaturamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TiposFaturamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TiposFaturamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TiposFaturamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TiposFaturamento findOrCreate($search, callable $callback = null, $options = [])
 */
class TiposFaturamentosTable extends Table
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

        $this->setTable('tipos_faturamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsToMany('TabelasPrecos', [
            'foreignKey' => 'tipos_faturamento_id',
            'targetForeignKey' => 'tabelas_preco_id',
            'joinTable' => 'tabelas_precos_tipos_faturamentos'
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

        return $validator;
    }
}
