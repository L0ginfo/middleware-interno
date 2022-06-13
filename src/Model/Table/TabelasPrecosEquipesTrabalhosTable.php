<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TabelasPrecosEquipesTrabalhos Model
 *
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsTo $TabelasPrecos
 * @property \App\Model\Table\EquipesTrabalhosTable&\Cake\ORM\Association\BelongsTo $EquipesTrabalhos
 *
 * @method \App\Model\Entity\TabelasPrecosEquipesTrabalho get($primaryKey, $options = [])
 * @method \App\Model\Entity\TabelasPrecosEquipesTrabalho newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosEquipesTrabalho[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosEquipesTrabalho|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosEquipesTrabalho saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosEquipesTrabalho patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosEquipesTrabalho[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosEquipesTrabalho findOrCreate($search, callable $callback = null, $options = [])
 */
class TabelasPrecosEquipesTrabalhosTable extends Table
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

        $this->setTable('tabelas_precos_equipes_trabalhos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('TabelasPrecos', [
            'foreignKey' => 'tabelas_preco_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('EquipesTrabalhos', [
            'foreignKey' => 'equipes_trabalho_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['tabelas_preco_id'], 'TabelasPrecos'));
        $rules->add($rules->existsIn(['equipes_trabalho_id'], 'EquipesTrabalhos'));

        return $rules;
    }
}
