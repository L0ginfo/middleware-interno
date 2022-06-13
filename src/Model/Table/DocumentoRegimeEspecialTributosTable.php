<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentoRegimeEspecialTributos Model
 *
 * @property &\Cake\ORM\Association\BelongsTo $DocumentoRegimeEspeciais
 * @property \App\Model\Table\TributosTable&\Cake\ORM\Association\BelongsTo $Tributos
 *
 * @method \App\Model\Entity\DocumentoRegimeEspecialTributo get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialTributo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialTributo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialTributo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialTributo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialTributo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialTributo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoRegimeEspecialTributo findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentoRegimeEspecialTributosTable extends Table
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
        

        $this->setTable('documento_regime_especial_tributos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('DocumentoRegimeEspeciais', [
            'foreignKey' => 'documento_regime_especial_id',
        ]);
        $this->belongsTo('Tributos', [
            'foreignKey' => 'tributo_id',
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
            ->numeric('suspenso')
            ->requirePresence('suspenso', 'create')
            ->notEmptyString('suspenso');

        $validator
            ->numeric('recolhido')
            ->requirePresence('recolhido', 'create')
            ->notEmptyString('recolhido');

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
        $rules->add($rules->existsIn(['documento_regime_especial_id'], 'DocumentoRegimeEspeciais'));
        $rules->add($rules->existsIn(['tributo_id'], 'Tributos'));

        return $rules;
    }
}
