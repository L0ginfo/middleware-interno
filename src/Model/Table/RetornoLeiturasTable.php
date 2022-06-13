<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RetornoLeituras Model
 *
 * @property \App\Model\Table\FaturamentoBaixasTable&\Cake\ORM\Association\HasMany $FaturamentoBaixas
 *
 * @method \App\Model\Entity\RetornoLeitura get($primaryKey, $options = [])
 * @method \App\Model\Entity\RetornoLeitura newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RetornoLeitura[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RetornoLeitura|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RetornoLeitura saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RetornoLeitura patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RetornoLeitura[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RetornoLeitura findOrCreate($search, callable $callback = null, $options = [])
 */
class RetornoLeiturasTable extends Table
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

        $this->setTable('retorno_leituras');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('FaturamentoBaixas', [
            'foreignKey' => 'retorno_leitura_id',
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
            ->scalar('arquivo_nome')
            ->maxLength('arquivo_nome', 255)
            ->requirePresence('arquivo_nome', 'create')
            ->notEmptyString('arquivo_nome');

        $validator
            ->dateTime('data_leitura')
            ->requirePresence('data_leitura', 'create')
            ->notEmptyDateTime('data_leitura');

        $validator
            ->dateTime('data_processamento')
            ->allowEmptyDateTime('data_processamento');

        $validator
            ->dateTime('data_reprocessamento')
            ->allowEmptyDateTime('data_reprocessamento');

        $validator
            ->dateTime('data_conclusao')
            ->allowEmptyDateTime('data_conclusao');

        $validator
            ->scalar('dados')
            ->allowEmptyString('dados');

        $validator
            ->scalar('erros')
            ->allowEmptyString('erros');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->integer('tipo')
            ->requirePresence('tipo', 'create')
            ->notEmptyString('tipo');

        return $validator;
    }
}
