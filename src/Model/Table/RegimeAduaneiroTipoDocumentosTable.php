<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RegimeAduaneiroTipoDocumentos Model
 *
 * @property \App\Model\Table\RegimesAduaneirosTable&\Cake\ORM\Association\BelongsTo $RegimesAduaneiros
 * @property \App\Model\Table\TipoDocumentosTable&\Cake\ORM\Association\BelongsTo $TipoDocumentos
 *
 * @method \App\Model\Entity\RegimeAduaneiroTipoDocumento get($primaryKey, $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoDocumento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoDocumento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoDocumento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoDocumento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoDocumento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoDocumento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RegimeAduaneiroTipoDocumento findOrCreate($search, callable $callback = null, $options = [])
 */
class RegimeAduaneiroTipoDocumentosTable extends Table
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

        $this->setTable('regime_aduaneiro_tipo_documentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('RegimesAduaneiros', [
            'foreignKey' => 'regime_aduaneiro_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TipoDocumentos', [
            'foreignKey' => 'tipo_documento_id',
            'joinType' => 'INNER'
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['regime_aduaneiro_id'], 'RegimesAduaneiros'));
        $rules->add($rules->existsIn(['tipo_documento_id'], 'TipoDocumentos'));

        return $rules;
    }
}
