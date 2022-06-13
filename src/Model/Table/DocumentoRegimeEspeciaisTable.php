<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentoRegimeEspeciais Model
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
 * @property \App\Model\Table\PessoasTable&\Cake\ORM\Association\BelongsTo $Pessoas
 *
 * @method \App\Model\Entity\DocumentoRegimeEspecial get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecial newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecial[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecial|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecial saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecial patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecial[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecial findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentoRegimeEspeciaisTable extends Table
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
        

        $this->setTable('documento_regime_especiais');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Clientes', [
            'className' => 'Empresas',
            'foreignKey' => 'cliente_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('TipoDocumentos', [
            'foreignKey' => 'tipo_documento_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_fob_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_frete_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_seguro_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_cif_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Canais', [
            'foreignKey' => 'canal_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('RegimesAduaneiros', [
            'foreignKey' => 'regime_aduaneiro_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Aftns', [
            'foreignKey' => 'aftn_id',
        ]);
        $this->belongsTo('TipoDocumentos', [
            'foreignKey' => 'tipo_documento_especial_id',
        ]);
        $this->belongsTo('Pessoas', [
            'foreignKey' => 'pessoa_id',
        ]);

        $this->hasMany('DocumentoRegimeEspecialAdicoes', [
            'foreignKey' => 'documento_regime_especial_id'
        ]);
        $this->hasMany('DocumentoRegimeEspecialAdicaoItens', [
            'foreignKey' => 'documento_regime_especial_id'
        ]);
        $this->hasMany('DocumentoRegimeEspecialAdicaoTributos',[
            'foreignKey' => 'documento_regime_especial_id'
        ]);
        $this->hasMany('DocumentoRegimeEspecialDocumentoMercadorias',[
            'foreignKey' => 'documento_regime_especial_id'
        ]);

        $this->belongsToMany('DocumentosMercadorias', [
            'className'=> 'DocumentosMercadorias',
            'targetForeignKey' => 'documento_mercadoria_id',
            'foreignKey' => 'documento_regime_especial_id',
            'through' => 'DocumentoRegimeEspecialDocumentoMercadorias'
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
            ->scalar('numero_documento_especial')
            ->maxLength('numero_documento_especial', 45)
            ->allowEmptyString('numero_documento_especial');

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
            ->allowEmptyDateTime('data_desembaraco');

        $validator
            ->integer('quantidade_adicoes')
            ->allowEmptyString('quantidade_adicoes');

        $validator
            ->decimal('valor_fob_moeda')
            ->requirePresence('valor_fob_moeda', 'create')
            ->notEmptyString('valor_fob_moeda');

        $validator
            ->decimal('valor_frete_moeda')
            ->requirePresence('valor_frete_moeda', 'create')
            ->notEmptyString('valor_frete_moeda');

        $validator
            ->decimal('valor_seguro_moeda')
            ->requirePresence('valor_seguro_moeda', 'create')
            ->notEmptyString('valor_seguro_moeda');

        $validator
            ->decimal('valor_cif_moeda')
            ->requirePresence('valor_cif_moeda', 'create')
            ->notEmptyString('valor_cif_moeda');

        $validator
            ->decimal('quantidade_total')
            ->allowEmptyString('quantidade_total');

        $validator
            ->decimal('peso_bruto')
            ->allowEmptyString('peso_bruto');

        $validator
            ->decimal('peso_liquido')
            ->allowEmptyString('peso_liquido');

        $validator
            ->scalar('observacao')
            ->maxLength('observacao', 4294967295)
            ->allowEmptyString('observacao');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        $validator
            ->integer('libera_por_transportadora')
            ->notEmptyString('libera_por_transportadora');

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
        $rules->add($rules->existsIn(['tipo_documento_especial_id'], 'TipoDocumentos'));
        $rules->add($rules->existsIn(['pessoa_id'], 'Pessoas'));

        return $rules;
    }
}
