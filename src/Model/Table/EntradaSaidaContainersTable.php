<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EntradaSaidaContainers Model
 *
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\ContainersTable&\Cake\ORM\Association\BelongsTo $Containers
 *
 * @method \App\Model\Entity\EntradaSaidaContainer get($primaryKey, $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainer findOrCreate($search, callable $callback = null, $options = [])
 */
class EntradaSaidaContainersTable extends Table
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
        

        $this->setTable('entrada_saida_containers');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ResvEntrada', [
            'foreignKey' => 'resv_entrada_id',
            'joinType' => 'LEFT',
            'className' => 'Resvs', 
            'propertyName' => 'resv_entrada'
        ]);
        $this->belongsTo('ResvSaida', [
            'foreignKey' => 'resv_saida_id',
            'joinType' => 'LEFT',
            'className' => 'Resvs', 
            'propertyName' => 'resv_saida'
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('ContainerFormaUsos', [
            'foreignKey' => 'container_forma_uso_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('SituacaoContainers', [
            'foreignKey' => 'situacao_container_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('DriveEspacos', [
            'foreignKey' => 'drive_espaco_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('ContainerDestinos', [
            'foreignKey' => 'container_destino_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('DriveEspacosAtual', [
            'foreignKey' => 'drive_espaco_atual_id',
            'joinType' => 'LEFT',
            'className' => 'DriveEspacos', 
            'propertyName' => 'drive_espaco_atual'
        ]);
        $this->hasOne('ResvsContainers', [
            'foreignKey' => 'container_id',
            'bindingKey' => 'container_id',
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
            ->scalar('tipo')
            ->requirePresence('tipo', 'create')
            ->notEmptyString('tipo');

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
        $rules->add($rules->existsIn(['resv_entrada_id'], 'ResvEntrada'));
        $rules->add($rules->existsIn(['resv_saida_id'], 'ResvSaida'));
        $rules->add($rules->existsIn(['container_id'], 'Containers'));

        return $rules;
    }

    public function beforeSave($event, $entity, $options) {

        if (in_array('drive_espaco_id', $entity->getDirty())) 
            $entity->drive_espaco_atual_id = $entity->drive_espaco_id;

        if (in_array('drive_espaco_saida_id', $entity->getDirty())) 
            $entity->drive_espaco_atual_id = $entity->drive_espaco_saida_id;
            
    }

}
