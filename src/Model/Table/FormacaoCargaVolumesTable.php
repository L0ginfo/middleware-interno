<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormacaoCargaVolumes Model
 *
 * @property \App\Model\Table\FormacaoCargasTable&\Cake\ORM\Association\BelongsTo $FormacaoCargas
 * @property \App\Model\Table\FormacaoCargaVolumeItensTable&\Cake\ORM\Association\HasMany $FormacaoCargaVolumeItens
 * @property \App\Model\Table\OrdemServicoVolumeCarregamentosTable&\Cake\ORM\Association\HasMany $OrdemServicoVolumeCarregamentos
 *
 * @method \App\Model\Entity\FormacaoCargaVolume get($primaryKey, $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolume newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolume[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolume|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolume saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolume patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolume[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolume findOrCreate($search, callable $callback = null, $options = [])
 */
class FormacaoCargaVolumesTable extends Table
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
        

        $this->setTable('formacao_carga_volumes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('FormacaoCargas', [
            'foreignKey' => 'formacao_carga_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('FormacaoCargaVolumeItens', [
            'foreignKey' => 'formacao_carga_volume_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('OrdemServicoVolumeCarregamentos', [
            'foreignKey' => 'formacao_carga_volume_id',
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
            ->scalar('codigo_barras')
            ->maxLength('codigo_barras', 55)
            ->requirePresence('codigo_barras', 'create')
            ->notEmptyString('codigo_barras');

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
        $rules->add($rules->existsIn(['formacao_carga_id'], 'FormacaoCargas'));

        return $rules;
    }
}
