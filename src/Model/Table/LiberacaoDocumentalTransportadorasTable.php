<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LiberacaoDocumentalTransportadoras Model
 *
 * @property \App\Model\Table\TransportadorasTable&\Cake\ORM\Association\BelongsTo $Transportadoras
 * @property \App\Model\Table\LiberacoesDocumentaisTable&\Cake\ORM\Association\BelongsTo $LiberacoesDocumentais
 * @property \App\Model\Table\LiberacaoDocumentalTransportadoraItensTable&\Cake\ORM\Association\HasMany $LiberacaoDocumentalTransportadoraItens
 *
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadora get($primaryKey, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadora newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadora[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadora|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadora saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadora patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadora[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalTransportadora findOrCreate($search, callable $callback = null, $options = [])
 */
class LiberacaoDocumentalTransportadorasTable extends Table
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
        

        $this->setTable('liberacao_documental_transportadoras');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Transportadoras', [
            'foreignKey' => 'transportadora_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('LiberacoesDocumentais', [
            'foreignKey' => 'liberacao_documental_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('LiberacaoDocumentalTransportadoraItens', [
            'foreignKey' => 'liberacao_documental_transportadora_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('ResvsLiberacoesDocumentais', [
            'foreignKey' => 'liberacao_documental_transportadora_id',
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

        $validator
            ->dateTime('data_fim_retirada')
            ->allowEmptyDateTime('data_fim_retirada');

        $validator
            ->dateTime('data_inicio_retirada')
            ->allowEmptyDateTime('data_inicio_retirada');

        $validator
            ->scalar('tolerancia')
            ->maxLength('tolerancia', 255)
            ->allowEmptyString('tolerancia');

        $validator
            ->scalar('numero_pedido')
            ->maxLength('numero_pedido', 255)
            ->allowEmptyString('numero_pedido');

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
        $rules->add($rules->existsIn(['transportadora_id'], 'Transportadoras'));
        $rules->add($rules->existsIn(['liberacao_documental_id'], 'LiberacoesDocumentais'));

        return $rules;
    }
}
