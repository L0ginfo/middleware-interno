<?php
namespace App\Model\Table;

use App\Model\Entity\ParametroGeral;
use App\RegraNegocio\Integracoes\HandlerIntegracao;
use App\RegraNegocio\Rfb\RfbManager;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use ArrayObject;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Programacoes Model
 *
 * @property \App\Model\Table\OperacoesTable&\Cake\ORM\Association\BelongsTo $Operacoes
 * @property \App\Model\Table\VeiculosTable&\Cake\ORM\Association\BelongsTo $Veiculos
 * @property \App\Model\Table\TransportadorasTable&\Cake\ORM\Association\BelongsTo $Transportadoras
 * @property \App\Model\Table\PessoasTable&\Cake\ORM\Association\BelongsTo $Pessoas
 * @property \App\Model\Table\ModaisTable&\Cake\ORM\Association\BelongsTo $Modais
 * @property \App\Model\Table\PortariasTable&\Cake\ORM\Association\BelongsTo $Portarias
 * @property \App\Model\Table\EmbalagensTable&\Cake\ORM\Association\BelongsTo $Embalagens
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\ProgramacaoLiberacaoDocumentaisTable&\Cake\ORM\Association\HasMany $ProgramacaoLiberacaoDocumentais
 * @property \App\Model\Table\ProgramacaoVeiculosTable&\Cake\ORM\Association\HasMany $ProgramacaoVeiculos
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\HasMany $Resvs
 *
 * @method \App\Model\Entity\Programacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\Programacao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Programacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Programacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Programacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Programacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Programacao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Programacao findOrCreate($search, callable $callback = null, $options = [])
 */
