<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Phinx\Db\Table\ForeignKey;

/**
 * LiberacoesDocumentais Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\TipoDocumentosTable&\Cake\ORM\Association\BelongsTo $TipoDocumentos
 * @property \App\Model\Table\MoedasTable&\Cake\ORM\Association\BelongsTo $Moedas
 * @property \App\Model\Table\MoedasTable&\Cake\ORM\Association\BelongsTo $Moedas
 * @property \App\Model\Table\MoedasTable&\Cake\ORM\Association\BelongsTo $Moedas
 * @property \App\Model\Table\MoedasTable&\Cake\ORM\Association\BelongsTo $Moedas
 * @property \App\Model\Table\CanaisTable&\Cake\ORM\Association\BelongsTo $Canais
 * @property \App\Model\Table\RegimesAduaneirosTable&\Cake\ORM\Association\BelongsTo $RegimesAduaneiros
 * @property \App\Model\Table\AftnsTable&\Cake\ORM\Association\BelongsTo $Aftns
 * @property \App\Model\Table\TipoDocumentosTable&\Cake\ORM\Association\BelongsTo $TipoDocumentos
 * @property &\Cake\ORM\Association\BelongsToMany $Resvs
 *
 * @method \App\Model\Entity\LiberacoesDocumental get($primaryKey, $options = [])
 * @method \App\Model\Entity\LiberacoesDocumental newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LiberacoesDocumental[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LiberacoesDocumental|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacoesDocumental saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacoesDocumental patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacoesDocumental[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacoesDocumental findOrCreate($search, callable $callback = null, $options = [])
 */
