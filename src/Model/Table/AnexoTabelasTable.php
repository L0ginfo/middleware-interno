<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AnexoTabelas Model
 *
 * @property \App\Model\Table\AnexosTable&\Cake\ORM\Association\BelongsTo $Anexos
 * @property \App\Model\Table\AnexoTiposTable&\Cake\ORM\Association\BelongsTo $AnexoTipos
 * @property \App\Model\Table\AnexoSituacoesTable&\Cake\ORM\Association\BelongsTo $AnexoSituacoes
 *
 * @method \App\Model\Entity\AnexoTabela get($primaryKey, $options = [])
 * @method \App\Model\Entity\AnexoTabela newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AnexoTabela[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AnexoTabela|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AnexoTabela saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AnexoTabela patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AnexoTabela[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AnexoTabela findOrCreate($search, callable $callback = null, $options = [])
 */
class AnexoTabelasTable extends Table
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
        

        $this->setTable('anexo_tabelas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Anexos', [
            'foreignKey' => 'anexo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('AnexoTipos', [
            'foreignKey' => 'anexo_tipo_id',
        ]);
        $this->belongsTo('AnexoSituacoes', [
            'foreignKey' => 'anexo_situacao_id',
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
            ->integer('id_tabela')
            ->requirePresence('id_tabela', 'create')
            ->notEmptyString('id_tabela');

        // $validator
        //     ->scalar('tabela')
        //     ->maxLength('tabela', 255)
        //     ->requirePresence('tabela', 'create')
        //     ->notEmptyString('tabela');

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
        $rules->add($rules->existsIn(['anexo_id'], 'Anexos'));
        $rules->add($rules->existsIn(['anexo_tipo_id'], 'AnexoTipos'));
        $rules->add($rules->existsIn(['anexo_situacao_id'], 'AnexoSituacoes'));

        return $rules;
    }
}
