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
 * Resvs Model
 *
 * @property \App\Model\Table\OperacoesTable&\Cake\ORM\Association\BelongsTo $Operacoes
 * @property \App\Model\Table\VeiculosTable&\Cake\ORM\Association\BelongsTo $Veiculos
 * @property \App\Model\Table\TransportadorasTable&\Cake\ORM\Association\BelongsTo $Transportadoras
 * @property \App\Model\Table\PessoasTable&\Cake\ORM\Association\BelongsTo $Pessoas
 * @property \App\Model\Table\ModaisTable&\Cake\ORM\Association\BelongsTo $Modais
 * @property \App\Model\Table\PortariasTable&\Cake\ORM\Association\BelongsTo $Portarias
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\HasMany $OrdemServicos
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\BelongsToMany $DocumentosTransportes
 * @property &\Cake\ORM\Association\BelongsToMany $LiberacoesDocumentais
 * @property \App\Model\Table\VeiculosTable&\Cake\ORM\Association\BelongsToMany $Veiculos
 *
 * @method \App\Model\Entity\Resv get($primaryKey, $options = [])
 * @method \App\Model\Entity\Resv newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Resv[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Resv|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Resv saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Resv patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Resv[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Resv findOrCreate($search, callable $callback = null, $options = [])
 */
class ResvsTable extends Table
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

        $this->setTable('resvs');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Operacoes', [
            'foreignKey' => 'operacao_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OperacoesResv', [
            'foreignKey' => 'operacao_id',
            'className' => 'Operacoes',
            'propertyName' => 'operacao',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Veiculos', [
            'foreignKey' => 'veiculo_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Transportadoras', [
            'foreignKey' => 'transportador_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Pessoas', [
            'foreignKey' => 'pessoa_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Modais', [
            'foreignKey' => 'modal_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Portarias', [
            'foreignKey' => 'portaria_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('OrdemServicos', [
            'foreignKey' => 'resv_id'
        ]);
        $this->hasOne('OrdemServicosHasOneLeft', [
            'foreignKey' => 'resv_id',
            'className' => 'OrdemServicos',
            'propertyName' => 'ordem_servico',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('OrdemServicosLeft', [
            'foreignKey' => 'resv_id',
            'className' => 'OrdemServicos',
            'propertyName' => 'ordem_servicos',
            'joinType' => 'LEFT'
        ]);
        $this->belongsToMany('DocumentosTransportes', [
            'foreignKey' => 'resv_id',
            'targetForeignKey' => 'documentos_transporte_id',
            'joinTable' => 'resvs_documentos_transportes'
        ]);

        $this->hasMany('ResvsDocumentosTransportes', [
            'foreignKey' => 'resv_id',
        ]);

        $this->hasMany('Pesagens', [
            'foreignKey' => 'resv_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('ResvsVeiculos', [
            'foreignKey' => 'resv_id',
        ]);

        $this->hasMany('ResvsLiberacoesDocumentais', [
            'foreignKey' => 'resv_id',
        ]);

        $this->hasMany('ResvsFormacaoCargas', [
            'foreignKey' => 'resv_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsToMany('FormacaoCargas', [
            'foreignKey' => 'resv_id',
            'targetForeignKey' => 'formacao_carga_id',
            'joinTable' => 'resvs_formacao_cargas'
        ]);

        $this->belongsToMany('LiberacoesDocumentais', [
            'foreignKey' => 'resv_id',
            'targetForeignKey' => 'liberacoes_documental_id',
            'joinTable' => 'resvs_liberacoes_documentais'
        ]);
        $this->belongsToMany('Veiculos', [
            'foreignKey' => 'resv_id',
            'targetForeignKey' => 'veiculo_id',
            'joinTable' => 'resvs_veiculos'
        ]);   

        $this->belongsTo('Veiculos', [
            'foreignKey' => 'veiculo_id',
            'targetForeignKey' => 'veiculo_id',
            'bindingKey' => 'id',
        ]);

        $this->hasOne('AcessosPessoas', [
            'foreignKey' => 'resv_id',
        ]);

        $this->hasMany('ResvsContainers', [
            'foreignKey' => 'resv_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsToMany('LiberacoesDocumentaisIndex', [
            'className' => 'LiberacoesDocumentais',
            'foreignKey' => 'resv_id',
            'targetForeignKey' => 'liberacao_documental_id',
            'through' => 'resvs_liberacoes_documentais'
        ]);

        $this->belongsToMany('DocumentosTransportesIndex', [
            'className' => 'DocumentosTransportes',
            'foreignKey' => 'resv_id',
            'targetForeignKey' => 'documento_transporte_id',
            'through' => 'resvs_documentos_transportes'
        ]);

        $this->belongsToMany('Reboque1', [
            'className' => 'Veiculos',
            'foreignKey' => 'resv_id',
            'targetForeignKey' => 'veiculo_id',
            'through' => 'ResvsVeiculos',
            'conditions' => ['ResvsVeiculos.sequencia_veiculo' => 1],
            'sort' => [
                'ResvsVeiculos.id' => 'DESC'
            ]
        ]);

        $this->belongsToMany('Reboque2', [
            'className' => 'Veiculos',
            'foreignKey' => 'resv_id',
            'targetForeignKey' => 'veiculo_id',
            'through' => 'ResvsVeiculos',
            'conditions' => ['ResvsVeiculos.sequencia_veiculo' => 2],
            'sort' => [
                'ResvsVeiculos.id' => 'DESC'
            ]
        ]);

        $this->hasMany('EntradaSaidaContainerResvEntradas', [
            'foreignKey' => 'resv_entrada_id',
            'className' => 'EntradaSaidaContainers',
            'propertyName' => 'entrada_saida_containers',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('EntradaSaidaContainerResvSaidas', [
            'foreignKey' => 'resv_saida_id',
            'className' => 'EntradaSaidaContainers',
            'propertyName' => 'entrada_saida_containers',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('Vistorias', [
            'foreignKey' => 'resv_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('LeftPessoas', [
            'className' => 'Pessoas',
            'foreignKey' => 'pessoa_id',
            'joinType' => 'LEFT'
        ]);
    
        $this->belongsTo('LeftTransportadoras', [
            'className' => 'Transportadoras',
            'foreignKey' => 'transportador_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('Programacoes', [
            'foreignKey' => 'programacao_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('OrdemServicoItemLingadas', [
            'foreignKey' => 'resv_id',
            'joinType' => 'LEFT'
        ]);
        
        $this->hasMany('ChecklistResvs', [
            'foreignKey' => 'resv_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('ResvPlanejamentoMaritimos', [
            'foreignKey' => 'resv_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('ResvDriveEspacos', [
            'dependent' => true,
            'foreignKey' => 'resv_id'
        ]);

        $this->hasMany('ResvMaritimas', [
            'foreignKey' => 'resv_id'
        ]);

        $this->hasMany('OperacoesLeft', [
            'className' => 'Resvs',
            'propertyName' => 'operacao',
            'foreignKey' => 'operacao_id',
            'joinType' => 'LEFT'
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
            ->scalar('resv_codigo')
            ->maxLength('resv_codigo', 20)
            ->requirePresence('resv_codigo', 'create')
            ->notEmptyString('resv_codigo');

        $validator
            ->dateTime('data_hora_chegada')
            ->allowEmptyDateTime('data_hora_chegada');

        $validator
            ->dateTime('data_hora_entrada')
            ->allowEmptyDateTime('data_hora_entrada');

        $validator
            ->dateTime('data_hora_saida')
            ->allowEmptyDateTime('data_hora_saida');

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
        $rules->add($rules->existsIn(['operacao_id'], 'Operacoes'));
        $rules->add($rules->existsIn(['veiculo_id'], 'Veiculos'));
        $rules->add($rules->existsIn(['transportador_id'], 'Transportadoras'));
        $rules->add($rules->existsIn(['pessoa_id'], 'Pessoas'));
        $rules->add($rules->existsIn(['modal_id'], 'Modais'));
        $rules->add($rules->existsIn(['portaria_id'], 'Portarias'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));

        return $rules;
    }

    public function beforeSave($event, $entity, $options) {

        if ($entity->isNew())
            $entity->usuario_id = $_SESSION['Auth']['User']['id'];

        /*$oParamIntegracaoDadosAgenTranspMaritimo = ParametroGeral::getParameterByUniqueName('PARAM_INTE_DADOS_AGEN_TRANSP_MARITIMO');
        if ($oParamIntegracaoDadosAgenTranspMaritimo && $entity->programacao_id && !$entity->isNew()) {
            $oResponse = HandlerIntegracao::do(@$oParamIntegracaoDadosAgenTranspMaritimo->id, [
                'oEntity' => $entity
            ]);

            if (isset($oResponse) && $oResponse->getStatus() != 200) {
                $entity->setErrors(['integracao' => [$oResponse->getMessage()]]);
                return false;
            }
        }*/
        if (in_array('data_hora_entrada', $entity->getDirty()) && $entity->data_hora_entrada) 
            RfbManager::doAction('rfb', 'chegada-ponto-zero', 'init', $entity, ['nome_model' => 'Integracoes']);

        if (in_array('data_hora_saida', $entity->getDirty()) && $entity->data_hora_saida) 
            RfbManager::doAction('rfb', 'credenciamento-veiculos', 'init', $entity, ['nome_model' => 'Integracoes', 'tipo' => 'Resvs']);

        /*$oParamIntegracaoFinalizacaoResv = ParametroGeral::getParameterByUniqueName('PARAM_INTEGRACAO_FINALIZACAO_RESV');

        if ($oParamIntegracaoFinalizacaoResv) {
            $oResponse = HandlerIntegracao::do(@$oParamIntegracaoFinalizacaoResv->id, [
                'oEntity' => $entity,
                'iStatus' => 2,
                'function' => 3
            ]);
    
            if ($oResponse->getStatus() != 200) {
                $entity->setErrors(['data_hora_saida' => [$oResponse->getMessage()]]);
                return false;
            }
        }*/

        /*$oParamIntegracaoDadosAgenTranspMaritimo = ParametroGeral::getParameterByUniqueName('PARAM_INTE_DADOS_AGEN_TRANSP_MARITIMO');

        if ($oParamIntegracaoDadosAgenTranspMaritimo)
            $oResponse = HandlerIntegracao::do(@$oParamIntegracaoDadosAgenTranspMaritimo->id, [
                'oEntity' => $entity
            ]);*/
    }

    public function afterSave($event, $entity, $options)
    {
        
        /*if ($entity->data_hora_saida && $entity->programacao_id && !$entity->isNew()) {
            $oResponse = HandlerIntegracao::do(ParametroGeral::getParameterByUniqueName('PARAM_INTE_EMBARQUE_DESEMBARQUE')->id,[
                'resv_id' => $entity->id,
            ]);

            if (isset($oResponse) && $oResponse->getStatus() != 200) {
                $entity->setErrors(['integracao' => [$oResponse->getMessage()]]);
                return false;
            }

        }*/
    
        RfbManager::doAction('rfb', 'acesso-veiculos', 'init', $entity, ['nome_model' => 'Integracoes', 'tipo' => 'Resvs']);
    }

    public function beforeDelete($event, $entity, $options)
    {
        RfbManager::doAction('rfb', 'chegada-ponto-zero', 'init', $entity, ['nome_model' => 'Integracoes', 'operacao' => 'delete']);
    }

    public function afterDelete($event, $entity, $options)
    {
        RfbManager::doAction('rfb', 'credenciamento-veiculos', 'init', $entity, ['nome_model' => 'Integracoes', 'tipo' => 'Resvs', 'operacao' => 'delete']);
    }
}
