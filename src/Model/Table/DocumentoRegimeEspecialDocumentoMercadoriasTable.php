<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentoRegimeEspecialDocumentoMercadorias Model
 *
 * @property \App\Model\Table\DocumentosMercadoriasTable&\Cake\ORM\Association\BelongsTo $DocumentosMercadorias
 * @property \App\Model\Table\DocumentoRegimeEspeciaisTable&\Cake\ORM\Association\BelongsTo $DocumentoRegimeEspeciais
 *
 * @method \App\Model\Entity\DocumentoRegimeEspecialDocumentoMercadoria get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialDocumentoMercadoria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialDocumentoMercadoria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialDocumentoMercadoria|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialDocumentoMercadoria saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialDocumentoMercadoria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialDocumentoMercadoria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialDocumentoMercadoria findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentoRegimeEspecialDocumentoMercadoriasTable extends Table
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
        

        $this->setTable('documento_regime_especial_documento_mercadorias');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('DocumentosMercadorias', [
            'foreignKey' => 'documento_mercadoria_id',
        ]);
        $this->belongsTo('DocumentoRegimeEspeciais', [
            'foreignKey' => 'documento_regime_especial_id',
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
        $rules->add($rules->existsIn(['documento_mercadoria_id'], 'DocumentosMercadorias'));
        $rules->add($rules->existsIn(['documento_regime_especial_id'], 'DocumentoRegimeEspeciais'));

        return $rules;
    }
}
