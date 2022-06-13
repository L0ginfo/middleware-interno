<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cameras Model
 *
 * @property \App\Model\Table\GeorreferenciamentosTable&\Cake\ORM\Association\BelongsTo $Georreferenciamentos
 *
 * @method \App\Model\Entity\Camera get($primaryKey, $options = [])
 * @method \App\Model\Entity\Camera newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Camera[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Camera|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Camera saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Camera patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Camera[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Camera findOrCreate($search, callable $callback = null, $options = [])
 */
class CamerasTable extends Table
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
        

        $this->setTable('cameras');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Georreferenciamentos', [
            'foreignKey' => 'georreferenciamento_id',
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
            ->integer('id_coluna')
            ->allowEmptyString('id_coluna');

        $validator
            ->scalar('tabela')
            ->maxLength('tabela', 255)
            ->allowEmptyString('tabela');

        $validator
            ->scalar('codigo_cftv')
            ->maxLength('codigo_cftv', 255)
            ->allowEmptyString('codigo_cftv');

        $validator
            ->scalar('codigo_camera')
            ->maxLength('codigo_camera', 255)
            ->allowEmptyString('codigo_camera');

        $validator
            ->scalar('azimute')
            ->maxLength('azimute', 255)
            ->allowEmptyString('azimute');

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
        $rules->add($rules->existsIn(['georreferenciamento_id'], 'Georreferenciamentos'));

        return $rules;
    }
}
