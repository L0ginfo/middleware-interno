<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentoTransporteSituacoes Model
 *
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\HasMany $DocumentosTransportes
 *
 * @method \App\Model\Entity\DocumentoTransporteSituacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentoTransporteSituacao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentoTransporteSituacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoTransporteSituacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoTransporteSituacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoTransporteSituacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoTransporteSituacao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoTransporteSituacao findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentoTransporteSituacoesTable extends Table
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
        

        $this->setTable('documento_transporte_situacoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('DocumentosTransportes', [
            'foreignKey' => 'documento_transporte_situacao_id',
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
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
