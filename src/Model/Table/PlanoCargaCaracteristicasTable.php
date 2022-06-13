<?php
namespace App\Model\Table;

use Cake\ORM\Association\HasMany;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanoCargaCaracteristicas Model
 *
 * @property \App\Model\Table\PlanoCargasTable&\Cake\ORM\Association\BelongsTo $PlanoCargas
 * @property \App\Model\Table\CaracteristicasTable&\Cake\ORM\Association\BelongsTo $Caracteristicas
 *
 * @method \App\Model\Entity\PlanoCargaCaracteristica get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanoCargaCaracteristica newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanoCargaCaracteristica[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaCaracteristica|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaCaracteristica saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaCaracteristica patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaCaracteristica[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaCaracteristica findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanoCargaCaracteristicasTable extends Table
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
        

        $this->setTable('plano_carga_caracteristicas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('PlanoCargas', [
            'foreignKey' => 'plano_carga_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Caracteristicas', [
            'foreignKey' => 'caracteristica_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('TabelaTipoCaracteristicas', [
            'foreignKey' => 'tabela_tipo_caracteristica_id',
            'joinType' => 'LEFT',
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
        $rules->add($rules->existsIn(['caracteristica_id'], 'Caracteristicas'));

        return $rules;
    }
}
