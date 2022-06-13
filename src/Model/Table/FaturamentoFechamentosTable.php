<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Phinx\Db\Table\ForeignKey;

/**
 * FaturamentoFechamentos Model
 *
 * @property \App\Model\Table\FaturamentoFechamentoItensTable&\Cake\ORM\Association\HasMany $FaturamentoFechamentoItens
 *
 * @method \App\Model\Entity\FaturamentoFechamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\FaturamentoFechamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FaturamentoFechamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoFechamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoFechamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoFechamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoFechamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoFechamento findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FaturamentoFechamentosTable extends Table
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

        $this->setTable('faturamento_fechamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('LogsTabelas');

        $this->hasMany('FaturamentoFechamentoItens', [
            'foreignKey' => 'faturamento_fechamento_id'
        ]);

        $this->belongsTo('Usuarios',[
            'foreignKey' => 'created_by',
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
            ->integer('sequencia')
            ->requirePresence('sequencia', 'create')
            ->notEmptyString('sequencia');

        $validator
            ->dateTime('periodo_inicial')
            ->requirePresence('periodo_inicial', 'create')
            ->notEmptyDateTime('periodo_inicial');

        $validator
            ->dateTime('periodo_final')
            ->requirePresence('periodo_final', 'create')
            ->notEmptyDateTime('periodo_final');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        $validator
            ->integer('updated_by')
            ->allowEmptyString('updated_by');

        return $validator;
    }
}
