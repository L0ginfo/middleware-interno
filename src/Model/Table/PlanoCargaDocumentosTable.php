<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanoCargaDocumentos Model
 *
 * @property \App\Model\Table\PlanoCargasTable&\Cake\ORM\Association\BelongsTo $PlanoCargas
 * @property \App\Model\Table\DocumentosMercadoriasTable&\Cake\ORM\Association\BelongsTo $DocumentosMercadorias
 *
 * @method \App\Model\Entity\PlanoCargaDocumento get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanoCargaDocumento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanoCargaDocumento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaDocumento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaDocumento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaDocumento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaDocumento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaDocumento findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanoCargaDocumentosTable extends Table
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
        

        $this->setTable('plano_carga_documentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        
        $this->belongsTo('PlanoCargas', [
            'foreignKey' => 'plano_carga_id',
        ]);


        $this->belongsTo('DocumentosMercadorias', [
            'foreignKey' => 'documento_mercadoria_id',
        ]);

        $this->belongsTo('OperadorPortuarios', [
            'className' => 'Empresas',
            'foreignKey' => 'operador_portuario_id',
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
        $rules->add($rules->existsIn(['plano_carga_id'], 'PlanoCargas'));
        $rules->add($rules->existsIn(['documento_mercadoria_id'], 'DocumentosMercadorias'));

        return $rules;
    }
}
