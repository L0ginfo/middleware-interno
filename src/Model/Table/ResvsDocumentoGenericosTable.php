<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResvsDocumentoGenericos Model
 *
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\DocumentoGenericosTable&\Cake\ORM\Association\BelongsTo $DocumentoGenericos
 *
 * @method \App\Model\Entity\ResvsDocumentoGenerico get($primaryKey, $options = [])
 * @method \App\Model\Entity\ResvsDocumentoGenerico newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ResvsDocumentoGenerico[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResvsDocumentoGenerico|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvsDocumentoGenerico saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvsDocumentoGenerico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ResvsDocumentoGenerico[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResvsDocumentoGenerico findOrCreate($search, callable $callback = null, $options = [])
 */
class ResvsDocumentoGenericosTable extends Table
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
        

        $this->setTable('resvs_documento_genericos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('DocumentoGenericos', [
            'foreignKey' => 'documento_generico_id',
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
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));
        $rules->add($rules->existsIn(['documento_generico_id'], 'DocumentoGenericos'));

        return $rules;
    }
}
