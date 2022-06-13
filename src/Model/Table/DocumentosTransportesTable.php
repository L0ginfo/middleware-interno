<?php
namespace App\Model\Table;

use App\Model\Entity\ParametroGeral;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentosTransportes Model
 *
 * @property \App\Model\Table\ModaisTable&\Cake\ORM\Association\BelongsTo $Modais
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\TipoDocumentosTable&\Cake\ORM\Association\BelongsTo $TipoDocumentos
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsToMany $Resvs
 *
 * @method \App\Model\Entity\DocumentosTransporte get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentosTransporte newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentosTransporte[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentosTransporte|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentosTransporte saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentosTransporte patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentosTransporte[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentosTransporte findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentosTransportesTable extends Table
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
        

        $this->setTable('documentos_transportes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Modais', [
            'foreignKey' => 'modal_id',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'cliente_id',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'despachante_id',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'agente_id',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'parceiro_id',
        ]);
        $this->belongsTo('TipoDocumentos', [
            'foreignKey' => 'tipo_documento_id',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Resvs', [
            'foreignKey' => 'documentos_transporte_id',
            'targetForeignKey' => 'resv_id',
            'joinTable' => 'resvs_documentos_transportes',
        ]);
        $this->belongsToMany('ResvsDocumentosTransportes', [
            'foreignKey' => 'documento_transporte_id'
        ]);   
        $this->hasMany('ResvsDocumentosTransportesLeft', [
            'foreignKey' => 'documento_transporte_id',
            'className' => 'ResvsDocumentosTransportes',
            'propertyName' => 'resvs_documentos_transportes',
            'joinType' => 'LEFT'
        ]);        
        $this->belongsTo('DocumentosMercadorias', [
            'bindingKey' => 'documento_transporte_id',
            'foreignKey' => 'id'
        ]);
        $this->hasMany('DocumentosMercadoriasMany', [
            'bindingKey' => 'id',
            'foreignKey' => 'documento_transporte_id',
            'className' => 'DocumentosMercadorias',
            'propertyName' => 'documentos_mercadorias'
        ]);

        $this->hasMany('ResvsDocumentosTransportesMany', [
            'className' =>'ResvsDocumentosTransportes',
            'foreignKey' => 'documento_transporte_id'
        ]);
        $this->hasMany('DocumentoTransporteLacres', [
            'foreignKey' => 'documento_transporte_id'
        ]);
        $this->hasMany('ContainerEntradas', [
            'joinType' => 'LEFT',
            'foreignKey' => 'documento_transporte_id'
        ]);       
        $this->hasMany('ItemContainers', [
            'joinType' => 'LEFT',
            'foreignKey' => 'documento_transporte_id'
        ]);
        $this->hasMany('ResvsContainers', [
            'joinType' => 'LEFT',
            'foreignKey' => 'documento_transporte_id'
        ]);      
        $this->hasMany('ProgramacaoDocumentoTransportes', [
            'foreignKey' => 'documento_transporte_id',
            'className' => 'ProgramacaoDocumentoTransportes',
            'propertyName' => 'programacao_documento_transportes',
            'joinType' => 'LEFT'
        ]);
        $this->belongsToMany('DocumentosMercadoriasLote', [
            'foreignKey' => 'documento_transporte_id',
            'targetForeignKey' => 'id',
            'joinTable' => 'documentos_mercadorias',
            'propertyName' => 'documentos_mercadoria',
            'className' => 'DocumentosMercadorias',
        ])
        ->setConditions([
            'DocumentosMercadoriasLote.documento_mercadoria_id_master is NOT NULL'
        ]);
        $this->belongsToMany('DocumentosMercadoriasMaster', [
            'foreignKey' => 'documento_transporte_id',
            'targetForeignKey' => 'id',
            'joinTable' => 'documentos_mercadorias',
            'propertyName' => 'documentos_mercadoria',
            'className' => 'DocumentosMercadorias',
        ])
        ->setConditions([
            'DocumentosMercadoriasMaster.documento_mercadoria_id_master is NULL'
        ]);
        $this->hasMany('FormacaoLotesConsolidado', [
            'joinType' => 'LEFT',
            'foreignKey' => 'documento_transporte_id',
            'targetForeignKey' => 'id',
            'joinTable' => 'formacao_lotes',
            'propertyName' => 'formacao_lotes',
            'className' => 'FormacaoLotes',
        ])->setConditions([
            'FormacaoLotesConsolidado.consolidado = 1'
        ]); 
        $this->belongsTo('PlanejamentoMaritimos', [
            'foreignKey' => 'planejamento_maritimo_id',
            'joinType' => 'LEFT',
        ]); 
        $this->belongsTo('DocumentoTransporteSituacoes', [
            'foreignKey' => 'documento_transporte_situacao_id',
            'joinType' => 'LEFT',
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

        $oParamPermiteDocSemNumero = ParametroGeral::getParametroWithValue('PARAM_PERMITE_DOCUMENTO_TRANSPORTE_SEM_NUMERO');
        if (!@$oParamPermiteDocSemNumero)
            $validator
                ->scalar('numero')
                ->maxLength('numero', 45)
                ->requirePresence('numero', 'create')
                ->notEmptyString('numero');

        $validator
            ->date('data_emissao')
            ->allowEmptyDate('data_emissao');

        $validator
            ->decimal('valor_total')
            ->allowEmptyString('valor_total');

        $validator
            ->decimal('quantidade')
            ->allowEmptyString('quantidade');

        $validator
            ->decimal('peso_bruto')
            ->allowEmptyString('peso_bruto');

        $validator
            ->decimal('peso_liquido')
            ->allowEmptyString('peso_liquido');

        $validator
            ->decimal('valor_frete')
            ->allowEmptyString('valor_frete');

        $validator
            ->decimal('valor_seguro')
            ->allowEmptyString('valor_seguro');

        $validator
            ->scalar('numero_voo')
            ->maxLength('numero_voo', 20)
            ->allowEmptyString('numero_voo');

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
        $rules->add($rules->existsIn(['cliente_id'], 'Empresas'));
        $rules->add($rules->existsIn(['despachante_id'], 'Empresas'));
        $rules->add($rules->existsIn(['agente_id'], 'Empresas'));
        $rules->add($rules->existsIn(['parceiro_id'], 'Empresas'));
        $rules->add($rules->existsIn(['tipo_documento_id'], 'TipoDocumentos'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));

        return $rules;
    }
}
