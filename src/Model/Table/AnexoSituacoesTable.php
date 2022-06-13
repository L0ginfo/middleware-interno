<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AnexoSituacoes Model
 *
 * @property \App\Model\Table\AnexoTipoGruposTable&\Cake\ORM\Association\BelongsTo $AnexoTipoGrupos
 * @property \App\Model\Table\AnexoTabelasTable&\Cake\ORM\Association\HasMany $AnexoTabelas
 *
 * @method \App\Model\Entity\AnexoSituacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\AnexoSituacao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AnexoSituacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AnexoSituacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AnexoSituacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AnexoSituacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AnexoSituacao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AnexoSituacao findOrCreate($search, callable $callback = null, $options = [])
 */
class AnexoSituacoesTable extends Table
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
        

        $this->setTable('anexo_situacoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('AnexoTipoGrupos', [
            'foreignKey' => 'anexo_tipo_grupo_id',
        ]);
        $this->hasMany('AnexoTabelas', [
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
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

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
        $rules->add($rules->existsIn(['anexo_tipo_grupo_id'], 'AnexoTipoGrupos'));

        return $rules;
    }
}
