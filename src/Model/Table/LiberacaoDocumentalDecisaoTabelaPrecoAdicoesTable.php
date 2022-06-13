<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LiberacaoDocumentalDecisaoTabelaPrecoAdicoes Model
 *
 * @property &\Cake\ORM\Association\BelongsTo $LiberacaoDocumentalDecisaoTabelaPrecos
 * @property &\Cake\ORM\Association\BelongsTo $LiberacoesDocumentais
 * @property \App\Model\Table\RegimesAduaneirosTable&\Cake\ORM\Association\BelongsTo $RegimesAduaneiros
 * @property \App\Model\Table\IncotermsTable&\Cake\ORM\Association\BelongsTo $Incoterms
 * @property \App\Model\Table\MoedasTable&\Cake\ORM\Association\BelongsTo $Moedas
 * @property \App\Model\Table\NcmsTable&\Cake\ORM\Association\BelongsTo $Ncms
 *
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPrecoAdicao get($primaryKey, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPrecoAdicao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPrecoAdicao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPrecoAdicao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPrecoAdicao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPrecoAdicao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPrecoAdicao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPrecoAdicao findOrCreate($search, callable $callback = null, $options = [])
 */
class LiberacaoDocumentalDecisaoTabelaPrecoAdicoesTable extends Table
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
        

        $this->setTable('liberacao_documental_decisao_tabela_preco_adicoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('LiberacaoDocumentalDecisaoTabelaPrecos', [
            'foreignKey' => 'liberacao_documental_decisao_tabela_preco_id',
        ]);
        $this->belongsTo('LiberacoesDocumentais', [
            'foreignKey' => 'liberacao_documental_id',
        ]);
        $this->belongsTo('RegimesAduaneiros', [
            'foreignKey' => 'regime_aduaneiro_id',
        ]);
        $this->belongsTo('Incoterms', [
            'foreignKey' => 'incoterm_id',
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_id',
        ]);
        $this->belongsTo('Ncms', [
            'foreignKey' => 'ncm_id',
        ]);

        $this->belongsTo('TabelasPrecos', [
            'foreignKey' => 'tabela_preco_id',
        ]);

        $this->hasMany('FaturamentoAdicoes', [
            'foreignKey' => 'adicao_id',
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

        $validator
            ->scalar('numero')
            ->maxLength('numero', 255)
            ->requirePresence('numero', 'create')
            ->notEmptyString('numero');

        $validator
            ->decimal('vcmv')
            ->notEmptyString('vcmv');

        $validator
            ->decimal('peso_liquido')
            ->notEmptyString('peso_liquido');

        $validator
            ->integer('reimportacao')
            ->notEmptyString('reimportacao');

        $validator
            ->integer('insento')
            ->notEmptyString('insento');

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
        $rules->add($rules->existsIn(['liberacao_documental_decisao_tabela_preco_id'], 'LiberacaoDocumentalDecisaoTabelaPrecos'));
        $rules->add($rules->existsIn(['liberacao_documental_id'], 'LiberacoesDocumentais'));
        $rules->add($rules->existsIn(['regime_aduaneiro_id'], 'RegimesAduaneiros'));
        $rules->add($rules->existsIn(['incoterm_id'], 'Incoterms'));
        $rules->add($rules->existsIn(['moeda_id'], 'Moedas'));
        $rules->add($rules->existsIn(['ncm_id'], 'Ncms'));

        return $rules;
    }
}
