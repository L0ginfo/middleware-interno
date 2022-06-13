<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentoRegimeEspecialAdicoes Model
 *
 * @property \App\Model\Table\DocumentoRegimeEspeciaisTable&\Cake\ORM\Association\BelongsTo $DocumentoRegimeEspeciais
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property &\Cake\ORM\Association\BelongsTo $Incoterms
 * @property &\Cake\ORM\Association\BelongsTo $Ncms
 * @property &\Cake\ORM\Association\BelongsTo $Ncms
 * @property &\Cake\ORM\Association\BelongsTo $Moedas
 * @property &\Cake\ORM\Association\BelongsTo $RegimeTributacoes
 * @property &\Cake\ORM\Association\BelongsTo $RegimeTributacoes
 * @property &\Cake\ORM\Association\BelongsTo $RegimeTributacoes
 * @property \App\Model\Table\DocumentoRegimeEspecialAdicaoItensTable&\Cake\ORM\Association\HasMany $DocumentoRegimeEspecialAdicaoItens
 *
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicao get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicao findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentoRegimeEspecialAdicoesTable extends Table
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
        

        $this->setTable('documento_regime_especial_adicoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('DocumentoRegimeEspeciais', [
            'foreignKey' => 'documento_regime_especial_id',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Exportador', [
            'className' => 'Empresas',
            'foreignKey' => 'exportador_id',
        ]);
        $this->belongsTo('Paises', [
            'foreignKey' => 'pais_id',
        ]);
        $this->belongsTo('Incoterms', [
            'foreignKey' => 'incoterm_id',
        ]);
        $this->belongsTo('Ncms', [
            'foreignKey' => 'ncm_id',
        ]);
        $this->belongsTo('Nbms', [
            'className' => 'Ncms',
            'foreignKey' => 'nbm_id',
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_id',
        ]);
        $this->belongsTo('ImportacaoRegimeTributacoes', [
            'className' => 'RegimeTributacoes',
            'foreignKey' => 'importacao_regime_tributacao_id',
        ]);
        $this->belongsTo('ProdutoRegimeTributacoes', [
            'className' => 'RegimeTributacoes',
            'foreignKey' => 'produto_regime_tributacao_id',
        ]);
        $this->belongsTo('PisCofinsRegimeTributacoes', [
            'className' => 'RegimeTributacoes',
            'foreignKey' => 'pis_cofins_regime_tributacao_id',
        ]);
        $this->hasMany('DocumentoRegimeEspecialAdicaoItens', [
            'foreignKey' => 'documento_regime_especial_adicao_id',
        ]);

        $this->hasOne('OrdemServicoDocumentoRegimeEspeciais', [
            'foreignKey' => 'documento_regime_especial_id',
            'bindingKey' => 'documento_regime_especial_id'        
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
            ->numeric('peso_liquido')
            ->notEmptyString('peso_liquido');

        $validator
            ->numeric('vcmv')
            ->notEmptyString('vcmv');

        $validator
            ->numeric('importacao_aliquota')
            ->notEmptyString('importacao_aliquota');

        $validator
            ->numeric('importacao_recolher')
            ->notEmptyString('importacao_recolher');

        $validator
            ->numeric('produto_aliquota')
            ->notEmptyString('produto_aliquota');

        $validator
            ->numeric('produto_recolher')
            ->notEmptyString('produto_recolher');

        $validator
            ->numeric('pis_cofins_percentual')
            ->notEmptyString('pis_cofins_percentual');

        $validator
            ->numeric('base_calculo')
            ->notEmptyString('base_calculo');

        $validator
            ->numeric('pis_pasep_aloquita')
            ->notEmptyString('pis_pasep_aloquita');

        $validator
            ->numeric('pis_pasep_devido')
            ->notEmptyString('pis_pasep_devido');

        $validator
            ->numeric('pis_pasep_recolher')
            ->notEmptyString('pis_pasep_recolher');

        $validator
            ->numeric('cofins_aloquita')
            ->notEmptyString('cofins_aloquita');

        $validator
            ->numeric('cofins_devido')
            ->notEmptyString('cofins_devido');

        $validator
            ->numeric('cofins_recolher')
            ->notEmptyString('cofins_recolher');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

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
        $rules->add($rules->existsIn(['documento_regime_especial_id'], 'DocumentoRegimeEspeciais'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['exportador_id'], 'Empresas'));
        $rules->add($rules->existsIn(['incoterm_id'], 'Incoterms'));
        $rules->add($rules->existsIn(['ncm_id'], 'Ncms'));
        $rules->add($rules->existsIn(['nbm_id'], 'Ncms'));
        $rules->add($rules->existsIn(['moeda_id'], 'Moedas'));
        $rules->add($rules->existsIn(['importacao_regime_tributacao_id'], 'ImportacaoRegimeTributacoes'));
        $rules->add($rules->existsIn(['produto_regime_tributacao_id'], 'ProdutoRegimeTributacoes'));
        $rules->add($rules->existsIn(['pis_cofins_regime_tributacao_id'], 'PisCofinsRegimeTributacoes'));

        return $rules;
    }
}
