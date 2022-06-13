<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormacaoCargaVolumeItens Model
 *
 * @property \App\Model\Table\OrdemServicoItemSeparacoesTable&\Cake\ORM\Association\BelongsTo $OrdemServicoItemSeparacoes
 * @property \App\Model\Table\FormacaoCargaVolumesTable&\Cake\ORM\Association\BelongsTo $FormacaoCargaVolumes
 *
 * @method \App\Model\Entity\FormacaoCargaVolumeItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolumeItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolumeItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolumeItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolumeItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolumeItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolumeItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCargaVolumeItem findOrCreate($search, callable $callback = null, $options = [])
 */
class FormacaoCargaVolumeItensTable extends Table
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
        

        $this->setTable('formacao_carga_volume_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrdemServicoItemSeparacoes', [
            'foreignKey' => 'ordem_servico_item_separacao_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('FormacaoCargaVolumes', [
            'foreignKey' => 'formacao_carga_volume_id',
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

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        $validator
            ->decimal('quantidade')
            ->requirePresence('quantidade', 'create')
            ->notEmptyString('quantidade');

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
        $rules->add($rules->existsIn(['ordem_servico_item_separacao_id'], 'OrdemServicoItemSeparacoes'));
        $rules->add($rules->existsIn(['formacao_carga_volume_id'], 'FormacaoCargaVolumes'));

        return $rules;
    }
}
