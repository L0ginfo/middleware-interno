<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResvLiberacaoDocumentalItens Model
 *
 * @property \App\Model\Table\ResvsLiberacoesDocumentaisTable&\Cake\ORM\Association\BelongsTo $ResvsLiberacoesDocumentais
 * @property \App\Model\Table\LiberacoesDocumentaisItensTable&\Cake\ORM\Association\BelongsTo $LiberacoesDocumentaisItens
 * @property \App\Model\Table\LiberacaoDocumentalTransportadoraItensTable&\Cake\ORM\Association\BelongsTo $LiberacaoDocumentalTransportadoraItens
 *
 * @method \App\Model\Entity\ResvLiberacaoDocumentalItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\ResvLiberacaoDocumentalItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ResvLiberacaoDocumentalItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResvLiberacaoDocumentalItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvLiberacaoDocumentalItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvLiberacaoDocumentalItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ResvLiberacaoDocumentalItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResvLiberacaoDocumentalItem findOrCreate($search, callable $callback = null, $options = [])
 */
class ResvLiberacaoDocumentalItensTable extends Table
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
        

        $this->setTable('resv_liberacao_documental_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ResvsLiberacoesDocumentais', [
            'foreignKey' => 'resv_liberacao_documental_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('LiberacoesDocumentaisItens', [
            'foreignKey' => 'liberacao_documental_item_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('LiberacaoDocumentalTransportadoraItens', [
            'foreignKey' => 'liberacao_documental_transportadora_item_id',
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
        $rules->add($rules->existsIn(['resv_liberacao_documental_id'], 'ResvsLiberacoesDocumentais'));
        $rules->add($rules->existsIn(['liberacao_documental_item_id'], 'LiberacoesDocumentaisItens'));
        $rules->add($rules->existsIn(['liberacao_documental_transportadora_item_id'], 'LiberacaoDocumentalTransportadoraItens'));

        return $rules;
    }
}
