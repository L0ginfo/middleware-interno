<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoEstruturas Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\AreasTable&\Cake\ORM\Association\HasMany $Areas
 *
 * @method \App\Model\Entity\TipoEstrutura get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoEstrutura newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoEstrutura[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoEstrutura|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoEstrutura saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoEstrutura patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoEstrutura[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoEstrutura findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoEstruturasTable extends Table
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

        $this->setTable('tipo_estruturas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Areas', [
            'foreignKey' => 'tipo_estrutura_id'
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
            ->scalar('composicao1')
            ->maxLength('composicao1', 45)
            ->requirePresence('composicao1', 'create')
            ->notEmptyString('composicao1');

        $validator
            ->scalar('composicao2')
            ->maxLength('composicao2', 45)
            ->requirePresence('composicao2', 'create')
            ->notEmptyString('composicao2');

        $validator
            ->scalar('composicao3')
            ->maxLength('composicao3', 45)
            ->allowEmptyString('composicao3');

        $validator
            ->scalar('composicao4')
            ->maxLength('composicao4', 45)
            ->allowEmptyString('composicao4');

        $validator
            ->integer('ativo')
            ->requirePresence('ativo', 'create')
            ->notEmptyString('ativo');

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
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));

        return $rules;
    }
}
