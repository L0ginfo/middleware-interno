<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReportResponses Model
 *
 * @method \App\Model\Entity\ReportResponse get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReportResponse newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ReportResponse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReportResponse|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReportResponse saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReportResponse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReportResponse[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReportResponse findOrCreate($search, callable $callback = null, $options = [])
 */
class ReportResponsesTable extends Table
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
        

        $this->setTable('report_responses');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');
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
            ->scalar('tabela_referente')
            ->maxLength('tabela_referente', 255)
            ->allowEmptyString('tabela_referente');

        $validator
            ->integer('id_coluna')
            ->allowEmptyString('id_coluna');

        $validator
            ->scalar('response_util_obj')
            ->maxLength('response_util_obj', 4294967295)
            ->allowEmptyString('response_util_obj');

        $validator
            ->scalar('response_util_text')
            ->maxLength('response_util_text', 4294967295)
            ->allowEmptyString('response_util_text');

        $validator
            ->scalar('response_util_title')
            ->maxLength('response_util_title', 4294967295)
            ->allowEmptyString('response_util_title');

        $validator
            ->scalar('response_util_status')
            ->maxLength('response_util_status', 4294967295)
            ->allowEmptyString('response_util_status');

        $validator
            ->scalar('response_util_data_extra')
            ->maxLength('response_util_data_extra', 4294967295)
            ->allowEmptyString('response_util_data_extra');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        return $validator;
    }
}
