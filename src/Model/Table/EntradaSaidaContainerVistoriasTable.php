<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EntradaSaidaContainerVistorias Model
 *
 * @property \App\Model\Table\EntradaSaidaContainersTable&\Cake\ORM\Association\BelongsTo $EntradaSaidaContainers
 * @property \App\Model\Table\VistoriasTable&\Cake\ORM\Association\BelongsTo $Vistorias
 *
 * @method \App\Model\Entity\EntradaSaidaContainerVistoria get($primaryKey, $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainerVistoria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainerVistoria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainerVistoria|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainerVistoria saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainerVistoria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainerVistoria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaContainerVistoria findOrCreate($search, callable $callback = null, $options = [])
 */
class EntradaSaidaContainerVistoriasTable extends Table
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
        

        $this->setTable('entrada_saida_container_vistorias');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('EntradaSaidaContainers', [
            'foreignKey' => 'entrada_saida_container_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Vistorias', [
            'foreignKey' => 'vistoria_id',
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
        $rules->add($rules->existsIn(['entrada_saida_container_id'], 'EntradaSaidaContainers'));
        $rules->add($rules->existsIn(['vistoria_id'], 'Vistorias'));

        return $rules;
    }
}
