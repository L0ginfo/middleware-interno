<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProgramacaoLiberacaoDocumentalItens Model
 *
 * @property \App\Model\Table\ProgramacaoLiberacaoDocumentaisTable&\Cake\ORM\Association\BelongsTo $ProgramacaoLiberacaoDocumentais
 * @property \App\Model\Table\LiberacoesDocumentaisItensTable&\Cake\ORM\Association\BelongsTo $LiberacoesDocumentaisItens
 * @property \App\Model\Table\LiberacaoDocumentalTransportadoraItensTable&\Cake\ORM\Association\BelongsTo $LiberacaoDocumentalTransportadoraItens
 *
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumentalItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumentalItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumentalItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumentalItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumentalItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumentalItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumentalItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoLiberacaoDocumentalItem findOrCreate($search, callable $callback = null, $options = [])
 */
class ProgramacaoLiberacaoDocumentalItensTable extends Table
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
        

        $this->setTable('programacao_liberacao_documental_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProgramacaoLiberacaoDocumentais', [
            'foreignKey' => 'programacao_liberacao_documental_id',
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
        $rules->add($rules->existsIn(['programacao_liberacao_documental_id'], 'ProgramacaoLiberacaoDocumentais'));
        $rules->add($rules->existsIn(['liberacao_documental_item_id'], 'LiberacoesDocumentaisItens'));
        $rules->add($rules->existsIn(['liberacao_documental_transportadora_item_id'], 'LiberacaoDocumentalTransportadoraItens'));

        return $rules;
    }
}
