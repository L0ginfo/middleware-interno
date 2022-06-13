<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LiberacaoDocumentalDecisaoTabelaPrecos Model
 *
 * @property \App\Model\Table\LiberacaoDocumentaisTable&\Cake\ORM\Association\BelongsTo $LiberacaoDocumentais
 * @property \App\Model\Table\TabelaPrecosTable&\Cake\ORM\Association\BelongsTo $TabelaPrecos
 *
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPreco get($primaryKey, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPreco newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPreco[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPreco|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPreco saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPreco patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPreco[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPreco findOrCreate($search, callable $callback = null, $options = [])
 */
class LiberacaoDocumentalDecisaoTabelaPrecosTable extends Table
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
        

        $this->setTable('liberacao_documental_decisao_tabela_precos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('LiberacoesDocumentais', [
            'foreignKey' => 'liberacao_documental_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('TabelasPrecos', [
            'foreignKey' => 'tabela_preco_id',
            'joinType' => 'INNER',
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
            ->scalar('tipo_vinculo')
            ->maxLength('tipo_vinculo', 255)
            ->notEmptyString('tipo_vinculo');

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

        return $rules;
    }
}
