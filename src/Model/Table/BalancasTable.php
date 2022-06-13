<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Balancas Model
 *
 * @property \App\Model\Table\TipoBalancasTable&\Cake\ORM\Association\BelongsTo $TipoBalancas
 * @property \App\Model\Table\PortariasTable&\Cake\ORM\Association\BelongsTo $Portarias
 * @property \App\Model\Table\CancelasTable&\Cake\ORM\Association\HasMany $Cancelas
 * @property \App\Model\Table\EntradaSaidaFluxosTable&\Cake\ORM\Association\HasMany $EntradaSaidaFluxos
 * @property \App\Model\Table\PesagemVeiculoRegistrosTable&\Cake\ORM\Association\HasMany $PesagemVeiculoRegistros
 *
 * @method \App\Model\Entity\Balanca get($primaryKey, $options = [])
 * @method \App\Model\Entity\Balanca newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Balanca[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Balanca|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Balanca saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Balanca patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Balanca[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Balanca findOrCreate($search, callable $callback = null, $options = [])
 */
class BalancasTable extends Table
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
        

        $this->setTable('balancas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('TipoBalancas', [
            'foreignKey' => 'tipo_balanca_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Portarias', [
            'foreignKey' => 'portaria_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Cancelas', [
            'foreignKey' => 'balanca_id',
        ]);
        $this->hasMany('EntradaSaidaFluxos', [
            'foreignKey' => 'balanca_id',
        ]);
        $this->hasMany('PesagemVeiculoRegistros', [
            'foreignKey' => 'balanca_id',
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
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['tipo_balanca_id'], 'TipoBalancas'));
        $rules->add($rules->existsIn(['portaria_id'], 'Portarias'));

        return $rules;
    }
}
