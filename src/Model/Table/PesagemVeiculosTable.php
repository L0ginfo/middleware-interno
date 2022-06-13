<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PesagemVeiculos Model
 *
 * @property \App\Model\Table\VeiculosTable&\Cake\ORM\Association\BelongsTo $Veiculos
 * @property \App\Model\Table\PesagensTable&\Cake\ORM\Association\BelongsTo $Pesagens
 * @property &\Cake\ORM\Association\HasMany $PesagemVeiculoRegistros
 *
 * @method \App\Model\Entity\PesagemVeiculo get($primaryKey, $options = [])
 * @method \App\Model\Entity\PesagemVeiculo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PesagemVeiculo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PesagemVeiculo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PesagemVeiculo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PesagemVeiculo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PesagemVeiculo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PesagemVeiculo findOrCreate($search, callable $callback = null, $options = [])
 */
class PesagemVeiculosTable extends Table
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
        

        $this->setTable('pesagem_veiculos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Veiculos', [
            'foreignKey' => 'veiculo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Pesagens', [
            'foreignKey' => 'pesagem_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('PesagemVeiculoRegistros', [
            'foreignKey' => 'pesagem_veiculo_id',
            'joinType' => 'LEFT',
            'dependent' => true,
            'cascadeCallbacks' => true
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
            ->integer('cavalo')
            ->allowEmptyString('cavalo');

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
        $rules->add($rules->existsIn(['veiculo_id'], 'Veiculos'));
        $rules->add($rules->existsIn(['pesagem_id'], 'Pesagens'));

        return $rules;
    }
}
