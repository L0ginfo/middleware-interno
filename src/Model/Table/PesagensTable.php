<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pesagens Model
 *
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\PesagemVeiculosTable&\Cake\ORM\Association\HasMany $PesagemVeiculos
 *
 * @method \App\Model\Entity\Pesagem get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pesagem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Pesagem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pesagem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pesagem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pesagem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pesagem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pesagem findOrCreate($search, callable $callback = null, $options = [])
 */
class PesagensTable extends Table
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

        $this->setTable('pesagens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('PesagemVeiculos', [
            'foreignKey' => 'pesagem_id',
        ]);
        $this->hasMany('PesagemVeiculoRegistros', [
            'foreignKey' => 'pesagem_id',
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
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));

        return $rules;
    }
}
