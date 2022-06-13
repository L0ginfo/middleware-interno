<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ApreensaoItens Model
 *
 * @property &\Cake\ORM\Association\BelongsTo $Apreensoes
 * @property \App\Model\Table\NcmsTable&\Cake\ORM\Association\BelongsTo $Ncms
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 *
 * @method \App\Model\Entity\ApreensaoItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\ApreensaoItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ApreensaoItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ApreensaoItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ApreensaoItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ApreensaoItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ApreensaoItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ApreensaoItem findOrCreate($search, callable $callback = null, $options = [])
 */
class ApreensaoItensTable extends Table
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
        

        $this->setTable('apreensao_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Apreensoes', [
            'foreignKey' => 'apreensao_id',
        ]);
        $this->belongsTo('Ncms', [
            'foreignKey' => 'ncm_id',
        ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
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
            ->integer('sequencia')
            ->notEmptyString('sequencia');

        $validator
            ->decimal('quantidade')
            ->notEmptyString('quantidade');

        $validator
            ->decimal('valor_unitario_moeda')
            ->notEmptyString('valor_unitario_moeda');

        $validator
            ->decimal('valor_total')
            ->notEmptyString('valor_total');

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
        $rules->add($rules->existsIn(['apreensao_id'], 'Apreensoes'));
        $rules->add($rules->existsIn(['ncm_id'], 'Ncms'));
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));

        return $rules;
    }
}
