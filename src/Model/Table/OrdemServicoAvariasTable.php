<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoAvarias Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\ContainersTable&\Cake\ORM\Association\BelongsTo $Containers
 * @property \App\Model\Table\AvariasTable&\Cake\ORM\Association\BelongsTo $Avarias
 *
 * @method \App\Model\Entity\OrdemServicoAvaria get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoAvaria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoAvaria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoAvaria|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoAvaria saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoAvaria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoAvaria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoAvaria findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoAvariasTable extends Table
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
        

        $this->setTable('ordem_servico_avarias');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
        ]);
        $this->belongsTo('Avarias', [
            'foreignKey' => 'avaria_id',
        ]);
        $this->belongsTo('AvariaTipos', [
            'foreignKey' => 'avaria_tipo_id',
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
            ->decimal('volume')
            ->allowEmptyString('volume');

        $validator
            ->decimal('peso')
            ->allowEmptyString('peso');

        $validator
            ->scalar('lacre')
            ->maxLength('lacre', 255)
            ->allowEmptyString('lacre');

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
        $rules->add($rules->existsIn(['container_id'], 'Containers'));
        $rules->add($rules->existsIn(['avaria_id'], 'Avarias'));

        return $rules;
    }
}
