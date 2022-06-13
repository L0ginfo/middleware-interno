<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ImportacaoEstoques Model
 *
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 *
 * @method \App\Model\Entity\ImportacaoEstoque get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImportacaoEstoque newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ImportacaoEstoque[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImportacaoEstoque|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportacaoEstoque saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportacaoEstoque patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImportacaoEstoque[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImportacaoEstoque findOrCreate($search, callable $callback = null, $options = [])
 */
class ImportacaoEstoquesTable extends Table
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
        

        $this->setTable('importacao_estoques');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
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
            ->scalar('conhecimento')
            ->maxLength('conhecimento', 255)
            ->allowEmptyString('conhecimento');

        $validator
            ->scalar('navio_viagem')
            ->maxLength('navio_viagem', 255)
            ->allowEmptyString('navio_viagem');

        $validator
            ->scalar('produto_descricao')
            ->maxLength('produto_descricao', 255)
            ->allowEmptyString('produto_descricao');

        $validator
            ->scalar('produto_codigo')
            ->maxLength('produto_codigo', 255)
            ->allowEmptyString('produto_codigo');

        $validator
            ->scalar('empresa_descricao')
            ->maxLength('empresa_descricao', 255)
            ->allowEmptyString('empresa_descricao');

        $validator
            ->scalar('empresa_codigo')
            ->maxLength('empresa_codigo', 255)
            ->allowEmptyString('empresa_codigo');

        $validator
            ->scalar('empresa_cnpj')
            ->maxLength('empresa_cnpj', 255)
            ->allowEmptyString('empresa_cnpj');

        $validator
            ->scalar('data_entrada')
            ->maxLength('data_entrada', 255)
            ->allowEmptyString('data_entrada');

        $validator
            ->decimal('qtde_saldo')
            ->allowEmptyString('qtde_saldo');

        $validator
            ->decimal('saldo_coberto')
            ->allowEmptyString('saldo_coberto');

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
        $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));

        return $rules;
    }
}
