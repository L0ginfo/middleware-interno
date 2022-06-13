<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TabelasPrecosModais Model
 *
 * @property \App\Model\Table\ModaisTable&\Cake\ORM\Association\BelongsTo $Modais
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsTo $TabelasPrecos
 *
 * @method \App\Model\Entity\TabelasPrecosModal get($primaryKey, $options = [])
 * @method \App\Model\Entity\TabelasPrecosModal newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosModal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosModal|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosModal saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosModal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosModal[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosModal findOrCreate($search, callable $callback = null, $options = [])
 */
class TabelasPrecosModaisTable extends Table
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
        

        $this->setTable('tabelas_precos_modais');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Modais', [
            'foreignKey' => 'modal_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('TabelasPrecos', [
            'foreignKey' => 'tabela_preco_id',
            'joinType' => 'INNER',
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
        $rules->add($rules->existsIn(['modal_id'], 'Modais'));
        $rules->add($rules->existsIn(['tabela_preco_id'], 'TabelasPrecos'));

        return $rules;
    }
}
