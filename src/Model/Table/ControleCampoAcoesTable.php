<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleCampoAcoes Model
 *
 * @property \App\Model\Table\ControleCamposTable&\Cake\ORM\Association\BelongsTo $ControleCampos
 * @property \App\Model\Table\PerfisTable&\Cake\ORM\Association\BelongsToMany $Perfis
 *
 * @method \App\Model\Entity\ControleCampoAcao get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleCampoAcao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleCampoAcao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleCampoAcao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleCampoAcao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleCampoAcao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleCampoAcao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleCampoAcao findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleCampoAcoesTable extends Table
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
        

        $this->setTable('controle_campo_acoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ControleCampos', [
            'foreignKey' => 'controle_campo_id',
        ]);

        $this->hasMany('ControleCampoAcaoPerfis', [
            'foreignKey' => 'controle_campo_acao_id',
        ]);
        
        $this->belongsToMany('Perfis', [
            'foreignKey' => 'controle_campo_acao_id',
            'targetForeignKey' => 'perfil_id',
            'joinTable' => 'controle_campo_acao_perfis',
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
            ->scalar('action')
            ->maxLength('action', 255)
            ->allowEmptyString('action');

        $validator
            ->integer('ativo')
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
        $rules->add($rules->existsIn(['controle_campo_id'], 'ControleCampos'));

        return $rules;
    }
}
