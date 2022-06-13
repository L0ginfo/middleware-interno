<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentoRegimeEspecialAdicaoItens Model
 *
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\DocumentoRegimeEspeciaisTable&\Cake\ORM\Association\BelongsTo $DocumentoRegimeEspeciais
 * @property \App\Model\Table\DocumentoRegimeEspecialAdicoesTable&\Cake\ORM\Association\BelongsTo $DocumentoRegimeEspecialAdicoes
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\MoedasTable&\Cake\ORM\Association\BelongsTo $Moedas
 *
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicaoItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicaoItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicaoItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicaoItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicaoItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicaoItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicaoItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialAdicaoItem findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentoRegimeEspecialAdicaoItensTable extends Table
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
        

        $this->setTable('documento_regime_especial_adicao_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
        ]);
        $this->belongsTo('DocumentoRegimeEspeciais', [
            'foreignKey' => 'documento_regime_especial_id',
        ]);
        $this->belongsTo('DocumentoRegimeEspecialAdicoes', [
            'foreignKey' => 'documento_regime_especial_adicao_id',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('OrdemServicoDocumentoRegimeEspecialItens', [
            'foreignKey' => 'documento_regime_especial_adicao_item_id',
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
            ->numeric('quantidade')
            ->notEmptyString('quantidade');

        $validator
            ->numeric('vuvc')
            ->notEmptyString('vuvc');

        $validator
            ->scalar('descricao_completa')
            ->maxLength('descricao_completa', 4294967295)
            ->requirePresence('descricao_completa', 'create')
            ->notEmptyString('descricao_completa');

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
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['documento_regime_especial_id'], 'DocumentoRegimeEspeciais'));
        $rules->add($rules->existsIn(['documento_regime_especial_adicao_id'], 'DocumentoRegimeEspecialAdicoes'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['moeda_id'], 'Moedas'));

        return $rules;
    }
}
