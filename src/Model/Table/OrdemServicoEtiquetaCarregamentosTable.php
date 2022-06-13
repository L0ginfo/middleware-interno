<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoEtiquetaCarregamentos Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EtiquetaProdutosTable&\Cake\ORM\Association\BelongsTo $EtiquetaProdutos
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 *
 * @method \App\Model\Entity\OrdemServicoEtiquetaCarregamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoEtiquetaCarregamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoEtiquetaCarregamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoEtiquetaCarregamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoEtiquetaCarregamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoEtiquetaCarregamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoEtiquetaCarregamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoEtiquetaCarregamento findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoEtiquetaCarregamentosTable extends Table
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

        $this->setTable('ordem_servico_etiqueta_carregamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('EtiquetaProdutos', [
            'foreignKey' => 'etiqueta_produto_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('OrdemServicoCarregamentos', [
            'foreignKey' => [
                'ordem_servico_id'
            ],
            'targetForeignKey' => [
                'ordem_servico_id'
            ],
            'bindingKey' => [
                'ordem_servico_id'
            ],
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
            ->requirePresence('quantidade_carregada', 'create')
            ->notEmptyString('quantidade_carregada');

        $validator
            ->requirePresence('peso_carregada', 'create')
            ->notEmptyString('peso_carregada');

        $validator
            ->requirePresence('m2_carregada', 'create')
            ->notEmptyString('m2_carregada');

        $validator
            ->requirePresence('m3_carregada', 'create')
            ->notEmptyString('m3_carregada');

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
        $rules->add($rules->existsIn(['etiqueta_produto_id'], 'EtiquetaProdutos'));
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));

        return $rules;
    }
}
