<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoDocumentoRegimeEspeciais Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\DocumentoRegimeEspeciaisTable&\Cake\ORM\Association\BelongsTo $DocumentoRegimeEspeciais
 *
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecial get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecial newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecial[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecial|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecial saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecial patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecial[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecial findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoDocumentoRegimeEspeciaisTable extends Table
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
        

        $this->setTable('ordem_servico_documento_regime_especiais');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
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
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));
        $rules->add($rules->existsIn(['documento_regime_especial_id'], 'DocumentoRegimeEspeciais'));

        return $rules;
    }
}
