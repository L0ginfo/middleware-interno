<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleAcessoControladoras Model
 *
 * @property \App\Model\Table\ControleAcessoAreasTable&\Cake\ORM\Association\BelongsTo $ControleAcessoAreas
 * @property \App\Model\Table\ControleAcessoAreasTable&\Cake\ORM\Association\BelongsTo $ControleAcessoAreas
 * @property \App\Model\Table\DirecaoControladorasTable&\Cake\ORM\Association\BelongsTo $DirecaoControladoras
 * @property \App\Model\Table\ModeloEquipamentosTable&\Cake\ORM\Association\BelongsTo $ModeloEquipamentos
 * @property \App\Model\Table\TipoEquipamentosTable&\Cake\ORM\Association\BelongsTo $TipoEquipamentos
 * @property \App\Model\Table\ControleAcessoLogsTable&\Cake\ORM\Association\HasMany $ControleAcessoLogs
 * @property \App\Model\Table\ControleAcessoSolicitacaoLeiturasTable&\Cake\ORM\Association\HasMany $ControleAcessoSolicitacaoLeituras
 *
 * @method \App\Model\Entity\ControleAcessoControladora get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleAcessoControladora newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleAcessoControladora[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoControladora|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoControladora saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoControladora patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoControladora[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoControladora findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleAcessoControladorasTable extends Table
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
        

        $this->setTable('controle_acesso_controladoras');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('DeAreas', [
            'foreignKey' => 'area_de_id',
            'className' => 'ControleAcessoAreas',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ParaAreas', [
            'foreignKey' => 'area_para_id',
            'className' => 'ControleAcessoAreas',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('DirecaoControladoras', [
            'foreignKey' => 'direcao_controladora_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ModeloEquipamentos', [
            'foreignKey' => 'modelo_equipamento_id',
        ]);
        $this->belongsTo('TipoEquipamentos', [
            'foreignKey' => 'tipo_equipamento_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ControleAcessoLogs', [
            'foreignKey' => 'controle_acesso_controladora_id',
        ]);
        $this->hasMany('ControleAcessoSolicitacaoLeituras', [
            'foreignKey' => 'controle_acesso_controladora_id',
        ]);
        $this->hasMany('ControleAcessoControladoraLeitoras', [
            'foreignKey' => 'controle_acesso_controladora_id',
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

        $validator
            ->integer('situacao')
            ->notEmptyString('situacao');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 45)
            ->allowEmptyString('ip');

        $validator
            ->scalar('porta')
            ->maxLength('porta', 45)
            ->allowEmptyString('porta');

        $validator
            ->scalar('offline_interval')
            ->maxLength('offline_interval', 45)
            ->allowEmptyString('offline_interval');

        $validator
            ->integer('anti_dupla')
            ->notEmptyString('anti_dupla');

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
        $rules->add($rules->existsIn(['area_de_id'], 'DeAreas'));
        $rules->add($rules->existsIn(['area_para_id'], 'ParaAreas'));
        $rules->add($rules->existsIn(['direcao_controladora_id'], 'DirecaoControladoras'));
        $rules->add($rules->existsIn(['modelo_equipamento_id'], 'ModeloEquipamentos'));
        $rules->add($rules->existsIn(['tipo_equipamento_id'], 'TipoEquipamentos'));

        return $rules;
    }
}
