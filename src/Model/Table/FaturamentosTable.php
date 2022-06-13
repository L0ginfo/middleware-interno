<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Faturamentos Model
 *
 * @property \App\Model\Table\FormaPagamentosTable&\Cake\ORM\Association\BelongsTo $FormaPagamentos
 * @property \App\Model\Table\LiberacoesDocumentaisTable&\Cake\ORM\Association\BelongsTo $LiberacoesDocumentais
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsTo $TabelasPrecos
 * @property \App\Model\Table\RegimesAduaneirosTable&\Cake\ORM\Association\BelongsTo $RegimesAduaneiros
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\TiposFaturamentosTable&\Cake\ORM\Association\BelongsTo $TiposFaturamentos
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\FaturamentoArmazenagensTable&\Cake\ORM\Association\HasMany $FaturamentoArmazenagens
 * @property \App\Model\Table\FaturamentoBaixasTable&\Cake\ORM\Association\HasMany $FaturamentoBaixas
 * @property \App\Model\Table\FaturamentoServicosTable&\Cake\ORM\Association\HasMany $FaturamentoServicos
 *
 * @method \App\Model\Entity\Faturamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\Faturamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Faturamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Faturamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Faturamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Faturamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Faturamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Faturamento findOrCreate($search, callable $callback = null, $options = [])
 */
class FaturamentosTable extends Table
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

        $this->setTable('faturamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('FormaPagamentos', [
            'foreignKey' => 'forma_pagamento_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('LiberacoesDocumentais', [
            'foreignKey' => 'liberacao_documental_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('TabelasPrecos', [
            'foreignKey' => 'tabela_preco_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('RegimesAduaneiros', [
            'foreignKey' => 'regime_aduaneiro_id',
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
        $this->belongsTo('TiposFaturamentos', [
            'foreignKey' => 'tipo_faturamento_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TipoServicoBancarios', [
            'foreignKey' => 'tipo_servico_bancario_id',
            'joinType' => 'INNER'
        ]);        
        $this->hasMany('FaturamentoArmazenagens', [
            'foreignKey' => 'faturamento_id'
        ]);
        $this->hasMany('FaturamentoBaixas', [
            'foreignKey' => 'faturamento_id'
        ]);
        $this->hasMany('FaturamentoServicos', [
            'foreignKey' => 'faturamento_id'
        ]);
        $this->hasMany('FaturamentoAdicoes', [
            'foreignKey' => 'faturamento_id'
        ]);
        $this->belongsTo('FormaPagamentosDocumento', [
            'className'=>'FormaPagamentos',
            'foreignKey' => 'forma_pagamento_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('RegimesAduaneirosDocumento', [
            'className'=>'RegimesAduaneiros',
            'foreignKey' => 'regime_aduaneiro_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('ClientesDocumento', [
            'className'=>'Empresas',
            'foreignKey' => 'cliente_id',
            'joinType' => 'LEFT'
        ]);
       
        $this->belongsTo('IndexRegimesAduaneiros', [
            'className' => 'RegimesAduaneiros',
            'propertyName' => 'regimes_aduaneiro',
            'foreignKey' => 'regime_aduaneiro_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('LeftLiberacoesDocumentais', [
            'className' => 'LiberacoesDocumentais',
            'propertyName' => 'liberacoes_documental',
            'foreignKey' => 'liberacao_documental_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('TiposFaturamentosDocumento', [
            'className'=>'TiposFaturamentos',
            'foreignKey' => 'tipo_faturamento_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('ManyLiberacoesDocumentais', [
            'className' => 'LiberacoesDocumentais',
            'propertyName' => 'liberacoes_documentais',
            'bindingKey' => 'liberacao_documental_id',
            'foreignKey' => 'id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('LeftRegimesAduaneiros', [
            'className'=>'RegimesAduaneiros',
            'foreignKey' => 'regime_aduaneiro_id',
            'propertyName' => 'regimes_aduaneiro',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('CapaDaiFaturamentos', [
            'className'=> 'Faturamentos',
            'foreignKey' => [
                'count_dai_primario',
            ],
            'bindingKey' => [
                'count_dai_primario',
            ],
            'conditions' => [
                'CapaDaiFaturamentos.count_dai_secundario' => '000',
                'Faturamentos.count_dai_secundario <>'     => '000'
            ]
        ]);

        $this->belongsTo('LeftTabelasPrecos', [
            'className'=> 'TabelasPrecos',
            'propertyName' => 'tabelas_preco',
            'foreignKey' => 'tabela_preco_id',
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
            ->scalar('numero_faturamento')
            ->maxLength('numero_faturamento', 45)
            ->requirePresence('numero_faturamento', 'create')
            ->notEmptyString('numero_faturamento');

        $validator
            ->dateTime('data_hora_emissao')
            ->requirePresence('data_hora_emissao', 'create')
            ->notEmptyDateTime('data_hora_emissao');

        $validator
            ->decimal('valor_armazenagem')
            ->requirePresence('valor_armazenagem', 'create')
            ->notEmptyString('valor_armazenagem');

        $validator
            ->decimal('valor_servicos')
            ->requirePresence('valor_servicos', 'create')
            ->notEmptyString('valor_servicos');

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
        $rules->add($rules->existsIn(['forma_pagamento_id'], 'FormaPagamentos'));
        $rules->add($rules->existsIn(['tipo_servico_bancario_id'], 'TipoServicoBancarios'));
        $rules->add($rules->existsIn(['liberacao_documental_id'], 'LiberacoesDocumentais'));
        $rules->add($rules->existsIn(['tabela_preco_id'], 'TabelasPrecos'));
        $rules->add($rules->existsIn(['regime_aduaneiro_id'], 'RegimesAduaneiros'));
        $rules->add($rules->existsIn(['cliente_id'], 'Empresas'));
        $rules->add($rules->existsIn(['tipo_faturamento_id'], 'TiposFaturamentos'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));

        return $rules;
    }
}
