<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LiberacaoDocumentalTransportadoraItens Model
 *
 * @property \App\Model\Table\LiberacaoDocumentalTransportadorasTable&\Cake\ORM\Association\BelongsTo $LiberacaoDocumentalTransportadoras
 * @property \App\Model\Table\LiberacaoDocumentalItensTable&\Cake\ORM\Association\BelongsTo $LiberacaoDocumentalItens
 *
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadoraItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadoraItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadoraItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadoraItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadoraItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadoraItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadoraItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadoraItem findOrCreate($search, callable $callback = null, $options = [])
 */
class LiberacaoDocumentalTransportadoraItensTable extends Table
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
        

        $this->setTable('liberacao_documental_transportadora_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('LiberacaoDocumentalTransportadoras', [
            'foreignKey' => 'liberacao_documental_transportadora_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('LiberacoesDocumentaisItens', [
            'foreignKey' => 'liberacao_documental_item_id',
            'joinType' => 'INNER',
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
            ->decimal('quantidade_liberada')
            ->allowEmptyString('quantidade_liberada');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

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
        $rules->add($rules->existsIn(['liberacao_documental_transportadora_id'], 'LiberacaoDocumentalTransportadoras'));
        $rules->add($rules->existsIn(['liberacao_documental_item_id'], 'LiberacoesDocumentaisItens'));

        return $rules;
    }
}
