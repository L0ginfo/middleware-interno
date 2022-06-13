<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleAcessoEquipamentos Model
 *
 * @property \App\Model\Table\ModeloEquipamentosTable&\Cake\ORM\Association\BelongsTo $ModeloEquipamentos
 * @property \App\Model\Table\ControleAcessoSolicitacaoLeiturasTable&\Cake\ORM\Association\HasMany $ControleAcessoSolicitacaoLeituras
 *
 * @method \App\Model\Entity\ControleAcessoEquipamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleAcessoEquipamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleAcessoEquipamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoEquipamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoEquipamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoEquipamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoEquipamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoEquipamento findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleAcessoEquipamentosTable extends Table
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
        

        $this->setTable('controle_acesso_equipamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ModeloEquipamentos', [
            'foreignKey' => 'modelo_equipamento_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('TipoAcessos', [
            'foreignKey' => 'tipo_acesso_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('ControleAcessoSolicitacaoLeituras', [
            'foreignKey' => 'controle_acesso_equipamento_id',
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
            ->allowEmptyString('codigo');

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
        $rules->add($rules->existsIn(['modelo_equipamento_id'], 'ModeloEquipamentos'));

        return $rules;
    }
}
