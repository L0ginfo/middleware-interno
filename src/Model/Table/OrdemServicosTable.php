<?php
namespace App\Model\Table;

use App\Model\Entity\ParametroGeral;
use App\RegraNegocio\Integracoes\HandlerIntegracao;
use App\RegraNegocio\Rfb\RfbManager;
use App\Util\LgDbUtil;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicos Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\OrdemServicoTiposTable&\Cake\ORM\Association\BelongsTo $OrdemServicoTipos
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 * @property \App\Model\Table\OrdemServicoItensTable&\Cake\ORM\Association\HasMany $OrdemServicoItens
 * @property \App\Model\Table\OrdemServicoServexecsTable&\Cake\ORM\Association\HasMany $OrdemServicoServexecs
 * @property \App\Model\Table\TermoAvariasTable&\Cake\ORM\Association\HasMany $TermoAvarias
 *
 * @method \App\Model\Entity\OrdemServico get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServico newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServico[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServico|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServico saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServico[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServico findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdemServicosTable extends Table
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

        $this->setTable('ordem_servicos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrdemServicoTipos', [
            'foreignKey' => 'ordem_servico_tipo_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrdemServicoTiposLeft', [
            'className'     => 'OrdemServicoTipos',
            'foreignKey'    => 'ordem_servico_tipo_id',
            'propertyName'  => 'ordem_servico_tipo',
            'joinType'      => 'LEFT'
        ]);
        $this->belongsTo('DocumentosMercadorias', [
            'foreignKey' => 'documentos_mercadoria_id',
            'bindingKey' => 'id',
        ]);
        
        $this->belongsTo('Servicos', [
            'foreignKey' => 'servico_principal_id',
            'bindingKey' => 'id',
        ]);

        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ResvsLeft', [
            'className' => 'Resvs',
            'propertyName' => 'resv',
            'foreignKey' => 'resv_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'initiated_by_id'
        ]);
        $this->belongsTo('InitiatedBy', [
            'foreignKey' => 'initiated_by_id',
            'joinType' => 'LEFT',
            'className' => 'Usuarios', 
            'propertyName' => 'initiated_by'
        ]);
        $this->belongsTo('ReabertaPor', [
            'foreignKey' => 'reaberta_por',
            'joinType' => 'LEFT',
            'className' => 'Usuarios', 
            'propertyName' => 'reaberta_por'
        ]);
        $this->belongsTo('CanceladaPor', [
            'foreignKey' => 'cancelada_por',
            'joinType' => 'LEFT',
            'className' => 'Usuarios', 
            'propertyName' => 'cancelada_por'
        ]);
        $this->hasMany('OrdemServicoItens', [
            'foreignKey' => 'ordem_servico_id'
        ]);
        $this->hasMany('OrdemServicoCarregamentos', [
            'foreignKey' => 'ordem_servico_id'
        ]);
        $this->hasMany('OrdemServicoItemSeparacoes', [
            'foreignKey' => 'ordem_servico_id'
        ]);
        $this->hasMany('OrdemServicoSeparacaoCargas', [
            'foreignKey' => 'ordem_servico_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('OrdemServicoServexecs', [
            'foreignKey' => 'ordem_servico_id'
        ]);
        $this->hasMany('TermoAvarias', [
            'foreignKey' => 'ordem_servico_id'
        ]);
        $this->hasMany('OrdemServicoMovs', [
            'foreignKey' => 'ordem_servico_id'
        ]);
        $this->hasMany('OrdemServicoLacres', [
            'foreignKey' => 'ordem_servico_id'
        ]);
        $this->belongsTo('OrdemServicoTiposLeft', [
            'foreignKey' => 'ordem_servico_tipo_id',
            'joinType' => 'LEFT',
            'className' => 'OrdemServicoTipos', 
            'propertyName' => 'ordem_servico_tipo'
        ]);

        $this->belongsToMany('Usuarios', [
            'className'=> 'Usuarios',
            'foreignKey' => 'ordem_servico_id',
            'targetForeignKey' => 'conferente_id',
            'through' => 'OrdemServicoConferentes'
        ]);
        $this->hasMany('OrdemServicoUnitizacoes', [
            'foreignKey' => 'ordem_servico_id'
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_exclusivo_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('OrdemServicoDocumentoRegimeEspeciais', [
            'foreignKey' => 'ordem_servico_id'
        ]);
        $this->hasMany('OrdemServicoDsics', [
            'foreignKey' => 'ordem_servico_id'
        ]);
        $this->hasMany('OrdemServicoConferentes', [
            'foreignKey' => 'ordem_servico_id'
        ]);

        $this->hasMany('OrdemServicoItemLoteDesestufados', [
            'foreignKey' => 'ordem_servico_id'
        ]);
        
        $this->hasMany('OrdemServicoItemLoteEstufados', [
            'foreignKey' => 'ordem_servico_id'
        ]);

        $this->hasMany('OrdemServicoItemLingadas', [
            'foreignKey' => 'ordem_servico_id'
        ]);
        
        $this->hasMany('OrdemServicoAvarias', [
            'foreignKey' => 'ordem_servico_id'
        ]);
        $this->hasMany('OrdemServicoTemperaturas', [
            'foreignKey' => 'ordem_servico_id'
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
            ->dateTime('data_hora_programada')
            ->allowEmptyDateTime('data_hora_programada');

        $validator
            ->dateTime('data_hora_inicio')
            ->allowEmptyDateTime('data_hora_inicio');

        $validator
            ->dateTime('data_hora_fim')
            ->allowEmptyDateTime('data_hora_fim');

        $validator
            ->scalar('observacao')
            ->maxLength('observacao', 200)
            ->allowEmptyString('observacao');

        $validator
            ->integer('retroativo')
            ->requirePresence('retroativo', 'create')
            ->notEmptyString('retroativo');

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
        $rules->add($rules->existsIn(['ordem_servico_tipo_id'], 'OrdemServicoTipos'));
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));
        return $rules;
    }

    public function beforeSave($event, $entity, $options) {

        $oParamIntegracaoDesova = ParametroGeral::getParameterByUniqueName('PARAM_INTEGRACAO_FINAL_DESOVA');

        if ($entity->data_hora_fim)
            RfbManager::doAction('rfb', 'carregamento-lotes', 'init', $entity, ['nome_model' => 'Integracoes']);

        if ($oParamIntegracaoDesova) {
            $oResponse = HandlerIntegracao::do(@$oParamIntegracaoDesova->id, [
                'oEntity' => $entity,
                'iContainer' => $entity->container_id,
                'iStatus' => 2,
                'function' => 3
            ]);
    
            if ($oResponse->getStatus() != 200) {
                $entity->setErrors(['data_hora_fim' => [$oResponse->getMessage()]]);
                return false;
            }
        }
    }

    public function beforeDelete($event, $entity, $options)
    {
        RfbManager::doAction('rfb', 'carregamento-lotes', 'init', $entity, ['nome_model' => 'Integracoes', 'operacao' => 'delete']);
    }
}
