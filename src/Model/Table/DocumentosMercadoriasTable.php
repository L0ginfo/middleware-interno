<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentosMercadorias Model
 *
 * @property \App\Model\Table\ModaisTable&\Cake\ORM\Association\BelongsTo $Modais
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\RegimesAduaneirosTable&\Cake\ORM\Association\BelongsTo $RegimesAduaneiros
 * @property \App\Model\Table\MoedasTable&\Cake\ORM\Association\BelongsTo $Moedas
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\BelongsTo $DocumentosTransportes
 * @property \App\Model\Table\PaisTable&\Cake\ORM\Association\BelongsTo $Pais
 * @property \App\Model\Table\MoedasTable&\Cake\ORM\Association\BelongsTo $Moedas
 * @property \App\Model\Table\MoedasTable&\Cake\ORM\Association\BelongsTo $Moedas
 * @property \App\Model\Table\NaturezasCargasTable&\Cake\ORM\Association\BelongsTo $NaturezasCargas
 * @property \App\Model\Table\TratamentosCargasTable&\Cake\ORM\Association\BelongsTo $TratamentosCargas
 * @property &\Cake\ORM\Association\BelongsTo $TipoDocumentos
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property &\Cake\ORM\Association\HasMany $DocumentosMercadoriasItens
 *
 * @method \App\Model\Entity\DocumentosMercadoria get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentosMercadoria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentosMercadoria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentosMercadoria|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentosMercadoria saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentosMercadoria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentosMercadoria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentosMercadoria findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentosMercadoriasTable extends Table
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

        $this->setTable('documentos_mercadorias');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Modais', [
            'foreignKey' => 'modal_id'
        ]);
        $this->belongsTo('Clientes', [
            'className'=>'Empresas',
            'foreignKey' => 'cliente_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Despachantes', [
            'className'=>'Empresas',
            'foreignKey' => 'despachante_id'
        ]);
        $this->belongsTo('Agentes', [
            'className'=>'Empresas',
            'foreignKey' => 'agente_id'
        ]);
        $this->belongsTo('TipoMercadorias', [
            'foreignKey' => 'tipo_mercadoria_id'
        ]);
        $this->belongsTo('Procedencias', [
            'foreignKey' => 'procedencia_origem_id'
        ]);
        $this->belongsTo('ProcedenciasOrigens', [
            'className'  => 'Procedencias',
            'foreignKey' => 'procedencia_origem_id'
        ]);
        $this->belongsTo('ProcedenciasDestinos', [
            'className'  => 'Procedencias',
            'foreignKey' => 'procedencia_destino_id'
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'parceiro_id'
        ]);
        $this->belongsTo('RegimesAduaneiros', [
            'foreignKey' => 'regimes_aduaneiro_id'
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_id'
        ]);
        $this->belongsTo('DocumentosTransportes', [
            'foreignKey' => 'documento_transporte_id'
        ]);
        $this->belongsTo('Paises', [
            'foreignKey' => 'pais_origem_id'
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_frete_id'
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_seguro_id'
        ]);
        $this->belongsTo('NaturezasCargas', [
            'foreignKey' => 'natureza_carga_id'
        ]);
        $this->belongsTo('TratamentosCargas', [
            'foreignKey' => 'tratamento_carga_id'
        ]);
        $this->belongsTo('TipoDocumentos', [
            'foreignKey' => 'tipo_documento_id'
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('DocumentosMercadoriasItens', [
            'foreignKey' => 'documentos_mercadoria_id'
        ]);
        $this->hasMany('OrdemServicos', [
            'joinType' => 'INNER',
            'targetKey' => 'documentos_mercadoria_id',
            'bindingKey' => 'documentos_mercadoria_id',
            'foreignKey' => 'documentos_mercadoria_id'
        ]);
        $this->belongsTo('DocumentosMercadoriasHouse', [
            'className' => 'DocumentosMercadorias',
            'foreignKey' => 'documento_mercadoria_id_master',
            'propertyName' => 'DocumentosMercadorias'
        ]);
        $this->belongsTo('DocumentosMercadoriasHouses', [
            'className' => 'DocumentosMercadorias',
            'foreignKey' => 'id',
            'bindingKey' => 'documento_mercadoria_id_master',
            'targetKey' => 'id',
            'propertyName' => 'DocumentosMercadorias'
        ]);

        $this->belongsTo('DocumentosMercadoriasMasterFilter', [
            'className' => 'DocumentosMercadorias',
            'foreignKey' => 'documento_mercadoria_id_master',
            'propertyName' => 'DocumentosMercadorias'
        ]);

        $this->belongsTo('DocumentosMercadoriasMastersFilter', [
            'className' => 'DocumentosMercadorias',
            'foreignKey' => 'documento_mercadoria_id_master',
            'propertyName' => 'DocumentosMercadoriasMasters'
        ]);

        $this->hasMany('Estoques', [
            'className' => 'Estoques',
            'foreignKey' => 'lote_codigo',
            'bindingKey' => 'lote_codigo',
        ]);

        $this->hasMany('EstoqueEnderecos', [
            'className' => 'EstoqueEnderecos',
            'foreignKey' => 'lote_codigo',
            'bindingKey' => 'lote_codigo',
        ]);
              
        $this->hasMany('OrdemServicoItemManyLeft', [
            'className' => 'OrdemServicoItens',
            'foreignKey' => 'lote_codigo',
            'bindingKey' => 'lote_codigo',
            'targetForeignKey' => 'lote_codigo',
            'propertyName' => 'ordem_servico_itens',
            'joinType' => 'LEFT',
        ]);  

        $this->hasMany('OrdemServicoCarregamentoManyLeft', [
            'className' => 'OrdemServicoCarregamentos',
            'foreignKey' => 'lote_codigo',
            'bindingKey' => 'lote_codigo',
            'propertyName' => 'ordem_servico_carregamentos',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('OrdemServicoDocumentoRegimeEspecialItens', [
            'foreignKey' => 'lote_codigo',
            'bindingKey' => 'lote_codigo',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('OrdemServicos', [
            'foreignKey' => 'documentos_mercadoria_id',
            'bindingKey' => 'id',
        ]);

        $this->belongsTo('DocumentosMercadoriasAWB', [
            'className' => 'DocumentosMercadorias',
            'foreignKey' => 'documento_mercadoria_id_master',
            'propertyName' => 'DocumentosMercadorias'
        ]);

        $this->hasMany('DocumentosMercadoriasHAWB', [
            'className' => 'DocumentosMercadorias',
            'foreignKey' => 'documento_mercadoria_id_master',
            'propertyName' => 'DocumentosMercadorias'
        ]);

        $this->hasMany('PlanoCargaDocumentos', [
            'foreignKey' => 'documento_mercadoria_id',
            'bindingKey' => 'id',
        ]);

        $this->belongsTo('MoedaFretes', [
            'className' => 'Moedas',
            'foreignKey' => 'moeda_frete_id'
        ]);

        $this->belongsTo('MoedaSeguros', [
            'className' => 'Moedas',
            'foreignKey' => 'moeda_seguro_id'
        ]);

        $this->belongsTo('Beneficiarios', [
            'className'=>'Empresas',
            'foreignKey' => 'beneficiario_id'
        ]);

        $this->belongsToMany('PlanoCargas', [
            'className'=> 'PlanoCargas',
            'foreignKey' => 'documento_mercadoria_id',
            'targetForeignKey' => 'plano_carga_id',
            'through' => 'PlanoCargaDocumentos'
        ]);

        $this->belongsTo('Ncms', [
            'foreignKey' => 'ncm_id'
        ]);

        $this->hasMany('LiberacoesDocumentaisItensLotes', [
            'className'=>'LiberacoesDocumentaisItens',
            'foreignKey' => 'lote_codigo',
            'bindingKey' => 'lote_codigo',
            'joinType' => 'LEFT'
        ])
        ->setConditions([
            'LiberacoesDocumentaisItensLotes.lote_codigo is NOT NULL',
            'LiberacoesDocumentaisItensLotes.lote_codigo <>' => ''
        ]);

        $this->belongsTo('Mapas', [
            'className' => 'Mapas',
            'foreignKey' => 'documento_transporte_id',
            'bindingKey' => 'documento_transporte_id',
            'targetKey' => 'documento_transporte_id',
            'propertyName' => 'mapa',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('MapasINNER', [
            'className' => 'Mapas',
            'foreignKey' => 'id',
            'bindingKey' => 'documento_mercadoria_id',
            'targetKey' => 'id',
            'propertyName' => 'mapa',
            'joinType' => 'INNER'
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
            ->scalar('numero_documento')
            ->maxLength('numero_documento', 45)
            ->allowEmptyString('numero_documento');

        $validator
            ->date('data_emissao')
            ->allowEmptyDate('data_emissao');

        $validator
            ->scalar('lote_codigo')
            ->maxLength('lote_codigo', 16)
            ->allowEmptyString('lote_codigo');

        $validator
            ->decimal('valor_cif_moeda')
            ->allowEmptyString('valor_cif_moeda');

        $validator
            ->decimal('valor_cif_real')
            ->allowEmptyString('valor_cif_real');

        $validator
            ->decimal('peso_liquido')
            ->allowEmptyString('peso_liquido');

        $validator
            ->decimal('peso_bruto')
            ->allowEmptyString('peso_bruto');

        $validator
            ->date('data_vencimento_regime')
            ->allowEmptyDate('data_vencimento_regime');

        $validator
            ->decimal('valor_frete_moeda')
            ->allowEmptyString('valor_frete_moeda');

        $validator
            ->decimal('valor_seguro_moeda')
            ->allowEmptyString('valor_seguro_moeda');

        $validator
            ->decimal('m3')
            ->allowEmptyString('m3');

        $validator
            ->scalar('numero_voo')
            ->maxLength('numero_voo', 20)
            ->allowEmptyString('numero_voo');

        $validator
            ->decimal('volume')
            ->allowEmptyString('volume');

        $validator
            ->integer('documento_mercadoria_id_master')
            ->allowEmptyString('documento_mercadoria_id_master');

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
        $rules->add($rules->existsIn(['regimes_aduaneiro_id'], 'RegimesAduaneiros'));
        $rules->add($rules->existsIn(['moeda_id'], 'Moedas'));
        $rules->add($rules->existsIn(['documento_transporte_id'], 'DocumentosTransportes'));
        $rules->add($rules->existsIn(['pais_origem_id'], 'Paises'));
        $rules->add($rules->existsIn(['moeda_frete_id'], 'Moedas'));
        $rules->add($rules->existsIn(['moeda_seguro_id'], 'Moedas'));
        $rules->add($rules->existsIn(['natureza_carga_id'], 'NaturezasCargas'));
        $rules->add($rules->existsIn(['tratamento_carga_id'], 'TratamentosCargas'));
        $rules->add($rules->existsIn(['tipo_documento_id'], 'TipoDocumentos'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        return $rules;
    }

    public function beforeSave($event, $oDocumentoMercadoria, $options)
    {
        //Se for o master, salva um lote zerado para nao gerar um lote em cima dele
        if (!$oDocumentoMercadoria->documento_mercadoria_id_master && !$oDocumentoMercadoria->lote_codigo) 
            $oDocumentoMercadoria->lote_codigo = str_pad('', 15, '0', STR_PAD_LEFT);
    }
}
