<?php
namespace App\Model\Table;

use App\RegraNegocio\Rfb\RfbManager;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResvsDocumentosTransportes Model
 *
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\BelongsTo $DocumentosTransportes
 *
 * @method \App\Model\Entity\ResvsDocumentosTransporte get($primaryKey, $options = [])
 * @method \App\Model\Entity\ResvsDocumentosTransporte newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ResvsDocumentosTransporte[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResvsDocumentosTransporte|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvsDocumentosTransporte saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvsDocumentosTransporte patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ResvsDocumentosTransporte[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResvsDocumentosTransporte findOrCreate($search, callable $callback = null, $options = [])
 */
class ResvsDocumentosTransportesTable extends Table
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

        $this->setTable('resvs_documentos_transportes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'resv_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DocumentosTransportes', [
            'foreignKey' => 'documento_transporte_id',
            'joinType' => 'INNER'
        ]); 
        
        
        $this->hasMany('DocumentosMercadorias', [
            'foreignKey' => 'documento_transporte_id',
            'bindingKey' => 'documento_transporte_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));
        $rules->add($rules->existsIn(['documento_transporte_id'], 'DocumentosTransportes'));

        return $rules;
    }

    public function afterSave($event, $entity, $options)
    {
        RfbManager::doAction('rfb', 'acesso-veiculos', 'init', $entity, ['nome_model' => 'Integracoes', 'tipo' => 'ResvsDocumentosTransportes']);
    }
    
}