class ProgramacoesTable extends Table
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
        

        $this->setTable('programacoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Operacoes', [
            'foreignKey' => 'operacao_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Veiculos', [
            'foreignKey' => 'veiculo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('VeiculosLeft', [
            'foreignKey' => 'veiculo_id',
            'className' => 'Veiculos',
            'propertyName' => 'veiculo',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Transportadoras', [
            'foreignKey' => 'transportadora_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('TransportadorasLeft', [
            'foreignKey' => 'transportadora_id',
            'className' => 'Transportadoras',
            'propertyName' => 'transportadora',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Pessoas', [
            'foreignKey' => 'pessoa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PessoasLeft', [
            'foreignKey' => 'pessoa_id',
            'className' => 'Pessoas',
            'propertyName' => 'pessoa',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Modais', [
            'foreignKey' => 'modal_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Portarias', [
            'foreignKey' => 'portaria_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Embalagens', [
            'foreignKey' => 'embalagem_id',
        ]);
        $this->belongsTo('ResvsFirstLeft', [
            'foreignKey' => 'resv_id',
            'className' => 'Resvs',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('ProgramacaoLiberacaoDocumentais', [
            'dependent' => true,
            'foreignKey' => 'programacao_id',
        ]);
        $this->hasMany('ProgramacaoVeiculos', [
            'foreignKey' => 'programacao_id',
        ]);
        $this->hasMany('ProgramacaoContainers', [
            'dependent' => true,
            'foreignKey' => 'programacao_id',
        ]);
        $this->hasMany('Resvs', [
            'foreignKey' => 'programacao_id',
        ]);
        $this->hasMany('ProgramacaoDocumentoTransportes', [
            'dependent' => true,
            'foreignKey' => 'programacao_id'
        ]);
        $this->hasMany('ProgramacaoDocumentoGenericos', [
            'dependent' => true,
            'foreignKey' => 'programacao_id'
        ]);
        $this->hasOne('Vistorias', [
            'foreignKey' => 'programacao_id'
        ]);
        $this->hasOne('VistoriasLeft', [
            'foreignKey' => 'programacao_id',
            'className' => 'Vistorias',
            'propertyName' => 'vistoria',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('ProgramacaoSituacoes', [
            'foreignKey' => 'programacao_situacao_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('ProgramacaoHistoricoSituacoes', [
            'dependent' => true,
            'foreignKey' => 'programacao_id'
        ]);
        $this->belongsTo('GradeHorarios', [
            'foreignKey' => 'grade_horario_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('ProgramacaoDriveEspacos', [
            'dependent' => true,
            'foreignKey' => 'programacao_id'
        ]);

        $this->hasMany('ProgramacaoResvMaritimas', [
            'dependent' => true,
            'foreignKey' => 'programacao_id'
        ]);
        $this->belongsTo('CodigoBarras', [
            'foreignKey' => 'codigo_barra_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('PortoDestinos', [
            'className'=>'Procedencias',
            'foreignKey' => 'porto_destino_id',
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
            ->dateTime('data_hora_programada')
            ->allowEmptyDateTime('data_hora_programada');

        $validator
            ->dateTime('data_hora_chegada')
            ->allowEmptyDateTime('data_hora_chegada');

        $validator
            ->decimal('peso_maximo')
            ->allowEmptyString('peso_maximo');

        $validator
            ->decimal('peso_estimado_carga')
            ->allowEmptyString('peso_estimado_carga');

        $validator
            ->decimal('peso_pallets')
            ->allowEmptyString('peso_pallets');

        $validator
            ->scalar('observacao')
            ->allowEmptyString('observacao');

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
        $rules->add($rules->existsIn(['transportadora_id'], 'Transportadoras'));
        $rules->add($rules->existsIn(['pessoa_id'], 'Pessoas'));
        $rules->add($rules->existsIn(['modal_id'], 'Modais'));
        $rules->add($rules->existsIn(['portaria_id'], 'Portarias'));
        $rules->add($rules->existsIn(['embalagem_id'], 'Embalagens'));
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));

        return $rules;
    }

    public function beforeSave($event, $entity, $options) {

        if ($entity->isNew()) {
            $entity->usuario_id = $_SESSION['Auth']['User']['id'];
            RfbManager::doAction('rfb', 'credenciamento-veiculos', 'init', $entity, ['nome_model' => 'Integracoes', 'tipo' => 'Programacao']);
        }

        $oParamIntegracaoProg = ParametroGeral::getParameterByUniqueName('PARAM_INTEGRACAO_PROG_APROVADA');

        $aDataModified = array_flip($entity->getDirty());
        if ($oParamIntegracaoProg && isset($aDataModified['programacao_situacao_id'])
            && $entity->programacao_situacao_id == EntityUtil::getIdByParams('ProgramacaoSituacoes', 'descricao', 'Aprovado')) {
            $oResponse = HandlerIntegracao::do(@$oParamIntegracaoProg->id, [
                'oEntity' => $entity,
                'sTable' => 'Programacoes',
                'iStatus' => 1,
                'function' => 1
            ]);
    
            if ($oResponse->getStatus() != 200) {
                $entity->setErrors([
                    'programacao_situacao_id' => [$oResponse->getMessage()]
                ]);
                
                return false;
            }
        }

        $oOperacao = LgDbUtil::getByID('Operacoes', $entity->operacao_id);

        if (@$oOperacao->gera_servico_completo_aprovar) {
            $oResponse = HandlerIntegracao::do(@$oParamIntegracaoProg->id, [
                'oEntity' => $entity,
                'sTable' => 'Programacoes',
                'iStatus' => 2,
                'function' => 3
            ]);
    
            if ($oResponse->getStatus() != 200) {
                $entity->setErrors([
                    'programacao_situacao_id' => [$oResponse->getMessage()]
                ]);
                
                return false;
            }
        }
            
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $aColumnsDiff = $entity->extractOriginal($entity->getDirty());

        if (isset($aColumnsDiff['programacao_situacao_id']) && @$entity->programacao_situacao_id) {
            $oProgHistoricoSitu = LgDbUtil::get('ProgramacaoHistoricoSituacoes')->newEntity([
                'programacao_id' => $entity->id,
                'programacao_situacao_id' => $entity->programacao_situacao_id
            ]);

            LgDbUtil::save('ProgramacaoHistoricoSituacoes', $oProgHistoricoSitu);
        }

        RfbManager::doAction('rfb', 'acesso-veiculos', 'init', $entity, ['nome_model' => 'Integracoes', 'tipo' => 'Programacoes']);

        RfbManager::doAction('rfb', 'conferencia-fisica', 'init', $entity, ['nome_model' => 'Integracoes', 'tipo' => 'Programacao']);
    }

    public function afterDelete($event, $entity, $options)
    {
        RfbManager::doAction('rfb', 'credenciamento-veiculos', 'init', $entity, ['nome_model' => 'Integracoes', 'tipo' => 'Programacao', 'operacao' => 'delete']);

        RfbManager::doAction('rfb', 'conferencia-fisica', 'init', $entity, ['nome_model' => 'Integracoes', 'tipo' => 'Programacao', 'operacao' => 'delete']);
    }

}