class LiberacoesDocumentaisTable extends Table
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

        $this->setTable('liberacoes_documentais');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'cliente_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Clientes', [
            'className'  => 'Empresas',
            'foreignKey' => 'cliente_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TipoDocumentos', [
            'foreignKey' => 'tipo_documento_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_fob_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_frete_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_seguro_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_cif_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('MoedaCif', [
            'className'  => 'Moedas',
            'foreignKey' => 'moeda_cif_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Canais', [
            'foreignKey' => 'canal_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('RegimesAduaneiros', [
            'foreignKey' => 'regime_aduaneiro_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('RegimesAduaneirosLeft', [
            'propertyName' => 'regime_aduaneiro',
            'className' => 'RegimesAduaneiros',
            'foreignKey' => 'regime_aduaneiro_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Aftns', [
            'foreignKey' => 'aftn_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('TipoDocumentos', [
            'foreignKey' => 'tipo_documento_id'
        ]);
        $this->belongsTo('TipoDocumentosLiberacao', [
            'className'  => 'TipoDocumentos',
            'foreignKey' => 'tipo_documento_liberacao_id'
        ]);
        $this->belongsToMany('Resvs', [
            'foreignKey' => 'liberacao_documental_id',
            'targetForeignKey' => 'resv_id',
            'joinTable' => 'resvs_liberacoes_documentais'
        ]);        
        $this->belongsTo('LiberacoesDocumentaisItens', [
            'foreignKey' => 'id',
            'bindingKey' => 'liberacao_documental_id',
            'targetForeignKey' => 'liberacao_documental_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);

        $this->hasMany('LiberacoesDocumentaisItensHasMany', [
            'foreignKey' => 'liberacao_documental_id',
            'className' => 'LiberacoesDocumentaisItens',
            'propertyName' => 'liberacoes_documentais_itens',
        ]);  

        $this->belongsTo('LiberacoesDocumentaisItensLeft', [
            'foreignKey' => 'id',
            'bindingKey' => 'liberacao_documental_id',
            'targetForeignKey' => 'liberacao_documental_id',
            'joinType' => 'LEFT',
            'propertyName' => 'liberacoes_documentais_itens',
            'className' => 'LiberacoesDocumentaisItens',
        ]);

        $this->hasMany('RegimeAduaneiroTipoFaturamentos', [
            'foreignKey'       => 'regime_aduaneiro_id',
            'targetForeignKey' => 'regime_aduaneiro_id',
            'bindingKey'       => 'regime_aduaneiro_id'
        ]);

        $this->hasMany('LiberacoesDocumentaisItensLeftMany', [
            'foreignKey' => 'liberacao_documental_id',
            'joinType' => 'LEFT',
            'propertyName' => 'liberacoes_documentais_itens',
            'className' => 'LiberacoesDocumentaisItens',
        ]);

        $this->hasMany('LiberacoesDocumentaisItensInnerMany', [
            'foreignKey' => 'liberacao_documental_id',
            'joinType' => 'INNER',
            'propertyName' => 'liberacoes_documentais_itens',
            'className' => 'LiberacoesDocumentaisItens',
        ]);
        
        $this->hasMany('LiberacoesDocumentaisTransportadorasLeftMany', [
            'foreignKey' => 'liberacao_documental_id',
            'joinType' => 'LEFT',
            'propertyName' => 'liberacao_documental_transportadoras',
            'className' => 'LiberacaoDocumentalTransportadoras',
        ]);

        $this->hasOne('Faturamentos', [
            'foreignKey' => 'liberacao_documental_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('ResvsLiberacoesDocumentais', [
            'foreignKey'       => 'liberacao_documental_id',
            'targetForeignKey' => 'id',
            'bindingKey'       => 'id'
        ]);

        $this->belongsTo('CanaisLiberacao', [
            'className'=>'Canais',
            'foreignKey' => 'canal_id',
        ]);

        $this->belongsToMany('ResvsIndex', [
            'className'=> 'Resvs',
            'foreignKey' => 'liberacao_documental_id',
            'targetForeignKey' => 'resv_id',
            'through' => 'resvs_liberacoes_documentais'
        ]);  

        $this->hasMany('LiberacaoDocumentalItemDados', [
            'foreignKey' => 'liberacao_documental_id',
            'joinType'   => 'LEFT'
        ]); 

        $this->hasMany('LiberacaoDocumentalTributos', [
            'foreignKey' => 'liberacao_documental_id',
            'cascadeCallbacks' => true,
            'dependent' => true
        ]); 

        
        $this->belongsTo('Pessoas', [
            'foreignKey' => 'pessoa_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Veiculos', [
            'foreignKey' => 'veiculo_id',
            'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('LeftPessoas', [
            'className' => 'Pessoas',
            'propertyName'=>'pessoa',
            'foreignKey' => 'pessoa_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('RecintoAduaneiros', [
            'foreignKey' => 'recinto_aduaneiro_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('LiberacaoDocumentalSituacoes', [
            'foreignKey' => 'liberacao_documental_situacao_id',
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
            ->scalar('numero_documento_liberacao')
            ->maxLength('numero_documento_liberacao', 45)
            ->allowEmptyString('numero_documento_liberacao');

        $validator
            ->scalar('numero')
            ->maxLength('numero', 45)
            ->requirePresence('numero', 'create')
            ->notEmptyString('numero');

        $validator
            ->dateTime('data_registro')
            ->requirePresence('data_registro', 'create')
            ->notEmptyDateTime('data_registro');

        $validator
            ->dateTime('data_desembaraco')
            ->requirePresence('data_desembaraco', 'create')
            ->notEmptyDateTime('data_desembaraco');

        $validator
            ->integer('quantidade_adicoes')
            ->requirePresence('quantidade_adicoes', 'create')
            ->allowEmptyString('quantidade_adicoes');

        $validator
            ->requirePresence('valor_fob_moeda', 'create')
            ->notEmptyString('valor_fob_moeda');

        $validator
            ->requirePresence('valor_frete_moeda', 'create')
            ->notEmptyString('valor_frete_moeda');

        $validator
            ->requirePresence('valor_seguro_moeda', 'create')
            ->notEmptyString('valor_seguro_moeda');

        $validator
            ->requirePresence('valor_cif_moeda', 'create')
            ->notEmptyString('valor_cif_moeda');

        $validator
            ->allowEmptyString('quantidade_total');

        $validator
            ->requirePresence('peso_bruto', 'create')
            ->allowEmptyString('peso_bruto');

        $validator
            ->requirePresence('peso_liquido', 'create')
            ->allowEmptyString('peso_liquido');

        $validator
            ->scalar('observacao')
            ->maxLength('observacao', 4294967295)
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
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['cliente_id'], 'Empresas'));
        $rules->add($rules->existsIn(['tipo_documento_id'], 'TipoDocumentos'));
        $rules->add($rules->existsIn(['moeda_fob_id'], 'Moedas'));
        $rules->add($rules->existsIn(['moeda_frete_id'], 'Moedas'));
        $rules->add($rules->existsIn(['moeda_seguro_id'], 'Moedas'));
        $rules->add($rules->existsIn(['moeda_cif_id'], 'Moedas'));
        $rules->add($rules->existsIn(['canal_id'], 'Canais'));
        $rules->add($rules->existsIn(['regime_aduaneiro_id'], 'RegimesAduaneiros'));
        $rules->add($rules->existsIn(['aftn_id'], 'Aftns'));
        $rules->add($rules->existsIn(['tipo_documento_liberacao_id'], 'TipoDocumentos'));
        $rules->add($rules->existsIn(['veiculo_id'], 'Veiculos'));

        return $rules;
    }

    public function findRecord(Query $query, array $options = [])
    {
        die;
    }
}
