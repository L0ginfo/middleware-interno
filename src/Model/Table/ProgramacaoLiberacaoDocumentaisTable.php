<?php
namespace App\Model\Table;

use App\RegraNegocio\Rfb\RfbManager;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProgramacaoLiberacaoDocumentais Model
 *
 * @property \App\Model\Table\LiberacoesDocumentaisTable&\Cake\ORM\Association\BelongsTo $LiberacoesDocumentais
 * @property \App\Model\Table\LiberacaoDocumentalTransportadorasTable&\Cake\ORM\Association\BelongsTo $LiberacaoDocumentalTransportadoras
 * @property \App\Model\Table\ProgramacoesTable&\Cake\ORM\Association\BelongsTo $Programacoes
 * @property \App\Model\Table\ProgramacaoLiberacaoDocumentalItensTable&\Cake\ORM\Association\HasMany $ProgramacaoLiberacaoDocumentalItens
 *
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumental get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumental newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumental[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumental|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumental saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumental patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumental[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumental findOrCreate($search, callable $callback = null, $options = [])
 */
class ProgramacaoLiberacaoDocumentaisTable extends Table
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
        

        $this->setTable('programacao_liberacao_documentais');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('LiberacoesDocumentais', [
            'foreignKey' => 'liberacao_documental_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('LiberacaoDocumentalTransportadoras', [
            'foreignKey' => 'liberacao_documental_transportadora_id',
        ]);
        $this->belongsTo('Programacoes', [
            'foreignKey' => 'programacao_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ProgramacaoLiberacaoDocumentalItens', [
            'foreignKey' => 'programacao_liberacao_documental_id',
            'dependent' => true
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
        $rules->add($rules->existsIn(['liberacao_documental_id'], 'LiberacoesDocumentais'));
        $rules->add($rules->existsIn(['liberacao_documental_transportadora_id'], 'LiberacaoDocumentalTransportadoras'));
        $rules->add($rules->existsIn(['programacao_id'], 'Programacoes'));

        return $rules;
    }

    public function afterSave($event, $entity, $options)
    {
        RfbManager::doAction('rfb', 'acesso-veiculos', 'init', $entity, ['nome_model' => 'Integracoes', 'tipo' => 'ProgramacaoLiberacaoDocumentais']);
    }
    
}
