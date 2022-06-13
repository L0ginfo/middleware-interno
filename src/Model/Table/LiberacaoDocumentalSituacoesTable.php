<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LiberacaoDocumentalSituacoes Model
 *
 * @property \App\Model\Table\LiberacoesDocumentaisTable&\Cake\ORM\Association\HasMany $LiberacoesDocumentais
 *
 * @method \App\Model\Entity\LiberacaoDocumentalSituacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalSituacao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalSituacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalSituacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalSituacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalSituacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalSituacao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalSituacao findOrCreate($search, callable $callback = null, $options = [])
 */
class LiberacaoDocumentalSituacoesTable extends Table
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
        

        $this->setTable('liberacao_documental_situacoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('LiberacoesDocumentais', [
            'foreignKey' => 'liberacao_documental_situacao_id',
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
