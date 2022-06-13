<?php
namespace App\Model\Table;

use App\RegraNegocio\Rfb\RfbManager;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResvsLiberacoesDocumentais Model
 *
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\LiberacoesDocumentaisTable&\Cake\ORM\Association\BelongsTo $LiberacoesDocumentais
 *
 * @method \App\Model\Entity\ResvsLiberacoesDocumental get($primaryKey, $options = [])
 * @method \App\Model\Entity\ResvsLiberacoesDocumental newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ResvsLiberacoesDocumental[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResvsLiberacoesDocumental|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvsLiberacoesDocumental saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvsLiberacoesDocumental patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ResvsLiberacoesDocumental[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResvsLiberacoesDocumental findOrCreate($search, callable $callback = null, $options = [])
 */
class ResvsLiberacoesDocumentaisTable extends Table
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

        $this->setTable('resvs_liberacoes_documentais');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('LiberacoesDocumentais', [
            'foreignKey' => 'liberacao_documental_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'resv_id',
            'targetForeignKey' => 'resv_id',
            'bindingKey' => 'resv_id',
        ]);
        $this->belongsTo('ResvsVeiculos', [
            'foreignKey' => 'resv_id',
            'targetForeignKey' => 'resv_id',
            'bindingKey' => 'resv_id',
        ]);
        $this->belongsTo('LiberacaoDocumentalTransportadoras', [
            'foreignKey' => 'liberacao_documental_transportadora_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('ResvLiberacaoDocumentalItens', [
            'foreignKey' => 'resv_liberacao_documental_id',
            'joinType' => 'LEFT',
            'dependent' => true,
            'cascadeCallbacks' => true
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
        $rules->add($rules->existsIn(['liberacao_documental_id'], 'LiberacoesDocumentais'));

        return $rules;
    }

    public function afterSave($event, $entity, $options)
    {
        RfbManager::doAction('rfb', 'acesso-veiculos', 'init', $entity, ['nome_model' => 'Integracoes', 'tipo' => 'ResvsLiberacoesDocumentais']);
    }
    
}
