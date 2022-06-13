<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RfbProtocolos Model
 *
 * @method \App\Model\Entity\RfbProtocolo get($primaryKey, $options = [])
 * @method \App\Model\Entity\RfbProtocolo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RfbProtocolo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RfbProtocolo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RfbProtocolo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RfbProtocolo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RfbProtocolo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RfbProtocolo findOrCreate($search, callable $callback = null, $options = [])
 */
class RfbProtocolosTable extends Table
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
        

        $this->setTable('rfb_protocolos');
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
            ->scalar('endpoint_rfb')
            ->maxLength('endpoint_rfb', 45)
            ->allowEmptyString('endpoint_rfb');

        $validator
            ->scalar('trigger')
            ->maxLength('trigger', 45)
            ->allowEmptyString('trigger');

        $validator
            ->scalar('id_coluna')
            ->maxLength('id_coluna', 45)
            ->allowEmptyString('id_coluna');

        $validator
            ->scalar('protocolo_gerado')
            ->maxLength('protocolo_gerado', 45)
            ->allowEmptyString('protocolo_gerado');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('modified_at')
            ->allowEmptyDateTime('modified_at');

        return $validator;
    }
}
