<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Apreensoes Model
 *
 * @property \App\Model\Table\DocumentosMercadoriasTable&\Cake\ORM\Association\BelongsTo $DocumentosMercadorias
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\AftnsTable&\Cake\ORM\Association\BelongsTo $Aftns
 * @property \App\Model\Table\TipoDocumentosTable&\Cake\ORM\Association\BelongsTo $TipoDocumentos
 *
 * @method \App\Model\Entity\Apreensao get($primaryKey, $options = [])
 * @method \App\Model\Entity\Apreensao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Apreensao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Apreensao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Apreensao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Apreensao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Apreensao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Apreensao findOrCreate($search, callable $callback = null, $options = [])
 */
class ApreensoesTable extends Table
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

        $this->setTable('apreensoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('DocumentosMercadorias', [
            'foreignKey' => 'documento_mercadoria_id',
        ]);

        $this->belongsTo('DocumentosTransportes', [
            'foreignKey' => 'documento_transporte_id',
        ]);

        $this->belongsTo('StatusApreensoes', [
            'foreignKey' => 'status_apreensao_id',
        ]);

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
        ]);
        $this->belongsTo('Aftns', [
            'foreignKey' => 'fiscal_id',
        ]);
        $this->belongsTo('TipoDocumentos', [
            'foreignKey' => 'tipo_doc_apreensao_id',
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
            ->date('data_apreensao')
            ->requirePresence('data_apreensao', 'create')
            ->notEmptyDate('data_apreensao');

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
        $rules->add($rules->existsIn(['documento_transporte_id'], 'DocumentosTransportes'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        return $rules;
    }
}
