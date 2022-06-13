<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentoMercadoriaItemControleEspecificos Model
 *
 * @property \App\Model\Table\ControleEspecificosTable&\Cake\ORM\Association\BelongsTo $ControleEspecificos
 * @property \App\Model\Table\DocumentosMercadoriasItensTable&\Cake\ORM\Association\BelongsTo $DocumentosMercadoriasItens
 *
 * @method \App\Model\Entity\DocumentoMercadoriaItemControleEspecifico get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentoMercadoriaItemControleEspecifico newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentoMercadoriaItemControleEspecifico[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoMercadoriaItemControleEspecifico|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoMercadoriaItemControleEspecifico saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoMercadoriaItemControleEspecifico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoMercadoriaItemControleEspecifico[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoMercadoriaItemControleEspecifico findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentoMercadoriaItemControleEspecificosTable extends Table
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
        

        $this->setTable('documento_mercadoria_item_controle_especificos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ControleEspecificos', [
            'foreignKey' => 'controle_especifico_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('DocumentosMercadoriasItens', [
            'foreignKey' => 'documento_mercadoria_item_id',
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
        $rules->add($rules->existsIn(['controle_especifico_id'], 'ControleEspecificos'));
        $rules->add($rules->existsIn(['documento_mercadoria_item_id'], 'DocumentosMercadoriasItens'));

        return $rules;
    }
}
