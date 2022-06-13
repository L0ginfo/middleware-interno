<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IntegracaoFiscais Model
 *
 * @property \App\Model\Table\LiberacaoDocumentaisTable&\Cake\ORM\Association\BelongsTo $LiberacaoDocumentais
 * @property \App\Model\Table\LiberacaoDocumentalItensTable&\Cake\ORM\Association\BelongsTo $LiberacaoDocumentalItens
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 *
 * @method \App\Model\Entity\IntegracaoFiscal get($primaryKey, $options = [])
 * @method \App\Model\Entity\IntegracaoFiscal newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IntegracaoFiscal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IntegracaoFiscal|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IntegracaoFiscal saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IntegracaoFiscal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IntegracaoFiscal[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IntegracaoFiscal findOrCreate($search, callable $callback = null, $options = [])
 */
class IntegracaoFiscaisTable extends Table
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
        
        // $this->addBehavior('LogsTabelas');
        

        $this->setTable('integracao_fiscais');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('LiberacaoDocumentais', [
            'foreignKey' => 'liberacao_documental_id',
        ]);
        $this->belongsTo('LiberacaoDocumentalItens', [
            'foreignKey' => 'liberacao_documental_item_id',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
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
            ->maxLength('numero_documento', 255)
            ->allowEmptyString('numero_documento');

        $validator
            ->scalar('cnpj_cliente')
            ->maxLength('cnpj_cliente', 255)
            ->allowEmptyString('cnpj_cliente');

        $validator
            ->scalar('produto_codigo')
            ->maxLength('produto_codigo', 255)
            ->allowEmptyString('produto_codigo');

        $validator
            ->decimal('saldo')
            ->allowEmptyString('saldo');

        $validator
            ->decimal('entrada')
            ->allowEmptyString('entrada');

        $validator
            ->decimal('saida')
            ->allowEmptyString('saida');

        $validator
            ->date('date_created')
            ->allowEmptyDate('date_created');

        $validator
            ->time('hour_created')
            ->allowEmptyTime('hour_created');

        $validator
            ->date('date_updated')
            ->allowEmptyDate('date_updated');

        $validator
            ->time('hour_updated')
            ->allowEmptyTime('hour_updated');

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
        // $rules->add($rules->existsIn(['liberacao_documental_id'], 'LiberacaoDocumentais'));
        // $rules->add($rules->existsIn(['liberacao_documental_item_id'], 'LiberacaoDocumentalItens'));
        // $rules->add($rules->existsIn(['produto_id'], 'Produtos'));

        return $rules;
    }
}
