<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoVolumeCarregamentos Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\FormacaoCargaVolumesTable&\Cake\ORM\Association\BelongsTo $FormacaoCargaVolumes
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 *
 * @method \App\Model\Entity\OrdemServicoVolumeCarregamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoVolumeCarregamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoVolumeCarregamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoVolumeCarregamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoVolumeCarregamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoVolumeCarregamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoVolumeCarregamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoVolumeCarregamento findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoVolumeCarregamentosTable extends Table
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
        

        $this->setTable('ordem_servico_volume_carregamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('FormacaoCargaVolumes', [
            'foreignKey' => 'formacao_carga_volume_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
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
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['formacao_carga_volume_id'], 'FormacaoCargaVolumes'));
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));

        return $rules;
    }
}
